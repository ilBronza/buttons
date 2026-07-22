<?php

namespace IlBronza\Buttons\Tests;

use IlBronza\Buttons\ButtonsServiceProvider;
use IlBronza\UikitTemplate\UikitTemplate;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
	protected function getPackageProviders($app)
	{
		return [
			ButtonsServiceProvider::class
		];
	}

	protected function defineEnvironment($app)
	{
		$app['config']->set('app.locale', 'it');
		$app['config']->set('app.template', UikitTemplate::class);
		$app['config']->set('menu.childrenPerColumn', 8);
	}
}
