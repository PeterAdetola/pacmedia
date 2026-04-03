<?php

namespace App\Http\Controllers;

class LegalController extends Controller
{
    // ─────────────────────────────────────────────────
    // Terms & Conditions
    // ─────────────────────────────────────────────────
    public function terms()
    {
        $sections = $this->parseLegal(
            resource_path('markdown/terms-and-conditions.md')
        );

        return view('legal', array_merge($sections, [
            'isHomePage'    => false,
            'pageTitle'     => 'Terms & Conditions',
            'pageIcon'      => 'ph-thin ph-scroll',
            'effectiveDate' => 'March 2026',
            'tagline'       => 'Governing the engagement between The Pacmedia and its clients worldwide.',
        ]), [
            'pageTitle' => 'Terms & Conditions',
            'pageIcon'  => 'ph ph-scroll',
        ]);
    }

    public function privacy()
    {
        $sections = $this->parseLegal(
            resource_path('markdown/privacy-policy.md')
        );

        return view('legal', array_merge($sections, [
            'isHomePage'    => false,
            'pageTitle'     => 'Privacy Policy',
            'pageIcon'      => 'ph-thin ph-shield-check',
            'effectiveDate' => 'March 2026',
            'tagline'       => 'How The Pacmedia collects, uses, and protects your personal information.',
        ]), [
            'pageTitle' => 'Privacy Policy',
            'pageIcon'  => 'ph ph-shield-check',
        ]);
    }

    // ─────────────────────────────────────────────────
    // Shared markdown parser
    // ─────────────────────────────────────────────────
    private function parseLegal(string $path): array
    {
        $raw   = file_get_contents($path);
        $lines = explode("\n", $raw);

        $sections = [];
        $current  = null;
        $currentSub = null;

        foreach ($lines as $line) {
            $line = rtrim($line);

            // Skip the document title (# Title) and subtitle (## subtitle)
            if (preg_match('/^# /', $line))  continue;
            if (preg_match('/^## (?!\d)/', $line)) continue;

            // Section heading: ## 1. Introduction
            if (preg_match('/^## (\d+\..+)$/', $line, $m)) {
                if ($current) {
                    if ($currentSub) {
                        $current['subsections'][] = $currentSub;
                        $currentSub = null;
                    }
                    $sections[] = $current;
                }
                $current = [
                    'heading'     => trim($m[1]),
                    'subsections' => [],
                ];
                $currentSub = ['title' => '', 'blocks' => []];
                continue;
            }

            // Subsection heading: ### 3.1 How Engagements Begin
            if (preg_match('/^### (.+)$/', $line, $m)) {
                if ($currentSub && (!empty($currentSub['blocks']) || !empty($currentSub['title']))) {
                    $current['subsections'][] = $currentSub;
                }
                $currentSub = ['title' => trim($m[1]), 'blocks' => []];
                continue;
            }

            // Horizontal rule — skip
            if (preg_match('/^---+$/', $line)) continue;

            // Bullet item: - text or * text
            if (preg_match('/^[-*] (.+)$/', $line, $m)) {
                // Append to existing bullets block or start a new one
                $lastIdx = count($currentSub['blocks']) - 1;
                if ($lastIdx >= 0 && $currentSub['blocks'][$lastIdx]['type'] === 'bullets') {
                    $currentSub['blocks'][$lastIdx]['items'][] = $this->cleanInline(trim($m[1]));
                } else {
                    $currentSub['blocks'][] = [
                        'type'  => 'bullets',
                        'items' => [$this->cleanInline(trim($m[1]))],
                    ];
                }
                continue;
            }

            // Blockquote / note: > text
            if (preg_match('/^> (.+)$/', $line, $m)) {
                $currentSub['blocks'][] = [
                    'type'    => 'note',
                    'content' => $this->cleanInline(trim($m[1])),
                ];
                continue;
            }

            // Non-empty line = paragraph
            if ($line !== '' && $currentSub !== null) {
                $lastIdx = count($currentSub['blocks']) - 1;
                // Merge consecutive non-empty lines into one paragraph
                if ($lastIdx >= 0 && $currentSub['blocks'][$lastIdx]['type'] === 'paragraph') {
                    $currentSub['blocks'][$lastIdx]['content'] .= ' ' . $this->cleanInline($line);
                } else {
                    $currentSub['blocks'][] = [
                        'type'    => 'paragraph',
                        'content' => $this->cleanInline($line),
                    ];
                }
                continue;
            }
        }

        // Flush remaining
        if ($current) {
            if ($currentSub && (!empty($currentSub['blocks']) || !empty($currentSub['title']))) {
                $current['subsections'][] = $currentSub;
            }
            $sections[] = $current;
        }

        return ['sections' => $sections];
    }

    // Strip markdown bold/italic markers and clean up
    private function cleanInline(string $text): string
    {
        // Remove **bold** and *italic* markers
        $text = preg_replace('/\*\*(.+?)\*\*/', '$1', $text);
        $text = preg_replace('/\*(.+?)\*/', '$1',   $text);
        // Remove inline code backticks
        $text = preg_replace('/`(.+?)`/', '$1', $text);
        return $text;
    }
}
