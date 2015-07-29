<?php

namespace app\components\widgets;

use yii\base\Widget;
use app\models\Entry;

/**
 * @property Entry $Entry
 */
class EntryWidget extends Widget {

    public $entry;

    public function run() {
        return $this->render('entryWidget', ['entry' => $this->entry]);
    }

}
