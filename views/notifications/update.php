<?php

use yii\helpers\Html;
use yii\web\View;

$this->registerJS(

    "function changeInsert(data){

             $.ajax(
                {
                    type     :'POST',
                    cache    : false,
                    url  : 'index.php?r=notifications/get-inserts',
                    data : {event_code : data },
                    success  : function(response) {
                        $('#inserts_block').html(response);
                    }
                }
            );

            return false;
    }",

    View::POS_HEAD, 'my_options');

/* @var $this yii\web\View */
/* @var $model app\models\Notifications */

$this->title = 'Редактирование уведомления: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Уведомления', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="notifications-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
