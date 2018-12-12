<?php

namespace backend\modules\disbursement\models;

use Yii;

/**
 * This is the model class for table "disbursement".
 *
 * @property integer $disbursement_id
 * @property integer $disbursement_batch_id
 * @property integer $application_id
 * @property integer $programme_id
 * @property integer $loan_item_id
 * @property double $disbursed_amount
 * @property integer $status
 * @property string $created_at
 * @property integer $created_by
 *
 * @property Application $application
 * @property DisbursementBatch $disbursementBatch
 * @property LoanItem $loanItem
 * @property Programme $programme
 * @property User $createdBy
 */
class Disbursement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $institution_code;
	public $employer_id;
	public $applicant_id;
	public $academic_year_id;
    public static function tableName()
    {
        return 'disbursement';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['disbursement_batch_id', 'application_id', 'programme_id', 'loan_item_id', 'disbursed_amount', 'status', 'created_at', 'created_by','disbursed_as'], 'required'],
            [['disbursement_batch_id', 'application_id', 'programme_id', 'loan_item_id', 'status', 'created_by'], 'integer'],
            [['disbursed_amount'], 'number'],
            [['created_at','version','institution_code'], 'safe'],
            [['application_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\application\models\Application::className(), 'targetAttribute' => ['application_id' => 'application_id']],
            [['disbursement_batch_id'], 'exist', 'skipOnError' => true, 'targetClass' => DisbursementBatch::className(), 'targetAttribute' => ['disbursement_batch_id' => 'disbursement_batch_id']],
            [['loan_item_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\allocation\models\LoanItem::className(), 'targetAttribute' => ['loan_item_id' => 'loan_item_id']],
            [['programme_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\application\models\Programme::className(), 'targetAttribute' => ['programme_id' => 'programme_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\User::className(), 'targetAttribute' => ['created_by' => 'user_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'disbursement_id' => 'Disbursement',
            'disbursement_batch_id' => 'Disbursement Batch',
            'application_id' => 'Application',
            'programme_id' => 'Programme',
            'loan_item_id' => 'Loan Item',
            'disbursed_amount' => 'Disbursed Amount',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
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
    public function getDisbursementBatch()
    {
        return $this->hasOne(DisbursementBatch::className(), ['disbursement_batch_id' => 'disbursement_batch_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanItem()
    {
        return $this->hasOne(\backend\modules\allocation\models\LoanItem::className(), ['loan_item_id' => 'loan_item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramme()
    {
        return $this->hasOne(\backend\modules\application\models\Programme::className(), ['programme_id' => 'programme_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(\common\models\User::className(), ['user_id' => 'created_by']);
    }
  public function getLoan($form4index){
       $total_loan=0;
  $sql_system=Yii::$app->db->createCommand("select SUM(disbursed_amount) as amount from loan_view where f4indexno='{$form4index}'")->queryAll();    
    if($sql_system){
  foreach($sql_system as $rows);
  $total_loan=$rows["amount"];
    }
    return $total_loan;            
    }
 public function getLoanPayment($form4index){
       $total_payment=0;
  $sql_system=Yii::$app->db->createCommand("SELECT SUM(amount) as amount FROM applicant a,`loan_repayment` l WHERE l.`applicant_id`=a.`applicant_id` AND `f4indexno`='{$form4index}'")->queryAll();    
    if($sql_system){
  foreach($sql_system as $rows);
  $total_payment=$rows["amount"];
    }
    return $total_payment;            
    }
}
