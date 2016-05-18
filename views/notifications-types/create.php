<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\NotificationsTypes */

$this->title = 'Create Notifications Types';
$this->params['breadcrumbs'][] = ['label' => 'Notifications Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notifications-types-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
