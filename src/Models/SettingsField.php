<?php

namespace WCM\TermLimit\Models;

use WCM\TermLimit\OptionsPageInterface;
use WCM\TermLimit\OptionsSectionInterface;

/**
 * Class SettingsField
 * @package WCM\TermLimit\Models
 */
class SettingsField implements SettingsFieldInterface
{
	/** @var OptionsSectionInterface */
	private $section;

	/** @var \ArrayAccess | SettingsArgsInterface */
	private $args;

	/**
	 * @param OptionsSectionInterface $section
	 * @param SettingsArgsInterface   $args
	 */
	public function __construct(
		OptionsSectionInterface $section,
		SettingsArgsInterface $args
		)
	{
		$this->section = $section;
		$this->args    = $args;
	}

	public function getPage()
	{
		return $this->section->getPage();
	}

	public function getSection()
	{
		return $this->section->getSection();
	}

	public function getArgs()
	{
		return $this->args;
	}
}