<?php

/***
 * @var $this yii\web\View
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $searchModel BookSearch
 */

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\select2\Select2;
use core\forms\search\BookSearch;
use yii\widgets\ActiveForm;
use core\entities\Books;

$this->title = 'Книги';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="book-index">
    <div class="bd-example">
        <?php $form = ActiveForm::begin(['method' => 'get', 'options' => ['class' => 'row g-3']]); ?>
        <div class="col-md-4">
            <?= $form->field($searchModel, 'name')->textInput(['placeholder' => 'Название'])->label('Название книги') ?>
        </div>

        <div class="col-md-8">
            <?= $form->field($searchModel, 'description')->textInput(['placeholder' => 'Описание'])->label('Описание книги') ?>
        </div>

        <div class="col-4">
            <?= $form->field($searchModel, 'author_id')->widget(\kartik\select2\Select2::classname(), [
                'data' => $searchModel::getAuthors(),
                'options' => ['placeholder' => 'Выберите авторов ...', 'multiple' => true],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Автор книги') ?>
        </div>
        <div class="col-4">
            <?= $form->field($searchModel, 'language_id')->widget(\kartik\select2\Select2::classname(), [
                'data' => $searchModel::getLanguages(),
                'options' => ['placeholder' => 'Выберите язык ...', 'multiple' => true],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Язык  книги') ?>
        </div>

        <div class="col-4">
            <?= $form->field($searchModel, 'genre_id')->widget(\kartik\select2\Select2::classname(), [
                'data' => $searchModel::getGenres(),
                'options' => ['placeholder' => 'Выберите жанр ...', 'multiple' => false],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Жанр книги') ?>
        </div>

        <div class="col-2">
            <?= $form->field($searchModel, 'pageFrom')->textInput(['placeholder' => 'Страница от'])->label('Страница от') ?>
        </div>

        <div class="col-2">
            <?= $form->field($searchModel, 'pageTo')->textInput(['placeholder' => 'Страница до'])->label('Страница до') ?>
        </div>
        <div class="col-4">
            <?= $form->field($searchModel, 'status')->dropDownList(
                $searchModel::getStatusList(),
                ['prompt' => 'Выберите статус']
            )->label('Статус книги') ?>
        </div>
        <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>

        <?php ActiveForm::end(); ?>
    </div>
    <hr>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            [
                'attribute' => 'author_id',
                'label' => 'Автор',
                'value' => function (Books $model) {
                    return $model->author->name;
                }
            ],
            [
                'attribute' => 'language_id',
                'label' => 'Язык',
                'value' => function (Books $model) {
                    return $model->language->language_name;
                }
            ],
            [
                'attribute' => 'genre_id',
                'label' => 'Жанр',
                'value' => function (Books $model) {
                    return $model->genre->genre_name;
                }
            ],
            'name:text:Название книги',
            'description:text:Описание',
            'num_pages:text:Кол. страниц',

            [
                'attribute' => 'status',
                'label' => 'Статус',
                'format' => 'html',
                'value' => function (Books $model) {
                    $statuses = BookSearch::getStatusList();
                    return $statuses[$model->status] ?? 'Неизвестно';
                }
            ]
        ]
    ]) ?>
</div>

