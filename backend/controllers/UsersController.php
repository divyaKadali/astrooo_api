<?php

namespace backend\controllers;

use Yii;
use backend\models\Users;
use backend\models\Userssearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\User;
use backend\models\UserDetails;
use backend\models\Planets;
use yii\filters\AccessControl;

use backend\models\AstroDeviceInfo;


use backend\models\ResetPasswordForm;
/**
 * UsersController implements the CRUD actions for Users model.
 */
class UsersController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
//         		'access' => [
//         				'class' => AccessControl::className(),
//         				'only' => [
//         						'index','create','update','view','delete'
//         				],
//         				'rules' => [
//         						[
        				
//         								'allow' => true,
//         								'roles' => ['@'],
        				
//         						],
//         				]
//         		],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Users models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new Userssearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionUserslist()
    {
    	$result=[];
    	$searchModel = new Userssearch();
        $userdetailview=UserDetails::find()->all();
        $result[] =$userdetailview;
    	
    	//print_r($userdetailview);exit;
    	return $result;
    }

    /**
     * Displays a single Users model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
 
     	$userdetailview=UserDetails::find()->where(['userid'=>$id])->one();
     	$users=Users::find()->where(['id'=>$id])->one();
     	$result['status']="success";
     	$result['message']="user detail view";
     	
     	$result['userdetailview']['userId']=$userdetailview->userId;
     	$result['userdetailview']['username']=$users->username;
     	$result['userdetailview']['email']=$users->email;
     	$result['userdetailview']['mobile']=$userdetailview->mobile;
     	$result['userdetailview']['first_name']=$userdetailview->first_name;
     	$result['userdetailview']['last_name']=$userdetailview->last_name;
     	$result['userdetailview']['dateofbirth']=$userdetailview->dateofbirth;
     	$result['userdetailview']['timeofbirth']=$userdetailview->timeofbirth;
     	$result['userdetailview']['placeofbirth']=$userdetailview->placeofbirth;
     	$result['userdetailview']['current_city']=$userdetailview->current_city;
     	$result['userdetailview']['current_state']=$userdetailview->current_state;
     	$result['userdetailview']['current_country']=$userdetailview->current_country;
     	$result['userdetailview']['address']=$userdetailview->address;
     	

        return $result;
          
    }
    public function actionRemedies($id)
    {
        $userdetailview=UserDetails::find()->where(['userid'=>$id])->one();
        $result['status']="success";
        $result['message']="successfully view remedies";
        if(!empty($userdetailview->remedies)){
    	 $result['remedies']=$userdetailview->remedies;
        }else{
        	$result['remedies']=" ";
        	
        }
    
    
    	return $result;
    
    }

    /**
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
    	
      //echo "hai";exit;
        $model = new Users();
        $user = new User();
        $userDetails = new UserDetails();
        $astrowDeviceinfo = new AstroDeviceInfo();
        $model->scenario = 'create';
        $result = [];
      
       
       if($model->load(\Yii::$app->getRequest()->getBodyParams(),'') ) {
       	
            $modelvalues = User::find()->where(['username'=> $model->username])->one();
           if(empty($modelvalues))
            {
            $username = Users::find()->where(['username'=>$model->username])->orwhere(['email'=>$model->email])->one(); 
            if(empty($username))
            {
            
            $result['status']="success";
            $result['message']="success fully registered";
            $user->username = $model->username;
        	$user->email = $model->email;
        	$user->roleId = 2;
        	$user->status = 0;
        	$user->setPassword($model->password);
        	$user->generateAuthKey();        	
        	$user->save();
        	
        	$userDetails->userId = $user->id;
        	$userDetails->first_name = $model->first_name;
        	$userDetails->last_name = $model->last_name;
        	
        	if(!empty($model->dateofbirth )){
        		$userDetails->dateofbirth = date('Y-m-d',strtotime($model->dateofbirth));
        	}else{
        		$userDetails->dateofbirth = '0000-00-00';
        	}
        	$userDetails->timeofbirth = $model->timeofbirth;        	
        	$userDetails->placeofbirth = $model->placeofbirth;
        	$userDetails->current_city = $model->current_city;        	
        	$userDetails->current_state = $model->current_state;
        	$userDetails->current_country = $model->current_country;
        	$userDetails->mobile = $model->mobile;
        	$userDetails->dasa_at_birth = $model->dasa_at_birth;
        	$userDetails->dasa_end_date = date('Y-m-d H:i',strtotime($model->dasa_end_date));
        	if(!empty($model->dasa_end_date )){
        	$userDetails->dasa_end_date = date('Y-m-d H:i',strtotime($model->dasa_end_date));
        	}else{
        	    $userDetails->dasa_end_date = '0000-00-00';
        	}
        	$userDetails->save();
        	$astrowDeviceinfo->uId = $user->id;
        	$astrowDeviceinfo->notification_status = 1;
        	$astrowDeviceinfo->deviceToken =$model->deviceToken;
        	$astrowDeviceinfo->mobileDeviceToken =$model->mobileDeviceToken;
        	$astrowDeviceinfo->createdDate = date('Y-m-d H:i');
        	$astrowDeviceinfo->deviceType =$model->deviceType;
        	
                	
        	$astrowDeviceinfo->save();
        	}else {
        	    $result['status'] = 'fail';
        		$result['message'] = "Email has already been taken.";
        	}
        	}else{
        		$result['status']="fail";
        		$result['message']="already registered";
        	}
       }

        	

       return $result ;
    }

    /**
     * Updates an existing Users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate()
    {

     $model = new Users();
     $user = new User();
     $model->scenario = 'create';
     $result = [];
 
     if($model->load(\Yii::$app->getRequest()->getBodyParams(),'') ) {

	        $modelvalues = User::find()->where(['id'=> $model->userid])->one();
	       
	   	        
            $model->save();
            $UserDetails= UserDetails::find()->where(['userid'=>$model->userid])->one();
            $UserDetails->userId=$model->userid;
        	$UserDetails->first_name=$model->first_name;
        	$UserDetails->last_name=$model->last_name;
        	$UserDetails->dateofbirth=  date('Y-m-d',strtotime($model->dateofbirth)); 
        	$UserDetails->timeofbirth=$model->timeofbirth;
        	$UserDetails->placeofbirth=$model->placeofbirth;
        	$UserDetails->current_city=$model->current_city;
        	$UserDetails->current_state=$model->current_state;
        	$UserDetails->current_country=$model->current_country;
        	$UserDetails->address=$model->address;
        	$UserDetails->mobile=$model->mobile;
        	$UserDetails->dasa_at_birth=$model->dasa_at_birth;
        	$UserDetails->dasa_end_date= date('Y-m-d H:i',strtotime($model->dasa_end_date));
        	$UserDetails->save();
        	
        	$result['status']="success";
        	$result['message']=" profile update Successfully";
	            
        }
        else{
        	$result['status']='fail';
        	$result['messge']='try again';
        }
        
        return $result;

    }
    
    public function getToken($token)
    {
    	$model=Users::model()->findByAttributes(array('token'=>$token));
    	if($model===null)
    		throw new CHttpException(404,'The requested page does not exist.');
    		return $model;
    }
    
    
    public function actionChangepassword()
    {
    	    
    	try {
    		$model = new ResetPasswordForm();
    	} catch (InvalidParamException $e) {
    		throw new BadRequestHttpException($e->getMessage());
    	}
    	    	
     	$result = [];
     	if($model->load(\Yii::$app->getRequest()->getBodyParams(),'') ) {
    		$userid = $model->userid;
    		$docinfo = User::find()->where(['id' => $userid])->one();
    		$model->resetPassword($model->userid);
    		$result['status']='success';
    		$result['message']='New password was saved';
    		
     		return $result;
    	}else{
     		$result['status']='fail';
    		$result['message']='Please try again';
    	}
    	
    
    }
    

    /**
     * Deletes an existing Users model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
