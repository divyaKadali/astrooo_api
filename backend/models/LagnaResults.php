<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "lagna_results".
 *
 * @property int $lagnaresult_id
 * @property string $rashi_name
 * @property string $information
 */
class LagnaResults extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lagna_results';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['information'], 'string'],
            [['rashi_name'], 'string', 'max' => 60],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'lagnaresult_id' => 'Lagnaresult ID',
            'rashi_name' => 'Rashi Name',
            'information' => 'Information',
        ];
    }
}
