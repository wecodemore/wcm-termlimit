<?php

namespace WCM\TermLimit;

class SettingsField
{
	/** @var Models\SettingsArgsInterface */
	private $args;

	/** @var Models\SettingsFieldInterface */
	private $setting;

	/** @var SettingsViewInterface */
	private $view;

	/** @var \Closure */
	private $sanitize;

	/**
	 * @throws \InvalidArgumentException
	 * @param Models\SettingsFieldInterface $setting
	 * @param SettingsViewInterface         $view
	 * @param callable                      $sanitize
	 */
	public function __construct(
		Models\SettingsFieldInterface $setting,
		SettingsViewInterface $view,
		\Closure $sanitize
		)
	{
		$this->args     = $setting->getArgs();
		$this->setting  = $setting;
		$this->view     = $view;
		$this->sanitize = $sanitize;

		$this->register();
		$this->add();
	}

	private function register()
	{
		register_setting(
			$this->setting->getPage(),
			$this->args->getID(),
			$this->sanitize
		);
	}

	private function add()
	{
		add_settings_field(
			$this->args->getID(),
			$this->args->getLabel(),
			[ $this->view, 'render' ],
			$this->setting->getPage(),
			$this->setting->getSection(),
			$this->setting->getArgs()
		);
	}
}