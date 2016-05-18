<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\NotificationsTypes */

$this->title = $model->type;
$this->params['breadcrumbs'][] = ['label' => 'Типы уведомлений', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notifications-types-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'type',
            [
                'label' => 'Время создания',
                'value' => Yii::t('user', '{0, date, MMMM dd, YYYY HH:mm}', [$model->created_at])
            ],
            [
                'label' => 'Время посл.редактирования',
                'value' => Yii::t('user', '{0, date, MMMM dd, YYYY HH:mm}', [$model->updated_at])
            ],
        ],
    ]) ?>

</div>
