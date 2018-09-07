<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "bhava_details".
 *
 * @property int $bhavadetails_id
 * @property string $bhava_name
 * @property string $information
 */
class BhavaDetails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bhava_details';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['information'], 'string'],
            [['bhava_name'], 'string', 'max' => 60],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'bhavadetails_id' => 'Bhavadetails ID',
            'bhava_name' => 'Bhava Name',
            'information' => 'Information',
        ];
    }
}
