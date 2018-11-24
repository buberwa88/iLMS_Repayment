<?php

namespace backend\modules\allocation\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "admitted_student".
 *
 * @property integer $admitted_student_id
 * @property integer $admission_batch_id
 * @property string $f4indexno
 * @property integer $programme_id
 * @property integer $has_transfered
 *
 * @property \backend\modules\allocation\models\AdmissionBatch $admissionBatch
 * @property \backend\modules\allocation\models\Programme $programme
 */
class AdmittedStudent extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;
 

    public function __construct(){
        parent::__construct();
        
    }

    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'admissionBatch',
            'programme'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['admission_batch_id', 'f4indexno', 'programme_id'], 'required'],
            [['admission_batch_id', 'programme_id', 'has_transfered'], 'integer'],
            [['f4indexno'], 'string', 'max' => 45],
            [['f4indexno'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admitted_student';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'admitted_student_id' => 'Admitted Student ID',
            'admission_batch_id' => 'Admission Batch ID',
            'f4indexno' => 'F4indexno',
            'programme_id' => 'Programme ID',
            'has_transfered' => 'Has Transfered',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdmissionBatch()
    {
        return $this->hasOne(\backend\modules\allocation\models\AdmissionBatch::className(), ['admission_batch_id' => 'admission_batch_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramme()
    {
        return $this->hasOne(\backend\modules\allocation\models\Programme::className(), ['programme_id' => 'programme_id']);
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
