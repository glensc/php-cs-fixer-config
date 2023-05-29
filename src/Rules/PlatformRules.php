<?php

namespace glen\PhpCsFixerConfig\Rules;

use glen\PhpCsFixerConfig\PlatformVersion;
use glen\PhpCsFixerConfig\RuleBuilder;

class PlatformRules implements RuleInterface
{
    /** @var PlatformVersion */
    private $platform;

    public function __construct($dir)
    {
        $this->platform = new PlatformVersion($dir);
    }

    public function apply(RuleBuilder $builder)
    {
        $php54 = $this->platform->satisfies('>=5.4');
        $php70 = $this->platform->satisfies('>=7.0');
        $php71 = $this->platform->satisfies('>=7.1');

        $builder['array_syntax'] = ['syntax' => $php54 ? 'short' : 'long'];

        // "self::" accessor in closures requires php >= 5.4, not safe to always enable
        $builder['self_accessor'] = $php54;

        $builder['combine_nested_dirname'] = $php70;
        $builder['void_return'] = $php71;
       
        // visibility settings of class constans are available from php7.1+
        $builder['visibility_required'] = ['elements' => ['property', 'method']];
        if ($php71) {
            $builder['visibility_required']['elements'][] = 'const';  
        }
    }
}
