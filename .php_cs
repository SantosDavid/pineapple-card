<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude('Infrastructure/UI/Laravel/bootstrap/cache')
    ->in(__DIR__ . '/src');

return PhpCsFixer\Config::create()
    ->setFinder($finder);
