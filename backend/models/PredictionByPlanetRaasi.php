<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "prediction_by_planet_raasi".
 *
 * @property int $pprId
 * @property int $position_id
 * @property string $Moon
 * @property string $Jupiter
 * @property string $Mercury
 * @property string $Sun
 * @property string $Mars
 * @property string $Venus
 * @property string $Saturn
 * @property string $Rahu
 * @property string $Ketu
 */
class PredictionByPlanetRaasi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'prediction_by_planet_raasi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['position_id'], 'integer'],
        	[['position_id'], 'required'],
            [['Moon', 'Jupiter', 'Mercury', 'Sun', 'Mars', 'Venus', 'Saturn', 'Rahu', 'Ketu'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pprId' => 'Ppr ID',
            'position_id' => 'Position ID',
            'Moon' => 'Moon',
            'Jupiter' => 'Jupiter',
            'Mercury' => 'Mercury',
            'Sun' => 'Sun',
            'Mars' => 'Mars',
            'Venus' => 'Venus',
            'Saturn' => 'Saturn',
            'Rahu' => 'Rahu',
            'Ketu' => 'Ketu',
        ];
    }
}
