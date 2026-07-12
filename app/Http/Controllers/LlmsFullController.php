<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class LlmsFullController extends Controller
{
    public function index(): Response
    {
        $markdownPath = resource_path('markdown');

        // 1. Grab all .md files in the root of the markdown directory
        $files = File::glob($markdownPath . '/*.md');

        // 2. Optional: Custom sorting so important pages appear first
        $priorityOrder = ['hero', 'about', 'services', 'process'];

        usort($files, function ($a, $b) use ($priorityOrder) {
            $nameA = basename($a, '.md');
            $nameB = basename($b, '.md');

            $posA = array_search($nameA, $priorityOrder);
            $posB = array_search($nameB, $priorityOrder);

            $posA = $posA === false ? 999 : $posA;
            $posB = $posB === false ? 999 : $posB;

            if ($posA === $posB) {
                return strcmp($nameA, $nameB);
            }
            return $posA <=> $posB;
        });

        // 3. Initialize the LLM output header
        $output = "# Full Website Context & Documentation\n";
        $output .= "> This document compiles all core site pages and services into a single context stream optimized for LLMs.\n\n";
        $output .= "---\n\n";

        // 4. Loop through each file and append its content cleanly
        foreach ($files as $file) {
            $filename = basename($file, '.md');

            // Clean up titles (e.g., "service_brand-architecture" becomes "Service Brand Architecture")
            $cleanTitle = Str::of($filename)
                ->replace(['_', '-'], ' ')
                ->title();

            $content = File::get($file);

            // Append structured page markers for the AI
            $output .= "## Section: {$cleanTitle}\n";
            $output .= "\n\n";
            $output .= trim($content) . "\n\n";
            $output .= "---\n\n";
        }

        // 5. Return as a clean plain-text response
        return response($output, 200)
            ->header('Content-Type', 'text/plain; charset=UTF-8');
    }

    public function works(): Response
    {
        $worksPath = resource_path('markdown/works');
        $files = File::exists($worksPath) ? File::glob($worksPath . '/*.md') : [];

        $output = "# Portfolio & Project Case Studies\n\n---\n\n";

        foreach ($files as $file) {
            $filename = basename($file, '.md');
            $cleanTitle = Str::of($filename)->replace(['_', '-'], ' ')->title();

            $output .= "## Project: {$cleanTitle}\n";
            $output .= trim(File::get($file)) . "\n\n---\n\n";
        }

        return response($output, 200)->header('Content-Type', 'text/plain; charset=UTF-8');
    }
}
