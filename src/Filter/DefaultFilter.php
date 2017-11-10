<?php

namespace ED\CS\Config\Filter;

use Symfony\Component\Finder\Finder;

/**
 * Implements default finder configuration
 */
class DefaultFilter implements FilterInterface
{
    /**
     * {@inheritdoc}
     */
    public function apply(Finder $finder)
    {
        $ds = preg_quote(DIRECTORY_SEPARATOR, '/');

        // revert *.xml from DefaultFinder
        $finder
            ->notPath("{^\.idea{$ds}.+\.xml$}");

        // ignore config/envSpecific
        $finder
            ->notPath("#^config{$ds}envSpecific{$ds}.+$#");

        // unhide dot files, include .php_cs fixer config itself
        // because php-cs-fixer maintainers are idiots
        // https://github.com/FriendsOfPHP/PHP-CS-Fixer/issues/1027
        $finder
            ->ignoreDotFiles(false)
            ->name('.php_cs');
    }
}
