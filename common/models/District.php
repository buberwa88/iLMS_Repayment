<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "district".
 *
 * @property integer $district_id
 * @property string $district_name
 * @property integer $region_id
 *
 * @property Region $region
 * @property Ward[] $wards
 */
class District extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'district';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['district_name', 'region_id'], 'required'],
            [['region_id'], 'integer'],
            [['district_name'], 'string', 'max' => 45],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => Region::className(), 'targetAttribute' => ['region_id' => 'region_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'district_id' => 'District ID',
            'district_name' => 'District Name',
            'region_id' => 'Region ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['region_id' => 'region_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWards()
    {
        return $this->hasMany(Ward::className(), ['district_id' => 'district_id']);
    }
      public static function getDistrict($region_code) {
            $data2 = self::findBySql(" SELECT district_id AS id, district_name AS name FROM district WHERE region_id='{$region_code}'")->asArray()->all();
            $value2 = (count($data2) == 0) ? ['' => ''] : $data2;
            return $value2;
        
    }
    public static function getWard($district_code) {
            $data2 = \backend\modules\disbursement\models\Ward::findBySql(" SELECT ward_id AS id, ward_name AS name FROM ward WHERE district_id='{$district_code}'")->asArray()->all();
            $value2 = (count($data2) == 0) ? ['' => ''] : $data2;
            return $value2;
        
    }
}
