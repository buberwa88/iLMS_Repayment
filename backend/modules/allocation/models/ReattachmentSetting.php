<?php

namespace backend\modules\allocation\models;

use Yii;

/**
 * This is the model class for table "reattachment_setting".
 *
 * @property integer $reattachment_setting_id
 * @property integer $verification_status
 * @property integer $status_flag
 * @property integer $comment_id
 * @property integer $is_active
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 */
class ReattachmentSetting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reattachment_setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['verification_status', 'status_flag'], 'required'],
            [['verification_status', 'status_flag', 'comment_id', 'is_active', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'reattachment_setting_id' => 'Reattachment Setting ID',
            'verification_status' => 'Verification Status',
            'status_flag' => 'Status Flag',
            'comment_id' => 'Comment ID',
            'is_active' => 'Is Active',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
        ];
    }
}
