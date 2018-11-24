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
class Items extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '';
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
            [['academic_year_id','cluster_definition_id','programme_category_id'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'academic_year_id'=>'Academic Year',
            'programme_category_id'=>'Programme Category',
            'cluster_definition_id'=>'cluster_definition_id',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
}
