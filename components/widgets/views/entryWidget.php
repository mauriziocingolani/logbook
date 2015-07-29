<?php
/* @var $this mauriziocingolani\yii2fmwkphp\View */
/* @var $entry \app\models\Entry */
?>

<div class="panel panel-default entry-widget">
    <div class="panel-heading">
        <span class="badge"><?= date('d-m-Y', strtotime($entry->Created)); ?></span>
        by <strong><i class="fa fa-at"></i><?= $entry->creator->UserName; ?></strong>
    </div>
    <div class="panel-body">
        <?= $entry->text; ?>
    </div>
</div>