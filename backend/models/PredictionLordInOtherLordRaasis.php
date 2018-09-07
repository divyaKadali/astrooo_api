<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "prediction_lord_in_other_lord_raasis".
 *
 * @property int $plord_rasiid
 * @property string $lord
 * @property int $position1
 * @property int $position2
 * @property int $position3
 * @property int $position4
 * @property int $position5
 * @property int $position6
 * @property int $position7
 * @property int $position8
 * @property int $position9
 * @property int $position10
 * @property int $position11
 * @property int $position12
 */
class PredictionLordInOtherLordRaasis extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'prediction_lord_in_other_lord_raasis';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['position1', 'position2', 'position3', 'position4', 'position5', 'position6', 'position7', 'position8', 'position9', 'position10', 'position11', 'position12'], 'safe'],
            [['lord'], 'string', 'max' => 20],
        	[['lord'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'plord_rasiid' => 'Plord Rasiid',
            'lord' => 'Lord',
            'position1' => 'Position1',
            'position2' => 'Position2',
            'position3' => 'Position3',
            'position4' => 'Position4',
            'position5' => 'Position5',
            'position6' => 'Position6',
            'position7' => 'Position7',
            'position8' => 'Position8',
            'position9' => 'Position9',
            'position10' => 'Position10',
            'position11' => 'Position11',
            'position12' => 'Position12',
        ];
    }
}
