<?php

namespace common\models\base;


use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "logs".
 *
 * @property integer $logs_id
 * @property string $primary_id_value
 * @property string $old_data
 * @property string $new_data
 * @property string $http_user_agent
 * @property string $remote_address
 * @property integer $table_name
 * @property string $action
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class Logs extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;
 

    public function __construct(){
       
    }

    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            ''
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['http_user_agent', 'remote_address','new_data', 'table_name', 'action'], 'required'],
            //[['old_data', 'new_data', 'http_user_agent', 'action'], 'string'],
            [['created_by', 'updated_by'], 'integer'],
             [['old_data', 'new_data', 'http_user_agent', 'action','created_at', 'updated_at','column_name'], 'safe'],
           // [['primary_id_value', 'remote_address'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'logs';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'logs_id' => 'Logs ',
            'primary_id_value' => 'Primary Id Value',
            'old_data' => 'Old Data',
            'new_data' => 'New Data',
            'http_user_agent' => 'Http User Agent',
            'remote_address' => 'Remote Address',
            'table_name' => 'Table Name',
            'action' => 'Action',
        ];
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
   public function CreateLog($primaryKey,$old_data,$new_data,$table_name,$action){
         // $new_data= print_r($new_data);
          $model= new \common\models\base\Logs();
                    //$model->primary_id_value=$primaryKey;
                   // $model->column_name=  implode(",",array_keys($new_data));
                    //$model->old_data= implode(",",$old_data);
                    $model->new_data=$new_data;
                    $model->table_name=$table_name;
                    $model->action=$action;
                    $model->remote_address=Yii::$app->getRequest()->getUserIP();
                    $model->http_user_agent=Yii::$app->request->getUserAgent();
          $model->save();
         // print_r($model->errors);
        // exit();
    }
    public function CreateLogall($primaryKey,$old_data,$new_data,$table_name,$action,$status){
         // $new_data= print_r($new_data);
          $model= new \common\models\base\Logs();
                    $model->primary_id_value=$primaryKey;
                    $model->column_name="none";
                    $model->old_data=$old_data;
                    $model->new_data=$new_data;
                    $model->table_name=$table_name;
                    $model->action=$action;
                    $model->status=$status;
                    $model->remote_address=Yii::$app->getRequest()->getUserIP();
                    $model->http_user_agent=Yii::$app->request->getUserAgent();
          $model->save();
      
    }
}

