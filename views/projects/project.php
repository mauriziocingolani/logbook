<?php
/* @var $this mauriziocingolani\yii2fmwkphp\View */
/* @var $model app\models\Project */

use yii\bootstrap\ActiveForm;
use mauriziocingolani\yii2fmwkphp\Html;

$this->addBreadcrumb('Progetti', 'progetti');
$this->title = $this->addBreadcrumb($model->isNewRecord ? 'Nuovo progetto' : 'Utente ' . $model->Slug);
?>

<h1>
    <?php if ($model->isNewRecord) : ?>
        Nuovo progetto
    <?php else : ?>
        Progetto <span class="lb-obj"><i class="fa fa-usd"></i><?= $model->Slug; ?></span>
    <?php endif; ?>
</h1>

<?php if (Yii::$app->session->hasFlash('success')) : ?>
    <div class="alert alert-success">
        <?= Yii::$app->session->getFlash('success'); ?>
    </div>
<?php elseif (Yii::$app->session->hasFlash('error')) : ?>
    <div class="alert alert-danger">
        <?= Yii::$app->session->getFlash('error'); ?>
    </div>
<?php endif; ?>

<?php
$form = ActiveForm::begin([
            'id' => 'project-form',
            'options' => ['class' => 'form-vertical'],
        ])
?>

<?= $form->field($model, 'Name')->input('text'); ?>

<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Crea' : 'Aggiorna', ['class' => 'btn btn-primary']) ?> 
</div>

<?php ActiveForm::end(); ?>