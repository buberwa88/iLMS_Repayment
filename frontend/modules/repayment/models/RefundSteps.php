<?php

namespace frontend\modules\repayment\models;

use Yii;

/**
 * This is the model class for table "refund_steps".
 *
 * @property integer $refund_steps_id
 * @property integer $refund_type
 * @property integer $refund_application_id
 * @property string $step_code
 * @property string $created_at
 */
class RefundSteps extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'refund_steps';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['refund_type', 'refund_application_id'], 'integer'],
            [['created_at'], 'safe'],
            [['step_code'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'refund_steps_id' => 'Refund Steps ID',
            'refund_type' => 'Refund Type',
            'refund_application_id' => 'Refund Application ID',
            'step_code' => 'Step Code',
            'created_at' => 'Created At',
        ];
    }
    public static function insertRefundStepsAttained($refund_application_id,$refund_type,$step_code)
    {
        $refundTypeStepsDetails = self::findBySql("SELECT  *  FROM refund_steps
                    where refund_type='$refund_type' AND refund_application_id='$refund_application_id' AND step_code='$step_code'")->all();
        if (count($refundTypeStepsDetails) == 0) {
            Yii::$app->db->createCommand()
                ->insert('refund_steps', [
                    'refund_application_id' => $refund_application_id,
                    'refund_type' => $refund_type,
                    'step_code' => $step_code,
                    'created_at' => date("Y-m-d H:i:s"),
                ])->execute();
        }
    }

    public static function getCountThestepsAttained($refund_application_id,$refund_type)
    {
        $stepsOpen=0;
        $resultsStepsCount=self::findBySql("SELECT  *  FROM refund_steps
                    where refund_type='$refund_type' AND refund_application_id='$refund_application_id'")->count();
        $steps=\backend\modules\repayment\models\RefundType::findBySql("SELECT  minimum_steps  FROM refund_type
                    where type='$refund_type' AND is_active='1'")->one()->minimum_steps;
        if($resultsStepsCount>=$steps){
            if($refund_type==1){
    $educationAttained = \frontend\modules\repayment\models\RefundApplication::findBySql("SELECT   	educationAttained   FROM  refund_application   where refund_application_id='$refund_application_id'")->one()->educationAttained;
      if($educationAttained==1){
      if($resultsStepsCount > $steps){
          $stepsOpen=1;
      }else{
      $stepsOpen=0;
      }
      }else{
          $stepsOpen=1;
      }
            }else {
                $stepsOpen = 1;
            }
        }
     return $stepsOpen;

    }
}
