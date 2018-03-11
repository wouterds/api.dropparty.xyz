<?php

namespace WouterDeSchuyter\DropParty\Application\Http;

use Jenssegers\Lean\SlimServiceProvider;
use WouterDeSchuyter\DropParty\Application\Http\Handlers\ExceptionHandler;
use WouterDeSchuyter\DropParty\Application\Http\Handlers\NotAllowedHandler;

class ServiceProvider extends SlimServiceProvider
{
    public function register()
    {
        parent::register();

        $this->container->share('errorHandler', function () {
            return $this->container->get(ExceptionHandler::class);
        });

        $this->container->share('phpErrorHandler', function () {
            return $this->container->get(ExceptionHandler::class);
        });

        $this->container->share('notAllowedHandler', function () {
            return $this->container->get(NotAllowedHandler::class);
        });
    }
}
