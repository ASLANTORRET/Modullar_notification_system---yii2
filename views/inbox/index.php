<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\User;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\InboxSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Входящие';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inbox-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'article:ntext',
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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
