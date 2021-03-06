<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use mauriziocingolani\yii2fmwkphp\Html;
use app\components\widgets\EntryWidget;
use app\models\Entry;
use app\models\Project;
use app\modules\user\models\User;

/* @var $this mauriziocingolani\yii2fmwkphp\View */
/* @var $form ActiveForm */
/* @var $entry Entry */
/* @var $users User[] */

$this->title = $this->addBreadcrumb('Log');
?>

<h1>Log</h1>

<hr />

<!-- Form inserimento entry -->
<?php if (Yii::$app->user->isEditor()) : ?>

    <?php foreach (Yii::$app->session->getAllFlashes() as $flash) : ?>
        <div class="alert alert-<?= $flash; ?>"><?= Yii::$app->session->getFlash($flash); ?></div>
    <?php endforeach; ?>

    <?php
    $form = ActiveForm::begin([
                'id' => 'entry-form',
                'options' => ['class' => 'form-vertical'],
    ]);
    ?>

    <?=
    $form->field($entry, 'ProjectID', [
        'template' => '{label} <div class="row"><div class="col-sm-6 col-md-4">{input}{error}</div></div>',
    ])->dropDownList(ArrayHelper::map(Project::GetAll(), 'ProjectID', 'Name'));
    ?>
    <?=
    $form->field($entry, 'EntryText', [
        'template' => '{label} <div class="row"><div class="col-sm-6 col-md-4">{input}{error}</div></div>',
    ])->textarea(['placeholder' => 'Testo della nuova voce...']);
    ?>

    <div class="form-group">
        <?= Html::submitButton('Inserisci nuova voce', ['class' => 'btn btn-primary']); ?>
    </div>

    <?php ActiveForm::end(); ?>

    <hr />

<?php endif; ?>

<!-- Elenco entries -->

<script>
    function deleteEntry(entryid) {
        if (confirm('Sei sicuro di voler eliminare questa voce?')) {
            $('#' + entryid + '_entry_delete').submit();
        }
    }
</script>

<?php if (Yii::$app->session->hasFlash('entrysuccess')) : ?>
    <div class="alert alert-success"><?= Yii::$app->session->getFlash('entrysuccess'); ?></div>
<?php elseif (Yii::$app->session->hasFlash('entrydanger')) : ?>
    <div class="alert alert-danger"><?= Yii::$app->session->getFlash('entrydanger'); ?></div>
<?php endif; ?>

<?php foreach (Entry::GetAll(5) as $en) : ?>
    <?= EntryWidget::widget(['entry' => $en]); ?>
<?php endforeach; ?>