<?php

namespace backend\modules\application\models;

use Yii;

/**
 * This is the model class for table "gepg_recon_master".
 *
 * @property integer $recon_master_id
 * @property string $recon_date
 * @property string $created_at
 * @property integer $status
 */
class GepgReconMaster extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gepg_recon_master';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
		    [['recon_date'], 'required'],
            [['created_at','created_by','description'], 'safe'],
            [['recon_date'], 'validateReconDate','skipOnEmpty' => false],
            [['status'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'recon_master_id' => 'Reconciliation ID',
            'recon_date' => 'Reconciliation Date',
            'created_at' => 'Created At',
            'status' => 'Status',
			'created_by' => 'Created By',
			'description' => 'Description',
        ];
    }

public function validateReconDate($attribute, $params){
    // Maximum date today - 18 years
     $maxBirthday = new \DateTime();
     //$maxBirthday->sub(new \DateInterval('P18Y'));
    if($this->recon_date >= $maxBirthday->format('Y-m-d')){
        $this->addError($attribute,'Wrong Recon. Date');
    }
  }

}
