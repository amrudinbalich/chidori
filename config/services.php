<?php

global $container;

$container->register(\Twig\Environment::class, fn () => (new \Chidori\Foundation\Factories\TwigFactory())->create());
