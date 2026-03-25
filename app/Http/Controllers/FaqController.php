<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $raw = file_get_contents(resource_path('markdown/faqs_page.md'));
        $parts = array_map('trim', explode('---', $raw));

        // First block — title and subtitle
        $headerLines = array_values(array_filter(
            array_map('trim', explode("\n", array_shift($parts)))
        ));
        $faqTitle    = str_replace('|', '<br>', ltrim($headerLines[0] ?? 'FAQs', '# '));
        $faqSubtitle = ltrim($headerLines[1] ?? '', '## ');

        // Remaining blocks — group headings and Q&A pairs
        $groups  = [];
        $current = null;

        foreach ($parts as $block) {
            $lines = array_values(array_filter(
                array_map('trim', explode("\n", $block))
            ));

            if (empty($lines)) continue;

            // If block is a single line with no answer — it's a group heading
            if (count($lines) === 1) {
                $current = $lines[0];
                if (!isset($groups[$current])) {
                    $groups[$current] = [];
                }
            } elseif (count($lines) >= 2) {
                $question = $lines[0];
                $answer   = implode(' ', array_slice($lines, 1));
                if ($current) {
                    $groups[$current][] = [
                        'question' => $question,
                        'answer'   => $answer,
                    ];
                }
            }
        }

        return view('faqs', compact('faqTitle', 'faqSubtitle', 'groups'), [
            'isHomePage' => false,
            'pageTitle'  => 'FAQs',
            'pageIcon'   => 'ph ph-chats',
        ]);
    }
}
