<?php

namespace App\Console\Commands;

use App\Models\Program;
use Illuminate\Console\Command;
use Illuminate\Contracts\Http\Kernel as HttpKernel;
use Illuminate\Http\Request;

class PageCacheCommand extends Command
{
    protected $signature = 'pages:cache';

    protected $description = 'Pre-render public marketing pages to static HTML under public/_cache';

    protected array $clubSlugs = [
        'stem-club', 'brain-club', 'art-craft', 'leadership',
    ];

    public function handle(HttpKernel $httpKernel): int
    {
        $out = public_path('_cache');

        if (is_dir($out)) {
            $this->deleteTree($out);
        }

        @mkdir($out, 0775, true);

        $rendered = 0;
        foreach ($this->pages() as $rel) {
            $uri = $rel === '/' ? '' : ltrim($rel, '/');

            try {
                $request = Request::create(config('app.url').'/'.$uri, 'GET');
                $request->headers->set('Accept', 'text/html', true);

                $response = $httpKernel->handle($request);

                if ($response->getStatusCode() >= 500) {
                    $this->warn("Skipped {$rel} ({$response->getStatusCode()})");

                    continue;
                }

                $target = ($rel === '/' ? 'index' : $uri).'.html';
                $path = $out.'/'.$target;
                $dir = dirname($path);

                if (! is_dir($dir)) {
                    @mkdir($dir, 0775, true);
                }

                file_put_contents($path, $response->getContent());
                $rendered++;
                $this->info("Wrote /{$target} (".strlen($response->getContent()).' bytes)');
            } catch (\Throwable $e) {
                $this->warn("Failed {$rel}: ".$e->getMessage());
            }
        }

        if ($rendered === 0) {
            $this->error('No pages rendered — static cache left empty.');

            return Command::FAILURE;
        }

        $this->info("Static page cache complete ({$rendered} pages).");

        return Command::SUCCESS;
    }

    protected function pages(): array
    {
        $pages = ['/', '/about', '/pricing', '/programs', '/clubs'];

        foreach ($this->clubSlugs as $slug) {
            $pages[] = '/clubs/'.$slug;
        }

        foreach (Program::active()->pluck('slug') as $slug) {
            $pages[] = '/programs/'.$slug;
        }

        return $pages;
    }

    protected function deleteTree(string $dir): void
    {
        $items = scandir($dir);

        foreach ($items as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }

            $path = $dir.'/'.$item;

            if (is_dir($path)) {
                $this->deleteTree($path);
            } else {
                @unlink($path);
            }
        }

        @rmdir($dir);
    }
}
