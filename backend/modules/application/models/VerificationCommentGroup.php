<?php

namespace backend\modules\application\models;

use Yii;

/**
 * This is the model class for table "verification_comment_group".
 *
 * @property integer $verification_comment_group_id
 * @property string $comment_group
 * @property integer $created_by
 * @property string $created_at
 *
 * @property VerificationComment[] $verificationComments
 */
class VerificationCommentGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'verification_comment_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_by'], 'integer'],
            [['created_at','comment_group'], 'required'],
            [['created_at'], 'safe'],
            [['comment_group'],'unique','message'=>'Comment already exist'],
            [['comment_group'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'verification_comment_group_id' => 'Verification Comment Group ID',
            'comment_group' => 'Comment',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVerificationComments()
    {
        return $this->hasMany(VerificationComment::className(), ['verification_comment_group_id' => 'verification_comment_group_id']);
    }
}
