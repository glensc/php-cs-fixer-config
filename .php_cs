<?php
# vim:ft=php

/** @var ED\CS\Config\ED $config */
$config = require __DIR__ . '/phpcs.php';

// get defaults
$rules = $config->getRules();
// add more rules
$rules['@PSR2'] = true;
// apply
$config->setRules($rules);

$finder = $config->getFinder();

// test data that must be scanned for fixes
$finder->notPath('tests/res');

return $config;
