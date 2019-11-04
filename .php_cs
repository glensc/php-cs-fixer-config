<?php
// vim:ft=php

/** @var \glen\PhpCsFixerConfig\Config $config */
$config = require __DIR__ . '/phpcs.php';

$finder = $config->getFinder();

// test data that must be scanned for fixes
$finder->notPath('tests/res');

return $config;
