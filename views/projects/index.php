<?php
/* @var $this mauriziocingolani\yii2fmwkphp\View */

use yii\grid\GridView;
use mauriziocingolani\yii2fmwkphp\Html;

$this->title = $this->addBreadcrumb('Progetti');
?>

<h1 class="lb-obj"><!--<i class="fa fa-usd"></i>-->$Progetti</h1>

<p>
    <?= Html::faa('plus', 'Nuovo progetto', ['/progetti/nuovo'], ['class' => 'btn btn-default']); ?>
</p>

<?=
GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        'ProjectID',
        [
            'attribute' => 'Name',
            'format' => 'raw',
            'value' => function ($data) {
                return Html::a($data->Name, '/progetti/' . $data->Slug);
            },
        ],
    ],
    'emptyText' => 'Nessun progetto presente',
    'summary' => '<div style="text-align: right;">Progetti <strong>{begin}-{end}</strong> di <strong>{totalCount}</strong></div>',
    'pager' => [
        'firstPageLabel' => '&lt;&lt;',
        'prevPageLabel' => 'Prec.',
        'nextPageLabel' => 'Succ.',
        'lastPageLabel' => '&gt;&gt;',
        'options' => ['class' => 'pagination', 'style' => 'float: right;'],
    ],
]);
?>