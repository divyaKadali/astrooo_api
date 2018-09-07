<?php

namespace backend\controllers;

use Yii;
use backend\models\DailyPlanets;
use backend\models\DailyplanetsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Rashi;
use yii\web\UploadedFile;
use backend\models\UserDetails;
use backend\models\HoroscopePlanets;
use backend\models\Planets;
use backend\models\PlanetsPositions;
use backend\models\Monthly;
use backend\models\Yearly;
use backend\models\GochaaramDaily;
/**
 * DailyplanetsController implements the CRUD actions for DailyPlanets model.
 */
class DailyplanetsController extends Controller
{
    /**
     * @inheritdoc
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
     * Lists all DailyPlanets models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DailyplanetsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DailyPlanets model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
 public function actionView($id)
    {
    	
    	$modeldate =DailyPlanets::find()->select('planet_date')->where(['dpId'=>$id])->one();
    	$planetdate= date('d-M-Y H:i:s A',strtotime($modeldate->planet_date));
    	
    	 //print_r($model->planet_date);exit;
    	
    	
        return $this->render('view', [
            'model' => $this->findModel($id),
        	'planetdate' => $planetdate,
        ]);
    }
    
    public function actionDailyplanetdateold()
    {
    	ob_start();
    	$result = array();
    	$dailyplanets ='';
    	$model = new DailyPlanets();
    	if ($model->load(\Yii::$app->getRequest()->getBodyParams(), '')) {
    		
    		$id = $model->userid;
    	}    	
        $d = date("Y-m-d");
       
        $userDetails = UserDetails::find()->select("user.*,user_details.*")->innerJoin("user","user.id = user_details.userId")->where("user_details.userId = $id")->one();
        $horoscopeDetails = HoroscopePlanets::find()->select("horoscopedetails.rashiId,horoscopedetails.lagnaLord as lagnaLordinfo,horoscopedetails.rashiName as lagnaRashi,horoscope_planets.*")->innerJoin("horoscopedetails","horoscopedetails.horId = horoscope_planets.horoscopeId")->where("horoscope_planets.userid = $id")->orderBy('horoplanetId ASC')->all();
        if(!empty($horoscopeDetails)){
        $moonSign = $horoscopeDetails[0]->rashiname;       
        if(!empty($d)){
       	$modeldate =DailyPlanets::find()->where(['planet_date'=>$d])->all();       	
       	$planets = Planets::find()->select('planetName')->orderBy('planetId ASC')->all();
       	$rashiId = Rashi::find()->where(['rashiName'=>$moonSign])->one();
       	$reshiOrders = $this->getRashiOrderbyLagna($rashiId['rashiId']);        
       	for($i=0;$i<count($planets)-2;$i++)
       	{
       		$dailyplanets = trim($modeldate[0][$planets[$i]['planetName']]);   
       		//print_r($modeldate);exit;
       		$key= array_search($dailyplanets,$reshiOrders);
       		$pos = $key+1;
       		$positionvalue = PlanetsPositions::find()->select($planets[$i]['planetName'])->where(['position_id'=>$pos])->one();
       		$resultarray['daily_'.$planets[$i]['planetName']]=$positionvalue[$planets[$i]['planetName']];
       	}      
       	
        $result['status'] = 'success';
    	$result['message'] = 'successfully view user daily details';
    	$result['result']=$resultarray;
        }else{
        	$result['status'] = 'fail';
        	$result['message'] = 'no result';
        }
        }
        else {
        	$result['status'] = 'fail';
        	$result['message'] = 'no User Found';
        }
        return $result;
    }
    public function actionDailyplanetmonth()
    {
    	ob_start();
    	$result = array();
    	$dailyplanets ='';
    	$model = new DailyPlanets();
    	if ($model->load(\Yii::$app->getRequest()->getBodyParams(), '')) {
         $id = $model->userid;
    	}
    	$userDetails = UserDetails::find()->select("user.*,user_details.*")->innerJoin("user","user.id = user_details.userId")->where("user_details.userId = $id")->one();
    	$horoscopeDetails = HoroscopePlanets::find()->select("horoscopedetails.rashiId,horoscopedetails.lagnaLord as lagnaLordinfo,horoscopedetails.rashiName as lagnaRashi,horoscope_planets.*")->innerJoin("horoscopedetails","horoscopedetails.horId = horoscope_planets.horoscopeId")->where("horoscope_planets.userid = $id")->orderBy('horoplanetId ASC')->all();
    	if(!empty($horoscopeDetails)){
    	 	$moonSign = $horoscopeDetails[0]->rashiname;
    	$positionvalue = Monthly::find()->select(['description'])->where(['rashi_name'=>$moonSign])->one();
    	if(!empty($positionvalue)){
    	$result['status'] = 'success';
    	$result['message'] = 'successfully view user month details';
    	$result['moon']=$positionvalue->description;
    	}
    	}
    	else {
    		$result['status'] = 'fail';
    		$result['message'] = 'no User Found';
    	}
    	return $result;
    }
   
    public function actionDailyplanetyear()
    {
    	ob_start();
    	$result = array();
    	$dailyplanets ='';
    	$model = new DailyPlanets();
    	if ($model->load(\Yii::$app->getRequest()->getBodyParams(), '')) {
            $id = $model->userid;
    	}
    	$userDetails = UserDetails::find()->select("user.*,user_details.*")->innerJoin("user","user.id = user_details.userId")->where("user_details.userId = $id")->one();
    	$horoscopeDetails = HoroscopePlanets::find()->select("horoscopedetails.rashiId,horoscopedetails.lagnaLord as lagnaLordinfo,horoscopedetails.rashiName as lagnaRashi,horoscope_planets.*")->innerJoin("horoscopedetails","horoscopedetails.horId = horoscope_planets.horoscopeId")->where("horoscope_planets.userid = $id")->orderBy('horoplanetId ASC')->all();
    	if(!empty($horoscopeDetails)){
    	$moonSign = $horoscopeDetails[0]->rashiname;
    	$positionvalue = Yearly::find()->select(['description'])->where(['rashi_name'=>$moonSign])->one();
    	if(!empty($positionvalue)){
    	$result['status'] = 'success';
    	$result['message'] = 'successfully view user year details';
    	$result['moon']=$positionvalue->description;
    	}
    	}
    	else {
    		$result['status'] = 'fail';
    		$result['message'] = 'no User Found';
    	}
    	return $result;
    }
    public function actionDailyplanetdate()
    {
    	ob_start();
    	$result = array();
    	$dailyplanets ='';
    	$model = new DailyPlanets();
    	if ($model->load(\Yii::$app->getRequest()->getBodyParams(), '')) {
            $id = $model->userid;
    	}
    	$userDetails = UserDetails::find()->select("user.*,user_details.*")->innerJoin("user","user.id = user_details.userId")->where("user_details.userId = $id")->one();
    	$horoscopeDetails = HoroscopePlanets::find()->select("horoscopedetails.rashiId,horoscopedetails.lagnaLord as lagnaLordinfo,horoscopedetails.rashiName as lagnaRashi,horoscope_planets.*")->innerJoin("horoscopedetails","horoscopedetails.horId = horoscope_planets.horoscopeId")->where("horoscope_planets.userid = $id")->orderBy('horoplanetId ASC')->all();
    	if(!empty($horoscopeDetails)){
    	$moonSign = $horoscopeDetails[0]->rashiname;
    	$positionvalue = GochaaramDaily::find()->select(['description'])->where(['rashi_name'=>$moonSign])->one();
    	if(!empty($positionvalue)){
    	$result['status'] = 'success';
    	$result['message'] = 'successfully view user daily details';
    	$result['result']['daily_Moon']=$positionvalue->description;
    	$result['result']['daily_Jupiter']="";
    	$result['result']['daily_Mercury']="";
    	$result['result']['daily_Sun']="";
    	$result['result']['daily_Mars']="";
    	$result['result']['daily_Venus']="";
    	$result['result']['daily_Saturn']="";
    	
    	}
    	}
    	else {
    		$result['status'] = 'fail';
    		$result['message'] = 'no User Found';
    	}
    	return $result;
    }

    /**
     * Creates a new DailyPlanets model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DailyPlanets();
        $model->scenario = 'create';
        $rashilist = array();
        $rashi = Rashi::find()->all();
       foreach ($rashi as $r)
       {
       	$rashilist['']="Select Rashi";
       	$rashilist[$r->rashiName]=$r->rashiName;
       }

        if ($model->load(Yii::$app->request->post())) {
        	$date = date('Y-m-d H:i:s',strtotime($model->planet_date));
        	$planetdate = date('d-M-Y H:i:s',strtotime($model->planet_date));
        	$model->planet_date = $date;
            if($model->validate())
            {
            	
            	$model->save();
            }
            else {
            	$model->planet_date = date('d-M-Y H:i:s',strtotime($model->planet_date));
            	return $this->render('create', [
            			'model' => $model,
            			'rashilist'=>$rashilist
            	]);
            }
        	
            return $this->redirect(['view', 'id' => $model->dpId]);
        }

        return $this->render('create', [
            'model' => $model,
        		'rashilist'=>$rashilist
        ]);
    }

    /**
     * Updates an existing DailyPlanets model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        
	
        $modeldate =DailyPlanets::find()->select('planet_date')->where(['dpId'=>$id])->one();
        $model = $this->findModel($id); 
       // print_r($model->Ketu);exit;
        $model->planet_date= date('d-M-Y H:i:s',strtotime($modeldate->planet_date));
       
        $rashilist = array();
        $rashi = Rashi::find()->all();
        foreach ($rashi as $r)
        {
        	$rashilist['']="Select Rashi";
        	$rashilist[$r->rashiName]=$r->rashiName;
        }
		//print_r($rashilist);exit;
        if ($model->load(Yii::$app->request->post())) {
        $date = date('Y-m-d H:i:s',strtotime($model->planet_date));
        	$planetdate = date('d-M-Y H:i:s',strtotime($model->planet_date));
        	$model->planet_date = $date;
            if($model->validate())
            {
            	
            	$model->save();
            }
            else {
            	$model->planet_date = date('d-M-Y H:i:s',strtotime($model->planet_date));
            	return $this->render('create', [
            			'model' => $model,
            			'rashilist'=>$rashilist
            	]);
            }
            return $this->redirect(['view', 'id' => $model->dpId]);
        }

        return $this->render('update', [
            'model' => $model,
        	'rashilist'=>$rashilist
        ]);
    }

    /**
     * Deletes an existing DailyPlanets model.
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
     * Finds the DailyPlanets model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DailyPlanets the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DailyPlanets::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionUpload()
    {
    	
    	$model = new DailyPlanets();
    	$model->scenario = 'upload';
    	if($model->load(Yii::$app->request->post()))
    	{
    		$file =  UploadedFile::getInstance($model,'file');
    		$filename = 'Data.'.$file->extension;
    		$upload = $file->saveAs('uploads/'.$filename);
    		if($upload){
    			define('CSV_PATH','uploads/');
    			$csv_file = CSV_PATH . $filename;
    			  $filecsv = file($csv_file); 
    			
    			  for($i = 0;$i<count($filecsv);$i++){ 
    			  	if($i > 0)
    			  	{
    			  	$planet = explode(",",$filecsv[$i]);
    			  	$modelnew = new DailyPlanets();
    			  	$planetdate = date('Y-m-d H:i:s',strtotime($planet[0]));
    			 // print_r($planetdate);exit;
    			  	$modelnew->planet_date = $planetdate;
    			  	$modelnew->Moon = $planet[1];    			  
    			  	$modelnew->Jupiter = $planet[2];
    			  	$modelnew->Mercury = $planet[3];
    			  	$modelnew->Sun = $planet[4];
    			  	$modelnew->Mars = $planet[5];
    			  	$modelnew->Venus = $planet[6];
    			  	$modelnew->Saturn = $planet[7];
    			  	/* $modelnew->Rahu = $planet[8];
    			  	$modelnew->Ketu = $planet[9]; */
    			  	$modelnew->save();
    			  	//print_r($modelnew->errors);exit;   
    			  	}
    			  }
    			 
    			  //unlink('uploads/'.$filename);
    			  return $this->redirect(['index']);
    		}
    		
    		
    	}
    	else {
    		return $this->render('upload',['model'=>$model]);
    	}
    	  	
    }
    public function getRashiOrderbyLagna($lagnaRashiId)
    {
    	$allRashiDetails = Rashi::find()->all();
    	$allrashi = array();
    	$addingarray = array();
    	foreach ($allRashiDetails as $rashidetails)
    	{
    		if($rashidetails->rashiId < $lagnaRashiId)
    		{
    			$addingarray[] = $rashidetails->rashiName;
    		}
    		else{
    			$allrashi[] = $rashidetails->rashiName;
    		}
    	}
    	 
    	for($i=0; $i< count($addingarray); $i++)
    	{
    		array_push($allrashi, $addingarray[$i]);
    	}
    	 
    	return $allrashi;
    }
    
}
