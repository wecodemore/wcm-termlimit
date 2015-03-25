<?php

namespace WCM\TermLimit;

use WCM\TermLimit\Models\SettingsArgsInterface;

/** @noinspection PhpInconsistentReturnPointsInspection */
class SettingsView implements SettingsViewInterface
{
	/** @var string|\WP_Error */
	private $template;

	/**
	 * @param string $template
	 */
	public function __construct( $template )
	{
		$this->template = ! file_exists( $template )
			? new \WP_Error( 'term-limit', 'A settings view needs a template' )
			: $template;
	}

	/**
	 * @param Models\SettingsArgsInterface $args
	 * @return int|void
	 */
	public function render( Models\SettingsArgsInterface $args )
	{
		if ( is_wp_error( $this->template ) )
			return print $this->template->get_error_message();

		/** @var $callback \Closure */
		$callback = function( $template )
		{
			extract( get_object_vars( $this ) );
			require $template;
		};
		call_user_func(
			$callback->bindTo( $args ),
			$this->template
		);
	}
}