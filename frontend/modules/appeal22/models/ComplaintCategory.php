<?php

namespace backend\modules\appeal\models;

use Yii;

/**
 * This is the model class for table "complaint_category".
 *
 * @property integer $complaint_category_id
 * @property string $complaint_category_name
 * @property integer $status
 */
class ComplaintCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'complaint_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['complaint_category_name', 'status'], 'required'],
            [['status'], 'integer'],
            [['complaint_category_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'complaint_category_id' => 'Complaint Category ID',
            'complaint_category_name' => 'Complaint Category Name',
            'status' => 'Status',
        ];
    }

    public function getStatusValue(){
        
        $status = $this->status;

        if($status == 1){
            return "Active";
        }

        return "In Active";
    }
}
