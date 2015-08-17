<?php
/* @var $this mauriziocingolani\yii2fmwkphp\View */
/* @var $entry \app\models\Entry */
?>

<div class="panel panel-default entry-widget">
    <div class="panel-heading">
        <span class="badge"><?= date('d-m-Y', strtotime($entry->Created)); ?></span>
        <strong class="lb-obj"><!--<i class="fa fa-usd"></i>-->$<?= $entry->project->Slug; ?></strong>
        -
        by <strong><!--<i class="fa fa-at"></i>-->@<?= $entry->creator->UserName; ?></strong>
        <?php if (Yii::$app->user->isEditor()) : ?>
            <form id="<?= $entry->EntryID; ?>_entry_delete" action="" method="post" style="float: right;">
                <input name="_csrf" type="hidden" value="<?= Yii::$app->getRequest()->getCsrfToken(); ?>" />
                <input name="DeleteEntry[entryid]" type="hidden" value="<?= $entry->EntryID; ?>" />
                <a href="" onclick="deleteEntry(<?= $entry->EntryID; ?>);
                            return false;" title="Clicca per eliminare la voce">
                    <i class="fa fa-trash"></i>
                </a>
            </form>
        <?php endif; ?>
    </div>
    <div class="panel-body">
        <?= $entry->text; ?>
    </div>
</div>