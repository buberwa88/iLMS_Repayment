<?php

namespace backend\modules\allocation\models;

use Yii;

/**
 * This is the model class for table "allocation".
 *
 * @property integer $allocation_id
 * @property integer $allocation_batch_id
 * @property integer $application_id
 * @property integer $loan_item_id
 * @property double $allocated_amount
 * @property integer $is_canceled
 * @property string $cancel_comment
 *
 * @property AllocationBatch $allocationBatch
 * @property Application $application
 * @property LoanItem $loanItem
 */
class Allocation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'allocation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['allocation_batch_id', 'application_id', 'loan_item_id', 'allocated_amount','academic_year_id'], 'required'],
            [['allocation_batch_id', 'application_id', 'loan_item_id', 'is_canceled'], 'integer'],
            [['allocated_amount'], 'number'],
            [['cancel_comment'], 'string'],
            [['allocation_batch_id'], 'exist', 'skipOnError' => true, 'targetClass' => AllocationBatch::className(), 'targetAttribute' => ['allocation_batch_id' => 'allocation_batch_id']],
            [['application_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\application\models\Application::className(), 'targetAttribute' => ['application_id' => 'application_id']],
            [['loan_item_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanItem::className(), 'targetAttribute' => ['loan_item_id' => 'loan_item_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'allocation_id' => 'Allocation',
            'allocation_batch_id' => 'Allocation Batch',
            'application_id' => 'Application',
            'loan_item_id' => 'Loan Item ',
            'allocated_amount' => 'Allocated Amount',
            'is_canceled' => 'Is Canceled',
            'cancel_comment' => 'Cancel Comment',
            'academic_year_id'=>'Academic Year',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllocationBatch()
    {
        return $this->hasOne(AllocationBatch::className(), ['allocation_batch_id' => 'allocation_batch_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplication()
    {
        return $this->hasOne(\backend\modules\application\models\Application::className(), ['application_id' => 'application_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanItem()
    {
        return $this->hasOne(LoanItem::className(), ['loan_item_id' => 'loan_item_id']);
    }
    
    public function getAcademicYear()
    {
        return $this->hasOne(AcademicYear::className(), ['academic_year_id' => 'academic_year_id']);
    }
    public static function gettableColumnName($tableId) {
                $modeltable= SourceTable::findone($tableId);
              
                $data2 =  Yii::$app->db->createCommand("SELECT $modeltable->source_table_id_field AS id, $modeltable->source_table_text_field	AS name FROM  $modeltable->source_table_name")->queryAll();
            $value2 = (count($data2) == 0) ? ['' => ''] : $data2;
            return $value2;
              
    }
    static function getLoanItemsAllocatedHelpDesk($id,$allocation_batch_id){                
          return new \yii\data\ActiveDataProvider([
            'query' => \backend\modules\allocation\models\Allocation::find()->where("allocation_batch_id ='$allocation_batch_id' AND application_id='$id' AND is_canceled='0'"),
        ]);
    }
    
}
