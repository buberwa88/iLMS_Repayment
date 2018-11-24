<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "staff".
 *
 * @property integer $staff_id
 * @property integer $user_id
 * @property integer $title_id
 * @property integer $staff_position_id
 * @property integer $learning_institution_id
 * @property string $type
 *
 * @property StaffPosition $staffPosition
 * @property Title $title
 * @property User $user
 * @property LearningInstitution $learningInstitution
 */
class Staff extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'staff';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'title_id'], 'required'],
            [['user_id', 'title_id', 'staff_position_id', 'learning_institution_id'], 'integer'],
            [['type'], 'string'],
            [['staff_position_id'], 'exist', 'skipOnError' => true, 'targetClass' => StaffPosition::className(), 'targetAttribute' => ['staff_position_id' => 'staff_position_id']],
            [['title_id'], 'exist', 'skipOnError' => true, 'targetClass' => Title::className(), 'targetAttribute' => ['title_id' => 'title_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'user_id']],
            [['learning_institution_id'], 'exist', 'skipOnError' => true, 'targetClass' => LearningInstitution::className(), 'targetAttribute' => ['learning_institution_id' => 'learning_institution_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'staff_id' => Yii::t('app', 'Staff ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'title_id' => Yii::t('app', 'Title ID'),
            'staff_position_id' => Yii::t('app', 'Staff Position ID'),
            'learning_institution_id' => Yii::t('app', 'Learning Institution ID'),
            'type' => Yii::t('app', 'Type'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaffPosition()
    {
        return $this->hasOne(StaffPosition::className(), ['staff_position_id' => 'staff_position_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTitle()
    {
        return $this->hasOne(Title::className(), ['title_id' => 'title_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['user_id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLearningInstitution()
    {
        return $this->hasOne(LearningInstitution::className(), ['learning_institution_id' => 'learning_institution_id']);
    }
}
