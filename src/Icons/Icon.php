<?php

namespace IlBronza\Buttons\Icons;

abstract class Icon
{
	public $code;

	abstract function render() : string;

	public function getCode() : string
	{
		return $this->code;
	}

	static function create(array $parameters) : static
	{
		$icon = new static;

		foreach($parameters as $key => $value)
			$icon->$key = $value;

		return $icon;
	}
}