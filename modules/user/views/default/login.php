<?php
/* @var $this \yii\web\View */
/* @var $model app\modules\user\models\LoginForm */

use yii\widgets\ActiveForm;
use mauriziocingolani\yii2fmwkphp\Html;

$this->title = 'Login';
?>

<h1>Login</h1>

<div class="row">

    <!-- LOGIN UTENTE -->
    <div class="col-sm-6">

        <?php
        $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'options' => ['class' => 'form-horizontal'],
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-sm-3\">{input}</div>\n<div class=\"col-sm-6\">{error}</div>",
                        'labelOptions' => ['class' => 'col-sm-3 control-label'],
                    ],
                ])
        ?>
        <?= $form->field($model, 'UserName') ?>
        <?= $form->field($model, 'Password')->passwordInput() ?>

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary']) ?> 
            </div>
        </div>
        <?php ActiveForm::end() ?>

    </div>

    <!-- LOGIN SOCIAL -->
    <?php if (Yii::$app->getModule('user')->canLoginWithSocial) : ?>
        <div class="col-sm-6" style="border-left: 1px solid #bababa;">

            <div class="col-sm-6">
                <p>Login via social networks</p>

                <p>
                    <a href="/user/default/auth?authclient=facebook" class="btn btn-default btn-block"><i class="fa fa-facebook" style="width: 20px;"></i> Facebook</a>
                </p>

                <p>
                    <a href="/user/default/auth?authclient=twitter" class="btn btn-default btn-block"><i class="fa fa-twitter" style="width: 20px;"></i> Twitter</a>
                </p>

                <p>
                    <a href="/user/default/auth?authclient=linkedin" class="btn btn-default btn-block"><i class="fa fa-linkedin" style="width: 20px;"></i> Linkedin</a>
                </p>
            </div> 

        </div> 
    <?php endif; ?>

</div>
