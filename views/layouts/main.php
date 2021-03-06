<?php
/* @var $this \yii\web\View */

use app\assets\AppAsset;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use mauriziocingolani\yii2fmwkphp\Html;

AppAsset::register($this);
?>

<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <title><?= Html::encode($this->title) ?></title>
        <?= Html::csrfMetaTags() ?>
        <?php $this->registerMetaTag(['charset' => Yii::$app->charset]); ?>
        <?php $this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1']); ?>
        <?php $this->registerMetaTag(['name' => 'description', 'content' => Yii::$app->params['description']]); ?>
        <?php $this->head() ?>
        <link rel="icon" type="image/png" href="http://logbook.mauriziocingolani.it//favicon.png" />
    </head>

    <body>
        <?php $this->beginBody(); ?>

        <?= $this->render('//navbar'); ?>

        <div class="container">
            <?=
            Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ])
            ?>
            <?= $content ?>
        </div>

        <footer>
            <div class="container">
                <p class="pull-left">
                    <i class="fa fa-bookmark-o" style="font-size: 30px;"></i> <span style="font-size: 24px;"><?= Yii::$app->name; ?></span>
                    <small>&copy;<?= Yii::$app->params['app']['year']; ?></small>
                    <br />
                    Versione: <?= Yii::$app->version; ?>
                    <?php if (!Yii::$app->user->isGuest) : ?>
                        <br />
                        <small>
                            Powered by <?= Html::a('Yii ' . Yii::getVersion(), 'http://www.yiiframework.com/doc-2.0/index.html', ['target' => 'blank']); ?>
                            (php: <?= PHP_VERSION; ?>)
                        </small>
                    <?php endif; ?>
                    <br />
                    <small><?= Html::a('Licenza', ['/licenza']); ?></small>
                </p>
                <p class="social pull-right">
                    Sviluppo web: <?= \yii\helpers\Html::a('Maurizio Cingolani', 'http://www.mauriziocingolani.it', ['target' => 'blank']); ?><br />
                    <?= Html::famailto('envelope-o', null, 'm.cingolani@ggfgroup.it'); ?>
                    <?= Html::faa('linkedin-square', null, 'https://www.linkedin.com/in/mauriziocingolani/it', ['target' => 'blank', 'title' => 'Linkedin - Maurizio Cingolani']); ?>
                    <?= Html::faa('twitter-square', null, 'https://www.twitter.com/m_cingolani', ['target' => 'blank', 'title' => 'Twitter - @m_cingolani']); ?>
                    <?= Html::faa('github-square', null, 'https://github.com/mauriziocingolani', ['target' => 'blank', 'title' => 'Github - mauriziocingolani']); ?>
                </p>
            </div>
        </footer>

        <?php $this->endBody(); ?>
    </body>

</html>
<?php $this->endPage(); ?>