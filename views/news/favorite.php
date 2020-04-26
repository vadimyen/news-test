<?php

/* @var $this yii\web\View */

/* @var $news app\models\News */

use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = 'Новостник';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Новостной сайт для тестового задания Red-Promo</h1>

        <h2>Избранные новости</h2>

    </div>

    <div class="body-content">

        <div class="row">
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
