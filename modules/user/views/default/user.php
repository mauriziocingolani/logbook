<?php
/* @var $this mauriziocingolani\yii2fmwkphp\View */
/* @var $model app\modules\user\models\User */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->addBreadcrumb('Utenti', 'utenti');
$this->title = $this->addBreadcrumb($model->isNewRecord ? 'Nuovo utente' : 'Utente ' . $model->UserName);
?>

<h1>
    <?php if ($model->isNewRecord) : ?>
        Nuovo utente
    <?php else : ?>
        Utente <u><?= $model->UserName; ?></u>
    <?php endif; ?>
</h1>

<?php if (Yii::$app->session->hasFlash('success')) : ?>

    <div class="alert alert-success">
        <?= Yii::$app->session->getFlash('success'); ?>
    </div>

<?php else : ?>

    <?php if (Yii::$app->session->hasFlash('error')) : ?>
    <div class="alert alert-danger">
        <?= Yii::$app->session->getFlash('error'); ?>
    </div>
    <?php endif; ?>

    <?php
    $form = ActiveForm::begin([
                'id' => 'user-form',
                'options' => ['class' => 'form-vertical'],
            ])
    ?>

    <?= $form->field($model, 'UserName')->textInput(); ?>
    <?= $form->field($model, 'Email')->textInput(); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crea' : 'Aggiorna', ['class' => 'btn btn-primary']) ?> 
    </div>

    <?php ActiveForm::end(); ?>

<?php endif; ?>
