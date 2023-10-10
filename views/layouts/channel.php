<?php

use Yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use app\assets\AppAsset;

AppAsset::register($this);

$this->title = Yii::$app->user->identity->username;

NavBar::begin([
        'brandLabel' => Yii::$app->user->identity->username." 's Channel",
        'brandUrl' => ['/channel/index'],
        'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark']
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => [
            ['label' => 'Upload Video', 'url' => ['/channel/create']],
            ['label' => 'Delete Videos', 'url' => ['/channel/delete']],
            ['label' => 'Update Videos', 'url' => ['/channel/update']],
        ]
    ]);
NavBar::end();
