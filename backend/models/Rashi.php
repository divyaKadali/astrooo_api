<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "rashi".
 *
 * @property int $rashiId
 * @property string $rashiName
 * @property string $description
 * @property int $createdBy
 * @property int $updatedBy
 * @property string $createdDate
 * @property string $updatedDate
 */
class Rashi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rashi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rashiName','lord'], 'required'],
            [['description'], 'string'],
            [['createdBy', 'updatedBy'], 'integer'],
            [['createdDate', 'updatedDate'], 'safe'],
            [['rashiName'], 'string'],
        		[['description'], 'string', 'max' => 250 ,'min'=>250],
            ['rashiName', 'unique', 'message' => 'This rashi has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rashiId' => 'Rashi ID',
            'rashiName' => 'Rashi Name',
        	'lord' => 'Lord',
            'description' => 'Description',
            'createdBy' => 'Created By',
            'updatedBy' => 'Updated By',
            'createdDate' => 'Created Date',
            'updatedDate' => 'Updated Date',
        ];
    }
}
