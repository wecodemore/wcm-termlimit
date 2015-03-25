<?php

namespace WCM\TermLimit;

class OptionsFieldBuilder
{
	/** @var Models\SettingsArgsInterface */
	private $args;

	/** @var SettingsViewInterface */
	private $view;

	/** @var OptionsSectionInterface */
	private $section;

	public function __construct(
		Models\SettingsArgsInterface $args,
		$template,
		$page,
		$section = 'default' )
	{
		$this->args    = $args;
		$this->section = new OptionsSection( new OptionsPage( $page ), $section );
		$this->view    = new SettingsView( $template );
	}

	public function build()
	{
		if ( $this->deny() )
			return;

		new SettingsField(
			new Models\SettingsField( $this->section, $this->args ),
			$this->view,
			function( $value )
			{
				return array_map( function( $value )
				{
					return filter_var_array( $value, [
						'min' => FILTER_VALIDATE_INT,
						'max' => FILTER_VALIDATE_INT,
					] );
				}, $value );
			}
		);
	}

	public function deny()
	{
		return (
			"options-{$this->section->getPage()}.php" !== $GLOBALS['pagenow']
			&& (
				(
					isset( $GLOBALS['pagenow'] )
					and 'options.php' !== $GLOBALS['pagenow']
				)
				or (
					isset( $_POST['action'] )
					and 'update' !== $_POST['action']
				)
				or (
					isset( $_POST['option_page'] )
					and $this->section->getPage() !== $_POST['option_page']
				)
			)
		);
	}
}