<?php

namespace backend\modules\application\models;

use Yii;

/**
 * This is the model class for table "verification_comment".
 *
 * @property integer $verification_comment_id
 * @property integer $verification_comment_group_id
 * @property integer $comment
 * @property integer $created_by
 * @property string $created_at
 *
 * @property VerificationCommentGroup $verificationCommentGroup
 */
class VerificationComment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    const STATUS_UNVERIFIED = 0;
    const STATUS_COMPLETE = 1;
    const STATUS_INCOMPLETE = 2;
    const STATUS_WAITING = 3;
    const STATUS_INVALID = 4;
    const STATUS_PENDING = 5;
    public static function tableName()
    {
        return 'verification_comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['verification_comment_group_id', 'created_by'], 'integer'],
            [['created_at','comment'], 'safe'],
            [['verification_comment_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => VerificationCommentGroup::className(), 'targetAttribute' => ['verification_comment_group_id' => 'verification_comment_group_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'verification_comment_id' => 'Verification Comment ID',
            'verification_comment_group_id' => 'Verification Comment Group',
            'comment' => 'Comment',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVerificationCommentGroup()
    {
        return $this->hasOne(VerificationCommentGroup::className(), ['verification_comment_group_id' => 'verification_comment_group_id']);
    }
public static function getVerificationComment($verification_comment_id){
      return $results=self::find()
               ->where(['verification_comment_id'=>$verification_comment_id])->one()->comment; 
    }
static function getApplicationStatus() {

        return array(
            self::STATUS_UNVERIFIED => 'Unverified',
            self::STATUS_PENDING => 'Pending',
            self::STATUS_INCOMPLETE => 'Incomplete',
            self::STATUS_WAITING => 'Waiting',
            self::STATUS_INVALID => 'Invalid',
            self::STATUS_COMPLETE => 'Complete',           
    );
    }
}
