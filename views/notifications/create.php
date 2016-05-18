<?php

use yii\helpers\Html;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\Notifications */


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

$this->title = 'Создать уведомление';
$this->params['breadcrumbs'][] = ['label' => 'Уведомления', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notifications-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
