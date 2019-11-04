<?php

namespace glen\PhpCsFixerConfig;

use PhpCsFixer\Config as PhpCsFixerConfig;
use PhpCsFixer\Finder;

/**
 * @method Finder getFinder()
 */
class Config extends PhpCsFixerConfig
{
    /** @var RuleBuilder */
    private $ruleBuilder;

    public function __construct() {
        parent::__construct();

        $dir = ProjectRootDetector::detect();

        $this->ruleBuilder = new RuleBuilder();

        $this->setUsingCache(true);
        $this->setRiskyAllowed(true);

        $this->applyFinderFilter(new Filter\GitFilter($dir));
        $this->applyFinderFilter(new Filter\DefaultFilter());

        $this->applyRuleSet(new Rules\PlatformRules($dir));
        $this->applyRuleSet(new Rules\DefaultRules());
    }

    public function getRuleBuilder() {
        return $this->ruleBuilder;
    }

    public function getRules() {
        return $this->getRuleBuilder()->getRules();
    }

    /**
     * @deprecated
     * @return array
     */
    public function getDefaultRules() {
        return $this->getRules();
    }

    /**
     * Apply $filter to $finder instance.
     *
     * @return $this
     */
    protected function applyFinderFilter(Filter\FilterInterface $filter) {
        $filter->apply($this->getFinder());

        return $this;
    }

    /**
     * Apply $filter to $finder instance.
     *
     * @return $this
     */
    protected function applyRuleSet(Rules\RuleInterface $rules) {
        $rules->apply($this->ruleBuilder);

        return $this;
    }
}
