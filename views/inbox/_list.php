<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>


<tr bgcolor=" <?= $model->is_new ? '#dcdcdc' : '#ffffff'?>">

    <td><?= Html::encode($model->title) ?></td>
    <td><?= HtmlPurifier::process($model->article) ?></td>
    <td><?= HtmlPurifier::process($model->userFrom->username) ?></td>

    <td><?= $model->is_new ? (Html::a('Прочитано','', [
            'title' => Yii::t('yii', 'Отметить как прочитанный'),
            'onclick'=>"markasread({$model->id});",
        ])) : ''?>

    </td>

    <td><?= Yii::t('user', '{0, date, MMMM dd, YYYY HH:mm}', [$model->created_at]) ?></td>

</tr>

