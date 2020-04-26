<?php

namespace glen\PhpCsFixerConfig;

use PhpCsFixer\Config as PhpCsFixerConfig;
use PhpCsFixer\Console\Application;
use PhpCsFixer\Finder;

/**
 * @method Finder getFinder()
 */
class Config extends PhpCsFixerConfig
{
    /** @var RuleBuilder */
    private $ruleBuilder;

    /** @var string */
    private $projectRoot;

    public function __construct()
    {
        parent::__construct();

        $this->projectRoot = ProjectRootDetector::detect();
        $this->ruleBuilder = new RuleBuilder();

        $this->setCacheFile($this->getCacheFile());
        $this->setUsingCache(true);
        $this->setRiskyAllowed(true);

        $this->applyFinderFilter(new Filter\GitFilter($this->projectRoot));
        $this->applyFinderFilter(new Filter\DefaultFilter());

        $this->configure();
    }

    /**
     * Method called from constructor to do extra configuration.
     * To be overridden by a subclass.
     */
    protected function configure() {
        $this->applyRuleSet(new Rules\DefaultRules());
        $this->applyRuleSet(new Rules\PlatformRules($this->projectRoot));
    }

    public function getProjectRoot()
    {
        return $this->projectRoot;
    }

    public function getCacheFile() {
        return sprintf('%s/vendor/php_cs-%s.cache', $this->projectRoot, Application::VERSION);
    }

    public function getRuleBuilder()
    {
        return $this->ruleBuilder;
    }

    public function getRules()
    {
        return $this->getRuleBuilder()->getRules();
    }

    /**
     * @return array
     * @deprecated
     */
    public function getDefaultRules()
    {
        return $this->getRules();
    }

    /**
     * Apply $filter to $finder instance.
     *
     * @return $this
     */
    protected function applyFinderFilter(Filter\FilterInterface $filter)
    {
        $filter->apply($this->getFinder());

        return $this;
    }

    /**
     * Apply $filter to $finder instance.
     *
     * @return $this
     */
    protected function applyRuleSet(Rules\RuleInterface $rules)
    {
        $rules->apply($this->ruleBuilder);

        return $this;
    }
}
