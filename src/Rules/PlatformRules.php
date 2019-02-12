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
		$php54 = $this->platform->satisfies('>=5.4');

		$builder['array_syntax'] = ['syntax' => $php54 ? 'short' : 'long'];

		// "self::" accessor in closures requires php >= 5.4, not safe to always enable
		$builder['self_accessor'] = $php54;
	}
}
