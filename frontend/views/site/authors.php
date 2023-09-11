<?php
/***
 * @var $this yii\web\View
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $searchModel AuthorSearch
 */

use yii\grid\GridView;
use core\forms\search\AuthorSearch;
use kartik\datetime\DateTimePicker;

$this->title = 'Авторы';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="author-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'name:text:Название автора',
            [
                'attribute' => 'birthdate',
                'label' => 'Дата рождения',
                'filter' => \kartik\date\DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'birthdate',
                    'options' => ['placeholder' => 'Дата рождения'],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]),
            ],
            'biography:text:Биография автора',
            [
                'attribute' => 'status',
                'label' => 'Статус',
                'format' => 'html',
                'filter' => \yii\helpers\Html::activeDropDownList(
                    $searchModel,
                    'status',
                    $searchModel::getStatusList(),
                    ['class' => 'form-control', 'prompt' => 'Статус']
                ),
                'value' => function ($model) {
                    $statuses = AuthorSearch::getStatusList();
                    return $statuses[$model->status] ?? 'Неизвестно';
                }
            ]
        ]
    ]) ?>
</div>

