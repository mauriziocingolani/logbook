<?php
/* @var $this mauriziocingolani\yii2fmwkphp\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $entry app\models\Entry */

use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use mauriziocingolani\yii2fmwkphp\Html;
use app\models\Entry;
use app\models\Project;

$this->title = $this->addBreadcrumb('Log');
?>

<h1>Log</h1>

<hr />

<?php foreach (Yii::$app->session->getAllFlashes() as $flash) : ?>
    <div class="alert alert-<?= $flash; ?>"><?= Yii::$app->session->getFlash($flash); ?>)</div>
<?php endforeach; ?>

<?php if (Yii::$app->session->hasFlash('success')) : ?>
    <div class="alert alert-success"><?= Yii::$app->session->getFlash('success'); ?></div>
<?php elseif (Yii::$app->session->hasFlash('danger')) : ?>
    <div class="alert alert-danger"><?= Yii::$app->session->getFlash('danger'); ?></div>
<?php endif; ?>

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

<ul>
    <?php foreach (Entry::GetAll(5) as $en) : ?>
        <li>
            <em><?= date('d-m-Y', strtotime($en->Created)); ?></em>
            -
            <span class="lb-obj"><i class="fa fa-usd"></i><?= $en->project->Slug; ?></span>
            :
            <?= $en->text; ?>
        </li>
    <?php endforeach; ?>
</ul>
