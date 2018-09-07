<?php

namespace backend\controllers;

use Yii;
use backend\models\Notifications;
use backend\models\NotificationsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\NotificationsHistory;
use yii\filters\AccessControl;
use backend\models\AstroDeviceInfo;

use sngrl\PhpFirebaseCloudMessaging\Client;
use sngrl\PhpFirebaseCloudMessaging\Message;
use sngrl\PhpFirebaseCloudMessaging\Recipient\Device;
use sngrl\PhpFirebaseCloudMessaging\Notification;
/**
 * NotificationsController implements the CRUD actions for Notifications model.
 */
class NotificationsController extends Controller
{
    /**
     * {@inheritdoc}
     */
public function behaviors()
    {
    	return [
    		
    			'verbs' => [
    					'class' => VerbFilter::className(),
    					'actions' => [
    							'delete' => ['POST'],
    					],
    			],
    	];
    }

    /**
     * Lists all Notifications models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NotificationsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Notifications model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionNotificationlist()
    {
    	$result = array();
    	$not_id = array();
    	
    	$D = date('Y-m-d H:i:s');
    	
    	$notificationdata = Notifications::find()->all();
    	
    	$notificationdataaa = Notifications::find()->where('schedule_time'<= $D)->all();
    	
    	//"schedule_time LIKE '$D %'"
    	//print_r($notificationdataaa);exit;
    	
    	
     	if($notificationdata){
    		$result["status"]="success";
    		$result["message"]="successfully view Notification list ";
    		for($n=0; $n<count($notificationdata); $n++){
    		    	
    		    	if($D <= $notificationdata[$n]['schedule_time'])
    		    	{
    		        	$result['notificationlist'][$n]['not_id']=$notificationdata[$n]['not_id'];
    		    		$result['notificationlist'][$n]['notification_type']=$notificationdata[$n]['notification_type'];
    		    		$result['notificationlist'][$n]['notification_title']=$notificationdata[$n]['notification_title'];
    		    		$result['notificationlist'][$n]['notification_description']=$notificationdata[$n]['notification_description'];
    		    		$result['notificationlist'][$n]['schedule_time']=$notificationdata[$n]['schedule_time'];
    		    	}
    			}
    		    		
    		}else{
    	    $result["status"]="fail";
    		$result["message"]="don't have notifications";
    	}
    	return $result;
    }
    public function actionView($id)
    {
    	
    	//echo"hai";exit();
    	$result = array();
    	$notificationdata = Notifications::find()->where(['not_id' =>  $id])->one();
    	
    	if($notificationdata){
    	$result["status"]="success";
    	$result["message"]="successfully view notification details";
    	
    	//$result['notificationdata']=$notificationdata;
    	$result['notificationview']['not_id']=$notificationdata['not_id'];
    	$result['notificationview']['notification_type']=$notificationdata['notification_type'];
    	$result['notificationview']['notification_title']=$notificationdata['notification_title'];
    	$result['notificationview']['notification_description']=$notificationdata['notification_description'];
    	$result['notificationview']['schedule_time']=$notificationdata['schedule_time'];
    	}else{
    	    $result["status"]="fail";
    		$result["message"]="don't have notifications";
    	}
    	return $result;
    	    }

    /**
     * Creates a new Notifications model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Notifications();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
        	$model->created_by=Yii::$app->user->id;
        	$model->created_date=date('Y-m-d H:i:s');
        	$model->save();
            return $this->redirect(['view', 'id' => $model->not_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Notifications model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
        	$model->updated_by=Yii::$app->user->id;
        	$model->updated_date=date('Y-m-d H:i:s');
        	$model->save();
            return $this->redirect(['view', 'id' => $model->not_id]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Notifications model.
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
     * Finds the Notifications model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Notifications the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Notifications::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionNotificationhistory()
    {
    	date_default_timezone_set("Asia/Kolkata");
    	$presenttime = date("Y-m-d G:i:s");
    	$notificationdata = Notifications::find()->where("schedule_time <= '$presenttime'")->asArray()->all();
    	$deviceUsers = AstroDeviceInfo::find()->select('*')->innerJoin('user','astro_device_info.uid=user.id')->where("user.status=10")->all();
    	
    	//print_r($deviceUsers);exit();
    	foreach($notificationdata as $data)
    	{
    		foreach ($deviceUsers as $deviceInfo)
    		{
    					if($deviceInfo['deviceType'] == 'Android'){
    						$server_key = 'AIzaSyBfU4pD7SQyfc7BUgp_RyBDbgWVFCZPiy0';
    					}
    					if($deviceUsers->deviceType == 'IOS'){
    							$server_key = 'AIzaSyA7p6dCGdHwBJ6W6CJn1dP0REF4lhdIIUE';
    					}
    			$client = new Client();
    			$client->setApiKey($server_key);
    			$client->injectGuzzleHttpClient(new \GuzzleHttp\Client());
    			$setNotifications = new Notification($data['notification_title'], $data['notification_description']);
    			$setNotifications->setSound(true);
    		
    			$message = new Message();
    			$message->setPriority('high');
    			$message->addRecipient(new Device($deviceInfo['deviceToken']));
    			$message
    			->setNotification($setNotifications)
    		
    			;
    			 
    			$response = $client->send($message);
    		}
    		$history  = new NotificationsHistory();
    		$history->not_id = $data['not_id'];
    		$history->notification_type = $data['notification_type'];
    		$history->notification_title = $data['notification_title'];
    		$history->notification_description = $data['notification_description'];
    		$history->schedule_time = $data['schedule_time'];
    		$history->created_date = date("Y-m-d h:i:s");
    		$history->updated_date =date("Y-m-d h:i:s");
    		$history->created_by = Yii::$app->user->identity->id;
    		$history->updated_by = Yii::$app->user->identity->id;
    		$history->save();
    	}
    	Notifications::deleteAll("schedule_time <= '$presenttime'");
    	
    }
    
    public function actionNotificationhistorylist()
    {
        $result = array();
        $NotificationsHistorylist =NotificationsHistory::find()->orderBy(['notification_historyid'=>SORT_DESC])->limit(10)->all();
       // print_r($NotificationsHistorylist);exit;
        if($NotificationsHistorylist){
    		$result["status"]="success";
    		$result["message"]="successfully view notification details list";
    		for($n=0; $n<count($NotificationsHistorylist); $n++){
    		$result['notificationhistorylist'][$n]['not_id']=$NotificationsHistorylist[$n]['not_id'];
    		$result['notificationhistorylist'][$n]['notification_type']=$NotificationsHistorylist[$n]['notification_type'];
    		$result['notificationhistorylist'][$n]['notification_title']=$NotificationsHistorylist[$n]['notification_title'];
    		$result['notificationhistorylist'][$n]['notification_description']=$NotificationsHistorylist[$n]['notification_description'];
    		$result['notificationhistorylist'][$n]['schedule_time']=$NotificationsHistorylist[$n]['schedule_time'];
    		}
    	}else{
    		$result["status"]="fail";
    		$result["message"]="don't have notifications";
    	}
    	return $result;
    
    }
}
