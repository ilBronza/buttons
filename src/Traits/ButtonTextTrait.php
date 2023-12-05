<?php

namespace IlBronza\Buttons\Traits;

trait ButtonTextTrait
{
	public function setShowText(bool $show) : static
	{
		$this->showText = $show;

		return $this;
	}

	public function getShowText()
	{
		if(isset($this->showText))
			return $this->showText;

		return true;
	}

	public function setText(string $text = null) : static
	{
		$this->text = $text;

		return $this;
	}

	public function setTranslatedText(string $translatedText = null)
	{
		$this->translatedText = $translatedText;
	}

	public function setEmptyText()
	{
		$this->setText();
		$this->setTranslatedText();
	}

	public function getText() : string
	{
		if($this->getShowText() === false)
			return '';

		if($this->translatedText)
			return $this->translatedText;

		if($this->text)
			return trans($this->text);

		return '';
	}
}