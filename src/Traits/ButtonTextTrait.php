<?php

namespace IlBronza\Buttons\Traits;

trait ButtonTextTrait
{
    /**
     * Set whether the button text should be visible.
     *
     * @param bool $show True to show the text, false to hide it.
     * @return static
     */
	public function setShowText(bool $show) : static
	{
		$this->showText = $show;

		return $this;
	}

    /**
     * Get whether the button text is set to be visible.
     *
     * @return bool True if the text is visible, false otherwise.
     */
	public function getShowText()
	{
		if(isset($this->showText))
			return $this->showText;

		return true;
	}

    /**
     * Set the base text of the button.
     *
     * @param string|null $text The text to display.
     * @return static
     */
	public function setText(string $text = null) : static
	{
		$this->text = $text;

		return $this;
	}

    /**
     * Set a translated string to display as the button text.
     *
     * @param string|null $translatedText The translated text.
     * @return void
     */
	public function setTranslatedText(string $translatedText = null)
	{
		$this->translatedText = $translatedText;
	}

    /**
     * Set an empty text for the button.
     *
     * @return void
     */
	public function setEmptyText()
	{
		$this->setText();
		$this->setTranslatedText();
	}

    /**
     * Retrieve the current text to display on the button.
     * If text visibility is disabled, returns an empty string.
     * If a translated text is set, it will be returned.
     * Otherwise, it attempts to translate the base text.
     *
     * @return string
     */
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