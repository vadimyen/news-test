<?php

/* @var $this \yii\web\View */

/* @var $content string */

/* @var $topics \app\models\Topic[] */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);

$topicList = array_map(function ($topic) {
    return ['label' => $topic->name, 'url' => ['news/topic', 'id' => $topic->id]];
}, $this->params['topics']);


$formUrl = Url::to(['news/default', 'search']);
$searchInput = "<form action='$formUrl' class='navbar-form navbar-left' role='search'>
         <div class='form-group'>
               <input style='color: black' type='text' name='search' class='input-sm' placeholder='Найти'>
         </div>
       <button type='submit' class='btn btn-sm'>Поиск</button>
</form>";
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Новостник',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Все новости', 'url' => ['news/default']],
            ...$topicList,
            ['label' => $searchInput, 'url' => null, 'encode' => false],
        ]

    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Еникеев Вадим <?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
