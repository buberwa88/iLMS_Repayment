<?php

namespace backend\modules\allocation\models;

use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ClustProgramme extends Model
{
    public $academic_year_id;
    public $cluster_definition_id;
    public $programme_category_id;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            //[['academic_year_id', 'cluster_definition_id', 'programme_category_id'], 'required'],
			[['academic_year_id', 'cluster_definition_id', 'programme_category_id'], 'required', 'on' => 'clust_programme_add'],
			[['academic_year_id', 'cluster_definition_id','programme_category_id'], 'integer'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'academic_year_id'=>'Academic Year',
            'programme_category_id'=>'Programme Category',
            'cluster_definition_id'=>'cluster_definition_id',
        ];
    }

}
