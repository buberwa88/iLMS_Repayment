<?php

namespace backend\modules\allocation\models;

use Yii;

/**
 * This is the model class for table "learning_institution_contact".
 *
 * @property integer $learning_institution_id
 * @property string $cp_firstname
 * @property string $cp_middlename
 * @property string $cp_surname
 * @property string $cp_email_address
 * @property string $cp_phone_number
 * @property string $photo
 * @property string $category
 * @property string $signature
 * @property integer $is_signator
 * @property string $updated_at
 * @property integer $updated_by
 * @property string $created_at
 * @property integer $is_active
 */
class LearningInstitutionContact extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'learning_institution_contact';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cp_firstname',   'cp_surname','category','learning_institution_id'], 'required'],
            [['is_signator', 'updated_by', 'is_active'], 'integer'],
            [['updated_at','cp_phone_number', 'created_at'], 'safe'],
            [['cp_firstname', 'cp_middlename', 'cp_surname'], 'string', 'max' => 45],
            [['cp_email_address'], 'string', 'max' => 100],
            [['cp_phone_number'], 'string', 'max' => 50],
            [['photo', 'signature'], 'string', 'max' => 300],
            [['category'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'learning_institution_id' => 'Learning Institution ID',
            'cp_firstname' => 'First Name',
            'cp_middlename' => 'Middle Name',
            'cp_surname' => 'Last Name',
            'cp_email_address' => 'Email Address',
            'cp_phone_number' => 'Phone Number',
            'photo' => 'Photo',
            'category' => 'Category',
            'signature' => 'Signature',
            'is_signator' => 'Is Signator',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'is_active' => 'Is Active',
        ];
    }
}
