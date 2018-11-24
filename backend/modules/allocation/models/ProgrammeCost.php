<?php

namespace backend\modules\allocation\models;

use Yii;

/**
 * This is the model class for table "programme_fee".
 *
 * @property integer $programme_fee_id
 * @property integer $academic_year_id
 * @property integer $programme_id
 * @property integer $loan_item_id
 * @property double $amount
 * @property integer $days
 * @property integer $year_of_study
 *
 * @property AcademicYear $academicYear
 * @property LoanItem $loanItem
 * @property Programme $programme
 */
class ProgrammeCost extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public $learning_institution_id;
    //public $rate_type;
    public $item_category;
    //constants for fee upload
    public $programmes_cost_import_file;
    public $amount;
    
    public static function tableName() {
        return 'programme_cost';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['academic_year_id', 'programme_id', 'loan_item_id', 'unit_amount', 'year_of_study', 'rate_type', 'duration'], 'required'],
            [['unit_amount'], 'number'],
            [['loan_item_id'], 'validateProgrameLoanItem'],
            [['rate_type'], 'validateRate'],
            [['learning_institution_id', 'rate_type', 'item_category'], 'safe'],
            [['academic_year_id'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\AcademicYear::className(), 'targetAttribute' => ['academic_year_id' => 'academic_year_id']],
            [['loan_item_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanItem::className(), 'targetAttribute' => ['loan_item_id' => 'loan_item_id']],
            [['programme_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\application\models\Programme::className(), 'targetAttribute' => ['programme_id' => 'programme_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'programme_fee_id' => 'Programme Fee ',
            'academic_year_id' => 'Academic Year ',
            'programme_id' => 'Programme Name ',
            'loan_item_id' => 'Loan Item ',
            'unit_amount' => 'Unit Amount',
            'rate_type' => 'Rate',
            'duration' => 'Duration (Year or Days)',
            'year_of_study' => 'Year Of Study',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAcademicYear() {
        return $this->hasOne(\common\models\AcademicYear::className(), ['academic_year_id' => 'academic_year_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanItem() {
        return $this->hasOne(LoanItem::className(), ['loan_item_id' => 'loan_item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramme() {
        return $this->hasOne(\backend\modules\application\models\Programme::className(), ['programme_id' => 'programme_id']);
    }

    /*
     * Valdates if the given loan Item and rate_type used are correct
     */

    public function validateRate($attribute) {
        if ($this->loan_item_id && $this->rate_type && $attribute) {
            if (LoanItem::find()->where(['loan_item_id' => $this->loan_item_id, 'rate_type' => $this->rate_type])->exists()) {
                $this->addError($attribute, 'Item "Rate Type for :' . LoanItem::getLoanItemNameById($this->loan_item_id) . '" is not correct, please check');
                return FALSE;
            }
        }
        return TRUE;
    }

    public function validateProgrameLoanItem($attribute) {
        if ($this->academic_year_id && $this->programme_id && $this->loan_item_id && $this->year_of_study && $attribute) {
            if (self::find()->where(
                            ['academic_year_id' => $this->academic_year_id,
                                'programme_id' => $this->programme_id,
                                'loan_item_id' => $this->loan_item_id,
                                'year_of_study' => $this->year_of_study,
                            ]
                    )->exists()) {
                $this->addError($attribute, 'Selected "Loan Item" already exist for a given year');
                return FALSE;
            }
        }
        return TRUE;
    }

    public static function getProgrammesIdAndNameByInstitution($learningId) {
        $sql = \backend\modules\allocation\models\Programme::getProgrammesByLearningInstitutionId($learningId, Programme::STATUS_ACTIVE);
        foreach ($sql as $rows) {
            $programme_id = $rows["programme_id"];
            $programme_name = $rows["programme_code"] . ' - ' . $rows['programme_name'];
            $data2[] = array('id' => $programme_id, 'name' => $programme_name);
        }
        //print_r($tablecolumn);
        $value2 = (count($data2) == 0) ? ['' => ''] : $data2;
        return $value2;
    }

    public static function insertProgrammesCost($academic_year_id, $programme_id, $programme_type, $loan_item_id, $rate_type, $unit_amount, $duration, $year_of_study) {
        Yii::$app->db->createCommand()
                ->insert('programme_cost', [
                    'academic_year_id' => $academic_year_id,
                    'programme_id' => $programme_id,
                    'programme_type' => $programme_type,
                    'loan_item_id' => $loan_item_id,
                    'rate_type' => $rate_type,
                    'unit_amount' => $unit_amount,
                    'duration' => $duration,
                    'year_of_study' => $year_of_study,
                ])->execute();
    }

    static function getProgrammeLoanItemCostByAcademicYearProgrammeLoanItem($academic_year_id, $programme_id, $loan_item_id) {
        return self::find()
                        ->where([
                            'academic_year_id' => $academic_year_id,
                            'programme_id' => $programme_id,
                            'loan_item_id' => $loan_item_id
                        ])->one();
    }
    
    static function getProgrammeLoanItemsByProgrammeID($programme_id) {
        return self::find()->where(['programme_id' => $programme_id])->asArray()->all();
    }
    
    static function getProgrammeCostByProgrammeID($ProgrammeID, $AcademicYearId) {
        $sql = 'SELECT SUM(unit_amount*duration) AS unit_amount
                FROM programme_cost
                WHERE programme_id=:programme_id AND academic_year_id=:academic_year
                ';
        $data = self::findBySql($sql, [':programme_id' => $ProgrammeID, ':academic_year' => $AcademicYearId])->one();
        
        if ($data) {
            return $data->unit_amount;
        }
        return 0;
    }
}
