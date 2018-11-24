<?php

namespace backend\modules\allocation\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "complaint_category".
 *
 * @property integer $complaint_category_id
 * @property string $complaint_category_name
 * @property string $description
 * @property integer $status
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property \backend\modules\allocation\models\Complaint[] $complaints
 */
class ComplaintCategory extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    private $_rt_softdelete;
    private $_rt_softrestore;

    public function __construct(){
        parent::__construct();
        $this->_rt_softdelete = [
            'deleted_by' => 1,
            'deleted_at' => 1,
        ];
        $this->_rt_softrestore = [
            'deleted_by' => 0,
            'deleted_at' => date('Y-m-d H:i:s'),
        ];
    }

    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'complaints'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['status', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['complaint_category_name'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'complaint_category';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'complaint_category_id' => 'Complaint Category ID',
            'complaint_category_name' => 'Complaint Category Name',
            'description' => 'Description',
            'status' => 'Status',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComplaints()
    {
        return $this->hasMany(\backend\modules\allocation\models\Complaint::className(), ['complaint_category_id' => 'complaint_category_id']);
    }
    
    /**
     * @inheritdoc
     * @return array mixed
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new \yii\db\Expression('NOW()'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
                'value' => \Yii::$app->user->identity->user_id,
            ],
        ];
    }
}
