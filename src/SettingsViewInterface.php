<?php

namespace WCM\TermLimit;

/**
 * Interface SettingsViewInterface
 * @package WCM\TermLimit
 */
interface SettingsViewInterface
{
	/**
	 * @param Models\SettingsArgsInterface $args
	 * @return int|void
	 */
	public function render( Models\SettingsArgsInterface $args );
}