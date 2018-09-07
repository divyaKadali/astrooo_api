<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "daily_planets".
 *
 * @property int $dpId
 * @property string $planet_date
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
class DailyPlanets extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	public $file;
	public $userid;
    public static function tableName()
    {
        return 'daily_planets';
    }
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        	[['planet_date'], 'required'],
            [['planet_date','userid'], 'safe'],
        	[['planet_date'], 'unique','targetClass' => '\backend\models\DailyPlanets', 'message' => 'This planet Date has already been taken.','on' =>'create'],
            [['Moon', 'Jupiter', 'Mercury', 'Sun', 'Mars', 'Venus', 'Saturn', 'Rahu', 'Ketu'], 'string'],
       		[['Ketu'],'safe'],
        		[['file'],'required','on'=>'upload'],
            [['file'],'file','extensions'=>'csv','maxSize'=>1024 * 1024 * 5],
        		
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'dpId' => 'Dp ID',
            'planet_date' => 'Planet Date',
            'Moon' => 'Moon',
            'Jupiter' => 'Jupiter',
            'Mercury' => 'Mercury',
            'Sun' => 'Sun',
            'Mars' => 'Mars',
            'Venus' => 'Venus',
            'Saturn' => 'Saturn',
            'Rahu' => 'Rahu',
            'Ketu' => 'Ketu',
        	'file'=>'Select File',
        ];
    }
}
