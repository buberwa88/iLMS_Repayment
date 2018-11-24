<?php

namespace backend\modules\allocation\models;

use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ProgrammeLoanItemCost extends Model
{
    public $programme_id;
    public $academic_year_id;
    public $year_of_study;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            //[['academic_year_id', 'cluster_definition_id', 'programme_category_id'], 'required'],
			[['programme_id', 'academic_year_id', 'year_of_study'], 'required', 'on' => 'programme_loan_item_cost_add'],
			[['programme_id', 'academic_year_id','year_of_study'], 'integer'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'year_of_study'=>'Year of Study',
            'academic_year_id'=>'Academic Year',
            'year_of_study'=>'Study Year',
        ];
    }

}
