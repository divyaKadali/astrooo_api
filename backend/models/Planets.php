<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "planets".
 *
 * @property int $planetId
 * @property string $planetName
 * @property string $direction
 * @property string $organs
 * @property string $diceases
 * @property string $gemStone
 * @property string $dhaanam
 * @property string $characterstic
 * @property string $kaaraka
 * @property int $createdBy
 * @property int $updatedBy
 * @property string $createdDate
 * @property string $updatedDate
 */
class Planets extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'planets';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['planetName', 'direction'
            		//, 'organs', 'diceases', 'gemStone', 'dhaanam', 'characterstic', 'kaaraka'
            		
            ], 'required'],
        	[['planetName', 'direction', 'organs', 'diceases', 'gemStone', 'dhaanam', 'characterstic', 'kaaraka','nature','careerPath',
        			'friend','neutral','enemy','ucha','neecha','sama','shatru','swakshetram','mitra'], 'safe'],
        		
        	/* [['organs', 'diceases', 'gemStone', 'dhaanam', 'characterstic', 'kaaraka','nature'], 'string'],
            [['createdBy', 'updatedBy'], 'integer'],
            [['createdDate', 'updatedDate'], 'safe'],
            [['planetName'], 'string', 'max' => 20],
            [['direction'], 'string', 'max' => 200], */
            [['planetName'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'planetId' => 'Planet ID',
            'planetName' => 'Planet Name',
            'direction' => 'Direction',
            'organs' => 'Organs',
            'diceases' => 'Diceases',
            'gemStone' => 'Gem Stone',
            'dhaanam' => 'Dhaanam',
            'characterstic' => 'Characterstic',
            'kaaraka' => 'Kaaraka',
        	'nature' => 'Nature',
            'createdBy' => 'Created By',
            'updatedBy' => 'Updated By',
            'createdDate' => 'Created Date',
            'updatedDate' => 'Updated Date',
        	'ucha' => 'Uccha_Raasi',
        	'sama' => 'Sama_Raasi',
        	'neecha' => 'Neecha_Raasi',
        	'shatru' => 'Shatru_Raasi',
        	'mitra' => 'Mitra_Raasi'
        ];
    }
}
