<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Users */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-view">
<div class="box box-primary">
<div class="box-body">



    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    


   
  
    
    <div class="panel panel-default col-md-6">
	<div class="panel-body">
	
    <div class="container col-md-12">
    
    <h2>Detail View</h2>
    <hr>
    
    <div class="row">
    <div class="col-sm-4" ><a>UserName</a></div>
    <div class="col-sm-4" >:</div>
    <div class="col-sm-4" ><?= $model->username; ?></div></li>
    </div></br>
    <div class="row">
    <div class="col-sm-4" ><a>Email</a></div>
    <div class="col-sm-4" >:</div>
    <div class="col-sm-4" ><?= $model->email; ?></div></li>
    </div></br>
     <div class="row">
    <div class="col-sm-4" ><a>First Name </a></div>
    <div class="col-sm-4" >:</div>
    <div class="col-sm-4" ><?= $userdetailview->first_name; ?></div></li>
    </div></br>
     <div class="row">
    <div class="col-sm-4" ><a>Last Name </a></div>
    <div class="col-sm-4" >:</div>
    <div class="col-sm-4" ><?= $userdetailview->last_name; ?></div></li>
    </div></br>
     <div class="row">
    <div class="col-sm-4" ><a>Date Of Birth </a></div>
    <div class="col-sm-4" >:</div>
    <div class="col-sm-4" ><?php if ($userdetailview->dateofbirth == '0000-00-00'){
    	echo " ";}else{ echo date('d-M-Y',strtotime($userdetailview->dateofbirth));}?></div></li>
    </div></br>
     <div class="row">
    <div class="col-sm-4" ><a>Time Of Birth </a></div>
    <div class="col-sm-4" >:</div>
    <div class="col-sm-4" ><?= $userdetailview->timeofbirth; ?></div></li>
    </div></br>
     <div class="row">
    <div class="col-sm-4" ><a>Current City </a></div>
    <div class="col-sm-4" >:</div>
    <div class="col-sm-4" ><?= $userdetailview->current_city; ?></div></li>
    </div></br>
    
     <div class="row">
    <div class="col-sm-4" ><a>current_state </a></div>
    <div class="col-sm-4" >:</div>
    <div class="col-sm-4" ><?= $userdetailview->current_state; ?></div></li>
    </div></br>
     <div class="row">
    <div class="col-sm-4" ><a>Current Country</a></div>
    <div class="col-sm-4" >:</div>
    <div class="col-sm-4" ><?= $userdetailview->current_country; ?></div></li>
    </div></br>
    
     <div class="row">
    <div class="col-sm-4" ><a>Mobile </a></div>
    <div class="col-sm-4" >:</div>
    <div class="col-sm-4" ><?= $userdetailview->mobile; ?></div></li>
    </div></br>
     <div class="row">
    <div class="col-sm-4" ><a>Dasa At Birth </a></div>
    <div class="col-sm-4" >:</div>
    <div class="col-sm-4" ><?= $userdetailview->dasa_at_birth; ?></div></li>
    </div></br>
        <div class="row">
    <div class="col-sm-4" ><a>Dasa End Date </a></div>
    <div class="col-sm-4" >:</div>
    <div class="col-sm-4" >
    <?php if ($userdetailview->dasa_end_date == '0000-00-00'){echo " ";
    }else{
    echo date('d-M-Y',strtotime($userdetailview->dasa_end_date));}?></div></li>
    </div>
    <hr>
  
  
    </div>
    </div>
    </div>


</div>
</div>
</div>
