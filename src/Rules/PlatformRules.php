<?php

namespace ED\CS\Config\Rules;

use ED\CS\Config\PlatformVersion;
use ED\CS\Config\RuleBuilder;

class PlatformRules implements RuleInterface {
	/** @var PlatformVersion */
	private $platform;

	public function __construct($dir) {
		$this->platform = new PlatformVersion($dir);
	}

	/**
	 * @param RuleBuilder $builder
	 */
	public function apply(RuleBuilder $builder) {
		$builder['array_syntax'] = ['syntax' => $this->platform->satisfies('>=5.4') ? 'short' : 'long'];
	}
}
