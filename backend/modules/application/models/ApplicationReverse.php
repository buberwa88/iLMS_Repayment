<?php

namespace backend\modules\application\models;

use Yii;

/**
 * This is the model class for table "application_reverse".
 *
 * @property integer $application_reverse_id
 * @property integer $application_id
 * @property string $comment
 * @property integer $reversed_by
 * @property string $reversed_at
 */
class ApplicationReverse extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'application_reverse';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['application_id', 'reversed_by'], 'integer'],
            [['comment'], 'string'],
            [['reversed_at','form_number'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'application_reverse_id' => 'Application Reverse ID',
            'application_id' => 'Application ID',
            'comment' => 'Comment',
            'reversed_by' => 'Reversed By',
            'reversed_at' => 'Reversed At',
            'form_number'=>'Form Number',
        ];
    }

    public static function insertApplicationReverseHistory($application_id,$application_form_number,$comments,$reversed_by,$reversed_at){
        Yii::$app->db->createCommand()
        ->insert('application_reverse', [
        'application_id' =>$application_id,
        'form_number'=>$application_form_number,
        'comment' =>$comments,
        'reversed_by' =>$reversed_by,    
        'reversed_at' =>$reversed_at,   
        ])->execute(); 
    }

}
