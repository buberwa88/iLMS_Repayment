<?php

namespace backend\modules\allocation\models;

use Yii;

/**
 * This is the model class for table "customer".
 *
 * @property integer $id
 * @property string $first_name
 * @property integer $last_name
 *
 * @property Address[] $addresses
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * @inheritdoc
     */
    public $academic_year_id;
    public $cluster_definition_id;
    public $programme_category_id;
    public function rules()
    {
        return [
            [['last_name'], 'integer'],
            //[['academic_year_id', 'programme_category_id'], 'required'],
            [['academic_year_id','cluster_definition_id','programme_category_id'], 'safe'],
            [['first_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'academic_year_id'=>'Academic Year',
            'programme_category_id'=>'Programme Category',
            'cluster_definition_id'=>'cluster_definition_id',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddresses()
    {
        return $this->hasMany(Address::className(), ['customer_id' => 'id']);
    }
}
