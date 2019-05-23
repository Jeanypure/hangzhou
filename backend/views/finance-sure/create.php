<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\SampleReturn */

$this->title = 'Create Sample Return';
$this->params['breadcrumbs'][] = ['label' => 'Sample Returns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sample-return-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
