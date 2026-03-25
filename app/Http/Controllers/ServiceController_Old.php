<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Map URL slugs to their markdown file and page metadata.
     */
    private array $serviceMap = [
        'brand-architecture' => [
            'file'  => 'service_brand-architecture.md',
            'title' => 'Visual Brand Architecture',
            'icon'  => 'ph ph-cube',
        ],
        'interface-craftsmanship' => [
            'file'  => 'service_interface-craftsmanship.md',
            'title' => 'Interface Craftsmanship',
            'icon'  => 'ph ph-bezier-curve',
        ],
        'performance-engineering' => [
            'file'  => 'service_performance-engineering.md',
            'title' => 'Performance Engineering',
            'icon'  => 'ph ph-code',
        ],
        'intelligent-automation' => [
            'file'  => 'service_intelligent-automation.md',
            'title' => 'Intelligent Automation',
            'icon'  => 'ph ph-robot',
        ],
    ];

    /**
     * Render a service detail page from its markdown file.
     */
    public function show(string $slug)
    {
        abort_unless(array_key_exists($slug, $this->serviceMap), 404);

        $meta = $this->serviceMap[$slug];
        $raw  = file_get_contents(resource_path('markdown/' . $meta['file']));

        $service = $this->parse($raw);
        $service['icon'] = $meta['icon'];

        return view('service', compact('service'), [
            'isHomePage' => false,
            'pageTitle'  => $service['title_plain'],
            'pageIcon'   => $meta['icon'],
        ]);
    }

    /**
     * Parse a service markdown file into a structured array.
     *
     * Expected file structure (sections separated by ---):
     *
     *   # INDEX | Title<br>Line2          ← Block 0: header
     *   ## Headline                        ← first ## in block 0
     *   Body paragraphs…
     *
     *   COVERS                             ← Block 1
     *   Group Label (or _default)
     *   Item
     *   …
     *
     *   PROCESS                            ← Block 2
     *   01 | Label | Title
     *   Body text…
     *   NOTE: optional italicised note
     *   …
     */
    private function parse(string $raw): array
    {
        $sections = array_map('trim', explode('---', $raw));

        // ── Block 0: Header ──────────────────────────────────────────────
        $header   = array_shift($sections);
        $hLines   = array_values(array_filter(array_map('trim', explode("\n", $header))));

        // Title line: "# 01 | Visual Brand<br>Architecture"
        $titleRaw   = ltrim(array_shift($hLines), '# ');
        $titleParts = array_map('trim', explode('|', $titleRaw, 2));
        $index      = $titleParts[0] ?? '';
        $titleHtml  = str_replace('|', '<br>', $titleParts[1] ?? $titleRaw);
        $titlePlain = strip_tags(str_replace('<br>', ' ', $titleHtml));

        // Headline: first line starting with ##
        $headline = '';
        $bodyLines = [];
        foreach ($hLines as $line) {
            if (str_starts_with($line, '## ') && $headline === '') {
                $headline = ltrim($line, '# ');
            } else {
                $bodyLines[] = $line;
            }
        }

        // Body: remaining non-empty lines → wrap each paragraph in <p>
        $bodyHtml = implode('', array_map(
            fn($l) => "<p>{$l}</p>",
            array_filter($bodyLines, fn($l) => $l !== '')
        ));

        // ── Remaining blocks ─────────────────────────────────────────────
        $covers  = [];
        $process = [];

        foreach ($sections as $block) {
            $lines = array_values(array_filter(array_map('trim', explode("\n", $block))));
            if (empty($lines)) continue;

            $marker = strtoupper($lines[0]);

            // ── COVERS block ─────────────────────────────────────────────
            if ($marker === 'COVERS') {
                array_shift($lines); // remove "COVERS" marker

                $currentGroup = '_default';
                foreach ($lines as $line) {
                    // A group label is a line that has no leading dash/arrow
                    // and does not look like a cover item (heuristic: title-cased,
                    // shorter, no ampersand mid-sentence).
                    // Strategy: if the NEXT line(s) are items, the current is a group.
                    // Simpler rule used here: if the line equals "_default" treat as ungrouped,
                    // otherwise if it contains no lowercase letters at the start it's a group heading.
                    if ($line === '_default') {
                        $currentGroup = '_default';
                    } elseif ($this->isGroupLabel($line)) {
                        $currentGroup = $line;
                        if (!isset($covers[$currentGroup])) {
                            $covers[$currentGroup] = [];
                        }
                    } else {
                        $covers[$currentGroup][] = $line;
                    }
                }
            }

            // ── PROCESS block ────────────────────────────────────────────
            elseif ($marker === 'PROCESS') {
                array_shift($lines); // remove "PROCESS" marker

                $currentStep = null;
                foreach ($lines as $line) {
                    // Step header: "01 | Discovery | Intelligence Gathering"
                    if (preg_match('/^\d{2}\s*\|/', $line)) {
                        if ($currentStep !== null) {
                            $process[] = $currentStep;
                        }
                        $parts = array_map('trim', explode('|', $line, 3));
                        $currentStep = [
                            'label' => $parts[1] ?? '',
                            'title' => $parts[2] ?? '',
                            'body'  => '',
                            'note'  => '',
                        ];
                    }
                    // NOTE line
                    elseif (str_starts_with($line, 'NOTE:') && $currentStep !== null) {
                        $currentStep['note'] = trim(substr($line, 5));
                    }
                    // Body continuation
                    elseif ($currentStep !== null) {
                        $currentStep['body'] .= ($currentStep['body'] ? ' ' : '') . $line;
                    }
                }

                if ($currentStep !== null) {
                    $process[] = $currentStep;
                }
            }
        }

        return [
            'index'       => trim($index),
            'title'       => $titleHtml,
            'title_plain' => $titlePlain,
            'headline'    => $headline,
            'body_html'   => $bodyHtml,
            'covers'      => $covers,
            'process'     => $process,
        ];
    }

    /**
     * Heuristic: a line is a group label (not a cover item) when it:
     * - has no trailing period
     * - is relatively short (< 50 chars)
     * - doesn't start with a lowercase letter
     */
    private function isGroupLabel(string $line): bool
    {
        return strlen($line) < 50
            && !ctype_lower($line[0])
            && !str_ends_with($line, '.');
    }
}
