<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user_bhavas_strengths".
 *
 * @property int $ubs_id
 * @property int $userid
 * @property string $bhavam
 * @property string $strengths
 */
class UserBhavasStrengths extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
      return 'user_bhavas_strengths';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userid'], 'integer'],
            [['bhavam', 'strengths'], 'string', 'max' => 60],
        	[['bhavam', 'strengths','userid'], 'safe'],
        	[['bhavam', 'strengths'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ubs_id' => 'Ubs ID',
            'userid' => 'Userid',
            'bhavam' => 'Bhavam',
            'strengths' => 'Strengths',
        ];
    }
}
