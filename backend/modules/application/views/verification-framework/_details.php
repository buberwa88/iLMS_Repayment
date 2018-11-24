<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
?>
<div class="allocation-setting-index">
    <div class="panel panel-info">

        <div class="panel-body">
            <p>
                <?php if (!$model->hasApplication()) { ?>
                    <?= Html::a('Update', ['update', 'id' => $model->verification_framework_id], ['class' => 'btn btn-primary']) ?>
                    <?=
                    Html::a('Delete', ['delete', 'id' => $model->verification_framework_id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this Allocation Framework?',
                            'method' => 'post',
                        ],
                    ])
                    ?>
                <?php } ?>

                <?php if ($model->hasApplication()) { ?>
                    <?=
                    Html::a('Archieve this Framework', ['close', 'id' => $model->verification_framework_id], [
                        'class' => 'btn btn-info',
                        'data' => [
                            'confirm' => 'Are you sure you want to Close & Archieve this Framework?',
                            'method' => 'post',
                        ],
                    ])
                    ?>
                <?php } ?>

                <?=
                \yii\bootstrap\Html::a('Clone Framework', ['/allocation/allocation-plan/clone-all', 'id' => $model->allocation_plan_id], ['class' => 'btn btn-warning',
                    'data' => [
                        'confirm' => 'Are you sure you want to Copy this Framework?',
                        'method' => 'post',
                    ],]
                );
                ?>

            </p>
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
