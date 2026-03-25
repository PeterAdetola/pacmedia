<?php

namespace App\Http\Controllers;

class ServiceController extends Controller
{
    /**
     * Map URL slugs → markdown file + page metadata.
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
     * Render a service detail page.
     */
    public function show(string $slug)
    {
        abort_unless(array_key_exists($slug, $this->serviceMap), 404);

        $meta    = $this->serviceMap[$slug];
        $raw     = file_get_contents(resource_path('markdown/' . $meta['file']));
        $service = $this->parse($raw);

        // Merge meta fields that the blade needs directly on $service
        $service['icon'] = $meta['icon'];
        $service['slug'] = $slug;

        return view('service', [
            'service'    => $service,
            'isHomePage' => false,
            'pageTitle'  => $service['title_plain'],
            'pageIcon'   => $meta['icon'],
        ]);
    }

    /**
     * Parse a service markdown file into a structured array.
     *
     * ── File structure (sections delimited by ---) ────────────────────────
     *
     *   Block 0  →  Header
     *     # INDEX | Title<br>Continuation
     *     ## Headline
     *     Body paragraphs (one per line, blank lines ignored)
     *
     *   Block 1  →  COVERS
     *     +Group Label             ← + prefix = named group header
     *     Item text                ← plain line = list item
     *     (no + groups = all items under '_default', label suppressed in blade)
     *
     *   Block 2  →  PROCESS
     *     01 | Label | Step Title
     *     Body text (multi-line joined with a space)
     *     NOTE: Optional italicised aside
     */
    private function parse(string $raw): array
    {
        $sections = array_map('trim', explode('---', $raw));

        // ── Block 0: Header ──────────────────────────────────────────────
        $header = array_shift($sections);
        $hLines = array_values(array_filter(array_map('trim', explode("\n", $header))));

        // # 01 | Visual Brand<br>Architecture
        $titleRaw   = ltrim(array_shift($hLines), '# ');
        $titleParts = array_map('trim', explode('|', $titleRaw, 2));
        $index      = $titleParts[0] ?? '';
        $titleHtml  = $titleParts[1] ?? $titleRaw;
        $titlePlain = strip_tags(str_replace('<br>', ' ', $titleHtml));

        // ## Headline — first line starting with ##
        $headline  = '';
        $bodyLines = [];
        foreach ($hLines as $line) {
            if ($headline === '' && str_starts_with($line, '## ')) {
                $headline = ltrim($line, '# ');
            } else {
                $bodyLines[] = $line;
            }
        }

        // Wrap each non-empty body line in <p>
        $bodyHtml = implode('', array_map(
            fn($l) => "<p>{$l}</p>",
            array_filter($bodyLines, fn($l) => $l !== '')
        ));

        // ── Remaining blocks ─────────────────────────────────────────────
        $covers  = [];
        $process = [];

        foreach ($sections as $block) {
            $lines  = array_values(array_filter(array_map('trim', explode("\n", $block))));
            if (empty($lines)) continue;

            $marker = strtoupper($lines[0]);

            // ── COVERS ───────────────────────────────────────────────────
            if ($marker === 'COVERS') {
                array_shift($lines);
                $currentGroup = '_default';

                foreach ($lines as $line) {
                    if (str_starts_with($line, '+')) {
                        // + prefix = group header
                        $currentGroup = ltrim($line, '+ ');
                        if (!isset($covers[$currentGroup])) {
                            $covers[$currentGroup] = [];
                        }
                        continue;
                    }

                    // Any non-empty plain line = item under current group
                    if ($line !== '') {
                        $covers[$currentGroup][] = $line;
                    }
                }
            }

            // ── PROCESS ──────────────────────────────────────────────────
            elseif ($marker === 'PROCESS') {
                array_shift($lines);
                $currentStep = null;

                foreach ($lines as $line) {
                    // Step header: "01 | Discovery | Intelligence Gathering"
                    if (preg_match('/^\d{2}\s*\|/', $line)) {
                        if ($currentStep !== null) {
                            $process[] = $currentStep;
                        }
                        $parts       = array_map('trim', explode('|', $line, 3));
                        $currentStep = [
                            'label' => $parts[1] ?? '',
                            'title' => $parts[2] ?? '',
                            'body'  => '',
                            'note'  => '',
                        ];
                        continue;
                    }

                    if ($currentStep === null) continue;

                    if (str_starts_with($line, 'NOTE:')) {
                        $currentStep['note'] = trim(substr($line, 5));
                        continue;
                    }

                    $currentStep['body'] .= ($currentStep['body'] ? ' ' : '') . $line;
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
}
