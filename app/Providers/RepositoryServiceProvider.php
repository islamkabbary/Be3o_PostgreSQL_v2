<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $interfacesPath = app_path('Interfaces');
        $repositoriesPath = app_path('Repositories');

        foreach (glob($interfacesPath . '/*.php') as $file) {
            $interface = 'App\\Interfaces\\' . basename($file, '.php');

            $repositoryName = Str::replaceLast('Interface', '', class_basename($interface));

            $repository = 'App\\Repositories\\' . $repositoryName;

            if (interface_exists($interface) && class_exists($repository)) {
                $this->app->bind($interface, $repository);
            }
        }
    }
}

