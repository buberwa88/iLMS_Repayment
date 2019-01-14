<?php

namespace backend\modules\repayment\models;

use Yii;

/**
 * This is the model class for table "repayment_payer_category".
 *
 * @property integer $repayment_payer_category_id
 * @property integer $category
 * @property string $name
 */
class RepaymentPayerCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'repayment_payer_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category'], 'integer'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'repayment_payer_category_id' => 'Repayment Payer Category ID',
            'category' => 'Category',
            'name' => 'Name',
        ];
    }
}
