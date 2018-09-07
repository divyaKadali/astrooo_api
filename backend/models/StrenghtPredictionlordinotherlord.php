<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "strenght_predictionlordinotherlord".
 *
 * @property int $splord_rasiid
 * @property string $lord
 * @property string $position1
 * @property string $position2
 * @property string $position3
 * @property string $position4
 * @property string $position5
 * @property string $position6
 * @property string $position7
 * @property string $position8
 * @property string $position9
 * @property string $position10
 * @property string $position11
 * @property string $position12
 */
class StrenghtPredictionlordinotherlord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'strenght_predictionlordinotherlord';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['position1', 'position2', 'position3', 'position4', 'position5', 'position6', 'position7', 'position8', 'position9', 'position10', 'position11', 'position12'], 'string'],
            [['lord'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'splord_rasiid' => 'Splord Rasiid',
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
