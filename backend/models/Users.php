<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $roleId
 * @property int $created_at
 * @property int $updated_at
 */


class Users extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	public $first_name;
	public $last_name;
	public $dateofbirth;
	public $timeofbirth;
	public $placeofbirth;
	public $current_city;
	public $current_state;
	public $current_country;
	public $mobile;
	public $dasa_at_birth;
	public $password;
	public $confirmpassword;
	public $dasa_end_date;
	public $address;
	
	public $userid;
	public $deviceToken;
	public $deviceType;
	public $mobileDeviceToken;
	
	
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
          //  [['first_name', 'last_name','placeofbirth','current_city','current_state','current_country','mobile','dateofbirth','timeofbirth'], 'required'],
            [['username', 'email'], 'required'],
            [['status', 'roleId', 'created_at', 'updated_at'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username','email'], 'unique'],
            [['password_reset_token'], 'unique'],
        	[['mobileDeviceToken','deviceToken','deviceType','address','userid','first_name', 'last_name', 'placeofbirth', 'current_city', 'current_state', 'current_country','dateofbirth', 'dasa_at_birth','timeofbirth', 'mobile','password','confirmpassword','dasa_end_date'], 'safe'],
                [['password'], 'required' ,'on' =>'create'],
        		
                ['password', 'string', 'min' => 6],
        	[['confirmpassword'], 'compare', 'compareAttribute' => 'password'],
        	

        		
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'User Name',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'roleId' => 'Role ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        	'dasa_end_date' => 'Dasa End Date',
        		
        		
            'dateofbirth' => 'Date Of Birth',
            'timeofbirth' => 'Time Of Birth',
            'placeofbirth' => 'Place Of Birth',
        ];
    }
    
//     public function scenarios() {
//     	$scenarios = parent::scenarios();
//     	$scenarios['create'] = ['username','email','password','confirmpassword','first_name', 'last_name','placeofbirth','current_city','current_state','current_country','mobile','dateofbirth','timeofbirth'];//Scenario Values Only Accepted
//     	return $scenarios;
//     }
}
