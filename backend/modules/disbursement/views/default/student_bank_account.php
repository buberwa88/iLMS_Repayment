 <?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ApplicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List of Loanee ';
$this->params['breadcrumbs'][] = $this->title;

 
?>
<div class="application-index">
  <div class="panel panel-info">
        <div class="panel-heading">
<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
  
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

          //  'application_id',
        //    'applicant_id',
                  [
                     'attribute' => 'firstName',
                        'label'=>"First Name",
                        'vAlign' => 'middle',
                        'width' => '200px',
                        'value' => function ($model) {
                            return $model->applicant->user->firstname;
                        },
                    ],
                    [
                     'attribute' => 'lastName',
                        'vAlign' => 'middle',
                         
                        'width' => '200px',
                        'value' => function ($model) {
                            return $model->applicant->user->surname;
                        },
                    ],
                    [
                     'attribute' => 'f4indexno',
                        'label'=>"f4 Index #",
                        'vAlign' => 'middle',
                        'width' => '200px',
                        'value' => function ($model) {
                            return $model->applicant->f4indexno;
                        },
                    ],
            //'academic_year_id',
            //'bill_number',
           // 'control_number',
           
            // 'receipt_number',
            // 'amount_paid',
            // 'pay_phone_number',
            // 'date_bill_generated',
            // 'date_control_received',
            // 'date_receipt_received',
                    //   'programme.learningInstitution.institution_name',
                 [
                     'attribute' => 'instititution',
                        'vAlign' => 'middle',
                        'width' => '200px',
                        'value' => function ($model) {
                            return $model->programme->learningInstitution->institution_name;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => ArrayHelper::map(\common\models\AcademicYear::find()->where("is_current=1")->asArray()->all(), 'academic_year_id', 'academic_year'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search Any '],
                        'format' => 'raw'
                    ],
            // 'application_study_year',
             'current_study_year',
            // 'applicant_category_id',
            // 'bank_account_number',
                [
                     'attribute' => 'bank_account_number',
                        'vAlign' => 'middle',
                        'width' => '200px',
                        'value' => function ($model) {
                            return $model->bank_account_number;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => [1=>"Empty Bank Account"],
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search Any '],
                        'format' => 'raw'
                    ],
               [
                     'attribute' => 'registration_number',
                        'vAlign' => 'middle',
                        'width' => '200px',
                        'value' => function ($model) {
                            return $model->bank_account_number;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => [1=>"Empty Registration Number"],
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search Any '],
                        'format' => 'raw'
                    ],
             //'registration_number',
           //  'bank_account_name',
            // 'bank_id',
            // 'bank_branch_name',
            // 'submitted',
            // 'verification_status',
            // 'needness',
            // 'allocation_status',
            // 'allocation_comment',
            // 'student_status',
            // 'created_at',

             ['class' => 'yii\grid\ActionColumn',
             'template' => '{updateloanee}',
                'buttons' => [
                    'updateloanee' => function ($url,$model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil" title="Edit"></span>',
                            $url);
                    },
                   

                ],
                ],
        ],
    ]); ?>
</div>
  </div>
</div>