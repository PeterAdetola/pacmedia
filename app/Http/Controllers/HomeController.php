<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use League\CommonMark\CommonMarkConverter;

class HomeController extends Controller
{
    protected CommonMarkConverter $converter;

    public function __construct()
    {
        $this->converter = new CommonMarkConverter([
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);
    }

    public function index()
    {
        // ------------------------------------------------
        // HERO — resources/markdown/hero.md
        // Format:
        //   Line 1–N : typed strings (one per line)
        //   ---
        //   Headline text
        //   ---
        //   CTA button text
        // ------------------------------------------------
        $heroRaw = file_get_contents(resource_path('markdown/hero.md'));
        $heroParts = array_map('trim', explode('---', $heroRaw));

        $heroStatus = $heroParts[0] ?? '● STATUS: FULLY DEPLOYED // NEW PROJECTS ON HOLD';
        $heroTyped = array_filter(array_map('trim', explode("\n", $heroParts[1] ?? '')));
        $heroHeadline = $heroParts[2] ?? 'Forging Digital Prestige';
        $heroCta = $heroParts[3] ?? 'Start Engagement →';


        // ------------------------------------------------
        // ABOUT — resources/markdown/about.md
        // Format:
        //   Body paragraphs (markdown)
        //   ---
        //   Blockquote text
        //   ---
        //   Attribution paragraph
        // ------------------------------------------------
        $aboutRaw = file_get_contents(resource_path('markdown/about.md'));
        $aboutParts = array_map('trim', explode('---', $aboutRaw));

        $aboutBody = $this->converter->convert($aboutParts[0] ?? '');
        $aboutQuote = $aboutParts[1] ?? '';
        $aboutAttribution = $aboutParts[2] ?? '';



        // ------------------------------------------------
        // PROCESS — resources/markdown/process.md
        // Format:
        //   Section title
        //   ---
        //   Step Title
        //   Step Subtitle
        //   Step Description
        //   ---
        //   (repeat for each step)
        // ------------------------------------------------
        $processRaw = file_get_contents(resource_path('markdown/process.md'));
        $processParts = array_map('trim', explode('---', $processRaw));

        $processTitle = $processParts[0] ?? 'Our Mode of Operation';

        $processes = [];
        for ($i = 1; $i < count($processParts); $i++) {
            $lines = array_values(array_filter(
                array_map('trim', explode("\n", $processParts[$i]))
            ));
            if (count($lines) >= 3) {
                $processes[] = [
                    'title' => $lines[0],
                    'subtitle' => $lines[1],
                    'description' => implode(' ', array_slice($lines, 2)),
                ];
            }
        }

        // ------------------------------------------------
        // SERVICES — resources/markdown/services.md
        // Format:
        //   # Service Title
        //   Description text
        //   icon: ph-cube
        //   image: VIdentityArch.png
        //   (repeat for each service)
        // ------------------------------------------------
        $servicesRaw = file_get_contents(resource_path('markdown/services.md'));

        $serviceBlocks = array_values(array_filter(
            array_map('trim', preg_split('/^#\s+/m', $servicesRaw))
        ));

        $services = [];
        foreach ($serviceBlocks as $block) {
            $lines = array_map('trim', explode("\n", $block));
            $title = array_shift($lines);
            $title = strip_tags($title, '<br>');

            $icon  = 'ph-cube';
            $image = '';
            $slug  = '';
            $descriptionLines = [];

            foreach ($lines as $line) {
                if (str_starts_with($line, 'icon:')) {
                    $icon = trim(str_replace('icon:', '', $line));
                } elseif (str_starts_with($line, 'image:')) {
                    $image = trim(str_replace('image:', '', $line));
                } elseif (str_starts_with($line, 'slug:')) {
                    $slug = trim(str_replace('slug:', '', $line));
                } elseif ($line !== '') {
                    $descriptionLines[] = $line;
                }
            }

            $services[] = [
                'title'       => $title,
                'description' => implode(' ', $descriptionLines),
                'icon'        => $icon,
                'image'       => $image,
                'slug'        => $slug,
            ];
        }

        // ------------------------------------------------
        // FAQS — resources/markdown/faqs.md
        // Format:
        //   # Section Title
        //   ## Subtitle
        //   ---
        //   Question
        //   Answer
        //   (repeat)
        // ------------------------------------------------
                $faqsRaw = file_get_contents(resource_path('markdown/faqs.md'));
                $faqParts = array_map('trim', explode('---', $faqsRaw));

        // First block contains title and subtitle
                $faqHeader = array_shift($faqParts);
                $faqHeaderLines = array_values(array_filter(
                    array_map('trim', explode("\n", $faqHeader))
                ));
                $faqTitle = str_replace('|', '<br>', ltrim($faqHeaderLines[0] ?? 'FAQs', '# '));
                $faqSubtitle = ltrim($faqHeaderLines[1] ?? '', '## ');

        // Remaining blocks are question/answer pairs
                $faqs = [];
                foreach ($faqParts as $block) {
                    $lines = array_values(array_filter(
                        array_map('trim', explode("\n", $block))
                    ));
                    if (count($lines) >= 2) {
                        $faqs[] = [
                            'question' => $lines[0],
                            'answer'   => implode(' ', array_slice($lines, 1)),
                        ];
                    }
                }

        // ------------------------------------------------
        // CONTACT — resources/markdown/contact.md
        // Format: plain markdown paragraphs
        // ------------------------------------------------
        $contactRaw = file_get_contents(resource_path('markdown/contact.md'));
        $contactIntro = $this->converter->convert($contactRaw);

        return view('index', compact(
            'heroStatus',
            'heroTyped',
            'heroHeadline',
            'heroCta',
            'aboutBody',
            'aboutQuote',
            'aboutAttribution',
            'processTitle',
            'processes',
            'services',
            'faqTitle',
            'faqSubtitle',
            'faqs',
            'contactIntro'
        ), ['isHomePage' => true]
        );
    }
}
