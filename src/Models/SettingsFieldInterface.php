<?php

namespace WCM\TermLimit\Models;

/**
 * Interface SettingsFieldInterface
 * @package WCM\TermLimit\Models
 */
interface SettingsFieldInterface
{
	public function getPage();
	public function getSection();
	public function getArgs();
}