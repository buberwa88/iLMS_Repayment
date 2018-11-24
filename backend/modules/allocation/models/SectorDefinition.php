<?php

namespace backend\modules\allocation\models;

use Yii;

/**
 * This is the model class for table "sector_definition".
 *
 * @property integer $sector_definition_id
 * @property string $sector_name
 * @property string $sector_desc
 *
 * @property SectorProgramme[] $sectorProgrammes
 */
class SectorDefinition extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sector_definition';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sector_name'], 'required'],
            [['sector_name'], 'string', 'max' => 45],
            [['sector_desc'], 'string', 'max' => 300],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sector_definition_id' => 'Sector Definition ID',
            'sector_name' => 'Sector Name',
            'sector_desc' => 'Sector Desc',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSectorProgrammes()
    {
        return $this->hasMany(SectorProgramme::className(), ['sector_definition_id' => 'sector_definition_id']);
    }
}
