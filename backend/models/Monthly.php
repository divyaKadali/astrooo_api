<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "_monthly".
 *
 * @property int $month_id
 * @property string $rashi_name
 * @property string $description
 */
class Monthly extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gochaaram_monthly';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['month_id'], 'required'],
            [['month_id'], 'integer'],
            [['description'], 'string'],
            [['rashi_name'], 'string', 'max' => 60],
            [['month_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'month_id' => 'Month ID',
            'rashi_name' => 'Rashi Name',
            'description' => 'Description',
        ];
    }
}
