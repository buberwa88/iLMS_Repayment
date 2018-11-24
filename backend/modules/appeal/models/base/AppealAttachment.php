<?php

namespace backend\modules\appeal\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "appeal_attachment".
 *
 * @property integer $appeal_attachment_id
 * @property integer $appeal_id
 * @property integer $appeal_question_id
 * @property string $attachment_path
 * @property integer $verification_status
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property \backend\modules\appeal\models\Appeal $appeal
 * @property \backend\modules\appeal\models\AppealQuestion $appealQuestion
 */
class AppealAttachment extends \yii\db\ActiveRecord
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
            'appeal',
            'appealQuestion'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['appeal_id', 'attachment_path', 'created_by', 'updated_by'], 'required'],
            [['appeal_id', 'appeal_question_id', 'verification_status', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['attachment_path'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'appeal_attachment';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'appeal_attachment_id' => 'Appeal Attachment ID',
            'appeal_id' => 'Appeal ID',
            'appeal_question_id' => 'Appeal Question ID',
            'attachment_path' => 'Attachment Path',
            'verification_status' => 'Verification Status',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppeal()
    {
        return $this->hasOne(\backend\modules\appeal\models\Appeal::className(), ['appeal_id' => 'appeal_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppealQuestion()
    {
        return $this->hasOne(\backend\modules\appeal\models\AppealQuestion::className(), ['appeal_question_id' => 'appeal_question_id']);
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
