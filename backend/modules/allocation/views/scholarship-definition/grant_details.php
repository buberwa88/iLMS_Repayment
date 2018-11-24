<?php

use backend\modules\allocation\models\ScholarshipDefinition;
?>

<p>
    <?php if ($model->is_active != ScholarshipDefinition::STATUS_INACTIVE) { ?>
        <?= \yii\bootstrap\Html::a('Edit/Update', ['update', 'id' => $model->scholarship_id], ['class' => 'btn btn-primary']) ?>
        <?=
        \yii\bootstrap\Html::a('Delete', ['delete', 'id' => $model->scholarship_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]);
        ?>
    <?php } ?>
    <?php if ($model->is_active == ScholarshipDefinition::STATUS_ACTIVE && !$model->scholarshipStudents) { ?>
        <?=
        yii\bootstrap\Html::a('Close Scholarship', ['close', 'id' => $model->scholarship_id], [
            'class' => 'btn btn-info',
            'data' => [
                'confirm' => 'Are you sure you want to Close & Archieve this Item?',
                'method' => 'post',
            ],
        ])
        ?>
    <?php } ?>
</p>
<table class="table table-striped table-bordered detail-view" id="w0">
    <tbody>
        <tr>
            <th style="width: 13.5%;">Grant/Scholarship Name</th>
            <td colspan="5"> <?php echo strtoupper($model->scholarship_name); ?></td>
        </tr>
        <tr>
            <th>Details</th>
            <td colspan="5"> <?php echo ($model->scholarship_desc); ?></td>
        </tr>
        <tr>
            <th>Grant / Scholarship Type</th>
            <td><?php echo strtoupper($model->getScholarshipTypeName()); ?></td>
            <td></td>
            <th>Country Of Study</th>
            <td><?php echo $model->country->country_name; ?></td>
        </tr>
        <tr>
            <th>Sponsor</th>
            <td colspan="5"><?php echo $model->sponsor ?></td>
        </tr>
        <tr>
            <th>Start Year</th>
            <td><?php echo $model->start_year; ?></td>
            <td></td>
            <th>End Year</th>
            <td><?php echo $model->end_year ?></td>
        </tr>
        <tr>
            <th>Status</th>
            <td> <?php echo $model->getScholarshipStatusName(); ?></td>
            <td></td>

            <th>Closed Date</th>
            <td><?php echo $model->closed_date; ?></td>
        </tr>
    </tbody>
</table>






