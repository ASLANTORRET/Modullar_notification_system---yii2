<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\User;
use app\models\NotificationsTypes;
use app\models\Notifications;
/* @var $this yii\web\View */
/* @var $model app\models\Notifications */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="notifications-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'event_code')->dropDownList(Notifications::getEventList( 'Выберите событие' ), ['id'=>'client1','style' => 'width:400px;', 'onchange' => "changeInsert(this.value)"]) ?>

    <?= $form->field($model, 'title')->textInput(['id'=>'client2', 'style' => 'width:400px;']) ?>

    <?= $form->field($model, 'article')->textArea(['rows' => 6]) ?>

    <div id="inserts_block"></div>

    <?= $form->field($model, 'user_from')->dropDownList(User::listUsers( 'Выберите пользователя' ), ['id'=>'client3','style' => 'width:400px;']) ?>

    <?= $form->field($model, 'user_to')->dropDownList(User::listUsers( 'Все пользователи' ), ['id'=>'client4','style' => 'width:400px;']) ?>

    <?= $form->field($model, 'nt_id')->dropDownList(NotificationsTypes::listNotTypes(), ['id'=>'client5', 'multiple' => Yii::$app->controller->action->id == 'create' ? true : false,'style' => 'width:400px;']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Сохранить' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
