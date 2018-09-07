<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "astro_device_info".
 *
 * @property int $dev_id
 * @property string $deviceToken
 * @property string $mobileDeviceToken
 * @property string $deviceType
 * @property double $lat
 * @property double $lng
 * @property int $notification_status
 * @property int $uId
 * @property string $createdDate
 * @property string $modifiedDate
 * @property string $city
 * @property string $stateCode
 * @property string $stateName
 * @property string $countryName
 * @property string $countryCode
 * @property string $zipCode
 * @property int $state
 * @property int $country
 */
class AstroDeviceInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'astro_device_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['deviceToken', 'mobileDeviceToken'], 'string'],
            [['lat', 'lng'], 'number'],
            [['notification_status', 'uId', 'state', 'country'], 'integer'],
            [['createdDate', 'modifiedDate'], 'safe'],
            [['deviceType', 'city', 'stateCode', 'stateName', 'countryName', 'countryCode', 'zipCode'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'dev_id' => 'Dev ID',
            'deviceToken' => 'Device Token',
            'mobileDeviceToken' => 'Mobile Device Token',
            'deviceType' => 'Device Type',
            'lat' => 'Lat',
            'lng' => 'Lng',
            'notification_status' => 'Notification Status',
            'uId' => 'U ID',
            'createdDate' => 'Created Date',
            'modifiedDate' => 'Modified Date',
            'city' => 'City',
            'stateCode' => 'State Code',
            'stateName' => 'State Name',
            'countryName' => 'Country Name',
            'countryCode' => 'Country Code',
            'zipCode' => 'Zip Code',
            'state' => 'State',
            'country' => 'Country',
        ];
    }
}
