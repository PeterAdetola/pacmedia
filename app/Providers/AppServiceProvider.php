<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use League\CommonMark\CommonMarkConverter;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // 1. Manually load helper if Composer's map hasn't updated on the server
        $helperFile = app_path('Helpers/AppHelpers.php');
        if (file_exists($helperFile)) {
            require_once($helperFile);
        }
    }

    public function boot(): void
    {
        // Using a static variable so we only parse Markdown ONCE per page load
        static $sharedData = null;

        View::composer('*', function ($view) use (&$sharedData) {
            if ($sharedData === null) {
                // ── Contact intro ─────────────────────────────────────────
                $contactRaw = file_get_contents(resource_path('markdown/contact.md'));
                $converter  = new CommonMarkConverter([
                    'html_input'         => 'strip',
                    'allow_unsafe_links' => false,
                ]);

                // ── Services ──────────────────────────────────────────────
                $servicesRaw = file_get_contents(resource_path('markdown/services.md'));
                $serviceBlocks = array_values(array_filter(
                    array_map('trim', preg_split('/^#\s+/m', $servicesRaw))
                ));

                $services = [];
                foreach ($serviceBlocks as $block) {
                    $lines = array_map('trim', explode("\n", $block));
                    $title = array_shift($lines);
                    $title = strip_tags($title, '<br>');

                    $icon = 'ph-cube'; $image = ''; $slug = ''; $descriptionLines = [];

                    foreach ($lines as $line) {
                        if (str_starts_with($line, 'icon:')) $icon = trim(str_replace('icon:', '', $line));
                        elseif (str_starts_with($line, 'image:')) $image = trim(str_replace('image:', '', $line));
                        elseif (str_starts_with($line, 'slug:')) $slug = trim(str_replace('slug:', '', $line));
                        elseif ($line !== '') $descriptionLines[] = $line;
                    }

                    $services[] = [
                        'title'       => $title,
                        'title_plain' => strip_tags(str_replace('<br>', ' ', $title)),
                        'description' => implode(' ', $descriptionLines),
                        'icon'        => $icon,
                        'image'       => $image,
                        'slug'        => $slug,
                    ];
                }

                $sharedData = [
                    'contactIntro' => $converter->convert($contactRaw),
                    'services'     => $services,
                    'lqip'         => $this->loadLqip(),
                ];
            }

            $view->with($sharedData);
        });

        Blade::component('layouts.admin', 'admin-layout');
    }

    private function loadLqip(): array
    {
        $lqip = [];
        $path = resource_path('views/partials/lqip.blade.php');

        if (!file_exists($path)) return $lqip;

        $raw = file_get_contents($path);
        $raw = preg_replace(['/@php/', '/@endphp/', '/\{\{--.*?--\}\}/s'], ['<?php', '?>', ''], $raw);

        // DirectAdmin tip: If sys_get_temp_dir is restricted,
        // this might fail. We use a try-catch or check permissions.
        try {
            $tmpFile = tempnam(sys_get_temp_dir(), 'lqip');
            file_put_contents($tmpFile, $raw);

            // The include scope will populate the $lqip array defined above
            include $tmpFile;

            if (file_exists($tmpFile)) unlink($tmpFile);
        } catch (\Exception $e) {
            // Fallback if temp files are blocked
            return [];
        }

        return $lqip;
    }
}
