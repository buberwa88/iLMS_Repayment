<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
?>
<style>
    * {
        box-sizing: border-box;
    }

    /* Create two equal columns that floats next to each other */
    .column {
        float: left;
        width: 50%;
        padding: 10px;
        height: 300px; /* Should be removed. Only for demonstration */
    }

    /* Clear floats after the columns */
    .row:after {
        content: "";
        display: table;
        clear: both;
    }
</style>
<article>
    <div>
        <div class="row">	
            <div class="row" style="margin:0px;margin-top: 30px;">
                <div class="column">
                    <p style="margin:0px;font-size:16px;">
                        If you are want to request for refund, click here;
                    </p>
                    <p>
                        <strong>
                            <a href="index.php?r=site/refund-register">
                                <button type="button" class="btn btn-primary btn-sm" style="width:80%;font-size:16px;">
                                    NEW REFUND CLAIM REGISTRATION
                                </button>
                            </a>
                        </strong>
                    </p>
                </div>
                <div class="column">
                    <p style="margin:0px;font-size:16px;">
                        If you have registered a refund request click here to check status;
                    </p>
                    <p>
                        <strong>
                            <a href="index.php?r=site/view-refund">
                                <button type="button" class="btn btn-primary btn-sm" style="width:80%;font-size:16px;background-color: #00C0EF;">
                                    VIEW REFUND REQUEST
                                </button>
                            </a>
                        </strong>
                    </p>
                </div>
            </div>

        </div>
    </div>
</article>