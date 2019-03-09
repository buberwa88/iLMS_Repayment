<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Yii;

namespace common\models;

use backend\modules\application\models\Bank as BaseBank;

/**
 * Description of Bank
 *
 * @author charles
 */
class Bank extends BaseBank {

    public function rules() {
        return [
            [['bank_name', 'bank_account_number', 'bank_account_name'], 'required'],
            [['bank_name', 'branch', 'bank_account_name'], 'string', 'min' => 2, 'max' => 100],
            [['bank_account_number'], 'string', 'min' => 10, 'max' => 50],
            [['branch'], 'safe'],
        ];
    }

}
