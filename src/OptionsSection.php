<?php

namespace WCM\TermLimit;

class OptionsSection implements OptionsSectionInterface
{
	/** @var OptionsPageInterface */
	private $page;

	/** @var string */
	private $section;

	public function __construct( OptionsPageInterface $page, $section_id )
	{
		$this->page    = $page;
		$this->section = $section_id;
	}

	public function getSection()
	{
		return $this->section;
	}

	public function getPage()
	{
		return $this->page->getPage();
	}
}