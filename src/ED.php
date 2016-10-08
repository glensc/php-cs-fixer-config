<?php

namespace ED\CS\Config;

use Symfony\CS\Config\Config;
use Symfony\CS\FixerInterface;

class ED extends Config {
	protected $usingCache = false;

	public function __construct() {
		parent::__construct('ED', 'The configuration for ED PHP applications');

		$this->level = FixerInterface::NONE_LEVEL;
		$this->fixers = $this->getRules();

		$finder = $this->getFinder();

		// revert *.xml from DefaultFinder
		$finder
			->notPath('{^\.idea/.*\.xml$}');

		// because php-cs-fixer maintainers are idiots
		// https://github.com/FriendsOfPHP/PHP-CS-Fixer/issues/1027
		$finder
			->ignoreDotFiles(false)
			->name('.php_cs');
	}

	public function getRules() {
		return array(
			'controls_spaces',
			'-eof_ending',
			'function_declaration',
			'include',
			'linefeed',
			'php_closing_tag',
			'return',
			'trailing_spaces',
			'unused_use',
			'visibility',
			'elseif',
			'extra_empty_lines',
			'short_tag',
		);
	}
}
