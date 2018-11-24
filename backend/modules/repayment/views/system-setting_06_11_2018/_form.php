<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\AcademicYear;
use backend\models\Currency;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\SystemSetting */
/* @var $form yii\widgets\ActiveForm */
?>
<style type="text/css">
    .col-sm-8{
        width:80%;
    }
    .profile-info-name{
        width:750px;
    }
    .profile-info-value{
        width:50%;
    }
</style>
<div class="system-setting-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="col-sm-8">
        <div class="profile-user-info profile-user-info-striped">
            <div class="profile-info-row">
                <div class="profile-info-name">
                    <label class="control-label">Academic Year:</label>
                </div>
                <div class="profile-info-value">
                    <div class="col-sm-12">
                        <?=
                        $form->field($model, 'academic_year_id')->label(false)->dropDownList(
                                ArrayHelper::map(AcademicYear::find()->all(), 'academic_year_id', 'academic_year'
                                ), ['prompt' => ''])
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="profile-user-info profile-user-info-striped">
            <div class="profile-info-row">
                <div class="profile-info-name">
                    <label class="control-label">Currency:</label>
                </div>
                <div class="profile-info-value">
                    <div class="col-sm-12">
                        <?=
                        $form->field($model, 'currency_id')->label(false)->dropDownList(
                                ArrayHelper::map(Currency::find()->all(), 'currency_id', 'currency_ref'
                        ))
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="profile-user-info profile-user-info-striped">
            <div class="profile-info-row">
                <div class="profile-info-name">
                    <label class="control-label">Application Open Date:</label>
                </div>
                <div class="profile-info-value">
                    <div class="col-sm-12">
                        <?=
                        $form->field($model, 'application_open_date')->label(false)->widget(DatePicker::classname(), [
                            'name' => 'application_open_date',
                            'value' => date('d/m/Y', strtotime('+2 days')),
                            'options' => ['placeholder' => 'dd/mm/yyyy',
                                'todayHighlight' => true,
                            ],
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'dd/mm/yyyy',
                                'todayHighlight' => true,
                            ],
                        ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="profile-user-info profile-user-info-striped">
            <div class="profile-info-row">
                <div class="profile-info-name">
                    <label class="control-label">Application Close Date:</label>
                </div>
                <div class="profile-info-value">
                    <div class="col-sm-12">
                        <?=
                        $form->field($model, 'application_close_date')->label(false)->widget(DatePicker::classname(), [
                            'name' => 'application_close_date',
                            'value' => date('d/m/Y', strtotime('+2 days')),
                            'options' => ['placeholder' => 'dd/mm/yyyy',
                                'todayHighlight' => true,
                            ],
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'dd/mm/yyyy',
                                'todayHighlight' => true,
                            ],
                        ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="profile-user-info profile-user-info-striped">
            <div class="profile-info-row">
                <div class="profile-info-name">
                    <label class="control-label">Previous Loan Repayment For New Loan:</label>
                </div>
                <div class="profile-info-value">
                    <div class="col-sm-12">
                        <?= $form->field($model, 'previous_loan_repayment_for_new_loan')->label(false)->textInput(['maxlength' => true, 'style' => 'width:66%;float:left;text-align:right;']) ?>
                        <?= $form->field($model, 'value_type')->label(false)->dropDownList(Array('%' => 'Percentage', 'AMT' => 'Amount'),['style' => 'width:34%;']) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="profile-user-info profile-user-info-striped">
            <div class="profile-info-row">
                <div class="profile-info-name">
                    <label class="control-label">Total Budget:</label>
                </div>
                <div class="profile-info-value">
                    <div class="col-sm-12">
                        <?= $form->field($model, 'total_budget')->label(false)->textInput(['maxlength' => true,'style' =>'text-align:right;']) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="profile-user-info profile-user-info-striped">
            <div class="profile-info-row">
                <div class="profile-info-name">
                    <label class="control-label">Minimum Loanable Amount:</label>
                </div>
                <div class="profile-info-value">
                    <div class="col-sm-12">
                        <?= $form->field($model, 'minimum_loanable_amount')->label(false)->textInput(['maxlength' => true,'style' =>'text-align:right;']) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="profile-user-info profile-user-info-striped">
            <div class="profile-info-row">
                <div class="profile-info-name">
                    <label class="control-label">Waiting Days For Un-collected Disbursement Return:</label>
                </div>
                <div class="profile-info-value">
                    <div class="col-sm-12">
                        <?= $form->field($model, 'waiting_days_for_uncollected_disbursement_return')->label(false)->textInput(['maxlength' => true,'style' =>'text-align:right;']) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="profile-user-info profile-user-info-striped">
            <div class="profile-info-row">
                <div class="profile-info-name">
                    <label class="control-label">Loan Repayment Grace Period(Days):</label>
                </div>
                <div class="profile-info-value">
                    <div class="col-sm-12">
                        <?= $form->field($model, 'loan_repayment_grace_period_days')->label(false)->textInput(['maxlength' => true,'style' =>'text-align:right;']) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="profile-user-info profile-user-info-striped">
            <div class="profile-info-row">
                <div class="profile-info-name">
                    <label class="control-label">Employee Monthly Loan Repayment Percent:</label>
                </div>
                <div class="profile-info-value">
                    <div class="col-sm-12">
                        <?= $form->field($model, 'employee_monthly_loan_repayment_percent')->label(false)->textInput(['maxlength' => true,'style' =>'text-align:right;']) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="profile-user-info profile-user-info-striped">
            <div class="profile-info-row">
                <div class="profile-info-name">
                    <label class="control-label">Self Employed Monthly Loan Repayment Amount:</label>
                </div>
                <div class="profile-info-value">
                    <div class="col-sm-12">
                        <?= $form->field($model, 'self_employed_monthly_loan_repayment_amount')->label(false)->textInput(['maxlength' => true,'style' =>'text-align:right;']) ?>
                    </div>
                </div>
            </div>
        </div>       
        <div class="space10"></div>
        <div class="col-sm-12">
            <div class="form-group button-wrapper">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>


























</div>
