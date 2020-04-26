<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $news app\models\News */
/* @var $topic app\models\Topic */
/* @var $similarNews app\models\News[] */

$this->title = $news->title;
$this->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$formatter = Yii::$app->formatter;
?>
<main class="news-view">
    <section class="lead row">
        <header class="col-lg-12">
            <h1 class="text-center"><?= Html::encode($this->title) ?></h1>
        </header>
        <div class="col-lg-9">
            <?= $news->favorite ? "<strong>Избранное</strong> <span class='glyphicon glyphicon-star' aria-hidden='true'></span>" : '' ?>
            Дата публикации: <?= $formatter->asDate($news->created_at) ?>,
            Тема: <?= Html::a($topic->name, ['news/topic', 'id' => $topic->id]) ?>
        </div>
        <div class="col-lg-3">
            <?php if (!empty($news->update_at)) : ?>
                Последнее обновление: <?= $formatter->asDate($news->update_at) ?>
            <?php endif; ?>
        </div>
    </section>
    <section class="row">
        <?= $news->img ? Html::img("@img/$news->img", [
            'alt' => $news->title,
            'class' => 'img-responsive center-block'
        ]) : '' ?>
        <p class="text-justify col-lg-12">
            <?= Html::encode($news->body) ?>
        </p>
    </section>


    <section class="row">
        <header class="col-lg-12 text-center">
            <h2>Связанные новости:</h2>
        </header>
        <?php
        foreach ($similarNews as $news) : ?>
            <div class="col-lg-4">
                <div class="equal-header">
                    <h3 class=""><?= $news->title ?></h3>
                </div>
                <p><?= HTML::a('Читать далее', ['news/view', 'id' => $news->id]) ?></p>
            </div>
        <?php endforeach; ?>
        </div>

    </section>

</main>
