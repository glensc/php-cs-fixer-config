<?php

namespace ED\CS\Config\Rules;

use ED\CS\Config\RuleBuilder;

interface RuleInterface {
	/**
	 * @param RuleBuilder $builder
	 */
	public function apply(RuleBuilder $builder);
}
