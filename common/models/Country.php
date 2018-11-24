<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "country".
 *
 * @property integer $country_id
 * @property string $country_code
 * @property string $country_name
 */
class Country extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'country';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['country_code', 'country_name'], 'required'],
            [['country_code'], 'string', 'max' => 3],
            [['country_name'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'country_id' => 'Country ID',
            'country_code' => 'Country Code',
            'country_name' => 'Country Name',
        ];
    }

    /*
     * returns the detils of a country given its country code
     */

    static function getCountryDetailsByCode($country_code) {
        return self::find()->where(['country_code' => $country_code])->one();
    }

    /*
     * returns the country name given its country code
     */

    static function getCountryNameByCode($country_code) {
        $data = self::find()->select('country_name')->where(['country_code' => $country_code])->one();
        if ($data) {
            return $data->country_name;
        }
        return NULL;
    }

}
