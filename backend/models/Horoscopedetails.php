<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "horoscopedetails".
 *
 * @property int $horId
 * @property int $planatId
 * @property string $planatName
 * @property int $rashiId
 * @property string $rashiName
 * @property string $lagnaLord
 * @property string $dhanaLord
 * @property string $kutumbaLord
 * @property string $maatruLord
 * @property string $putraLord
 * @property string $shetruLord
 * @property string $kalatraLord
 * @property string $shatruLord
 * @property string $bhaagyaLord
 * @property string $raajayLord
 * @property string $laabhaLord
 * @property string $vyayaLord
 * @property int $createdBy
 * @property int $updatedBy
 * @property string $createdDate
 * @property string $updatedDate
 */
class Horoscopedetails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	public $planet;
	public $digrees;
	public $strength;
	public $nakshatram;
	public $rashiname;
	public $userid;
    public static function tableName()
    {
        return 'horoscopedetails';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['digrees','strength','nakshatram'], 'required'],
            [[ 'createdBy', 'updatedBy'], 'integer'],
            [[ 'rashiName', 'lagnaLord', 'dhanaLord', 'kutumbaLord', 'maatruLord', 'putraLord', 'shetruLord', 'kalatraLord', 'shatruLord', 'bhaagyaLord', 'raajayLord', 'laabhaLord', 'vyayaLord'
            		,'createdDate', 'updatedDate','planet','digrees','strength','nakshatram','rashiname','userid','horId'], 'safe'],
            [[ 'rashiName', 'lagnaLord', 'dhanaLord', 'kutumbaLord', 'maatruLord', 'putraLord', 'shetruLord', 'kalatraLord', 'shatruLord', 'bhaagyaLord', 'raajayLord', 'laabhaLord', 'vyayaLord'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'horId' => 'Hor ID',
            'planatId' => 'Planat Name',
            'planatName' => 'Planat Name',
            'rashiId' => 'Rashi Name',
            'rashiName' => 'Rashi Name',
            'lagnaLord' => 'Lagna Lord',
            'dhanaLord' => 'Dhana Lord',
            'kutumbaLord' => 'Kutumba Lord',
            'maatruLord' => 'Maatru Lord',
            'putraLord' => 'Putra Lord',
            'shetruLord' => 'Shetru Lord',
            'kalatraLord' => 'Kalatra Lord',
            'shatruLord' => 'Shatru Lord',
            'bhaagyaLord' => 'Bhaagya Lord',
            'raajayLord' => 'Raajay Lord',
            'laabhaLord' => 'Laabha Lord',
            'vyayaLord' => 'Vyaya Lord',
            'createdBy' => 'Created By',
            'updatedBy' => 'Updated By',
            'createdDate' => 'Created Date',
            'updatedDate' => 'Updated Date',
        	'userId' => 'User',
        ];
    }
}
