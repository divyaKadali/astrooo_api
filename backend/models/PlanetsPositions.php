<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "planets_positions".
 *
 * @property int $ppId
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
class PlanetsPositions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'planets_positions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        	[['position_id'], 'required'],
            [['position_id'], 'integer'],
        	[['position_id'], 'unique'],
            [['Moon', 'Jupiter', 'Mercury', 'Sun', 'Mars', 'Venus', 'Saturn', 'Rahu', 'Ketu'], 'string'],
        	[['position_id','Moon', 'Jupiter', 'Mercury', 'Sun', 'Mars', 'Venus', 'Saturn', 'Rahu', 'Ketu'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ppId' => 'Pp ID',
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
