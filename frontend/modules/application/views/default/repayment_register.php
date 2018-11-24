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
				If you are not registered yet;
			</p>
			<p>
				<strong>
					<a href="index.php?r=repayment/employer/create">
						<button type="button" class="btn btn-primary btn-sm" style="width:80%;font-size:16px;">
							NEW EMPLOYER REGISTRATION
						</button>
					</a>
				</strong>
			</p>
		</div>
		<div class="column">
			<p style="margin:0px;font-size:16px;">
				If you are registered already and want to login;
			</p>
			<p>
				<strong>
					<a href="index.php?r=application/default/home-page&amp;activeTab=login_tab_id">
						<button type="button" class="btn btn-primary btn-sm" style="width:80%;font-size:16px;background-color: #00C0EF;">
							LOGIN
						</button>
					</a>
				</strong>
			</p>
		</div>
	</div>
   
</div>
    </div>
</article>