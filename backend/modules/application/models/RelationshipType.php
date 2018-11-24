<?php

namespace backend\modules\application\models;

use Yii;

/**
 * This is the model class for table "relationship_type".
 *
 * @property integer $relationship_type_id
 * @property string $relationship_type
 *
 * @property Guarantor[] $guarantors
 */
class RelationshipType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'relationship_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['relationship_type'], 'required'],
            [['relationship_type'], 'string', 'max' => 40],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'relationship_type_id' => 'Relationship Type ID',
            'relationship_type' => 'Relationship Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGuarantors()
    {
        return $this->hasMany(Guarantor::className(), ['relationship_type_id' => 'relationship_type_id']);
    }
}
