<?php

namespace backend\modules\repayment\models;

use backend\modules\application\models\Applicant;
use common\models\User;
use Yii;

/**
 * This is the model class for table "loan_non_beneficiary".
 *
 * @property integer $applicant_id
 * @property string $date_created
 * @property integer $created_by
 * @property integer $is_beneficiary
 * @property string $user_comments
 *
 * @property Applicant $applicant
 * @property User $createdBy
 */
class LoanNonBeneficiary extends \yii\db\ActiveRecord {

    const ACTIVE = 1;
    const IN_ACTIVE = 0;
    const APPLICANT_BENEFICIARY = 1;
    const APPLICANT_NOT_BENEFITIARY = 0;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'loan_non_beneficiary';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['applicant_id', 'created_by', 'is_beneficiary'], 'required'],
            [['applicant_id', 'created_by', 'is_beneficiary'], 'integer'],
            [['date_created', 'user_comments'], 'safe'],
            [['user_comments'], 'string', 'max' => 255],
//            [['is_beneficiary'], 'unique'],
            [['applicant_id'], 'exist', 'skipOnError' => true, 'targetClass' => Applicant::className(), 'targetAttribute' => ['applicant_id' => 'applicant_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'user_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'applicant_id' => 'Applicant ID',
            'date_created' => 'Date Created',
            'created_by' => 'Created By',
            'is_beneficiary' => 'Is Beneficiary',
            'user_comments' => 'User Comments',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicant() {
        return $this->hasOne(Applicant::className(), ['applicant_id' => 'applicant_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy() {
        return $this->hasOne(User::className(), ['user_id' => 'created_by']);
    }

    /*
     * function to check the applicant in beneficary or not after confirmation
     */

    static function isNonBeneficiary($applicant_id) {
        $sql = "SELECT applicant_id from loan_non_beneficiary 
                WHERE applicant_id=:applicant_id AND is_active=:is_active AND is_beneficiary=:is_beneficiary
                ORDER BY date_created DESC LIMIT 1
              ";
        $data = self::find()
                ->where(
                        ['applicant_id' => $applicant_id, 'is_active' => self::ACTIVE, 'is_beneficiary' => self::APPLICANT_BENEFICIARY])
                ->limit(1)->orderBy('date_created DESC')
                ->exists();
        if ($data) {
            return TRUE;
        }
        return FALSE;
    }

    /*
     * checks if the applicant has any disbusement done to him
     */

    static function hasDisbursement($applicant_id) {
        $sql = "SELECT * FROM disbursement 
                INNER JOIN application ON disbursement.application_id=application.application_id
                WHERE application.applicant_id=:applicant_id AND disbursement.status=:status
               ";
        $data = self::findBySql($sql, [":applicant_id" => $applicant_id, ':status' => 8])->exists();
        if ($data) {
            return TRUE;
        }
        return FALSE;
    }

}
