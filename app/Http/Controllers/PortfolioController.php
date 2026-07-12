<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Contracts\View\View;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\FrontMatter\FrontMatterExtension;
use League\CommonMark\Extension\FrontMatter\Output\RenderedContentWithFrontMatter;
use League\CommonMark\MarkdownConverter;

class PortfolioController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Setup
    |--------------------------------------------------------------------------
    |
    | Markdown files: resources/markdown/works/{slug}.md
    | Images:         public/img/works/{slug}/
    |
    */
    private string $contentPath;
    private MarkdownConverter $converter;

    public function __construct()
    {
        $this->contentPath = resource_path('markdown/works');

        $environment = new Environment();
        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new FrontMatterExtension());

        $this->converter = new MarkdownConverter($environment);
    }


    /*
    |--------------------------------------------------------------------------
    | getCards()
    |--------------------------------------------------------------------------
    |
    | Called by HomeController::index() to build the homepage stack cards.
    |
    */
    public function getCards(): array
    {
        if (! File::isDirectory($this->contentPath)) {
            return [];
        }

        return collect(File::files($this->contentPath))
            ->filter(fn ($file) => $file->getExtension() === 'md')
            ->map(function ($file) {
                $result = $this->converter->convert(
                    File::get($file->getPathname())
                );

                $matter = $result instanceof RenderedContentWithFrontMatter
                    ? $result->getFrontMatter()
                    : [];

                $slug = $file->getFilenameWithoutExtension();

                return [
                    'slug'        => $slug,
                    'order'       => $matter['order']      ?? 99,
                    'title'       => $matter['title']      ?? $slug,
                    'card_service'        => $matter['card_service']  ?? null,
                    'industry'        => $matter['industry']  ?? null,
                    'url'         => route('portfolio.show', $slug),
                    'card_color'  => $matter['card_color'] ?? '#e0e0e0',
                    'card_image'  => isset($matter['card_image'])
                        ? asset($matter['card_image'])
                        : asset('img/works/' . $slug . '/card.webp'),
                    'card_video'  => isset($matter['card_video'])   // ← add this
                        ? asset($matter['card_video'])
                        : null,
                ];
            })
            ->sortBy('order')
            ->values()
            ->all();
    }


    /*
    |--------------------------------------------------------------------------
    | show()
    |--------------------------------------------------------------------------
    */
    public function show(string $slug): View
    {
        $path = resource_path("markdown/works/{$slug}.md");

        abort_if(! file_exists($path), 404);

        $raw     = file_get_contents($path);
        $project = $this->parseMarkdown($raw, $slug);

        $pageTitle = $project['title'];
        $pageIcon  = 'ph-briefcase';

        // OG meta for this project page
        $metaTitle = $project['title'] . ' — Pacmedia';

        // Prefer the pullquote (the assignment) over the problem-statement intro
        $metaDescription = $project['tagline'] ?? null;
        if (empty($metaDescription)) {
            foreach ($project['blocks'] as $block) {
                if ($block['type'] === 'brief' && !empty($block['pullquote'])) {
                    $metaDescription = $block['pullquote'];
                    break;
                }
            }
        }
        $metaDescription = $metaDescription ?? $project['brief_intro'] ?? null;

        // Case-insensitive card.jpg check (Linux servers are case-sensitive)
        $cardJpgPath = public_path('img/works/' . $slug . '/card.jpg');
        $cardJpgAlt  = public_path('img/works/' . $slug . '/card.JPG');
        $metaOgImage = (file_exists($cardJpgPath) || file_exists($cardJpgAlt))
            ? asset('img/works/' . $slug . '/card.jpg')
            : asset('img/og-image.jpg');

        return view('portfolio.show', compact(
            'project', 'pageTitle', 'pageIcon',
            'metaTitle', 'metaDescription', 'metaOgImage'
        ));
    }


    /*
    |--------------------------------------------------------------------------
    | parseMarkdown()
    |--------------------------------------------------------------------------
    |
    | Converts a case study .md file into the $project array the Blade needs.
    |
    | BLOCK TYPES produced in $project['blocks']:
    |
    |   brief    — ## Brief        → html (via commonmark), pullquote (optional)
    |   process  — ## Process      → html
    |   outcome  — ## Outcome      → html
    |   image    — ::image … ::    → src, caption, alt
    |   feedback — ## Feedback     → name, role, quote, avatar (optional)
    |   section  — any other ##    → label, html  (future-proofing)
    |
    */
    private function parseMarkdown(string $raw, string $slug): array
    {
        // ── 1. Use league/commonmark to extract frontmatter ───────────────────────
        $result      = $this->converter->convert($raw);
        $frontmatter = $result instanceof RenderedContentWithFrontMatter
            ? ($result->getFrontMatter() ?? [])
            : [];

        // Fallback: Symfony YAML (used internally by FrontMatterExtension) can
        // silently return null/empty when values contain em-dashes, ampersands,
        // or other special characters. If that happens, parse the --- block
        // ourselves with a simple line-by-line regex — sufficient for flat keys.
        if (empty($frontmatter) && str_contains($raw, '---')) {
            if (preg_match('/^---\s*\n(.*?)\n---/s', $raw, $fm)) {
                foreach (explode("\n", $fm[1]) as $line) {
                    if (preg_match('/^([\w_-]+):\s*"?([^"]*)"?\s*$/', trim($line), $m)) {
                        $frontmatter[trim($m[1])] = trim($m[2], '"\'');
                    }
                }
            }
        }

        // ── 2. Strip frontmatter block to get the raw body text ──────────────────
        $body = preg_replace('/^---\R.*?\R---\R/s', '', $raw) ?? $raw;
        $body = trim($body);

        // ── 3. Build $meta array for the metadata column ─────────────────────────
        $meta = array_filter([
            'Service'  => $frontmatter['service']  ?? null,
            'Client'   => $frontmatter['client']   ?? null,
            'Industry' => $frontmatter['industry'] ?? null,
            'Year'     => $frontmatter['year']      ?? null,
        ]);

        // ── 4. Parse body into ordered blocks ────────────────────────────────────
        $blocks = [];

        // Strip HTML comments (authoring notes)
        $body = preg_replace('/<!--.*?-->/s', '', $body);

        $lines        = explode("\n", $body);
        $currentH2    = null;
        $buffer       = [];
        $inImageBlock = false;
        $imageAttrs   = [];
        $inSisterBrand     = false;
        $sisterAttrs       = [];
        $sisterImageBuffer = [];
        $inSisterImage     = false;
        $sisterImageAttrs  = [];

        // Closure captures $this so we can use $this->converter for HTML conversion
        $flushSection = function () use (&$currentH2, &$buffer, &$blocks) {

            if ($currentH2 === null) return;

            $text = trim(implode("\n", $buffer));

            switch ($currentH2) {

                case 'brief':
                    $pullquote = null;
                    $subnote   = null;

                    // ── Pattern A: three-part --- separator structure ──────────
                    // lead paragraph
                    // ---
                    // The large display quote (blockquote scale)
                    // ---
                    // Smaller italic sub-note beneath the quote
                    if (str_contains($text, "\n---\n") || str_contains($text, "\n---")) {
                        $parts = preg_split('/\n---+\n?/', $text, 3);
                        $lead      = trim($parts[0] ?? '');
                        $pullquote = trim($parts[1] ?? '');
                        $subnote   = trim($parts[2] ?? '') ?: null;
                        $text      = $lead;
                    }
                    // ── Pattern B: legacy > blockquote line ───────────────────
                    elseif (preg_match('/^>\s+"?(.+?)"?\s*$/m', $text, $qm)) {
                        $pullquote = trim($qm[1], '"');
                        $text      = trim(preg_replace('/^>.*$/m', '', $text));
                    }

                    $blocks[] = [
                        'type'      => 'brief',
                        'html'      => $this->converter->convert($text)->getContent(),
                        'pullquote' => $pullquote,
                        'subnote'   => $subnote,
                    ];
                    break;

                case 'process':
                    $blocks[] = [
                        'type' => 'process',
                        'html' => $this->converter->convert($text)->getContent(),
                    ];
                    break;

                case 'outcome':
                    $blocks[] = [
                        'type' => 'outcome',
                        'html' => $this->converter->convert($text)->getContent(),
                    ];
                    break;

                case 'feedback':
                    // Feedback fields are plain  key: value  lines in the body section
                    $fb = [];
                    foreach (explode("\n", $text) as $fl) {
                        if (preg_match('/^(\w+):\s*"?(.+?)"?\s*$/', trim($fl), $fm)) {
                            $fb[trim($fm[1])] = trim($fm[2], '"\'');
                        }
                    }
                    if (! empty($fb)) {
                        $blocks[] = [
                            'type'   => 'feedback',
                            'name'   => $fb['name']   ?? '',
                            'role'   => $fb['role']   ?? '',
                            'quote'  => $fb['quote']  ?? '',
                            'avatar' => $fb['avatar'] ?? null,
                        ];
                    }
                    break;

                default:
                    // Future section types (e.g. ## Tech Stack) pass through here
                    if (! empty($text)) {
                        $blocks[] = [
                            'type'  => 'section',
                            'label' => ucfirst($currentH2),
                            'html'  => $this->converter->convert($text)->getContent(),
                        ];
                    }
            }

            $buffer    = [];
            $currentH2 = null;
        };

        foreach ($lines as $line) {

            // ── ::sister-brand open ───────────────────────────────
            if (preg_match('/^::sister-brand\s*$/', trim($line))) {
                $flushSection();
                $inSisterBrand     = true;
                $sisterAttrs       = [];
                $sisterImageBuffer = [];
                continue;
            }

            // ── ::end-sister-brand close ──────────────────────────
            if ($inSisterBrand && trim($line) === '::end-sister-brand') {
                $blocks[] = [
                    'type'           => 'sister-brand',
                    'name'           => $sisterAttrs['name']           ?? '',
                    'tagline'        => $sisterAttrs['tagline']        ?? '',
                    'year'           => $sisterAttrs['year']           ?? '',
                    'hero'           => $sisterAttrs['hero']           ?? '',
                    'hero_mobile'    => $sisterAttrs['hero_mobile']    ?? null,
                    'live_url'       => $sisterAttrs['live_url']       ?? null,
                    'live_url_label' => $sisterAttrs['live_url_label'] ?? 'Visit website',
                    'description'    => $sisterAttrs['description']    ?? '',
                    'colour_note'    => $sisterAttrs['colour_note']    ?? '',
                    'images'         => $sisterImageBuffer,
                ];
                $inSisterBrand = false;
                $sisterAttrs   = [];
                continue;
            }

            // ── Inside sister-brand: nested ::image open ──────────
            if ($inSisterBrand && preg_match('/^::image\s*$/', trim($line))) {
                $inSisterImage    = true;
                $sisterImageAttrs = [];
                continue;
            }

            // ── Inside sister-brand: nested ::image close ─────────
            if ($inSisterBrand && $inSisterImage && trim($line) === '::') {
                $src = $sisterImageAttrs['src'] ?? '';
                if (! empty($src)) {
                    $sisterImageBuffer[] = [
                        'src'     => trim($src),
                        'caption' => trim($sisterImageAttrs['caption'] ?? ''),
                        'alt'     => trim($sisterImageAttrs['alt'] ?? $sisterImageAttrs['caption'] ?? ''),
                    ];
                }
                $inSisterImage    = false;
                $sisterImageAttrs = [];
                continue;
            }

            // ── Inside sister-brand nested image: attr lines ──────
            if ($inSisterBrand && $inSisterImage) {
                if (preg_match('/^(\w+):\s*(.+)$/', trim($line), $km)) {
                    $sisterImageAttrs[$km[1]] = trim($km[2], '"\'');
                }
                continue;
            }

            // ── Inside sister-brand: top-level key: value lines ───
            if ($inSisterBrand) {
                if (preg_match('/^([\w_-]+):\s*"?(.+?)"?\s*$/', trim($line), $km)) {
                    $sisterAttrs[trim($km[1])] = trim($km[2], '"\'');
                }
                continue;
            }

            // ── ::image block open ────────────────────────────────
            if (preg_match('/^::image\s*$/', trim($line))) {
                $flushSection();
                $inImageBlock = true;
                $imageAttrs   = [];
                continue;
            }

            // ── ::image block close ───────────────────────────────
            if ($inImageBlock && trim($line) === '::') {
                $src     = $imageAttrs['src']     ?? '';
                $caption = $imageAttrs['caption'] ?? '';
                if (! empty($src)) {
                    $blocks[] = [
                        'type'    => 'image',
                        'src'     => trim($src),
                        'caption' => trim($caption),
                        'alt'     => trim($imageAttrs['alt'] ?? $caption),
                    ];
                }
                $inImageBlock = false;
                $imageAttrs   = [];
                continue;
            }

            // ── ::image attribute lines ───────────────────────────
            if ($inImageBlock) {
                if (preg_match('/^(\w+):\s*(.+)$/', trim($line), $km)) {
                    $imageAttrs[$km[1]] = trim($km[2], '"\'');
                }
                continue;
            }

            // ── ## section heading ────────────────────────────────
            if (preg_match('/^##\s+(.+)$/', $line, $hm)) {
                $flushSection();
                $currentH2 = strtolower(trim($hm[1]));
                continue;
            }

            $buffer[] = $line;
        }

        $flushSection(); // flush whatever is still open at end of file

        // ── 5. Derive brief_intro for the overview column ────────────────────────
        $briefIntro = null;
        foreach ($blocks as $block) {
            if ($block['type'] === 'brief') {
                $plain = trim(preg_replace('/\s+/', ' ', strip_tags($block['html'])));
                // Take up to first sentence break if text is long
                if (strlen($plain) > 180 && preg_match('/^(.{80,180}[.!?])\s/', $plain, $sm)) {
                    $briefIntro = $sm[1];
                } else {
                    $briefIntro = $plain;
                }
                break;
            }
        }

        // ── 6. Derive project index from filename sort order ─────────────────────
        $allSlugs = [];
        if (is_dir($this->contentPath)) {
            $files = glob($this->contentPath . '/*.md');
            sort($files);
            foreach ($files as $f) {
                $allSlugs[] = basename($f, '.md');
            }
        }
        $position = array_search($slug, $allSlugs);
        $index    = $position !== false
            ? str_pad($position + 1, 2, '0', STR_PAD_LEFT)
            : '01';

        // ── 7. Assemble and return $project ──────────────────────────────────────
        return [
            'slug'           => $slug,
            'title'          => $frontmatter['title']          ?? '',
            'type'           => $frontmatter['type']           ?? 'brand',
            'hero'           => $frontmatter['hero']           ?? '',
            'hero_mobile'    => $frontmatter['hero_mobile']    ?? null,  // ← add this
            'live_url'       => $frontmatter['live_url']       ?? null,
            'live_url_label' => $frontmatter['live_url_label'] ?? 'View Live',
            'card_color'     => $frontmatter['card_color']     ?? null,
            'card_image'     => $frontmatter['card_image']     ?? null,
            'overview'       => $frontmatter['overview']       ?? null,
            'brief_intro'    => $briefIntro,
            'meta'           => $meta,
            'blocks'         => $blocks,
            'stack'          => $frontmatter['stack']          ?? [],
            'index'          => $index,

            // Legacy keys — null-safe fallbacks so any old partials don't hard-crash
            'hero_landscape_url' => isset($frontmatter['hero']) ? asset($frontmatter['hero']) : null,
            'hero_portrait_url'  => null,
            'tagline'            => $frontmatter['tagline']    ?? null,
            'overview_html'      => null,
            'challenge_html'     => null,
            'process_html'       => null,
            'solution_html'      => null,
            'feedback'           => null,
            'sister_brand'       => null,
        ];
    }
}
