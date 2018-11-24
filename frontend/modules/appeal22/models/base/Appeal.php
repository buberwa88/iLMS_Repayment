<?php

namespace backend\modules\appeal\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "appeal".
 *
 * @property integer $appeal_id
 * @property integer $application_id
 * @property string $bill_number
 * @property string $control_number
 * @property string $receipt_number
 * @property double $amount_paid
 * @property string $pay_phone_number
 * @property string $date_bill_generated
 * @property string $date_control_received
 * @property string $date_receipt_received
 * @property integer $current_study_year
 * @property integer $appeal_category_id
 * @property integer $verification_status
 * @property double $needness
 * @property integer $updated_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property \backend\modules\appeal\models\Applicant $application
 * @property \backend\modules\appeal\models\AppealAttachment[] $appealAttachments
 */
class Appeal extends \yii\db\ActiveRecord
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
            'application',
            'appealAttachments'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['application_id', 'current_study_year', 'appeal_category_id', 'updated_by', 'created_at'], 'required'],
            [['application_id', 'current_study_year', 'appeal_category_id', 'verification_status', 'updated_by'], 'integer'],
            [['amount_paid', 'needness'], 'number'],
            [['date_bill_generated', 'date_control_received', 'date_receipt_received', 'created_at', 'updated_at'], 'safe'],
            [['bill_number', 'control_number', 'receipt_number'], 'string', 'max' => 20],
            [['pay_phone_number'], 'string', 'max' => 13]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'appeal';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'appeal_id' => 'Appeal ID',
            'application_id' => 'Application ID',
            'bill_number' => 'Bill Number',
            'control_number' => 'Control Number',
            'receipt_number' => 'Receipt Number',
            'amount_paid' => 'Amount Paid',
            'pay_phone_number' => 'Pay Phone Number',
            'date_bill_generated' => 'Date Bill Generated',
            'date_control_received' => 'Date Control Received',
            'date_receipt_received' => 'Date Receipt Received',
            'current_study_year' => 'Current Study Year',
            'appeal_category_id' => 'Appeal Category ID',
            'verification_status' => 'Verification Status',
            'needness' => 'Needness',
            'applicantfullname' => 'Applicant Name'
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplication()
    {
        return $this->hasOne(\backend\modules\appeal\models\Application::className(), ['application_id' => 'application_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppealAttachments()
    {
        return $this->hasMany(\backend\modules\appeal\models\AppealAttachment::className(), ['appeal_id' => 'appeal_id']);
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

    /**
     * The following code shows how to apply a default condition for all queries:
     *
     * ```php
     * class Customer extends ActiveRecord
     * {
     *     public static function find()
     *     {
     *         return parent::find()->where(['deleted' => false]);
     *     }
     * }
     *
     * // Use andWhere()/orWhere() to apply the default condition
     * // SELECT FROM customer WHERE `deleted`=:deleted AND age>30
     * $customers = Customer::find()->andWhere('age>30')->all();
     *
     * // Use where() to ignore the default condition
     * // SELECT FROM customer WHERE age>30
     * $customers = Customer::find()->where('age>30')->all();
     * ```
     */

    /**
     * @inheritdoc
     * @return \backend\modules\appeal\models\AppealQuery the active query used by this AR class.
     */
    public static function find()
    {
        $query = new \backend\modules\appeal\models\AppealQuery(get_called_class());
        return $query->where(['appeal.deleted_by' => 0]);
    }
}
