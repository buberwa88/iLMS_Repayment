<?php

namespace backend\modules\disbursement\models;

use Yii;

/**
 * This is the model class for table "disbursement_structure".
 *
 * @property integer $disbursement_structure_id
 * @property string $structure_name
 * @property integer $parent_id
 * @property integer $order_level
 * @property integer $status
 *
 * @property DisbursementStructure $parent
 * @property DisbursementStructure[] $disbursementStructures
 */
class DisbursementStructure extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'disbursement_structure';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['structure_name', 'status','order_level'], 'required'],
            [['order_level'], 'safe'],
            [['parent_id', 'order_level', 'status'], 'integer'],
            [['structure_name'], 'string', 'max' => 300],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => DisbursementStructure::className(), 'targetAttribute' => ['parent_id' => 'disbursement_structure_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'disbursement_structure_id' => 'Disbursement Structure ',
            'structure_name' => 'Structure Name',
            'parent_id' => 'Parent ',
            'order_level' => 'Order Level',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(DisbursementStructure::className(), ['disbursement_structure_id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisbursementStructures()
    {
        return $this->hasMany(DisbursementStructure::className(), ['parent_id' => 'disbursement_structure_id']);
    }
}
