<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user_details".
 *
 * @property int $userdetailid
 * @property int $userId
 * @property string $first_name
 * @property string $last_name
 * @property string $dateofbirth
 * @property string $timeofbirth
 * @property string $placeofbirth
 * @property string $current_city
 * @property string $current_state
 * @property string $current_country
 * @property string $mobile
 * @property string $dasa_at_birth
 */
class UserDetails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	public $username;
	public $email;
    public static function tableName()
    {
        return 'user_details';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        	[['first_name', 'last_name', 'placeofbirth', 'current_city', 'current_state', 'current_country','dasa_end_date','username','email'], 'safe'],
            /* [['userdetailid'], 'required'],
            [['userdetailid', 'userId'], 'integer'],
            [['dateofbirth', 'dasa_at_birth'], 'safe'],            
            [['timeofbirth', 'mobile'], 'string', 'max' => 20], */
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'userdetailid' => 'User Detail Id',
            'userId' => 'User ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'dateofbirth' => 'Date Of Birth',
            'timeofbirth' => 'Time Of Birth',
            'placeofbirth' => 'Place Of Birth',
            'current_city' => 'Current City',
            'current_state' => 'Current State',
            'current_country' => 'Current Country',
            'mobile' => 'Mobile',
            'dasa_at_birth' => 'Dasa At Birth',
        	'dasa_end_date' => 'Dasa End Date',
        ];
    }
}
