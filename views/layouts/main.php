<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'RGK Notification System',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    $navItems = [];


    if (Yii::$app->user->isGuest) {
        array_push($navItems,['label' => 'Войти', 'url' => ['/user/security/login']],['label' => 'Регистрация', 'url' => ['/user/registration/register']]);
    } else {

        if (Yii::$app->user->identity->isAdmin) {

            $navItems=[
                ['label' => 'Лог уведомлений', 'url' => ['/inbox/index']],
                ['label' => 'Уведомления', 'url' => ['/notifications/index']],
                ['label' => 'Тип уведомления', 'url' => ['/notifications-types/index']],
                ['label' => 'Статьи', 'url' => ['/articles/index']],
                ['label' => 'Пользователи', 'url' => ['/user/admin/index']],
            ];

        }
        else{

            $navItems=[
                ['label' => 'Мои уведомления', 'url' => ['inbox/view']]
            ];

        }

        array_push($navItems,['label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                'url' => ['/user/security/logout'],
                'linkOptions' => ['data-method' => 'post']]
        );
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $navItems,
    ]);

    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; RGK Notification System <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
