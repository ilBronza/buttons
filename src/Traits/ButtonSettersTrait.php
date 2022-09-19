<?php

namespace IlBronza\Buttons\Traits;

use IlBronza\Buttons\Button;

trait ButtonSettersTrait
{
	public function setCount(float $count)
	{
		return $this->count = $count;
	}

	public function setId(string $id)
	{
		$this->id = $id;
	}

	public function getBrothers()
	{
		if($this->isChild())
			throw new \Exception('gestire i fratelli in caso di pulsante figlio');

		if(! $navbar = $this->getNavbar())
			throw new \Exception('No navbar present');

		return $navbar->getAllButtons()->filter(function (Button $button)
		{
			return $button->name != $this->name;
		});
	}

	public function setPosition(float $position)
	{
		$brothers = $this->getBrothers();

		foreach($brothers->where('position', '>=', $position) as $brother)
			$brother->increasePosition();

		$this->position = $position;
	}

	public function setFirst()
	{
		return $this->setPosition(0);
	}

	public function increasePosition()
	{
		$this->position ++;
	}
}