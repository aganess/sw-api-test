<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'API KEY';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <?php if (!Yii::$app->user->isGuest) :?>
        <h4><?= Yii::$app->user->identity->getApiKey() ?></h4>

        <p>Your API KEY</p>

    <?php else:?>
        <p><a href="<?= \yii\helpers\Url::to(['/site/signup'])?>">Register to get the key</a> </p>
    <?php endif;?>

</div>
