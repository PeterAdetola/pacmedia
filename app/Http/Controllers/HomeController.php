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
        // PORTFOLIO — resources/markdown/works/
        // Format:
        //   Body paragraphs (markdown)
        //   ---
        //   Blockquote text
        //   ---
        //   Attribution paragraph
        // ------------------------------------------------

        $cards = (new PortfolioController)->getCards();

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
        // FAQS — single source: resources/markdown/faqs_page.md
        // Format:
        //   # Page Title|Subtitle
        //   ---
        //   SECTION NAME
        //   ---
        //   Question [home]   <- [home] tag optional, marks homepage inclusion
        //   Answer
        //   (repeat)
        // ------------------------------------------------
        $faqsRaw = file_get_contents(resource_path('markdown/faqs_page.md'));
        $faqParts = array_map('trim', explode('---', $faqsRaw));

        // First block is page title/subtitle
        $faqHeader = array_shift($faqParts);
        $faqHeaderLines = array_values(array_filter(array_map('trim', explode("\n", $faqHeader))));
        $faqPageTitle = str_replace('|', '<br>', ltrim($faqHeaderLines[0] ?? 'FAQs', '# '));

        $faqs = [];        // full page, grouped by section
        $homeFaqs = [];    // homepage subset only
        $currentSection = null;

        foreach ($faqParts as $block) {
            $lines = array_values(array_filter(array_map('trim', explode("\n", $block))));

            if (count($lines) === 0) {
                continue;
            }

            // Section headers are single-line blocks in ALL CAPS
            if (count($lines) === 1 && $lines[0] === strtoupper($lines[0])) {
                $currentSection = $lines[0];
                continue;
            }

            if (count($lines) >= 2) {
                $question = $lines[0];
                $isHome = false;

                if (str_ends_with($question, '[home]')) {
                    $isHome = true;
                    $question = trim(str_replace('[home]', '', $question));
                }

                $entry = [
                    'section'  => $currentSection,
                    'question' => $question,
                    'answer'   => implode(' ', array_slice($lines, 1)),
                ];

                $faqs[] = $entry;

                if ($isHome) {
                    $homeFaqs[] = $entry;
                }
            }
        }

        // ------------------------------------------------
        // CONTACT — resources/markdown/contact.md
        // Format: plain markdown paragraphs
        // ------------------------------------------------
        $contactRaw = file_get_contents(resource_path('markdown/contact.md'));
        $contactIntro = $this->converter->convert($contactRaw);
        $faqTitle = 'Are you<br>curious too?';
        $faqSubtitle = 'We have answers';

        return view('index', compact(
            'heroStatus',
            'heroTyped',
            'heroHeadline',
            'heroCta',
            'aboutBody',
            'aboutQuote',
            'aboutAttribution',
            'cards',
            'processTitle',
            'processes',
            'services',
            'faqTitle',
            'faqSubtitle',
            'homeFaqs',
            'contactIntro'
        ), ['isHomePage' => true]
        );
    }
}
