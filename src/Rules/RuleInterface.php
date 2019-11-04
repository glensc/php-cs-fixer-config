<?php

namespace glen\PhpCsFixerConfig\Rules;

use glen\PhpCsFixerConfig\RuleBuilder;

interface RuleInterface {
	public function apply(RuleBuilder $builder);
}
