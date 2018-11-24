<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
?>
<div class="allocation-setting-index">
    <div class="panel panel-info">

        <div class="panel-body">
            <p>
                <?php if ($model->allocation_plan_stage == backend\modules\allocation\models\AllocationPlan::STATUS_INACTIVE && !$model->hasStudents()) { ?>
                    <?=
                    Html::a('Delete', ['delete', 'id' => $model->allocation_plan_id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this Allocation Framework?',
                            'method' => 'post',
                        ],
                    ]);
                    ?>
                    <?= Html::a('Update', ['update', 'id' => $model->allocation_plan_id], ['class' => 'btn btn-primary']) ?>

                    <?php
                    if (!$model->hasStudents()) {
                        ?>
                        <?=
                        Html::a('Activate Framework', ['activate', 'id' => $model->allocation_plan_id], ['class' => 'btn btn-success', 'data' => [
                                'confirm' =>'Are you sure you want to Activate this Allocation Framework?',
                                'method' => 'post',
                            ],]
                        )
                        ?>

                        <?php
                    }
                }
                ?>

                <?php if ($model->allocation_plan_stage == backend\modules\allocation\models\AllocationPlan::STATUS_ACTIVE && !$model->hasStudents()) { ?>
                    <?=
                    Html::a('De-activate Framework', ['de-activate', 'id' => $model->allocation_plan_id], [
                        'class' => 'btn btn-info',
                        'data' => [
                            'confirm' => 'Are you sure you want to Deactive this Framework?',
                            'method' => 'post',
                        ],
                    ]);

//                    Html::a('Archieve this Framework', ['close', 'id' => $model->allocation_plan_id], [
//                        'class' => 'btn btn-info',
//                        'data' => [
//                            'confirm' => 'Are you sure you want to Close & Archieve this Framework?',
//                            'method' => 'post',
//                        ],
//                    ]);
                }
                    ?>
<?php if ($model->allocation_plan_stage == backend\modules\allocation\models\AllocationPlan::STATUS_ACTIVE) { ?>

                    <?=
                    \yii\bootstrap\Html::a('Clone This Framework', ['/allocation/allocation-plan/clone-all', 'id' => $model->allocation_plan_id], ['class' => 'btn btn-warning',
                        'data' => [
                            'confirm' => 'Are you sure you want to Clone this Framework into another Year?',
                            'method' => 'post',
                        ],]
                    );
                    ?>
                <?php } ?>

            </p>
            <?php if (Yii::$app->session->hasFlash('failure')) { ?>
                <div class="alert alert alert-warning" role="alert" style="padding: 3px;">
                    <?php echo Yii::$app->session->getFlash('failure'); ?>
                </div>
            <?php } ?>
            <table class="table table-striped table-bordered detail-view" id="w0">
                <tbody>
                    <tr>
                        <th>Plan Number</th>
                        <td><?php echo strtoupper($model->allocation_plan_number); ?></td>
                        <td></td>
                        <th>Academic Year</th>
                        <td><?php echo $model->academicYear->academic_year ?></td>
                    </tr>

                    <tr>
                        <th>Allocation Plan Title</th>
                        <td colspan="5"> <?php echo strtoupper($model->allocation_plan_title); ?></td>
                    </tr>

                    <tr>
                        <th>Plan Description</th>
                        <td colspan="5"><?php echo $model->allocation_plan_desc; ?></td>
                    </tr>

                    <tr>
                        <th>Status</th>
                        <td> <?php echo $model->getStatusNameByValue(); ?></td>
                        <td></td>

                        <th>Created At</th>
                        <td><?php echo $model->created_at; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
