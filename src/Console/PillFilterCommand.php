<?php

namespace Eolica\NovaPillFilter\Console;

use Illuminate\Console\GeneratorCommand;

final class PillFilterCommand extends GeneratorCommand
{
    protected $name = 'nova:pill-filter';

    protected $description = 'Create a new pill filter class';

    protected $type = 'PillFilter';

    protected function getStub()
    {
        $stub = '/stubs/nova/pill-filter.stub';

        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__ . str_replace('nova/', '', $stub);
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Nova\Filters';
    }
}
