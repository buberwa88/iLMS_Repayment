<?php

namespace backend\modules\allocation\models;

use Yii;

/**
 * This is the model class for table "sector_programme".
 *
 * @property integer $sector_programme_id
 * @property integer $sector_definition_id
 * @property integer $programme_id
 * @property integer $academic_year_id
 *
 * @property ClusterProgramme[] $clusterProgrammes
 * @property AcademicYear $academicYear
 * @property Programme $programme
 * @property SectorDefinition $sectorDefinition
 */
class SectorProgramme extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sector_programme';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sector_definition_id'], 'required'],
            [['sector_definition_id', 'programme_id', 'academic_year_id'], 'integer'],
            [['academic_year_id'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\AcademicYear::className(), 'targetAttribute' => ['academic_year_id' => 'academic_year_id']],
            [['programme_id'], 'exist', 'skipOnError' => true, 'targetClass' => Programme::className(), 'targetAttribute' => ['programme_id' => 'programme_id']],
            [['sector_definition_id'], 'exist', 'skipOnError' => true, 'targetClass' => SectorDefinition::className(), 'targetAttribute' => ['sector_definition_id' => 'sector_definition_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sector_programme_id' => 'Sector Programme',
            'sector_definition_id' => 'Sector Definition',
            'programme_id' => 'Programme',
            'academic_year_id' => 'Academic Year',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClusterProgrammes()
    {
        return $this->hasMany(ClusterProgramme::className(), ['sector_programme_id' => 'sector_programme_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAcademicYear()
    {
        return $this->hasOne(\common\models\AcademicYear::className(), ['academic_year_id' => 'academic_year_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramme()
    {
        return $this->hasOne(Programme::className(), ['programme_id' => 'programme_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSectorDefinition()
    {
        return $this->hasOne(SectorDefinition::className(), ['sector_definition_id' => 'sector_definition_id']);
    }
}
