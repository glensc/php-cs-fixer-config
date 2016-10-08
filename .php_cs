<?php

$config = require __DIR__ . '/phpcs.php';
$config->getFinder()->in(__DIR__);

return $config;