<?php
/* @var $this mauriziocingolani\yii2fmwkphp\View */
/* @var $model app\models\Project */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $form2 yii\bootstrap\ActiveForm */
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

    <?php if (count($model->hashtags) > 0) : ?>

        <?php foreach ($model->hashtags as $hash) : ?>
            <div class="alert alert-info" style="display: inline-block;"><i class="fa fa-slack"></i><?= $hash->Name; ?></div>
        <?php endforeach; ?>

    <?php else : ?>

        <p><em>Nessun argomento impostato per questo progetto.</em></p>

    <?php endif; ?>

    <?php if (Yii::$app->session->hasFlash('hashtag-success')) : ?>
        <div class="alert alert-success"><?= Yii::$app->session->getFlash('hashtag-success'); ?></div>
    <?php elseif (Yii::$app->session->hasFlash('hashtag-danger')) : ?>
        <div class="alert alert-danger"><?= Yii::$app->session->getFlash('hashtag-danger'); ?></div>
    <?php endif; ?>

    <?php
    $form2 = ActiveForm::begin([
                'id' => 'hashtag-form',
            ])
    ?>

    <?= $form->field($hashtag, 'Name', ['enableLabel' => false])->input('Name', [ 'placeholder' => 'Nuovo argomento...', 'style' => 'width: 200px;']); ?>

    <div class="form-group">
        <?= Html::submitButton('Aggiungi nuovo argomento', ['class' => 'btn btn-default']) ?> 
    </div>

    <?php ActiveForm::end(); ?>

<?php endif; ?>