<?php

namespace backend\modules\appeal\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "appeal_question".
 *
 * @property integer $appeal_question_id
 * @property integer $question_id
 * @property integer $attachment_definition_id
 * @property integer $created_by
 * @property string $created_at
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property \backend\modules\appeal\models\Question $question
 * @property \backend\modules\appeal\models\AttachmentDefinition $attachmentDefinition
 * @property \backend\modules\appeal\models\User $createdBy
 * @property \backend\modules\appeal\models\User $updatedBy
 */
class AppealQuestion extends \yii\db\ActiveRecord
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
            'question',
            'attachmentDefinition',
            'createdBy',
            'updatedBy'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['question_id', 'attachment_definition_id'], 'required'],
            [['question_id', 'attachment_definition_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'appeal_question';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'appeal_question_id' => 'Appeal Question',
            'question_id' => 'Question',
            'attachment_definition_id' => 'Attachment Definition',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(\backend\modules\appeal\models\Question::className(), ['question_id' => 'question_id']);
    }

    public function getQuestionString()
    {
        $res =  $this->question->question;

        return $res;
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttachmentDefinition()
    {
        return $this->hasOne(\backend\modules\appeal\models\AttachmentDefinition::className(), ['attachment_definition_id' => 'attachment_definition_id']);
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
    public function getUpdatedBy()
    {
        return $this->hasOne(\backend\modules\appeal\models\User::className(), ['user_id' => 'updated_by']);
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
