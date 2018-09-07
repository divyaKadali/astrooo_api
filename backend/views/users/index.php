<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\Userssearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-index">
<div class="box box-primary">
<div class="box-body">

    <h1><?php // Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Users', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
            'username',
            'email:email',
            //'password_hash',
            //'password_reset_token',
            //'email:email',
            //'status',
            //'roleId',
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn',
            		'template' => '{view} {update} {delete} {addhoroscope} {horoscope} {viewhoroscope} {analysis} {compatibilitydata}',
            		'buttons' => [
            				'horoscope' => function ($url,$data) {
            				$url = Url::to(['/horoscopeplanets/create','id'=>$data->id]);
            				return Html::a(
            						'<span class="glyphicon glyphicon-certificate"></span>',
            						$url,['title'=>'HoroscopePlanets Create']);
            				 
            				},
            				
            				'viewhoroscope' => function ($url,$data) {
            				$url = Url::to(['/horoscopeplanets/view','id'=>$data->id]);
            				return Html::a(
            						'<span class="glyphicon glyphicon-adjust"></span>',
            						$url,['title'=>'HoroscopePlanets View']);
            				 
            				},
            				'analysis' => function ($url,$data) {
            				$url = Url::to(['/horoscopeplanets/horoscopeanalysis','id'=>$data->id]);
            				return Html::a(
            						'<span class="glyphicon glyphicon-star-empty"></span>',
            						$url,['title'=>'Analysis View']);
            				 
            				},
            				'compatibilitydata' => function ($url,$data) {
            				$url = Url::to(['/compatibilitydata/index','id'=>$data->id]);
            				return Html::a(
            						'<span class="glyphicon glyphicon glyphicon-random"></span>',
            						$url,['title'=>'compatibilitydata']);
            				 
            				},
            				
            				
            		]
        		],
        ],
    ]); ?>
</div>
</div>
</div>
