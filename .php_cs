<?php
// vim:ft=php

/** @var ED\CS\Config\ED $config */
$config = require __DIR__ . '/phpcs.php';

$finder = $config->getFinder();

// test data that must be scanned for fixes
$finder->notPath('tests/res');

return $config;
