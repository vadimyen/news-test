<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $news app\models\News[] */
/* @var $topic app\models\Topic|null */
/* @var $newsCount int */
/* @var $search string|null */
$title = 'Новости';
$title .= !empty($topic) ? " по теме $topic->name" : "";
$title .= !empty($search) ? " по запросу «" . Html::encode($search) . "»" : '';
$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">
    <h1><?= Html::encode($title) ?></h1>
    <?= $newsCount ? "<p class='text-center lead'>Найдено результатов:  $newsCount </p>" : '' ?>
    <div class="body-content">
        <div class="row equal">
            <?php
            if (empty($newsCount)): ?>
                <div class="col-lg-12">
                    <h3>К сожалению, ничего не найдено</h3>
                    <p><?= $search ? HTML::a('Вернуться на главную', Url::home()) : '' ?></p>
                </div>
            <?php endif; ?>
            <?php
            foreach ($news as $item) : ?>
                <div class="col-lg-4">
                    <div class="equal-header">
                        <h3 class=""><?= $item->title ?></h3>
                    </div>
                    <p><?= HTML::a('Читать далее', ['news/view', 'id' => $item->id]) ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="row">
            <div class="col-lg-12 text-center">
                <?= LinkPager::widget(['pagination' => $pagination]) ?>
            </div>
        </div>
    </div>
</div>
