<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "gochaaram_daily".
 *
 * @property int $day_id
 * @property string $rashi_name
 * @property string $description
 */
class GochaaramDaily extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gochaaram_daily';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
       return [
            [['description'], 'string'],
            [['rashi_name'], 'string', 'max' => 60],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'day_id' => 'Day ID',
            'rashi_name' => 'Rashi Name',
            'description' => 'Description',
        ];
    }
}
