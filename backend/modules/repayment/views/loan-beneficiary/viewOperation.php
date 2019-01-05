<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\widgets\PasswordInput;
use yii\captcha\Captcha;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;

$fr = 'field';

/* @var $this yii\web\View */
/* @var $model backend\modules\report\models\Report */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Reports';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'enableClientValidation' => TRUE, 'action' => ['/report/report/print-report'], 'options' => ['method' => 'post']]); ?>

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-flat">
            <div class="panel-heading">
                <!--<h5 class="panel-title"></h5>-->
                <div class="heading-elements">
                    <h5 class="panel-title">REPORTS LIST</h5>
                </div>
            </div>
            <div class="panel-body">        
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    //'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'name',
		  [
          'class' => 'yii\grid\ActionColumn',
          'header' => 'Actions',
          'headerOptions' => ['style' => 'color:#337ab7'],
          'template' => '{view}',
          'buttons' => [
            'view' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                            'title' => Yii::t('app', 'view'),
                ]);
            },
          ],
          'urlCreator' => function ($action, $model, $key, $index) {
            if ($action === 'view') {
                $url ='index.php?r=repayment/loan-beneficiary/view-operation&id='.$model->id;
                return $url;
            }
          }
          ],
		  
		  
                    ],
                ]);
                ?>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="panel panel-flat">

            <div class="panel-body">
                <center>
                    <h5 class="panel-title">
                        <strong><?php echo strtoupper('REPORT GENERATION FORM<br/> ' . $model->name); ?></strong>
                    </h5>
                </center>
                <!--<br/>-->
                <?= $form->field($model, 'uniqid')->label(false)->hiddenInput(['value' => $model->id, 'readOnly' => 'readOnly']) ?>
                <?= $form->field($model, 'pageIdentify')->label(false)->hiddenInput(['value'=>'2','readOnly'=>'readOnly']) ?>
                <?php
                $results = \backend\modules\report\models\ReportFilterSetting::find()
                        ->select('number_of_rows')
                        ->where(['is_active' => '1'])
                        ->orderBy(['report_filter_setting_id' => SORT_DESC])
                        ->one();
                //$number_of_rows=$results->number_of_rows;
                $number_of_rows = 15;
                $model = \backend\modules\report\models\Report::findOne($model->id);
                for ($i = 1; $i <= $number_of_rows; $i++) {
                    $field = $fr . $i;
                    $description = 'description' . $i;
                    $type = 'type' . $i;
                    $type = $model->$type;
                    if (!empty($model->$field)) {
                        $name = 'input' . $i;
                        $value = '';
                        if (!empty($_POST[$name]))
                            $value = $_POST[$name];

                        if ($type == 'text') {
                            echo "<div class='form-group'><label class='col-md-3'>" . $model->$field . "</label><div class='col-md-9'>";
                            //echo CHtml::textField($name, $value, array('size' => 20,'class'=>'form-control'));
                            ?>
                            <?= $form->field($model, $name)->label(false)->textInput(['value' => $value, 'maxlength' => true]) ?>
                            <?php
                            echo "</div></div>";
                        }
                        if ($type == 'date') {
                            echo "<div class='form-group'><label class='col-md-3'>" . $model->$field . "</label><div class='col-md-9'>";
                            ?>                          

                            <?=
                            $form->field($model, $name)->label(false)->widget(DatePicker::classname(), [
                                'name' => $name,
                                'options' => ['placeholder' => 'yyyy-mm-dd',
                                    'todayHighlight' => false,
                                ],
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'format' => 'yyyy-mm-dd',
                                    'todayHighlight' => true,
                                    'allowClear' => true,
                                ],
                            ]);
                            ?>
                            <?php
                            echo "</div></div>";
                        }

                        if ($type == 'applicant_category') {
                            echo "<div class='form-group'><label class='col-md-3'>" . $model->$field . "</label><div class='col-md-9'>";
                            //echo CHtml::textField($name, $value, array('size' => 20,'class'=>'form-control'));
                            ?>
                            <?php
                            echo Form::widget([
                                'model' => $model,
                                'form' => $form,
                                'columns' => 1,
                                'attributes' => [ // 2 column layout
                                    $name => ['type' => Form::INPUT_WIDGET,
                                        'widgetClass' => \kartik\select2\Select2::className(),
                                        'label' => false,
                                        'options' => [
                                            'data' => ArrayHelper::map(\backend\modules\application\models\ApplicantCategory::find()->all(), 'applicant_category_id', 'applicant_category'),
                                            'options' => [
                                                'prompt' => 'Select Category',
                                            ],
                                            'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                        ],
                                    ],
                                ]
                            ]);
                            ?>
                            <?php
                            echo "</div></div>";
                        }
                        ?>
                        <?php
                        if ($type == 'institution') {
                            echo "<div class='form-group'><label class='col-md-3'>" . $model->$field . "</label><div class='col-md-9'>";
                            //echo CHtml::textField($name, $value, array('size' => 20,'class'=>'form-control'));
                            ?>
                            <?php
                            echo Form::widget([
                                'model' => $model,
                                'form' => $form,
                                'columns' => 1,
                                'attributes' => [ // 2 column layout
                                    $name => ['type' => Form::INPUT_WIDGET,
                                        'widgetClass' => \kartik\select2\Select2::className(),
                                        'label' => false,
                                        'options' => [
                                            'data' => ArrayHelper::map(\frontend\modules\application\models\LearningInstitution::find()->where(['institution_type' => ['UNIVERSITY', 'COLLEGE']])->all(), 'learning_institution_id', 'institution_name'),
                                            'options' => [
                                                'prompt' => 'Select Institution',
                                            ],
                                            'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                        ],
                                    ],
                                ]
                            ]);
                            ?>
                            <?php
                            echo "</div></div>";
                        }

                        if ($type == 'loan_item') {
                            echo "<div class='form-group'><label class='col-md-3'>" . $model->$field . "</label><div class='col-md-9'>";
                            //echo CHtml::textField($name, $value, array('size' => 20,'class'=>'form-control'));
                            ?>
                            <?php
                            echo Form::widget([
                                'model' => $model,
                                'form' => $form,
                                'columns' => 1,
                                'attributes' => [ // 2 column layout
                                    $name => ['type' => Form::INPUT_WIDGET,
                                        'widgetClass' => \kartik\select2\Select2::className(),
                                        'label' => false,
                                        'options' => [
                                            'data' => ArrayHelper::map(\backend\modules\allocation\models\LoanItem::find()->all(), 'loan_item_id', 'item_name'),
                                            'options' => [
                                                'prompt' => 'Select Loan Item',
                                            ],
                                            'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                        ],
                                    ],
                                ]
                            ]);
                            ?>

                            <?php
                            echo "</div></div>";
                        }

                        if ($type == 'country') {
                            echo "<div class='form-group'><label class='col-md-3'>" . $model->$field . "</label><div class='col-md-9'>";
                            //echo CHtml::textField($name, $value, array('size' => 20,'class'=>'form-control'));
                            ?>
                            <?php
                            echo Form::widget([
                                'model' => $model,
                                'form' => $form,
                                'columns' => 1,
                                'attributes' => [ // 2 column layout
                                    $name => ['type' => Form::INPUT_WIDGET,
                                        'widgetClass' => \kartik\select2\Select2::className(),
                                        'label' => false,
                                        'options' => [
                                            'data' => ArrayHelper::map(\frontend\modules\application\models\Country::find()->all(), 'country_id', 'country_name'),
                                            'options' => [
                                                'prompt' => 'Select Country',
                                            ],
                                            'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                        ],
                                    ],
                                ]
                            ]);
                            ?>
                            <?php
                            echo "</div></div>";
                        }

                        if ($type == 'programme_group') {
                            echo "<div class='form-group'><label class='col-md-3'>" . $model->$field . "</label><div class='col-md-9'>";
                            //echo CHtml::textField($name, $value, array('size' => 20,'class'=>'form-control'));
                            ?>
                            <?php
                            echo Form::widget([
                                'model' => $model,
                                'form' => $form,
                                'columns' => 1,
                                'attributes' => [ // 2 column layout
                                    $name => ['type' => Form::INPUT_WIDGET,
                                        'widgetClass' => \kartik\select2\Select2::className(),
                                        'label' => false,
                                        'options' => [
                                            'data' => ArrayHelper::map(\backend\modules\allocation\models\ProgrammeGroup::find()->all(), 'programme_group_id', 'group_name'),
                                            'options' => [
                                                'prompt' => 'Select Programme Group',
                                            ],
                                            'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                        ],
                                    ],
                                ]
                            ]);
                            ?>
                            <?php
                            echo "</div></div>";
                        }

                        if ($type == 'scholarship_type') {
                            echo "<div class='form-group'><label class='col-md-3'>" . $model->$field . "</label><div class='col-md-9'>";
                            //echo CHtml::textField($name, $value, array('size' => 20,'class'=>'form-control'));
                            ?>
                            <?php
                            echo Form::widget([
                                'model' => $model,
                                'form' => $form,
                                'columns' => 1,
                                'attributes' => [ // 2 column layout
                                    $name => ['type' => Form::INPUT_WIDGET,
                                        'widgetClass' => \kartik\select2\Select2::className(),
                                        'label' => false,
                                        'options' => [
                                            'data' => ArrayHelper::map(\backend\modules\allocation\models\ScholarshipDefinition::find()->all(), 'scholarship_id', 'scholarship_name'),
                                            'options' => [
                                                'prompt' => 'Select Scholarship Type',
                                            ],
                                            'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                        ],
                                    ],
                                ]
                            ]);
                            ?>
                            <?php
                            echo "</div></div>";
                        }

                        if ($type == 'academic_year') {
                            echo "<div class='form-group'><label class='col-md-3'>" . $model->$field . "</label><div class='col-md-9'>";
                            //echo CHtml::textField($name, $value, array('size' => 20,'class'=>'form-control'));
                            ?>
                            <?php
                            echo Form::widget([
                                'model' => $model,
                                'form' => $form,
                                'columns' => 1,
                                'attributes' => [ // 2 column layout
                                    $name => ['type' => Form::INPUT_WIDGET,
                                        'widgetClass' => \kartik\select2\Select2::className(),
                                        'label' => false,
                                        'options' => [
                                            'data' => ArrayHelper::map(\common\models\AcademicYear::find()->all(), 'academic_year_id', 'academic_year'),
                                            'options' => [
                                                'prompt' => 'Select Academic Year',
                                            ],
                                            'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                        ],
                                    ],
                                ]
                            ]);
                            ?>
                            <?php
                            echo "</div></div>";
                        }
                        ?>
                        <?php
                        if ($type == 'sex') {
                            echo "<div class='form-group'><label class='col-md-3'>" . $model->$field . "</label><div class='col-md-9'>";
                            //echo CHtml::textField($name, $value, array('size' => 20,'class'=>'form-control'));
                            ?>
                            <?php
                            echo Form::widget([
                                'model' => $model,
                                'form' => $form,
                                'columns' => 1,
                                'attributes' => [ // 2 column layout        
                                    $name => ['type' => Form::INPUT_WIDGET,
                                        'widgetClass' => \kartik\select2\Select2::className(),
                                        'label' => false,
                                        'options' => [
                                            'data' => ['M' => 'Male', 'F' => 'Female'],
                                            'options' => [
                                                'prompt' => 'Select Sex ',
                                            ],
                                            'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                        ],
                                    ],
                                ]
                            ]);
                            ?>
                            <?php
                            echo "</div></div>";
                        }
                        ?>
                        <?php
                        if ($type == 'allocation_batch') {
                            echo "<div class='form-group'><label class='col-md-3'>" . $model->$field . "</label><div class='col-md-9'>";
                            //echo CHtml::textField($name, $value, array('size' => 20,'class'=>'form-control'));
                            ?>
                            <?php
                            echo Form::widget([
                                'model' => $model,
                                'form' => $form,
                                'columns' => 1,
                                'attributes' => [ // 2 column layout
                                    $name => ['type' => Form::INPUT_WIDGET,
                                        'widgetClass' => \kartik\select2\Select2::className(),
                                        'label' => false,
                                        'options' => [
                                            'data' => ArrayHelper::map(\backend\modules\allocation\models\AllocationBatch::findBySql('SELECT allocation_batch.allocation_batch_id AS "allocation_batch_id",CONCAT(academic_year.academic_year,"-",allocation_batch.batch_number) AS "batch_number" FROM allocation_batch INNER JOIN academic_year ON allocation_batch.academic_year_id=academic_year.academic_year_id WHERE allocation_batch.allocation_batch_id >=53230')->asArray()->all(), 'allocation_batch_id', 'batch_number'),
                                            'options' => [
                                                'prompt' => 'Select Batch',
                                            ],
                                            'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                        ],
                                    ],
                                ]
                            ]);
                            ?>
                            <?php
                            echo "</div></div>";
                        }
                        ?>
                        <?php
                        if ($type == 'year_of_study') {
                            echo "<div class='form-group'><label class='col-md-3'>" . $model->$field . "</label><div class='col-md-9'>";
                            //echo CHtml::textField($name, $value, array('size' => 20,'class'=>'form-control'));
                            ?>
                            <?php
                            echo Form::widget([
                                'model' => $model,
                                'form' => $form,
                                'columns' => 1,
                                'attributes' => [ // 2 column layout        
                                    $name => ['type' => Form::INPUT_WIDGET,
                                        'widgetClass' => \kartik\select2\Select2::className(),
                                        'label' => false,
                                        'options' => [
                                            'data' => Yii::$app->params['programme_years_of_study'],
                                            'options' => [
                                                'prompt' => 'Select Year Of Study ',
                                            ],
                                            'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                        ],
                                    ],
                                ]
                            ]);
                            ?>
                            <?php
                            echo "</div></div>";
                        }
                        ?>
                <?php
                        if ($type == 'cluster_definition') {
                            echo "<div class='form-group'><label class='col-md-3'>" . $model->$field . "</label><div class='col-md-9'>";
                            //echo CHtml::textField($name, $value, array('size' => 20,'class'=>'form-control'));
                            ?>
                            <?php
                            echo Form::widget([
                                'model' => $model,
                                'form' => $form,
                                'columns' => 1,
                                'attributes' => [ // 2 column layout        
                                    $name => ['type' => Form::INPUT_WIDGET,
                                        'widgetClass' => \kartik\select2\Select2::className(),
                                        'label' => false,
                                        'options' => [
                                            'data' => ArrayHelper::map(\backend\modules\allocation\models\ClusterDefinition::find()->all(), 'cluster_definition_id', 'cluster_name'),
                                            'options' => [
                                                'prompt' => 'Select Cluster',
                                            ],
                                            'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                        ],
                                    ],
                                ]
                            ]);
                            ?>
                            <?php
                            echo "</div></div>";
                        }
                        ?>
						<?php
                        if ($type == 'form_storage') {
                            echo "<div class='form-group'><label class='col-md-3'>" . $model->$field . "</label><div class='col-md-9'>";
                            //echo CHtml::textField($name, $value, array('size' => 20,'class'=>'form-control'));
                            ?>
                            <?php
                            echo Form::widget([
                                'model' => $model,
                                'form' => $form,
                                'columns' => 1,
                                'attributes' => [ // 2 column layout        
                                    $name => ['type' => Form::INPUT_WIDGET,
                                        'widgetClass' => \kartik\select2\Select2::className(),
                                        'label' => false,
                                        'options' => [
                                            'data' => ArrayHelper::map(\common\models\FormStorage::find()->all(), 'id', 'folder_number'),
                                            'options' => [
                                                'prompt' => 'Select',
                                            ],
                                            'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                        ],
                                    ],
                                ]
                            ]);
                            ?>
                            <?php
                            echo "</div></div>";
                        }
                        ?>
						<?php
                        if ($type == 'user') {
                            echo "<div class='form-group'><label class='col-md-3'>" . $model->$field . "</label><div class='col-md-9'>";
                            //echo CHtml::textField($name, $value, array('size' => 20,'class'=>'form-control'));
                            ?>
                            <?php
                            echo Form::widget([
                                'model' => $model,
                                'form' => $form,
                                'columns' => 1,
                                'attributes' => [ // 2 column layout        
                                    $name => ['type' => Form::INPUT_WIDGET,
                                        'widgetClass' => \kartik\select2\Select2::className(),
                                        'label' => false,
                                        'options' => [
                                            'data' => ArrayHelper::map(\common\models\User::findBySql('SELECT user.user_id,CONCAT(user.firstname," ",user.surname) AS "Name" FROM `user` WHERE user.login_type=5')->asArray()->all(), 'user_id', 'Name'),
                                            'options' => [
                                                'prompt' => 'Select',
                                            ],
                                            'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                        ],
                                    ],
                                ]
                            ]);
                            ?>
                            <?php
                            echo "</div></div>";
                        }
                        ?>
                        <?php
                        /* else{
                          echo "<div class='form-group'><label class='col-md-3'>".$model->$field."</div><label class='col-md-3'>
                          ".CHtml::textField($name,$value,array('size'=>20))."
                          </div>";
                          } */
                    }
                }
                ?>

                <?php echo "<div class='form-group'><label class='col-md-3'>" . "EXPORT" . "</label><div class='col-md-9'>"; ?>
                <?= $form->field($model, 'exportCategory')->label(false)->dropDownList([ '1' => 'PDF','2' => 'EXCEL'], ['prompt' => 'Select']) ?>
                <?php echo "</div></div>"; ?> 
                <?php echo "<div class='form-group'><label class='col-md-3'>" . "EXPORT MODE" . "</label><div class='col-md-9'>"; ?>
                <?= $form->field($model, 'export_mode')->label(false)->dropDownList([ '1' => 'Landscape','2' => 'Portrait'], ['prompt' => 'Select']) ?>
                <?php echo "</div></div>"; ?>			
                <div class="text-right">
                    <?= Html::submitButton($model->isNewRecord ? 'Generate' : 'Generate', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    <?php
                    echo Html::resetButton('Reset', ['class' => 'btn btn-default']);
                    echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['all-reports'], ['class' => 'btn btn-warning']);
                    ?>
                </div>

            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
