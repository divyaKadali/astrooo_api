<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "notifications".
 *
 * @property int $not_id
 * @property string $notification_type
 * @property string $notification_title
 * @property string $notification_description
 * @property string $schedule_time
 * @property string $created_date
 * @property string $updated_date
 * @property int $created_by
 * @property int $updated_by
 */
class Notifications extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notifications';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['notification_description'], 'string'],
        		[['schedule_time', 'notification_type', 'notification_title','notification_description'], 'required'],
            [['schedule_time', 'created_date', 'updated_date'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['notification_type', 'notification_title'], 'string', 'max' => 60],
       [[ 'notification_description'], 'string', 'max' => 200], ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'not_id' => 'Not ID',
            'notification_type' => 'Notification Type',
            'notification_title' => 'Notification Title',
            'notification_description' => 'Notification Description',
            'schedule_time' => 'Schedule Time',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }
}
