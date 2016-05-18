<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\NotificationsTypes;
use app\models\User;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NotificationsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Уведомления';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notifications-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать уведомление', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php if(Yii::$app->session->hasFlash('create_message')): ?>
        <div class="alert alert-success" role="alert">
            <?= Yii::$app->session->getFlash('create_message') ?>
        </div>
    <?php endif; ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'event_code',
            'article',
            'title',
            [
                'attribute' => 'user_from',
                'value' => 'userFrom.username',
                'filter' => Html::activeDropDownList($searchModel, 'user_from',
                    ArrayHelper::map( User::find()->asArray()->all(),
                        'id',
                        'username'),
                    ['class'=>'form-control','prompt' => '----Все----']),
            ],
            [
                'attribute' => 'user_to',

                'value' => 'userTo.username',
                'filter' => Html::activeDropDownList($searchModel, 'user_to',
                    ArrayHelper::map( User::find()->asArray()->all(),
                        'id',
                        'username'),
                    ['class'=>'form-control','prompt' => '----Все----']),
            ],
            [
                'attribute' => 'nt_id',
                'value' => 'nt.type',
                'filter' => Html::activeDropDownList($searchModel, 'nt_id',
                    ArrayHelper::map( NotificationsTypes::find()->asArray()->all(),
                        'id',
                        'type'),
                    ['class'=>'form-control','prompt' => 'Выберите тип']),
            ],
            // 'sdate',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
