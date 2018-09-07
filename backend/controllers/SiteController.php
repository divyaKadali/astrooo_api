<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use yii\web\Response;
use yii\filters\auth\HttpBasicAuth ;
use common\models\User;
use app\models\UserSecurityTokens;
use backend\models\UserDetails;

use backend\models\Users;
use backend\models\PasswordResetRequestForm;
//use backend\models\ResetPasswordForm;
use backend\models\AstroDeviceInfo;

/**
 * Site controller
 */
class SiteController extends Controller
{
	
	
	/**
	 * Finds user by username and password
	 *
	 * @param string $username
	 * @param string $password
	 * @return static|null
	 */
	
    /**
     * @inheritdoc
     */
   /*  public function behaviors()
    {
    	$behaviors = parent::behaviors();
	
		$behaviors['contentNegotiator'] = [
				'class' => 'yii\filters\ContentNegotiator',
				'formats' => [
						'application/json' => Response::FORMAT_JSON,
				]
		];
	
		$behaviors['authenticator'] = [
				'class' => HttpBasicAuth::className(),
				'auth' => [$this, 'authenticate']
		];
	
		return $behaviors;
    }
		
		public function authenticate($username, $password)
		{
			// username, password are mandatory fields
			if(empty($username) || empty($password)) {
				return null;
			}
		
			// get user using requested email
			$user = User::findByUsername($username);
		
			// if no record matching the requested user
			if(empty($user)) {
				return null;
			}
		
			// if password validation fails
			if(!User::validatePassword($password)) {
				return null;
			}
		
			// if user validates (both user_email, user_password are valid)
			return $user;
		} */

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
    	$this->layout = false;
        //echo 'hello';
        
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        
    	$model = new LoginForm();
    	$tokenModel = new UserSecurityTokens();
    	$astrowDeviceinfo = new AstroDeviceInfo();
    	$result = array();
    	
    	
    	if ($model->load(\Yii::$app->getRequest()->getBodyParams(), '') && $model->login()) {
    		
    		$username = Users::find()->where(['username'=>$model->username])->orwhere(['email'=>$model->username])->one(); 
    		
    		if(!empty($username) && $username->status == 10)
    		{
    			
    	     $result['status'] = 'success';
             $result['message'] = 'login successfully';
             $result['result']['userid'] = $model->user->id;
             $result['result']['username'] = $model->user->username;
             $result['result']['email'] = $model->user->email;
             $userdetail=UserDetails::find()->where(['userid'=>$model->user->id])->one();
             $result['result']['first_name'] =$userdetail->first_name;
             $result['result']['first_name'] = $userdetail->first_name;
             $result['result']['last_name'] = $userdetail->last_name;
             $result['result']['dateofbirth'] = $userdetail->dateofbirth;
             $result['result']['timeofbirth'] = $userdetail->timeofbirth;
             $result['result']['placeofbirth'] = $userdetail->placeofbirth;
             $result['result']['current_city'] = $userdetail->current_city;
             $result['result']['current_state'] = $userdetail->current_state;
             $result['result']['current_country'] = $userdetail->current_country;
             $result['result']['mobile'] = $userdetail->mobile;
             $result['result']['dasa_at_birth'] = $userdetail->dasa_at_birth;
             $result['result']['dasa_end_date'] = $userdetail->dasa_end_date;
     
             $tokenModel->userId = $model->user->id;
             $tokenModel->token = \Yii::$app->security->generateRandomString();
             $tokenModel->status = 'Active';
             $tokenModel->createdDate = date('Y-m-d H:i:s');
             $tokenModel->save();
             $result['result']['token'] = $tokenModel->token;
             
             
             $getastrowDeviceinfo=AstroDeviceInfo::find()->where(['uId'=>$model->user->id])->one();
             if(!empty($getastrowDeviceinfo)){
             $userid = $getastrowDeviceinfo->uId;
             }else{
             $userid = '';
             }
             
             if($userid != $model->user->id || $userid == ' '){
             	
             	$astrowDeviceinfo->uId = $model->user->id;
             	$astrowDeviceinfo->notification_status = 1;
             	$astrowDeviceinfo->deviceToken =$model->deviceToken;
             	$astrowDeviceinfo->createdDate = date('Y-m-d H:i');
             	$astrowDeviceinfo->deviceType =$model->deviceType;
             	$astrowDeviceinfo->save();
               }else{
             	$getastrowDeviceinfo->notification_status = 1;
             	$getastrowDeviceinfo->deviceToken =$model->deviceToken;
             	$getastrowDeviceinfo->mobileDeviceToken =$model->mobileDeviceToken;
             	$getastrowDeviceinfo->createdDate = date('Y-m-d H:i');
             	$getastrowDeviceinfo->deviceType =$model->deviceType;
             	$getastrowDeviceinfo->save();
                }
    		    }else{
    			$result['status'] = 'fail';
                $result['message'] = "your details are not updated";
    			
    		}

        } 
        else {
       
        $username = Users::find()->where(['username'=>$model->username])->orwhere(['email'=>$model->username])->one(); 
      
        if(empty($username))
         {
         $result['status'] = 'fail';
         $result['message'] = "incorrect username";
         }else if(!empty($username)){
         $result['status'] = 'fail';
         $result['message'] = "incorrect password";
         }
        }
        return $result;
    }
    
   

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
    	
        Yii::$app->user->logout();

        return $this->goHome();
    }
   
  
    
    public function actionRequestpasswordreset()
    {
        $model = new PasswordResetRequestForm();
        $result = array();
    	
        if ($model->load(\Yii::$app->getRequest()->getBodyParams(), '') ) {
    		if ($model->sendEmail()) {
    		$result['status']='success';
    		$result['message']="Check your email for further instructions.";
    		} else {
    		$result['status']='fail';
    		$result['message']="Sorry, we are unable to reset password for the provided email address.";
    		}
    	}
    	return $result;

    }
   
  
    
    
}
