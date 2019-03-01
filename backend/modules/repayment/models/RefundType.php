<?php

namespace backend\modules\repayment\models;

use Yii;

/**
 * This is the model class for table "refund_type".
 *
 * @property integer $refund_type_id
 * @property string $name
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $is_active
 *
 * @property RefundApplication[] $refundApplications
 * @property User $createdBy
 * @property User $updatedBy
 */
class RefundType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    //refund types stages

    const TYPE1_STEP1 = "1CD";
    const TYPE1_STEP2 = "1PFED";
    const TYPE1_STEP3 = "1TED";
    const TYPE1_STEP4 = "1EMPD";
    const TYPE1_STEP5 = "1BD";
    const TYPE1_STEP6 = "1SFD";

    const TYPE2_STEP1 = "2CD";
    const TYPE2_STEP2 = "2EMPD";
    const TYPE2_STEP3 = "2RPD";
    const TYPE2_STEP4 = "2BD";
    const TYPE2_STEP5 = "2SFD";

    const TYPE3_STEP1 = "3CD";
    const TYPE3_STEP2 = "3PFED";
    const TYPE3_STEP3 = "3DD";
    const TYPE3_STEP4 = "3CTD";
    const TYPE3_STEP5 = "3BD";
    const TYPE3_STEP6 = "3SFD";

    const Contact_details_check = "CD";
    const Repayment_details_check = "RPD";
    const Primary_f4_details_check = "PFED";
    const Tertiary_education_check = "TED";
    const Employment_details_check = "EMPD";
    const Bank_details_check = "BD";
    const Social_fund_details_check = "SFD";
    const Death_details_check = "DD";
    const COURT_details_check = "CTD";
    //end for refund types stages

    public static function tableName()
    {
        return 'refund_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at','type','minimum_steps'], 'safe'],
            [['created_by', 'updated_by', 'is_active'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'user_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'user_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'refund_type_id' => 'Refund Type ID',
            'name' => 'Name',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'is_active' => 'Is Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefundApplications()
    {
        return $this->hasMany(RefundApplication::className(), ['refund_type_id' => 'refund_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['user_id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['user_id' => 'updated_by']);
    }
    public static function getRefundStepCode($refund_type,$generalStepCode)
    {
        ///////////
    if($refund_type==1 && $generalStepCode==self::Contact_details_check){
        $step_code=self::TYPE1_STEP1;
    }
        if($refund_type==2 && $generalStepCode==self::Contact_details_check){
            $step_code=self::TYPE2_STEP1;
        }
        if($refund_type==3 && $generalStepCode==self::Contact_details_check){
            $step_code=self::TYPE3_STEP1;
        }
        //////////////////////

        if($refund_type==1 && $generalStepCode==self::Repayment_details_check){
            $step_code='';
        }
        if($refund_type==2 && $generalStepCode==self::Repayment_details_check){
            $step_code=self::TYPE2_STEP3;
        }
        if($refund_type==3 && $generalStepCode==self::Repayment_details_check){
            $step_code='';
        }
        ////////////////////////
        if($refund_type==1 && $generalStepCode==self::Primary_f4_details_check){
            $step_code=self::TYPE1_STEP2;
        }
        if($refund_type==2 && $generalStepCode==self::Primary_f4_details_check){
            $step_code='';
        }
        if($refund_type==3 && $generalStepCode==self::Primary_f4_details_check){
            $step_code=self::TYPE3_STEP2;
        }
        ////////
        if($refund_type==1 && $generalStepCode==self::Tertiary_education_check){
            $step_code=self::TYPE1_STEP3;
        }
        if($refund_type==2 && $generalStepCode==self::Tertiary_education_check){
            $step_code='';
        }
        if($refund_type==3 && $generalStepCode==self::Tertiary_education_check){
            $step_code='';
        }
        //////////////////////
        if($refund_type==1 && $generalStepCode==self::Employment_details_check){
            $step_code=self::TYPE1_STEP4;
        }
        if($refund_type==2 && $generalStepCode==self::Employment_details_check){
            $step_code=self::TYPE2_STEP2;
        }
        if($refund_type==3 && $generalStepCode==self::Employment_details_check){
            $step_code='';
        }
        /////////////////////
        if($refund_type==1 && $generalStepCode==self::Bank_details_check){
            $step_code=self::TYPE1_STEP5;
        }
        if($refund_type==2 && $generalStepCode==self::Bank_details_check){
            $step_code=self::TYPE2_STEP4;
        }
        if($refund_type==3 && $generalStepCode==self::Bank_details_check){
            $step_code=self::TYPE3_STEP5;
        }
        //////////////////
        if($refund_type==1 && $generalStepCode==self::Social_fund_details_check){
            $step_code=self::TYPE1_STEP6;
        }
        if($refund_type==2 && $generalStepCode==self::Social_fund_details_check){
            $step_code=self::TYPE2_STEP5;
        }
        if($refund_type==3 && $generalStepCode==self::Social_fund_details_check){
            $step_code=self::TYPE3_STEP6;
        }
        //////////////////
        if($refund_type==1 && $generalStepCode==self::Death_details_check){
            $step_code='';
        }
        if($refund_type==2 && $generalStepCode==self::Death_details_check){
            $step_code='';
        }
        if($refund_type==3 && $generalStepCode==self::Death_details_check){
            $step_code=self::TYPE3_STEP3;
        }
        //////////////////
        if($refund_type==1 && $generalStepCode==self::COURT_details_check){
            $step_code='';
        }
        if($refund_type==2 && $generalStepCode==self::COURT_details_check){
            $step_code='';
        }
        if($refund_type==3 && $generalStepCode==self::COURT_details_check){
            $step_code=self::TYPE3_STEP4;
        }

    return $step_code;
    }
}
