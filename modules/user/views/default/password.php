<?php
/* @var $this \yii\web\View */
/* @var $model app\modules\user\models\PasswordForm */

use yii\widgets\ActiveForm;
use mauriziocingolani\yii2fmwkphp\Html;

$this->title = 'Password dimenticata';
?>

<h1>Password dimenticata</h1>

<p>Inserisci il tuo nome utente o il tuo indirizzo email. Riceverai un messaggio con la tua password attuale.</p>

<div class="row">

    <div class="col-sm-6">

        <?php if (Yii::$app->session->hasFlash('success')) : ?>

            <div class="alert alert-success">
                <?= Yii::$app->session->getFlash('success'); ?>
            </div>

        <?php else : ?>

            <?php
            $form = ActiveForm::begin([
                        'id' => 'password-form',
                        'options' => ['class' => 'form-horizontal'],
                        'fieldConfig' => [
                            'template' => "{label}\n<div class=\"col-sm-3\">{input}</div>\n<div class=\"col-sm-6\">{error}</div>",
                            'labelOptions' => ['class' => 'col-sm-3 control-label'],
                        ],
                    ])
            ?>

            <?= $form->field($model, 'UserName') ?>

            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <?= Html::submitButton('Recupera password', ['class' => 'btn btn-primary']) ?> 
                </div>
            </div>

            <?php ActiveForm::end() ?>

        <?php endif; ?>

    </div>

</div>