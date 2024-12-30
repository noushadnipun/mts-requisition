<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class EloquentCreateCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'sam:eloquent';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new eloquent file';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Command to create eloquent';

    /**
     * Replace the class name for the given stub.
     *
     * @param string $stub
     * @param string $name
     * @return string
     */
    protected function replaceClass($stub, $name)
    {
        $stub = parent::replaceClass($stub, $name);

        return str_replace(['dummy:command', '{{ command }}'], $this->option('command'), $stub);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        $eloquentPath = '/stubs/eloquent.stub';

        return file_exists($customPath = $this->laravel->basePath(trim($eloquentPath, '/'))) ? $customPath : __DIR__ . $eloquentPath;
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Repositories';
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the class'],
//            ['modelname', InputArgument::REQUIRED, 'The name of the parent model'],
//            ['interface_name', InputArgument::REQUIRED, 'The name of the interface']
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['command', null, InputOption::VALUE_OPTIONAL, 'The terminal command that should be assigned', 'sam:eloquent'],
        ];
    }
}
