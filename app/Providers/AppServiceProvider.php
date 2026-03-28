<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {

            // ── Contact intro ─────────────────────────────────────────
            $contactRaw  = file_get_contents(resource_path('markdown/contact.md'));
            $converter   = new \League\CommonMark\CommonMarkConverter([
                'html_input'         => 'strip',
                'allow_unsafe_links' => false,
            ]);
            $view->with('contactIntro', $converter->convert($contactRaw));

            // ── Services ──────────────────────────────────────────────
            // Parsed once and shared with every view so service links
            // can be rendered in the footer, nav, or anywhere else
            // without repeating this logic in individual controllers.
            $servicesRaw = file_get_contents(resource_path('markdown/services.md'));

            $serviceBlocks = array_values(array_filter(
                array_map('trim', preg_split('/^#\s+/m', $servicesRaw))
            ));

            $services = [];
            foreach ($serviceBlocks as $block) {
                $lines = array_map('trim', explode("\n", $block));
                $title = array_shift($lines);
                $title = strip_tags($title, '<br>');

                $icon             = 'ph-cube';
                $image            = '';
                $slug             = '';
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
                    'title_plain' => strip_tags(str_replace('<br>', ' ', $title)), // ← add this
                    'description' => implode(' ', $descriptionLines),
                    'icon'        => $icon,
                    'image'       => $image,
                    'slug'        => $slug,
                ];
            }

            $view->with('services', $services);
        });
    }
}
