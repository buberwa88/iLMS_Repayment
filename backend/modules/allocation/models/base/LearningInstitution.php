<?php

namespace backend\modules\allocation\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
 
/**
 * This is the base model class for table "learning_institution".
 *
 * @property integer $learning_institution_id
 * @property string $institution_type
 * @property string $institution_code
 * @property string $institution_name
 * @property string $institution_phone
 * @property string $institution_address
 * @property integer $ward_id
 * @property string $bank_account_number
 * @property string $bank_account_name
 * @property integer $bank_id
 * @property string $bank_branch_name
 * @property integer $entered_by_applicant
 * @property string $created_at
 * @property integer $created_by
 * @property string $contact_firstname
 * @property string $contact_middlename
 * @property string $contact_surname
 * @property string $contact_email_address
 * @property string $contact_phone_number
 *
 * @property \backend\modules\allocation\models\DisbursementBatch[] $disbursementBatches
 * @property \backend\modules\allocation\models\Education[] $educations
 * @property \backend\modules\allocation\models\InstitutionPaymentRequest[] $institutionPaymentRequests
 * @property \backend\modules\allocation\models\Bank $bank
 * @property \backend\modules\allocation\models\User $createdBy
 * @property \backend\modules\allocation\models\Ward $ward
 * @property \backend\modules\allocation\models\LearningInstitutionFee[] $learningInstitutionFees
 * @property \backend\modules\allocation\models\Programme[] $programmes
 */
class LearningInstitution extends \yii\db\ActiveRecord {
    public $region_id;
    public $district_id;
//constant for TZ institution
    const TZ_INSTITUTION = 'tz_institution';

    use \mootensai\relation\RelationTrait;

    public function __construct() {
        parent::__construct();
    }

    /**
     * This function helps \mootensai\relation\RelationTrait runs faster
     * @return array relation names of this model
     */
    public function relationNames() {
        return [
            'disbursementBatches',
            'educations',
            'institutionPaymentRequests',
            'bank',
            'createdBy',
            'ward',
            'learningInstitutionFees',
            'programmes'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['institution_type'], 'string'],
            [['institution_name', 'country', 'institution_type', 'ownership'], 'required'],
//          [['ward_id'], 'required', 'on' => self::TZ_INSTITUTION],
            [['ward_id', 'bank_id', 'entered_by_applicant', 'created_by', 'ownership'], 'integer'],
            [['created_at', 'institution_name','email', 'phone_number', 'physical_address', 'bank_branch_name', 'cp_firstname', 'cp_middlename', 'cp_surname', 'parent_id', 'country', 'ownership','region_id','district_id','ward_id'], 'safe'],
            [['institution_code'], 'string', 'max' => 10],
            [['institution_name', 'phone_number', 'physical_address', 'bank_branch_name', 'cp_firstname', 'cp_middlename', 'cp_surname'], 'string', 'max' => 45],
            [['bank_account_number'], 'string', 'max' => 20],
            [['bank_account_name'], 'string', 'max' => 60],
            [['cp_email_address'], 'string', 'max' => 100],
            [['cp_phone_number'], 'string', 'max' => 50],
            [['institution_name', 'institution_code'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'learning_institution';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'learning_institution_id' => 'Learning Institution',
            'institution_type' => 'Institution Type',
            'institution_code' => 'Institution Code',
            'institution_name' => 'Institution Name',
//            'institution_phone' => 'Institution Phone',
//            'institution_address' => 'Institution Address',
            'ward_id' => 'Ward ID',
            'bank_account_number' => 'Bank Account Number',
            'bank_account_name' => 'Bank Account Name',
            'bank_id' => 'Bank ID',
            'country' => 'Country',
            'bank_branch_name' => 'Bank Branch Name',
            'entered_by_applicant' => 'Entered By Applicant',
            'contact_firstname' => 'Contact Firstname',
            'cp_middlename' => 'Contact Middlename',
            'cp_surname' => 'Contact Surname',
            'cp_email_address' => 'Contact Email Address',
            'cp_phone_number' => 'Contact Phone Number',
            'parent_id' => 'Parent Name',
            'ownership' => 'Ownership',
            'is_active' => 'Is Active',
            'country' => 'Country Of Study'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisbursementBatches() {
        return $this->hasMany(\backend\modules\allocation\models\DisbursementBatch::className(), ['learning_institution_id' => 'learning_institution_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEducations() {
        return $this->hasMany(\backend\modules\allocation\models\Education::className(), ['learning_institution_id' => 'learning_institution_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstitutionPaymentRequests() {
        return $this->hasMany(\backend\modules\allocation\models\InstitutionPaymentRequest::className(), ['learning_institution_id' => 'learning_institution_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBank() {
        return $this->hasOne(\backend\modules\allocation\models\Bank::className(), ['bank_id' => 'bank_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy() {
        return $this->hasOne(\common\models\User::className(), ['user_id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWard() {
        return $this->hasOne(\backend\modules\application\models\Ward::className(), ['ward_id' => 'ward_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLearningInstitutionFees() {
        return $this->hasMany(\backend\modules\allocation\models\LearningInstitutionFee::className(), ['learning_institution_id' => 'learning_institution_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgrammes() {
        return $this->hasMany(\backend\modules\application\models\Programme::className(), ['learning_institution_id' => 'learning_institution_id']);
    }

    /**
     * @return \yii\db\ActiveQuery 
     */
    public function getParent() {
        return $this->hasOne(\backend\modules\allocation\models\LearningInstitution::className(), ['learning_institution_id' => 'parent_id']);
    }

    /**
     * @inheritdoc
     * @return array mixed
     */
    public function behaviors() {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new \yii\db\Expression('NOW()'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
                'value' => \Yii::$app->user->isGuest ? NULL : \Yii::$app->user->identity->user_id,
            ],
        ];
    }

}