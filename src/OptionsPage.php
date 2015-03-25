<?php

namespace WCM\TermLimit;

class OptionsPage implements OptionsPageInterface
{
	/** @var string */
	private $page;

	public function __construct( $page )
	{
		$this->page = $page;
	}

	public function getPage()
	{
		return $this->page;
	}
}