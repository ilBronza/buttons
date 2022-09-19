<?php

namespace IlBronza\Buttons\Traits;

trait ButtonTextTrait
{
	public function setText(string $text = null)
	{
		$this->text = $text;
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
		if($this->translatedText)
			return $this->translatedText;

		if($this->text)
			return trans($this->text);

		return '';
	}
}