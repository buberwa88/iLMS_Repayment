<?php

namespace backend\modules\disbursement\models;

use Yii;
use \backend\modules\disbursement\models\base\PayoutlistMovement as BasePayoutlistMovement;

/**
 * This is the model class for table "disbursement_payoutlist_movement".
 */
class PayoutlistMovement extends BasePayoutlistMovement
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['disbursements_batch_id', 'from_officer', 'to_officer'], 'required'],
            [['disbursements_batch_id', 'from_officer', 'to_officer', 'movement_status', 'disbursement_task_id'], 'integer'],
            [['date_out'], 'safe'],
            [['comment'], 'string'],
            [['signature'], 'string', 'max' => 200]
        ]);
    }
	
}
