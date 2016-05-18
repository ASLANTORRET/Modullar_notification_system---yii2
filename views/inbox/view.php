<?php


use yii\widgets\ListView;
use yii\helpers\Html;
use app\models\Inbox;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\Inbox */


$this->registerJS(

    "function markasread(data){

             $.ajax({
            type     :'POST',
            cache    : false,
            url  : 'index.php?r=inbox/mark-as-read',
            data : {id : data },
            success  : function(response) {
    location.reload();
}
            });return false;
    }",

    View::POS_HEAD, 'my_options');

$this->title = 'Ваши уведомления';
?>

<h2>Ваши уведомления</h2>
<br>

<div class="inbox-view">

    <table class="table">

        <tr>
            <td><strong>Заголовок</strong></td>
            <td><strong>Текст</strong></td>
            <td><strong>От кого</strong></td>
            <td><strong>Кнопка</strong></td>
            <td><strong>Дата отправки</strong></td>
        </tr>

        <?= ListView::widget( [
            'dataProvider' => $dataProvider,
            'itemView' => '_list',
        ] );
        ?>

    </table>

</div>