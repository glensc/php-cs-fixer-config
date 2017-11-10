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
			+ $this->getPSR2Rules()
			+ $this->getRiskyRules()
			+ $this->getSymfonyRules()
			+ array(
				'array_syntax' => array('syntax' => 'long'),
				'binary_operator_spaces' => array('align_double_arrow' => false),
				'braces' => false,
				'function_declaration' => array('closure_function_spacing' => 'one'),
				'linebreak_after_opening_tag' => false,
				'method_argument_space' => array('keep_multiple_spaces_after_comma' => false),
				'no_multiline_whitespace_before_semicolons' => true,
				'no_short_echo_tag' => true,
				'no_useless_else' => true,
				'no_useless_return' => true,
				'ordered_imports' => true,
				'phpdoc_order' => true,
				'semicolon_after_instruction' => true,
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
	 * @see RuleSet
	 * @return array
	 */
	public function getSymfonyRules() {
		return array(
			'blank_line_after_opening_tag' => false,
			'blank_line_before_return' => true,
			'cast_spaces' => false,
			'concat_space' => array('spacing' => 'one'),
			'include' => true,
			'new_with_braces' => true,
			'no_blank_lines_after_class_opening' => true,
			'no_blank_lines_after_phpdoc' => false,
			'no_empty_statement' => true,
			'no_extra_consecutive_blank_lines' => true,
			'no_leading_import_slash' => true,
			'no_leading_namespace_whitespace' => true,
			'no_mixed_echo_print' => array('use' => 'echo'),
			'no_multiline_whitespace_around_double_arrow' => true,
			'no_singleline_whitespace_before_semicolons' => true,
			'no_trailing_comma_in_list_call' => true,
			'no_trailing_comma_in_singleline_array' => true,
			'no_unused_imports' => true,
			'no_whitespace_before_comma_in_array' => true,
			'no_whitespace_in_blank_line' => true,
			'object_operator_without_whitespace' => true,
			'phpdoc_align' => false,
			'phpdoc_annotation_without_dot' => true,
			'phpdoc_indent' => true,
			'phpdoc_inline_tag' => true,
			'phpdoc_no_access' => false, // RemoteApi relies on these tags
			'phpdoc_no_alias_tag' => array('type' => 'var', 'link' => 'see'),
			'phpdoc_no_empty_return' => true,
			'phpdoc_no_package' => true,
			'phpdoc_scalar' => true,
			'phpdoc_separation' => false,
			'phpdoc_single_line_var_spacing' => true,
			'phpdoc_summary' => false,
			'phpdoc_to_comment' => false,
			'phpdoc_trim' => true,
			'self_accessor' => true,
			'single_quote' => true,
			'standardize_not_equals' => true,
			'ternary_operator_spaces' => true,
			'trailing_comma_in_multiline_array' => true,
			'trim_array_spaces' => true,
			'whitespace_after_comma_in_array' => true,
		);
	}
}
