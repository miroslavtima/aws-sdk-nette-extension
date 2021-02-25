<?php

/**
 * @copyright   Copyright (c) 2021 MT <tima.mirek@gmail.com>
 * @author      Miroslav Tima <tima.mirek@gmail.com>
 * @package     MT
 */

namespace MT\AwsSdkNetteExtension\DI;

use Nette;

class AwsSdkNetteExtension extends Nette\DI\CompilerExtension
{

	private $defaults = [
		'region' => NULL,
		'version' => 'latest',
		'credentials' => [
			'key' => NULL,
			'secret' => NULL
		]
	];

	/**
	 * @var array
	 */
	protected $config;


	/**
	 * @return void
	 */
	public function loadConfiguration()
	{
		$this->config = $this->_getConfig();
	}


	/**
	 * @return void
	 */
	public function beforeCompile()
	{
		$builder = $this->getContainerBuilder();
		$config = $this->config;

		$builder->addDefinition($this->prefix('aws'))
			->setType('Aws\Sdk')
			->setArguments([$config]);
	}


	/**
	 * @return array
	 */
	protected function _getConfig()
	{
        return $this->validateConfig($this->defaults, $this->config);
	}

}
