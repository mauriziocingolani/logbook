<?php
/* @var $this mauriziocingolani\yii2fmwkphp\View */
/* @var $entry \app\models\Entry */
?>

<div class="panel panel-default entry-widget">
    <div class="panel-heading">
        <strong><?= date('d-m-Y', strtotime($entry->Created)); ?></strong>
        by <span class="lb-obj"><i class="fa fa-at"></i><?= $entry->creator->UserName; ?></span>
    </div>
    <div class="panel-body">
        <?= $entry->text; ?>
    </div>
</div>