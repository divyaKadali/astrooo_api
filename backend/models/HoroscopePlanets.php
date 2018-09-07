<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "horoscope_planets".
 *
 * @property int $horoplanetId
 * @property int $horoscopeId
 * @property string $planet
 * @property string $digrees
 * @property string $strength
 * @property string $nakshatram
 */
class HoroscopePlanets extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	public $rashiId;
	public $lagnaRashi;
	public $lagnaLordinfo;
    public static function tableName()
    {
        return 'horoscope_planets';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
             // [['horoscopeId'], 'required'],
//              [['horoscopeId','userid'], 'integer'],
//              [['planet'], 'string', 'max' => 20],
//              [['digrees', 'strength', 'nakshatram','rashiname'], 'string', 'max' => 200],
        		[['rashiId',
        		 //'digrees','strength','nakshatram','shadbalam',
        		 'rashiname','navamsa_position'], 'required'],
        	    [['planet','digrees','strength','nakshatram','rashiname','userid','horoplanetId','shadbalam','navamsa_position','rashiId','lagnaRashi','lagnaLordinfo'], 'safe'],
    	
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'horoplanetId' => 'Horoplanet ID',
            'horoscopeId' => 'Horoscope ID',
            'planet' => 'Planet',
            'digrees' => 'Digrees',
            'strength' => 'Strength',
            'nakshatram' => 'Nakshatram',
        	'digrees' => 'Degrees',
        	'navamsa_position' => 'Navamsa Rashi',
        	'rashiId' => 'Lagna ',
        ];
    }
}
