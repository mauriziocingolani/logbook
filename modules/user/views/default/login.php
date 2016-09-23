<?php
/* @var $this mauriziocingolani\yii2fmwkphp\View */
/* @var $model app\modules\user\models\LoginForm */

use yii\widgets\ActiveForm;
use mauriziocingolani\yii2fmwkphp\Html;
use rmrevin\yii\fontawesome\FA;

$this->title = 'Login';
$this->registerShowPasswordScript();
?>

<h1>Login</h1>

<?php if (YII_LOCKED) : ?>
    <div class="alert alert-warning" style="font-size: 20px;">
        <?= FA::icon('lock'); ?>
        L'accesso al gestionale &egrave; mentaneamente bloccato per manutenzione. Attendere prego...
    </div>
<?php endif; ?>

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
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                <?= Html::checkbox('reveal-password', false, ['id' => 'reveal-password']) ?> <?= Html::label('Mostra password', 'reveal-password', ['style' => 'font-weight: normal;']) ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary']) ?> 
                <p style="margin-top: 10px;"><?= Html::a('Dimenticato la password?', ['/password-dimenticata']); ?></p>
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
                    <a href="/user/default/auth?authclient=facebook" class="btn btn-default btn-block"><i class="fa fa-fw fa-facebook" style="color: #3b5998;"></i> Facebook</a>
                </p>

                <p>
                    <a href="/user/default/auth?authclient=twitter" class="btn btn-default btn-block"><i class="fa fa-fw fa-twitter" style="color: #1da1f2"></i> Twitter</a>
                </p>

                <p>
                    <a href="/user/default/auth?authclient=linkedin" class="btn btn-default btn-block"><i class="fa fa-fw fa-linkedin" style="color: #0077b5;"></i> Linkedin</a>
                </p>
            </div> 

        </div> 
    <?php endif; ?>

</div>
