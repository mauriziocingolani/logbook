<?php
/* @var $this mauriziocingolani\yii2fmwkphp\View */
/* @var $model app\models\Project */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $form2 yii\bootstrap\ActiveForm */
/* @var $name string */

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
use yii\helpers\Url;
use mauriziocingolani\yii2fmwkphp\Html;

$this->addBreadcrumb('Progetti', 'progetti');
$this->title = $this->addBreadcrumb($model->isNewRecord ? 'Nuovo progetto' : 'Progetto $' . $model->Slug);
?>

<h1>
    <?php if ($model->isNewRecord) : ?>
        <?= $name; ?>
    <?php else : ?>
        Progetto <span class="lb-obj"><!--<i class="fa fa-usd"></i>-->$<?= $name; ?></span>
    <?php endif; ?>
</h1>

<!-- INFO -->
<?php if (!$model->isNewRecord) : ?>
    <p class="created">
        Creato il <?= date('d-m-Y', strtotime($model->Created)); ?> 
        da <strong><!--<i class="fa fa-at"></i>-->@<?= $model->creator->UserName; ?></strong>
        <?php if ($model->Updated) : ?>
            - Aggiornato il <?= date('d-m-Y', strtotime($model->Updated)); ?> 
            da <strong><!--<i class="fa fa-at"></i>-->@<?= $model->updater->UserName; ?></strong>
        <?php endif; ?>
    </p>
<?php endif; ?>

<!-- FLASH -->
<?php if (Yii::$app->session->hasFlash('success')) : ?>
    <div class="alert alert-success"><?= Yii::$app->session->getFlash('success'); ?></div>
<?php elseif (Yii::$app->session->hasFlash('danger')) : ?>
    <div class="alert alert-danger"><?= Yii::$app->session->getFlash('danger'); ?></div>
<?php endif; ?>

<!-- FORM -->
<?php
$form = ActiveForm::begin([
            'id' => 'project-form',
            'options' => ['class' => 'form-vertical'],
        ]);
?>

<?= $form->field($model, 'Name')->input('text'); ?>

<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Crea' : 'Aggiorna', ['class' => 'btn btn-primary']) ?> 
</div>

<?php ActiveForm::end(); ?>

<?php if (!$model->isNewRecord) : ?>

    <hr />

    <!-- ARGOMENTI -->
    <h3 class="lb-obj"><!--<i class="fa fa-slack"></i>-->#Argomenti</h3>

    <?php if (count($model->hashtags) > 0) : ?>

        <script>
            function submitDeleteForm(hashtagid) {
                console.log('pippo');
                if (confirm('Sei sicuro di voler eliminare questo argomento?')) {
                    $('#' + hashtagid + '_hashtag_delete').submit();
                }
            }
        </script>

        <?php foreach ($model->hashtags as $hash) : ?>
            <?php
            Alert::begin([
                'options' => [
                    'class' => 'alert-info',
                    'style' => 'display: inline-block;margin-right: 10px;',
                ],
                'closeButton' => false,
            ]);
            ?>
            <?= $hash->Slug; ?>
            <form id="<?= $hash->HashtagID; ?>_hashtag_delete" action="/progetti/<?= $model->Slug; ?>" method="post" style="display: inline-block;">
                <input name="DeleteHashtag[hashtagid]" type="hidden" value="<?= $hash->HashtagID; ?>" />
                <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>" />
                <a href="" title="Clicca per eliminare l'argomento" onclick="submitDeleteForm(<?= $hash->HashtagID; ?>);
                        return false;"><i class="fa fa-times"></i></a>
            </form>
            <?php Alert::end();
            ?>
        <?php endforeach; ?>

    <?php else : ?>

        <p><em>Nessun argomento impostato per questo progetto.</em></p>

    <?php endif; ?>

    <?php if (Yii::$app->session->hasFlash('hashtagsuccess')) : ?>
        <div class="alert alert-success"><?= Yii::$app->session->getFlash('hashtagsuccess'); ?></div>
    <?php elseif (Yii::$app->session->hasFlash('hashtagdanger')) : ?>
        <div class="alert alert-danger"><?= Yii::$app->session->getFlash('hashtagdanger'); ?></div>
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