<?php

namespace ED\CS\Config;

use PhpCsFixer\Config;
use PhpCsFixer\RuleSet;

class ED extends Config {
	public function __construct() {
		parent::__construct();

		$this->setUsingCache(true);
		$this->setRiskyAllowed(true);
		$this->setRules($this->getDefaultRules());
		$this->applyFinderFilter(new Filter\GitFilter());
		$this->applyFinderFilter(new Filter\DefaultFilter());
	}

	/**
	 * Apply $filter to $finder instance.
	 *
	 * @param Filter\FilterInterface $filter
	 * @return $this
	 */
	protected function applyFinderFilter(Filter\FilterInterface $filter) {
		$filter->apply($this->getFinder());

		return $this;
	}

	/**
	 * @see RuleSet
	 * @return array
	 */
	public function getDefaultRules() {
		return array()
			+ $this->getSymfonyRules()
			+ $this->getRiskyRules()
			+ array(
				'blank_line_before_return' => true,
				'array_syntax' => array('syntax' => 'long'),
				'binary_operator_spaces' => array('align_double_arrow' => false),
				'function_declaration' => array('closure_function_spacing' => 'one'),
				'linebreak_after_opening_tag' => false,
				'method_argument_space' => array('keep_multiple_spaces_after_comma' => false),
				'no_multiline_whitespace_before_semicolons' => true,
				'no_short_echo_tag' => true,
				'no_useless_else' => true,
				'no_useless_return' => true,
				'ordered_imports' => true,
				'phpdoc_order' => true,
				'simplified_null_return' => false,
				'single_blank_line_before_namespace' => true,
				'strict_comparison' => false,
			);
	}

	/**
	 * Collection of Risky rules that are applied.
	 *
	 * @return array
	 */
	public function getRiskyRules() {
		return array(
			'ereg_to_preg' => true,
			'no_alias_functions' => true,
			'no_php4_constructor' => true,
		);
	}

	/**
	 * @return array
	 */
	public function getPSR2Rules() {
		return array(
			'@PSR2' => true,
			// PSR2 that conflicts with Delfi Standard
			'indentation_type' => false,
			'class_definition' => false,
		);
	}

	/**
	 * Suitable rules from @Symfony RuleSet.
	 *
	 * NOTE: Due the way PhpCsFixer loads rules,
	 * reusing getPSR2Rules method will not work here
	 *
	 * @see RuleSet
	 * @return array
	 */
	public function getSymfonyRules() {
		return array(
			'@Symfony' => true,

			// PSR2 that conflicts with Delfi Standard
			'indentation_type' => false,
			'class_definition' => false,

			// Rules from Symfony to invert
			'phpdoc_annotation_without_dot' => true,
			'phpdoc_indent' => true,
			'phpdoc_inline_tag' => true,
			'phpdoc_no_access' => true,
			'phpdoc_no_empty_return' => true,
			'phpdoc_no_package' => true,
			'phpdoc_scalar' => true,
			'phpdoc_single_line_var_spacing' => true,
			'phpdoc_trim' => true,
			'self_accessor' => true,
			'single_quote' => true,
			'standardize_not_equals' => true,
			'ternary_operator_spaces' => true,
			'trailing_comma_in_multiline_array' => true,
			'trim_array_spaces' => true,
			'whitespace_after_comma_in_array' => true,
			'yoda_style' => false,
			'phpdoc_separation' => false,
			'blank_line_after_opening_tag' => false,
			'concat_space' => array('spacing' => 'one'),
			'no_blank_lines_after_phpdoc' => false,
			'phpdoc_align' => false,
			'phpdoc_no_alias_tag' => array('type' => 'var', 'link' => 'see'),
			'phpdoc_summary' => false,
			'phpdoc_to_comment' => false,
			'braces' => false,
			'phpdoc_var_without_name' => false,
		);
	}
}
