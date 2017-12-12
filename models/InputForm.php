<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * InputForm.
 */
class InputForm extends Model
{
    public $body;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['body'], 'required'],
        ];
    }
}
