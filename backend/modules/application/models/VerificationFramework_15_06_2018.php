<?php

namespace backend\modules\application\models;

use Yii;

/**
 * This is the model class for table "verification_framework".
 *
 * @property integer $verification_framework_id
 * @property string $verification_framework_title
 * @property string $verification_framework_desc
 * @property integer $verification_framework_stage
 * @property string $created_at
 * @property integer $created_by
 * @property integer $confirmed_by
 * @property string $confirmed_at
 * @property integer $is_active
 *
 * @property VerificationFrameworkItem[] $verificationFrameworkItems
 */
class VerificationFramework extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_CLOSED = 2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'verification_framework';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['verification_framework_title'], 'required'],
            [['verification_framework_stage', 'created_by', 'confirmed_by', 'is_active'], 'integer'],
            [['verification_framework_title'],'validateVerificationFrameworkActive'],
            [['created_at', 'confirmed_at'], 'safe'],
            [['verification_framework_title'], 'string', 'max' => 100],
            [['verification_framework_desc'], 'string', 'max' => 300],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'verification_framework_id' => 'Verification Framework ID',
            'verification_framework_title' => 'Title',
            'verification_framework_desc' => 'Description',
            'verification_framework_stage' => 'Confirmed',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'confirmed_by' => 'Confirmed By',
            'confirmed_at' => 'Confirmed At',
            'is_active' => 'Is Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVerificationFrameworkItems()
    {
        return $this->hasMany(VerificationFrameworkItem::className(), ['verification_framework_id' => 'verification_framework_id']);
    }
    function hasApplication() {
        if (Application::find()->where(['verification_framework_id' => $this->verification_framework_id])->exists()) {
            return TRUE;
        }
        return FALSE;
    }
    public function validateVerificationFrameworkActive($attribute) {
        
            if (self::find()->where('is_active=:is_active', [':is_active' => 1])
                            ->exists()) {
                $this->addError($attribute,' Active verification framework already exists');
                return FALSE;
            }
        
        return true;
    }
    function hasVerificationItem(){
     if (VerificationFrameworkItem::find()->where(['verification_framework_id' => $this->verification_framework_id])->exists()) {
            return TRUE;
        }
        return FALSE;
    }
}
