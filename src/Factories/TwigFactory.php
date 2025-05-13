<?php

namespace Chidori\Foundation\Factories;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

/**
 * Stores the resolve/setup logic for the Twig service.
 * It helps to keep the core clean by separating creation boilerplate from registering/calling logic.
 */
class TwigFactory implements FactoryInterface
{
    public function create(): Environment
    {
        $loader = new FilesystemLoader(__DIR__ . '/../../views');
        $twig = new Environment($loader, [
            'debug' => true, // Set to false in production
        ]);

        $twig->addFunction(new TwigFunction('asset', 'asset'));

        return $twig;
    }
}