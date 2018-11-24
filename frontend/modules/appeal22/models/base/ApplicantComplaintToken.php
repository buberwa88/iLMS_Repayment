<?php

namespace backend\modules\appeal\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "applicant_complaint_token".
 *
 * @property integer $applicant_complaint_token_id
 * @property string $token
 * @property integer $applicant_id
 * @property integer $created_by
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property \backend\modules\appeal\models\User $createdBy
 * @property \backend\modules\appeal\models\Applicant $applicant
 */
class ApplicantComplaintToken extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    private $_rt_softdelete;
    private $_rt_softrestore;

    public function __construct(){
        parent::__construct();
        $this->_rt_softdelete = [
            'deleted_by' => 1,
            'deleted_at' => 1,
        ];
        $this->_rt_softrestore = [
            'deleted_by' => 0,
            'deleted_at' => date('Y-m-d H:i:s'),
        ];
    }

    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'createdBy',
            'applicant'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['token', 'applicant_id', 'created_by', 'status', 'created_at', 'updated_at'], 'required'],
            [['applicant_id', 'created_by', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['token'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'applicant_complaint_token';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'applicant_complaint_token_id' => 'Applicant Complaint Token ID',
            'token' => 'Token',
            'applicant_id' => 'Applicant ID',
            'status' => 'Status',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(\backend\modules\appeal\models\User::className(), ['user_id' => 'created_by']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicant()
    {
        return $this->hasOne(\backend\modules\appeal\models\Applicant::className(), ['applicant_id' => 'applicant_id']);
    }
    
    /**
     * @inheritdoc
     * @return array mixed
     */
    public function behaviors()
    {
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
                'value' => \Yii::$app->user->identity->user_id,
            ],
        ];
    }
}
