<?php
/* @var $this mauriziocingolani\yii2fmwkphp\View */
/* @var $model app\modules\user\models\User[] */

use yii\grid\GridView;
use mauriziocingolani\yii2fmwkphp\Html;

$this->title = $this->addBreadcrumb('Utenti');
?>

<h1>Utenti</h1>

<p>
    <?= Html::faa('plus', 'Nuovo utente', ['/utenti/nuovo'], ['class' => 'btn btn-default']); ?>
</p>

<?=
GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        'UserID',
        [
            'attribute' => 'UserName',
            'format' => 'raw',
            'value' => function ($data) {
                return Html::a($data->UserName, '/utenti/' . $data->UserName);
            },
        ],
        'Email',
        [
            'attribute' => 'role',
            'value' => 'role.Description',
            'label' => 'Ruolo',
        ],
    ],
    'emptyText' => 'Nessun utente trovato',
]);
?>