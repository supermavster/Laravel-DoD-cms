<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ModelMakeCommand extends Command
{
    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return "{$rootNamespace}\Models";
    }
}
