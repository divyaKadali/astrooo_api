<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "_yearly".
 *
 * @property int $year_id
 * @property string $rashi_name
 * @property string $description
 */
class Yearly extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gochaaram_yearly';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['year_id'], 'required'],
            [['year_id'], 'integer'],
            [['description'], 'string'],
            [['rashi_name'], 'string', 'max' => 60],
            [['year_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'year_id' => 'Year ID',
            'rashi_name' => 'Rashi Name',
            'description' => 'Description',
        ];
    }
}
