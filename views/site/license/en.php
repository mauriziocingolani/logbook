<?php

use mauriziocingolani\yii2fmwkphp\Html;

/* @var $this \app\controllers\SiteController */
$this->title = $this->addBreadcrumb('License');
$copyright = isset(Yii::$app->params['app']['copyrightUrl']) ?
        Html::a(Yii::$app->params['app']['copyright'], Yii::$app->params['app']['copyrightUrl'], ['target' => 'blank']) :
        Yii::$app->params['app']['copyright'];
?>

<h1>License</h1>

<p>The <strong><?= Yii::$app->name; ?></strong> application is free software. It is released under the terms of the following BSD License.</p>

<div class="alert alert-info">

    <p>
        Copyright &copy;<?= Yii::$app->params['app']['year']; ?>, 
        <?= $copyright; ?><br />
        All rights reserved.
    </p>

    <p>
        Redistribution and use in source and binary forms, with or without
        modification, are permitted provided that the following conditions are met:
    </p>

    <ol>
        <li>Redistributions of source code must retain the above copyright
            notice, this list of conditions and the following disclaimer.</li>
        <li>Redistributions in binary form must reproduce the above copyright
            notice, this list of conditions and the following disclaimer in the
            documentation and/or other materials provided with the distribution.</li>
        <li>Neither the name of <?= $copyright; ?> nor the names of its contributors
            may be used to endorse or promote products derived from this software 
            without specific prior written permission.</li>
    </ol>

    <p>
        This software is provided by <?= $copyright; ?> &ldquo;as is&rdquo; and any
        express or implied warranties, including, but not limited to, the implied
        warranties of merchantability and fitness for a particular purpose are
        dislcaimed. In no event shall <?= $copyright; ?> be liable for any
        direct, indirect, incidental, special, exemplary, or consequential damages
        (including, but not limited to, procurement of subsitute goods or services;
        loss of use, data, or profits; or business interruption) however caused and
        on any theory of liability, wheter in contract, strict liability, or tort
        (including negligence or otherwise) arising in any way out of the use of this
        software, even if advised of the possibility of such damage.
    </p>

</div>

<p>
    <?= Html::a('Italiano', ['/licenza'], ['class' => 'btn btn-default']); ?>
</p>