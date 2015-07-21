<?php
/* @var $this mauriziocingolani\yii2fmwkphp\View */
/* @var $model app\modules\user\models\User */

use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use app\modules\user\models\Role;

$this->addBreadcrumb('@Utenti', 'utenti');
$this->title = $this->addBreadcrumb($model->isNewRecord ? 'Nuovo utente' : 'Utente @' . $model->UserName);
?>

<h1>
    <?php if ($model->isNewRecord) : ?>
        Nuovo utente
    <?php else : ?>
        Utente <span class="lb-obj"><i class="fa fa-at"></i><?= $model->UserName; ?></span>
    <?php endif; ?>
</h1>

<!-- Flash -->
<?php foreach (Yii::$app->session->allFlashes as $type => $message) : ?>
    <div class="alert alert-<?= $type; ?>">
        <?= $message; ?>
    </div>
<?php endforeach; ?>

<?php
$form = ActiveForm::begin([
            'id' => 'user-form',
            'options' => ['class' => 'form-vertical'],
        ])
?>

<?= $form->field($model, 'UserName')->textInput(['readonly' => !$model->isNewRecord]); ?>
<?= $form->field($model, 'RoleID')->dropDownList(ArrayHelper::map(Role::find()->all(), 'RoleID', 'Description')); ?>
<?= $form->field($model, 'Email')->textInput(); ?>
<?= $form->field($model, 'Password1')->passwordInput(); ?>
<?= $form->field($model, 'Password2')->passwordInput(); ?>

<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Crea' : 'Aggiorna', ['class' => 'btn btn-primary']) ?> 
</div>

<?php ActiveForm::end(); ?>

<div class="alert alert-info">
    <p><strong>Regole per il nome utente:</strong></p>
    <ul>
        <li>lunghezza minima 3 caratteri, massima 20</li>
        <li>pu&ograve; contenere solo lettere minuscole, numeri e underscore ( _ )</li>
        <li>deve iniziare con una lettera</li>
        <li>non pu&ograve; terminare con un underscore</li>
    </ul>
</div>


