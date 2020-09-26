<?php

namespace Eolica\NovaPillFilter\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

final class StubPublishCommand extends Command
{
    protected $signature = 'nova:pill-filter-stubs {--force : Overwrite any existing files}';

    protected $description = 'Publish all PillFilter package stubs that are available for customization';

    public function handle()
    {
        if (! is_dir($stubsPath = $this->laravel->basePath('stubs/nova'))) {
            (new Filesystem)->makeDirectory($stubsPath, 0755, true);
        }

        $files = [
            __DIR__.'/stubs/pill-filter.stub' => $stubsPath . '/pill-filter.stub',
        ];

        foreach ($files as $from => $to) {
            if (! file_exists($to) || $this->option('force')) {
                file_put_contents($to, file_get_contents($from));
            }
        }

        $this->info('Pill filter stubs published successfully.');
    }
}
