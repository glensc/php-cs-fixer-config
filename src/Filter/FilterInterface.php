<?php

namespace glen\PhpCsFixerConfig\Filter;

use Symfony\Component\Finder\Finder;

interface FilterInterface
{
    public function apply(Finder $finder);
}
