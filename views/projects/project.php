<?php
/* @var $this mauriziocingolani\yii2fmwkphp\View */
/* @var $model app\models\Project */
/* @var $name string */

use yii\bootstrap\ActiveForm;
use mauriziocingolani\yii2fmwkphp\Html;

$this->addBreadcrumb('Progetti', 'progetti');
$this->title = $this->addBreadcrumb($model->isNewRecord ? 'Nuovo progetto' : 'Progetto $' . $model->Slug);
?>

<h1>
    <?php if ($model->isNewRecord) : ?>
        <?= $name; ?>
    <?php else : ?>
        Progetto <span class="lb-obj"><i class="fa fa-usd"></i><?= $name; ?></span>
    <?php endif; ?>
</h1>

<?php if (!$model->isNewRecord) : ?>
    <p class="created">
        Creato il <?= date('d-m-Y', strtotime($model->Created)); ?> 
        da <strong><i class="fa fa-at"></i><?= $model->creator->UserName; ?></strong>
        <?php if ($model->Updated) : ?>
            - Aggiornato il <?= date('d-m-Y', strtotime($model->Updated)); ?> 
            da <strong><i class="fa fa-at"></i><?= $model->updater->UserName; ?></strong>
        <?php endif; ?>
    </p>
<?php endif; ?>

<!-- Flash -->
<?php foreach (Yii::$app->session->allFlashes as $type => $message) : ?>
    <div class="alert alert-<?= $type; ?>">
        <?= $message; ?>
    </div>
<?php endforeach; ?>

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

<?php if (!$model->isNewRecord) : ?>

    <hr />

    <h3 class="lb-obj"><i class="fa fa-slack"></i>Argomenti</h3>

<?php endif; ?>