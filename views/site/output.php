<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\OutputForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Output';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('OutputFormSubmitted')): ?>

        <div class="alert alert-success">
            Submited.
        </div>
    <?php else: ?>

        <p>
            Output form.
        </p>

        <div class="row">
            <div class="col-lg-5">

                <?php $form = ActiveForm::begin(['id' => 'output-form']); ?>

                <div id="output"></div>

                <div class="form-group">
                    <?= Html::Button('Get', ['class' => 'btn btn-primary', 'name' => 'get-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>

    <?php endif; ?>
</div>

<script>
    $(function() {
        var btn  = $('button[name=get-button');
        var body = $('#output');

        $(btn).click(function() {
            $.get('/index.php?r=site/getoutput', function(data) {
                var parsedData = $.parseJSON(data);
                body.html(parsedData);
            });
        });
    });
</script>