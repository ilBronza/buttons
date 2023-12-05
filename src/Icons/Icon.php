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

	public function setCode(string $code) : static
	{
		$this->code = $code;

		return $this;
	}

	static function create(array $parameters) : self
	{
		$icon = new static;

		foreach($parameters as $key => $value)
			$icon->$key = $value;

		return $icon;
	}
}