<?php

namespace IlBronza\Buttons\Helpers;

use IlBronza\Buttons\Button;
use IlBronza\CRUD\Models\BaseModel;

class DefaultButtonsCreatorHelper
{
	// static function getCreateButton(BaseModel $model) : Button
	// {
    //     return Button::create([
    //         'href' => $model->getCreateUrl(),
    //         'translatedText' => __('button::button.createNew', ['model' => __('models.' . get_class($model))]),
    //         'icon' => 'plus'
    //     ]);
	// }

	static function getEditButton(BaseModel $model) : Button
	{
        return Button::create([
            'href' => $model->getEditUrl(),
            'translatedText' => __('buttons::buttons.edit'),
            'icon' => 'pen'
        ]);
	}

	static function getShowButton(BaseModel $model) : Button
	{
        return Button::create([
            'href' => $model->getShowUrl(),
            'translatedText' => __('buttons::buttons.show'),
            'icon' => 'link'
        ]);
	}
}