<?php

namespace backend\controllers;

use Yii;
use backend\models\HoroscopePlanets;
use backend\models\HoroscopeplanetsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Rashi;
use common\models\User;
use backend\models\HoroscopeplanetsSearchmain;
use backend\models\Nakshatrams;
use backend\models\Users;
use backend\models\Horoscopedetails;
use backend\models\PlanetStrengths;
use backend\models\StrengthsInfo;
use yii\filters\AccessControl;

use yii\db\Query;

use backend\models\PlanetsPositions;
use backend\models\UserDetails;
use backend\models\PredictionByPlanetRaasi;
use backend\models\PredictionLordInOtherLordRaasis;
use backend\models\DailyPlanets;
use backend\models\Planets;
use backend\models\StrenghtPredictionlordinotherlord;

use backend\models\BhavaDetails;
use backend\models\UserBhavasStrengths;
use backend\models\LagnaResults;

/**
 * HoroscopeplanetsController implements the CRUD actions for HoroscopePlanets model.
 */
class HoroscopeplanetsController extends Controller
{
    /**
     * @inheritdoc
     */
//     public function behaviors()
//     {
//         return [
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
//             'verbs' => [
//                 'class' => VerbFilter::className(),
//                 'actions' => [
//                     'delete' => ['POST'],
//                 ],
//             ],
//         ];
//     }

    /**
     * Lists all HoroscopePlanets models.
     * @return mixed
     */
    public function actionIndex()
    {
    	//print_r(Yii::$app->user->id);exit();
        $searchModel = new HoroscopeplanetsSearchmain();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HoroscopePlanets model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
   
  public function actionView($id)
    {
    	
  $model = HoroscopePlanets::find()->distinct()->where(['userid'=> $id])->all();
  $result = array();
  $rashiresult = array();
  $rashi = array();
  $navamsaresult = array();
  $empres = array();
  $k =array();
  $empress = array();
  $short_planets=['MOON'=>'Mn','JUPITER'=>'Ju','MERCURY'=>'Me','SUN'=>'Su','MARS'=>'Ma','VENUS'=>'Ve','SATURN'=>'Sa','RAHU'=>'Ra','KETU'=>'Ke'];
  $saticrashis= Rashi::find()->select('rashiId,rashiName')->orderBy('rashiId ASC')->all();
   for($i = 0;$i<count($saticrashis);$i++)
  {
  	$empres[$saticrashis[$i]['rashiName']] = $saticrashis[$i]['rashiName'];
  }
  foreach($model as $v)
    {       	
    	$rashi[$v->rashiname] = $v->rashiname;
    	$navamsa[$v->navamsa_position] = $v->navamsa_position;
   		$rashiresult[$v->rashiname][] = $short_planets[$v->planet];  
        $navamsaresult[$v->navamsa_position][] = $short_planets[$v->planet];   	 	
    }
  
  $res = array_diff(array_values($empres),array_values($rashi));
  $rearray = array_values($res);
  for($i=0; $i<count($rearray);$i++){
  	$rashiresult[$rearray[$i]][]= '';
  }
  $navres = array_diff(array_values($empres),array_values($navamsa));
  $navrearray = array_values($navres);
  for($i=0; $i<count($navrearray);$i++){
  	$navamsaresult[$navrearray[$i]][]= '';
  }
  
     array_walk($rashiresult, create_function('&$v', '$v = (count($v) == 1)? array_pop($v):implode(",",$v);'));
     array_walk($navamsaresult, create_function('&$v', '$v = (count($v) == 1)? array_pop($v):implode(",",$v);'));
     $p=0;
     foreach($rashiresult as $key=>$v)
     {
     	$rashiresult2[$p]['HouseName']= $key;
     	$rashiresult2[$p]['HouseValue']= $v;
     	$p++;
     	
     } 
     $p1=0;
    foreach($navamsaresult as $key=>$v)
     {
     	$rashiresult3[$p1]['HouseName']= $key;
     	$rashiresult3[$p1]['HouseValue']= $v;
     	$p1++;
     	
     } 
     $userdob = UserDetails::find()->where(['userid'=> $id])->one();
     
   //  print_r($userdob);exit;
      
     $result["status"]="success";
     $result["message"]="successfully view user houses details";
     $result['janma']=$rashiresult2;
     $result['navamsha']=$rashiresult3;
     $result['dateofbirth'] = $userdob->dateofbirth;
     $result['timeofbirth']= $userdob->timeofbirth;

  
   return $result;
 
    }
    
    
    public function actionViewnew($id)
    {
    	$model = HoroscopePlanets::find()->distinct()->where(['userid'=> $id])->all();
    	$result = array();
    	$rashiresult = array();
    	$rashi = array();
    	$navamsaresult = array();
    	$empres = array();
    	$k =array();
    	$empress = array();
    	$userrasi = array();
    	
    	$navamsa = array();
    	$short_planets=['MOON'=>'Mn','JUPITER'=>'Ju','MERCURY'=>'Me','SUN'=>'Su','MARS'=>'Ma','VENUS'=>'Ve','SATURN'=>'Sa','RAHU'=>'Ra','KETU'=>'Ke'];
    	$saticrashis= Rashi::find()->select('rashiId,rashiName')->orderBy('rashiId ASC')->all();
    	for($i = 0;$i<count($saticrashis);$i++)
    	{
    		$empres[$saticrashis[$i]['rashiName']] = $saticrashis[$i]['rashiName'];
    	}
    	
    	foreach($model as $v)
    	{
    		$userrasi[]=$v->navamsa_position;
    		$rashi[$v->rashiname] = $v->rashiname;
    		$navamsa[$v->navamsa_position] = $v->navamsa_position;
    		$rashiresult["janma_".trim($v->rashiname)][] = $short_planets[$v->planet];
    		$navamsaresult["navamsha_".trim($v->navamsa_position)][] = $short_planets[$v->planet];
    	}
    	if(!empty($empres) && !empty($rashi)){
    	$res = array_diff(array_values($empres),array_values($rashi));    	
    	$rearray = array_values($res);
    	for($i=0; $i<count($rearray);$i++){
    		$rashiresult["janma_".trim($rearray[$i])][]= '';
    	}
    	}
    	
    	if(!empty($empres) && !empty($navamsa)){
    	$navres = array_diff(array_values($empres),array_values($navamsa));
    	$navrearray = array_values($navres);
    	for($i=0; $i<count($navrearray);$i++){
    		$navamsaresult["navamsha_".trim($navrearray[$i])][]= '';
    	}
    	}
    	array_walk($rashiresult, create_function('&$v', '$v = (count($v) == 1)? array_pop($v):implode(",",$v);'));
    	array_walk($navamsaresult, create_function('&$v', '$v = (count($v) == 1)? array_pop($v):implode(",",$v);'));
    	$userdob = UserDetails::find()->where(['userid'=> $id])->one();
    	$horoscopedetails = Horoscopedetails::find()->where(['userid'=> $id])->one();
    	
    	//print_r($model[0]['rashiname']);exit;
    	$saticrashisss= Horoscopedetails::find()->select('rashiName')->where(['userid'=> $id])->one();
    	if($rashiresult["janma_".$saticrashisss->rashiName] != ''){
    		$rashiresult["janma_".$saticrashisss->rashiName]= $rashiresult["janma_".$saticrashisss->rashiName] .','."<font color='#005ce6'>Asc</font>";
    	}
    	else {
    		$rashiresult["janma_".$saticrashisss->rashiName]="<font color='#005ce6'>Asc</font>";
    	}
    	
    	if(!empty($userdob) && !empty($model)){
        $result["status"]="success";
    	$result["message"]="successfully view user houses details";
    	$result['dateofbirth'] = $userdob->dateofbirth;
    	$result['timeofbirth']= $userdob->timeofbirth;
    	$result['moonsign']=$model[0]['rashiname'];
    	$result['rasi']=$model[0]['nakshatram'];
    	$result ["result"]= array_merge($rashiresult,$navamsaresult);
    	
    	}else {
    		$result["status"]="Sucess";
    		$result["message"]="Please Update Your Horoscope Details";
    	}
    	
     return $result;
    
    }
    public function actionViewnew2($id)
    {
    	$model = HoroscopePlanets::find()->distinct()->where(['userid'=> $id])->all();
    
    	//print_r($model);exit;
    	$result = array();
    	$rashiresult = array();
    	$rashi = array();
    	$navamsaresult = array();
    	$empres = array();
    	$k =array();
    	$empress = array();
    	$userrasi = array();
    	$short_planets=['MOON'=>'Mn','JUPITER'=>'Ju','MERCURY'=>'Me','SUN'=>'Su','MARS'=>'Ma','VENUS'=>'Ve','SATURN'=>'Sa','RAHU'=>'Ra','KETU'=>'Ke'];
    	$saticrashis= Rashi::find()->select('rashiId,rashiName')->orderBy('rashiId ASC')->all();
    	for($i = 0;$i<count($saticrashis);$i++)
    	{
    		$empres[$saticrashis[$i]['rashiName']] = $saticrashis[$i]['rashiName'];
    	}
    	if($model){
    	foreach($model as $v)
    	{
    		$userrasi[]=$v->navamsa_position;
    		$rashi[$v->rashiname] = $v->rashiname;
    		$navamsa[$v->navamsa_position] = $v->navamsa_position;
    		$rashiresult["janma_".trim($v->rashiname)][] = $short_planets[$v->planet];
    		$navamsaresult["navamsha_".trim($v->navamsa_position)][] = $short_planets[$v->planet];
    	}
    	$res = array_diff(array_values($empres),array_values($rashi));
    	$rearray = array_values($res);
    	
    	for($i=0; $i<count($rearray);$i++){
    		$rashiresult["janma_".trim($rearray[$i])][]= '';
    	}
    	$navres = array_diff(array_values($empres),array_values($navamsa));
    	$navrearray = array_values($navres);
    	for($i=0; $i<count($navrearray);$i++){
    		$navamsaresult["navamsha_".trim($navrearray[$i])][]= '';
    	}
    	 
    	array_walk($rashiresult, create_function('&$v', '$v = (count($v) == 1)? array_pop($v):implode(",",$v);'));
    	array_walk($navamsaresult, create_function('&$v', '$v = (count($v) == 1)? array_pop($v):implode(",",$v);'));
    	$userdob = UserDetails::find()->where(['userid'=> $id])->one();
    	$horoscopedetails = Horoscopedetails::find()->where(['userid'=> $id])->one();
    	//$bhavam = $this->Bhavam($id);
    	$bhavastrength = UserBhavasStrengths::find()->where(['userid' => $id])->all();
    	$strengths=array();
    	
    	
    	
     	$saticrashisss= Horoscopedetails::find()->select('rashiName')->where(['userid'=> $id])->one();
     	if($rashiresult["janma_".$saticrashisss->rashiName] != ''){ 
     		
     		$rashiresult["janma_".$saticrashisss->rashiName]= $rashiresult["janma_".$saticrashisss->rashiName] .','."<font color='#005ce6'>Asc</font>";
     		}
     		else {     			
     			$rashiresult["janma_".$saticrashisss->rashiName]="<font color='#005ce6'>Asc</font>";
     		}
     		
    
    	
    	    	
    	$result["status"]="success";
    	$result["message"]="successfully view user houses details";
    	$result['dateofbirth'] = $userdob->dateofbirth;
    	$result['timeofbirth']= $userdob->timeofbirth;
    	$result['moonsign']= $model[0]['rashiname'];
    	$result['rasi']=$model[0]['nakshatram'];
    	//$bhavas[$b]=$s;
    	
    	if(!empty($bhavastrength)){
    		foreach ($bhavastrength as $val)
    		{
    			$strengths[]=$val->strengths;
    			$bhavass[]=$val->bhavam;
    		}
    		$bhavas["Self"]="$strengths[0]";
    		$bhavas["Wealth_Family"]="$strengths[1]";
    		$bhavas["Coborns_Prowess"]="$strengths[2]";
    		$bhavas["Assets_Vehicles"]="$strengths[3]";
    		$bhavas["Children_Mantra"]="$strengths[4]";
    		$bhavas["Enemies_Debts"]="$strengths[5]";
    		$bhavas["Spouse_MarriedLife"]="$strengths[6]";
    		$bhavas["Health_Longevity"]="$strengths[7]";
    		$bhavas["Luck_Inheritance"]="$strengths[8]";
    		$bhavas["Career_Success"]="$strengths[9]";
    		$bhavas["Savings_Income"]="$strengths[10]";
    		$bhavas["Expenses_Moksha"]="$strengths[11]";
    	}else{
    		 
    	$bhavas["Self"]="0";
    	$bhavas["Wealth_Family"]="0";
    	$bhavas["Coborns_Prowess"]="0";
    	$bhavas["Assets_Vehicles"]="0";
    	$bhavas["Children_Mantra"]="0";
    	$bhavas["Enemies_Debts"]="0";
    	$bhavas["Spouse_MarriedLife"]="0";
    	$bhavas["Health_Longevity"]="0";
    	$bhavas["Luck_Inheritance"]="0";
    	$bhavas["Career_Success"]="0";
    	$bhavas["Savings_Income"]="0";
    	$bhavas["Expenses_Moksha"]="0";
    	}
    	
    	
    	//print_r($rashiresult);exit;horoscopedetails;

    	$result ["result"]= array_merge($rashiresult,$navamsaresult,$bhavas);
    	}else{
    		
    		$result["status"]="fail";
    		$result["message"]=" Your datails are  not updated ";
    	}
    	    	 
    	 
    	return $result;
    
    }
    

    /**
     * Creates a new HoroscopePlanets model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
    	$model = new HoroscopePlanets();
    	$horoplanetDetails = HoroscopePlanets::find()->where(['userid' => $id])->all();
    	$horoscopeDetails = Horoscopedetails::find()->where(['userId' => $id])->one();
    	if(!empty($horoscopeDetails))
    	{
    		
    		$model->rashiId = $horoscopeDetails->rashiName;
    	}
    	
    	if(!empty($horoplanetDetails))
    	{
        $digrees = array();
        $strengths = array();
        $nakhatrams = array();
        $rashilist =  array();
        $horoplanetIds = array();
        $shadbalams = array();
        $navamsa_positions = array();
        foreach ($horoplanetDetails as $horplanet)
        {
        	$userid[] = $horplanet->userid;
        	$digrees[] = $horplanet->digrees;
        	$strengths[] = $horplanet->strength;
        	$nakhatrams[] = $horplanet->nakshatram;
        	$rashilist[] = $horplanet->rashiname;
        	$horoplanetIds[] = $horplanet->horoplanetId;
        	$shadbalams[] = $horplanet->shadbalam;
        	$navamsa_positions[] = $horplanet->navamsa_position;
        }
        $model->userid = $id;
        $model->digrees = $digrees;
        $model->strength = $strengths;
        $model->nakshatram = $nakhatrams;
        $model->rashiname = $rashilist;
        $model->horoplanetId = $horoplanetIds;
        $model->shadbalam = $shadbalams;
        $model->navamsa_position = $navamsa_positions;
    	}
        
        $allRashiDetails = Rashi::find()->all();
        $rashilist = array();
        $userslist = array();
        $nakhatramList = array();
        foreach ($allRashiDetails as $droprashi)
        {
        	$rashilist[$droprashi->rashiName] = $droprashi->rashiName;
        }
        //UserList//
        $allUsers = User::find()->where(['status' => 10,'roleId' => 2])->all();
        foreach ($allUsers as $user)
        {
        	$userslist[$user->id] = $user->username;
        }
        
        $allnakshtrams = Nakshatrams::find()->all();
        foreach ($allnakshtrams as $nakhatram)
        {
        	$nakhatramList[$nakhatram->nakhatramName] = $nakhatram->nakhatramName;
        }
        
        $userInfo = Users::find()->select('user.*,user_details.*')->innerJoin('user_details','user.id = user_details.userId')->where(['user.id' => $id])->one();
        //print_r($userInfo);exit();

        if ($model->load(Yii::$app->request->post())) {
        	
        	if($model->validate())
        	{
        	
        	$rashi = Rashi::find()->where(['rashiName'=>$model->rashiId])->one();
        	/* $planetinf = Planets::find()->where(['planetId'=>$model->planatId])->one(); */
        	//print_r($planetinf);exit();
        	 
        	$allrashi = array();
        	$addingarray = array();
        	//print_r($rashi);exit();
        	foreach ($allRashiDetails as $rashidetails)
        	{
        		//print_r($rashidetails->rashiId);
        		if($rashidetails->rashiId < $rashi->rashiId)
        		{
        			$addingarray[] = $rashidetails->lord;
        		}
        		else{
        			$allrashi[] = $rashidetails->lord;
        		}
        	}
        //	exit;
        	for($i=0; $i< count($addingarray); $i++)
        	{
        		array_push($allrashi, $addingarray[$i]);
        	}
        	
        	if(empty($horoscopeDetails))
        	{        	
        	$horoscopeDetails = new Horoscopedetails();
        	}
        	 
        	$horoscopeDetails->lagnaLord =$allrashi[0];
        	$horoscopeDetails->dhanaLord =$allrashi[1];
        	$horoscopeDetails->kutumbaLord =$allrashi[2];
        	$horoscopeDetails->maatruLord =$allrashi[3];
        	$horoscopeDetails->putraLord =$allrashi[4];
        	$horoscopeDetails->shetruLord =$allrashi[5];
        	$horoscopeDetails->kalatraLord =$allrashi[6];
        	$horoscopeDetails->shatruLord =$allrashi[7];
        	$horoscopeDetails->bhaagyaLord	 =$allrashi[8];
        	$horoscopeDetails->raajayLord =$allrashi[9];
        	$horoscopeDetails->laabhaLord =$allrashi[10];
        	$horoscopeDetails->vyayaLord =$allrashi[11];
        	 
        	//$model->planatId = $planetinf->planetId;
        	//$model->planatName = $planetinf->planetName;
        	$horoscopeDetails->rashiId = $rashi->rashiId;
        	$horoscopeDetails->rashiName = $rashi->rashiName;
        	$horoscopeDetails->userId =$id;
        	$horoscopeDetails->createdBy=Yii::$app->user->id;
        	$horoscopeDetails->createdDate=date('Y-m-d H:i:s');
        	 
        	$horoscopeDetails->save();
        	
        	$horoId = $horoscopeDetails->horId;
        	

        	for($j=0; $j < 9; $j++)
        	{
        		
        		 if(empty($horoplanetDetails))
        		{
        			
        		$horoplanetModel = new HoroscopePlanets();
        		}
        		else{
        			//echo 'hello';exit();
        			$horoscopeplanetIdnew = $model->horoplanetId[$j];
        			$horoplanetModel = HoroscopePlanets::find()->where(['horoplanetId' => $horoscopeplanetIdnew])->one();
        		} 
        		//echo 'hello2';exit();
        		
        		//$horoplanetModel = new HoroscopePlanets();
        		$horoplanetModel->horoscopeId = $horoId;
        		$horoplanetModel->userid = $id;
        		$horoplanetModel->rashiId = $model->rashiId;
        		$horoplanetModel->planet = $model->planet[$j];
        		$horoplanetModel->digrees = $model->digrees[$j];
        		$horoplanetModel->strength = $model->strength[$j];
        		$horoplanetModel->nakshatram = $model->nakshatram[$j];
        		$horoplanetModel->rashiname = $model->rashiname[$j];
        		$horoplanetModel->shadbalam = $model->shadbalam[$j];
        		$horoplanetModel->navamsa_position = $model->navamsa_position[$j];
        		
     
        		
        		
        		$horoplanetModel->save();
        		//print_r($horoplanetModel->errors);exit();
        	}
           // return $this->redirect(['view', 'id' => $model->horoplanetId]);
        	return $this->redirect(['view','id' => $id]);
        	}
        	else{
        		print_r($model->errors);exit();
        	}
        }

//         return $this->render('create', [
//             'model' => $model,
//         ]);
        return $this->render('create', [
        		'model' => $model,
        		'rashilist'=>$rashilist,
        		//'planetlist' => $planetlist,
        		'userslist' => $userslist,
        		'nakhatramList' => $nakhatramList,
        		'userInfo' => $userInfo
        ]);
    }

    /**
     * Updates an existing HoroscopePlanets model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
 public function actionHoroscopeanalysis($id)
    {
 	
    	//echo "hai";exit;
 	
 	 $alllagnaanlysisData = array();
 	 $allplanetName = array();
 	 $allrashiname = array();
 	 $allData = array();
 	 $alllordplanetInfo = array();
 	 $userDetails = UserDetails::find()->select("user.*,user_details.*")->innerJoin("user","user.id = user_details.userId")->where("user_details.userId = $id")->one();
  	 $horoscopeDetails = HoroscopePlanets::find()->select("horoscopedetails.rashiId,horoscopedetails.lagnaLord as lagnaLordinfo,horoscopedetails.rashiName as lagnaRashi,horoscope_planets.*")->innerJoin("horoscopedetails","horoscopedetails.horId = horoscope_planets.horoscopeId")->where("horoscope_planets.userid = $id")->orderBy('horoplanetId ASC')->all();
     $lagnaRashiNameNew = '';
     
 	  $bhavam = $this->Bhavam($id);
 
 	    if(!empty($horoscopeDetails))
 	    { 
 	    	
 	    
 	  	$reshiOrders = $this->getRashiOrderbyLagna($horoscopeDetails[0]->rashiId);
 	  	$lordOrders = $this->getRashiOrderbyLagnaLord($horoscopeDetails[0]->rashiId);
 	  	$moonSign = $horoscopeDetails[0]->rashiname;
 	  	$moonSignOrders = $this->getRashiOrderbyLagnaByname($moonSign);
 	  	$currentDate = date('Y-m-d'); 	  	
 	  	$dailyPlanetsInfo = DailyPlanets::find()->where("DATE(planet_date) = '$currentDate'")->one();
 	  	//$dailyPlanetsInfo = DailyPlanets::find()->where(['planet_date' =>$currentDate])->one();
 	  	//print_r($dailyPlanetsInfo);exit;
 	  	$lagnaRashiNameNew = $horoscopeDetails[0]->lagnaRashi; 	  	
 	  	$i = 0;
 	  	foreach ($horoscopeDetails as $lagnaAnalysis)
 	  	{
 	  		$planet = ucfirst(strtolower($lagnaAnalysis->planet));
 	  		$key = array_search ($lagnaAnalysis->rashiname, $reshiOrders);
    	    $pos = $key+1;
 	  		$lagnaAnalysisData = PredictionByPlanetRaasi::find()->where(['position_id' => $pos])->one();
 	  		$allplanetName[] = strtoupper($planet);
 	  		$allrashiname[] = $lagnaAnalysis->rashiname;
 	  		$alllagnaanlysisData[] = $lagnaAnalysisData->$planet;
 	  		if($planet !='Rahu'&& $planet != 'Ketu')
 	  		{
 	  		$lordPlanet = $lordOrders[$planet];
 	  		$combineLordInfo = '';
 	  		for($m=0;$m<count($lordPlanet);$m++)
 	  		{
 	  			
 	  			$lordPos = $lordPlanet[$m]+1;
 	  			$lordNewDetails = PredictionLordInOtherLordRaasis::find()->where(['plord_rasiid' => $lordPos])->one();
 	  			$poscalc = 'position'.$pos;
 	  			$combineLordInfo .= $lordNewDetails->$poscalc.' ';
 	  		}
 	  		$alllordplanetInfo[ ] = $combineLordInfo;
 	  		if(empty($dailyPlanetsInfo)){
 	  			$allData[] = " ";
 	  		}else{
 	  		$gochkey = array_search ($dailyPlanetsInfo->$planet, $moonSignOrders);
 	  		$gochpos = $gochkey+1;
 	  		$planetPosInfo = PlanetsPositions::find()->where(['position_id' => $gochpos])->one();
 	  		$allData[] = $planetPosInfo->$planet;
 	  		}
 	  		
 	  		}
 	  		else{
 	  			$allData[] = '';
 	  			$allData[] = '';
 	  		}
 	  		
 	  		$i++;
 	  		
 	  		
 	  	}
 	  }
 	  
 	  
 
//     	return $this->render('Horoscopeanalisies', [
//     			'allData' => $allData,
//     			'userDetails' => $userDetails,
//     			'lagnaRashiNameNew' => $lagnaRashiNameNew,
//     			'bhavam' =>$bhavam
//     	        ]);

 	  
 	      $result['User Bhavam Of strenghts ']['Self']=$bhavam[0];
 	      $result['User Bhavam Of strenghts ']['Wealth']=$bhavam[1];
 	      $result['User Bhavam Of strenghts ']['Family']=$bhavam[2];
 	      $result['User Bhavam Of strenghts ']['Mother']=$bhavam[3];
 	      $result['User Bhavam Of strenghts ']['Assets']=$bhavam[4];
 	      $result['User Bhavam Of strenghts ']['Children']=$bhavam[5];
 	      $result['User Bhavam Of strenghts ']['EnemiesDebt']=$bhavam[6];
 	      $result['User Bhavam Of strenghts ']['Marriage']=$bhavam[7];
 	      $result['User Bhavam Of strenghts ']['Health']=$bhavam[8];
 	      $result['User Bhavam Of strenghts ']['Lucky,Father']=$bhavam[9];
 	      $result['User Bhavam Of strenghts ']['Career']=$bhavam[10];
 	      $result['User Bhavam Of strenghts ']['Savings']=$bhavam[11];
 	  
 	      $result['userDetails']=$userDetails;
 	  
 	      $result['lagnaRashiName']=$lagnaRashiNameNew;
 	
 	  	  $result['rashiname'][$allplanetName[0]]=$allrashiname[0];
 	   	  $result['rashiname'][$allplanetName[1]]=$allrashiname[1];
 	   	  $result['rashiname'][$allplanetName[2]]=$allrashiname[2];
 	   	  $result['rashiname'][$allplanetName[3]]=$allrashiname[3];
 	   	  $result['rashiname'][$allplanetName[4]]=$allrashiname[4];
 	   	  $result['rashiname'][$allplanetName[5]]=$allrashiname[5];
 	   	  $result['rashiname'][$allplanetName[6]]=$allrashiname[6];
 	   	  $result['rashiname'][$allplanetName[7]]=$allrashiname[7];
 	   	  $result['rashiname'][$allplanetName[8]]=$allrashiname[8];
 	   	  
 	   	
 	   	  
 	   	  $result['alllagnaanlysisData'][$allplanetName[0]]=$alllagnaanlysisData[0];
 	   	  $result['alllagnaanlysisData'][$allplanetName[1]]=$alllagnaanlysisData[1];
 	   	  $result['alllagnaanlysisData'][$allplanetName[2]]=$alllagnaanlysisData[2];
 	   	  $result['alllagnaanlysisData'][$allplanetName[3]]=$alllagnaanlysisData[3];
 	   	  $result['alllagnaanlysisData'][$allplanetName[4]]=$alllagnaanlysisData[4];
 	   	  $result['alllagnaanlysisData'][$allplanetName[5]]=$alllagnaanlysisData[5];
 	   	  $result['alllagnaanlysisData'][$allplanetName[6]]=$alllagnaanlysisData[6];
 	   	  $result['alllagnaanlysisData'][$allplanetName[7]]=$alllagnaanlysisData[7];
 	   	  $result['alllagnaanlysisData'][$allplanetName[8]]=$alllagnaanlysisData[8];
 	   	  
 	   	 
 	   	  
 	   	  $result['alllordplanetInfo'][$allplanetName[0]]=$alllordplanetInfo[0];
 	   	  $result['alllordplanetInfo'][$allplanetName[1]]=$alllordplanetInfo[1];
 	   	  $result['alllordplanetInfo'][$allplanetName[2]]=$alllordplanetInfo[2];
 	   	  $result['alllordplanetInfo'][$allplanetName[3]]=$alllordplanetInfo[3];
 	   	  $result['alllordplanetInfo'][$allplanetName[4]]=$alllordplanetInfo[4];
 	   	  $result['alllordplanetInfo'][$allplanetName[5]]=$alllordplanetInfo[5];
 	   	  $result['alllordplanetInfo'][$allplanetName[6]]=$alllordplanetInfo[6];
 	   	  
 	   	  //$result['gocharamInfo'][]= $allData[0];
 	   	  
 	   	  $result['gocharamInfo'][$allplanetName[0]]=$allData[0];
 	   	  $result['gocharamInfo'][$allplanetName[1]]=$allData[1];
 	   	  $result['gocharamInfo'][$allplanetName[2]]=$allData[2];
 	   	  $result['gocharamInfo'][$allplanetName[3]]=$allData[3];
 	   	  $result['gocharamInfo'][$allplanetName[4]]=$allData[4];
 	   	  $result['gocharamInfo'][$allplanetName[5]]=$allData[5];
 	   	  $result['gocharamInfo'][$allplanetName[6]]=$allData[6];
 	   	

        return $result;
    }
    
    
    public function actionAnalysisbylagna($id)
    {
    
    	$alllagnaanlysisData = array();
    	$allplanetName = array();
    	$horoscopeDetails = HoroscopePlanets::find()->select("horoscopedetails.rashiId,horoscopedetails.lagnaLord as lagnaLordinfo,horoscopedetails.rashiName as lagnaRashi,horoscope_planets.*")->innerJoin("horoscopedetails","horoscopedetails.horId = horoscope_planets.horoscopeId")->where("horoscope_planets.userid = $id")->orderBy('horoplanetId ASC')->all();
    	if(!empty($horoscopeDetails))
    	{
    	    $reshiOrders = $this->getRashiOrderbyLagna($horoscopeDetails[0]->rashiId);
    		foreach ($horoscopeDetails as $lagnaAnalysis)
    		{
    			$planet = ucfirst(strtolower($lagnaAnalysis->planet));
    			$key = array_search ($lagnaAnalysis->rashiname, $reshiOrders);
    			$pos = $key+1;
    			$lagnaAnalysisData = PredictionByPlanetRaasi::find()->where(['position_id' => $pos])->one();
    			$allplanetName[] = strtoupper($planet);
    			$alllagnaanlysisData[] = $lagnaAnalysisData->$planet;
    		    }
    	}
   
    	$result['analysisbylagna'][$allplanetName[0]]=$alllagnaanlysisData[0];
    	$result['analysisbylagna'][$allplanetName[1]]=$alllagnaanlysisData[1];
    	$result['analysisbylagna'][$allplanetName[2]]=$alllagnaanlysisData[2];
    	$result['analysisbylagna'][$allplanetName[3]]=$alllagnaanlysisData[3];
    	$result['analysisbylagna'][$allplanetName[4]]=$alllagnaanlysisData[4];
    	$result['analysisbylagna'][$allplanetName[5]]=$alllagnaanlysisData[5];
    	$result['analysisbylagna'][$allplanetName[6]]=$alllagnaanlysisData[6];
    	$result['analysisbylagna'][$allplanetName[7]]=$alllagnaanlysisData[7];
    	$result['analysisbylagna'][$allplanetName[8]]=$alllagnaanlysisData[8];
 
    	return $result;
    }
    
    public function actionAnalysisbylord($id)
    {
        $allplanetName = array();
    	$alllordplanetInfo = array();
    	$horoscopeDetails = HoroscopePlanets::find()->select("horoscopedetails.rashiId,horoscopedetails.lagnaLord as lagnaLordinfo,horoscopedetails.rashiName as lagnaRashi,horoscope_planets.*")->innerJoin("horoscopedetails","horoscopedetails.horId = horoscope_planets.horoscopeId")->where("horoscope_planets.userid = $id")->orderBy('horoplanetId ASC')->all();
    	    
    	if(!empty($horoscopeDetails))
    	{
    	    $lordOrders = $this->getRashiOrderbyLagnaLord($horoscopeDetails[0]->rashiId);
    		$reshiOrders = $this->getRashiOrderbyLagna($horoscopeDetails[0]->rashiId);
    		$i = 0;
    		foreach ($horoscopeDetails as $lagnaAnalysis)
    		{
    			$planet = ucfirst(strtolower($lagnaAnalysis->planet));
    			$key = array_search ($lagnaAnalysis->rashiname, $reshiOrders);
    			$pos = $key+1;
    			$allplanetName[] = strtoupper($planet);
    			if($planet !='Rahu'&& $planet != 'Ketu')
    			{
    				$lordPlanet = $lordOrders[$planet];
    				$combineLordInfo = '';
    				for($m=0;$m<count($lordPlanet);$m++)
    				{
    				    $lordPos = $lordPlanet[$m]+1;
    					$lordNewDetails = PredictionLordInOtherLordRaasis::find()->where(['plord_rasiid' => $lordPos])->one();
    					$poscalc = 'position'.$pos;
    					$combineLordInfo .= $lordNewDetails->$poscalc.' ';
    				}
    				$alllordplanetInfo[ ] = $combineLordInfo;
    			}
    			$i++;
                }
    	}
        $result['analysisbylord'][$allplanetName[0]]=$alllordplanetInfo[0];
    	$result['analysisbylord'][$allplanetName[1]]=$alllordplanetInfo[1];
    	$result['analysisbylord'][$allplanetName[2]]=$alllordplanetInfo[2];
    	$result['analysisbylord'][$allplanetName[3]]=$alllordplanetInfo[3];
    	$result['analysisbylord'][$allplanetName[4]]=$alllordplanetInfo[4];
    	$result['analysisbylord'][$allplanetName[5]]=$alllordplanetInfo[5];
    	$result['analysisbylord'][$allplanetName[6]]=$alllordplanetInfo[6];
      
    	return $result;
    }
    
    public function actionAnalysisbygochara($id)
    {
    
    	
    	$allplanetName = array();
        $allData = array();
    	$horoscopeDetails = HoroscopePlanets::find()->select("horoscopedetails.rashiId,horoscopedetails.lagnaLord as lagnaLordinfo,horoscopedetails.rashiName as lagnaRashi,horoscope_planets.*")->innerJoin("horoscopedetails","horoscopedetails.horId = horoscope_planets.horoscopeId")->where("horoscope_planets.userid = $id")->orderBy('horoplanetId ASC')->all();
    	$moonSign = $horoscopeDetails[0]->rashiname;
    	$moonSignOrders = $this->getRashiOrderbyLagnaByname($moonSign);
    	if(!empty($horoscopeDetails))
    	{
    		$currentDate = date('Y-m-d');
    		$dailyPlanetsInfo = DailyPlanets::find()->where("DATE(planet_date) = '$currentDate'")->one();
    	    $i = 0;
    		foreach ($horoscopeDetails as $lagnaAnalysis)
    		{
    			$planet = ucfirst(strtolower($lagnaAnalysis->planet));
    		     $allplanetName[] = strtoupper($planet);
    		     
    			if($planet !='Rahu'&& $planet != 'Ketu')
    			{
    				if(empty($dailyPlanetsInfo)){
    					$allData[] = " ";
    				}else{
    					$gochkey = array_search ($dailyPlanetsInfo->$planet, $moonSignOrders);
    					$gochpos = $gochkey+1;
    					$planetPosInfo = PlanetsPositions::find()->where(['position_id' => $gochpos])->one();
    					$allData[] = $planetPosInfo->$planet;
    				}
                 }
    			else{
    				$allData[] = '';
    				$allData[] = '';
    			}
    
    			$i++;
               }
    	}
        $result['analysisbygochara'][$allplanetName[0]]=$allData[0];
    	$result['analysisbygochara'][$allplanetName[1]]=$allData[1];
    	$result['analysisbygochara'][$allplanetName[2]]=$allData[2];
    	$result['analysisbygochara'][$allplanetName[3]]=$allData[3];
    	$result['analysisbygochara'][$allplanetName[4]]=$allData[4];
    	$result['analysisbygochara'][$allplanetName[5]]=$allData[5];
    	$result['analysisbygochara'][$allplanetName[6]]=$allData[6];
    
    
    	return $result;
    }
    
    
    
    public function actionHoroscopebhavasold($id ,$bhavam)
    {
    	$result = array();
    	$bhavam_strength= $this->Bhavam($id);
    	$strenthinfo["self"]=$bhavam_strength[0];
        $strenthinfo["wealth"]=$bhavam_strength[1];
        $strenthinfo["family"]=$bhavam_strength[2];
        $strenthinfo["mother"]=$bhavam_strength[3];
        $strenthinfo["assets"]=$bhavam_strength[4];
        $strenthinfo["children"]=$bhavam_strength[5];
        $strenthinfo["enemiesdebt"]=$bhavam_strength[6];
        $strenthinfo["marriage"]=$bhavam_strength[7];
        $strenthinfo["health"]=$bhavam_strength[8];
        $strenthinfo["lucky,father"]=$bhavam_strength[9];
        $strenthinfo["career"]=$bhavam_strength[10];
        $strenthinfo["savings"]=$bhavam_strength[11];
        $horoscopeDetails = HoroscopePlanets::find()->select("horoscopedetails.rashiId,horoscopedetails.lagnaLord as lagnaLordinfo,horoscopedetails.rashiName as lagnaRashi,horoscope_planets.*")->innerJoin("horoscopedetails","horoscopedetails.horId = horoscope_planets.horoscopeId")->where("horoscope_planets.userid = $id")->orderBy('horoplanetId ASC')->all();
        $result["status"]="success";
        $result["message"]="successfully view user Bhavas details";
        $reshiOrders = $this->getRashiOrderbyLagna($horoscopeDetails[0]->rashiId);
        $lordOrders = $this->getRashiOrderbyLagnaLord($horoscopeDetails[0]->rashiId);
    	if($bhavam != ''){
    		$strenthinfosearch=$strenthinfo[$bhavam];
    		if($strenthinfosearch == 100){
    		if(!empty($horoscopeDetails))
    			{
    			foreach ($horoscopeDetails as $lagnaAnalysis)
    				{
    					$planet = ucfirst(strtolower($lagnaAnalysis->planet));
    					$key = array_search ($lagnaAnalysis->rashiname, $reshiOrders);
    					$pos = $key+1;
    					$allplanetName[] = strtoupper($planet);
    					$allrashiname[] = $lagnaAnalysis->rashiname;
    					
    					if($planet !='Rahu'&& $planet != 'Ketu')
    					{
    						$lordPlanet = $lordOrders[$planet];
    						$combineLordInfo = '';
    						$combineLordInfo2 = '';
    						for($m=0;$m<count($lordPlanet);$m++)
    						{
    							$lordPos = $lordPlanet[$m]+1;
    							$lordNewDetails = StrenghtPredictionlordinotherlord::find()->where(['splord_rasiid' => $lordPos])->one();
    							$poscalc = 'position'.$pos;
    						    $combineLordInfo .= $lordNewDetails->$poscalc.' ';
    							$planetOverall[] = $lordNewDetails['position'.$pos];
    							
    							$lordNewDetails2 = PredictionLordInOtherLordRaasis::find()->where(['plord_rasiid' => $lordPos])->one();
    							$combineLordInfo2 .= $lordNewDetails2->$poscalc.' ';
    							$planetOverall2[] = $lordNewDetails2['position'.$pos];
    						}
    						$alllordplanetInfo = $planetOverall;
    						$alllordplanetInfo2 = $planetOverall2;
    					}
    			    	}
    			}
    			$allbhavastrengths=array("$alllordplanetInfo[0]"=>"self","$alllordplanetInfo[1]"=>"wealth","$alllordplanetInfo[2]"=>"family","$alllordplanetInfo[3]"=>"mother","$alllordplanetInfo[4]"=>"assets","$alllordplanetInfo[5]"=>"children","$alllordplanetInfo[6]"=>"enemiesdebt","$alllordplanetInfo[7]"=>"marriage","$alllordplanetInfo[8]"=>"health","$alllordplanetInfo[9]"=>"lucky,father","$alllordplanetInfo[10]"=>"career","$alllordplanetInfo[11]"=>"savings");
    			$bhavamofstrength =  array_search("$bhavam",$allbhavastrengths);
    			$result ['hundredpercentage_information']= $bhavamofstrength;
    			
    			$allbhavastrengths2=array("$alllordplanetInfo2[0]"=>"self","$alllordplanetInfo2[1]"=>"wealth","$alllordplanetInfo2[2]"=>"family","$alllordplanetInfo2[3]"=>"mother","$alllordplanetInfo2[4]"=>"assets","$alllordplanetInfo2[5]"=>"children","$alllordplanetInfo2[6]"=>"enemiesdebt","$alllordplanetInfo2[7]"=>"marriage","$alllordplanetInfo2[8]"=>"health","$alllordplanetInfo2[9]"=>"lucky,father","$alllordplanetInfo2[10]"=>"career","$alllordplanetInfo2[11]"=>"savings");
    			$bhavamofstrength2 =  array_search("$bhavam",$allbhavastrengths2);
    			$result['regular_information'] = $bhavamofstrength2;
    			
    		}else{
    			if(!empty($horoscopeDetails))
    			{
    			foreach ($horoscopeDetails as $lagnaAnalysis)
    				{
    					$planet = ucfirst(strtolower($lagnaAnalysis->planet));
    					$key = array_search ($lagnaAnalysis->rashiname, $reshiOrders);
    					$pos = $key+1;
    					$allplanetName[] = strtoupper($planet);
    					$allrashiname[] = $lagnaAnalysis->rashiname;
    					if($planet !='Rahu'&& $planet != 'Ketu')
    					{
    						$lordPlanet = $lordOrders[$planet];
    						$combineLordInfo = '';
    						for($m=0;$m<count($lordPlanet);$m++)
    						{
    							$lordPos = $lordPlanet[$m]+1;
    							$lordNewDetails = PredictionLordInOtherLordRaasis::find()->where(['plord_rasiid' => $lordPos])->one();
    							$poscalc = 'position'.$pos;
    							
    							$combineLordInfo .= $lordNewDetails->$poscalc.' ';
    							$planetOverall[] = $lordNewDetails['position'.$pos];
    						}
    						$alllordplanetInfo = $planetOverall;
    					}
    			
    				}
    			}
    			$allbhavastrengths=array("$alllordplanetInfo[0]"=>"self","$alllordplanetInfo[1]"=>"wealth","$alllordplanetInfo[2]"=>"family","$alllordplanetInfo[3]"=>"mother","$alllordplanetInfo[4]"=>"assets","$alllordplanetInfo[5]"=>"children","$alllordplanetInfo[6]"=>"enemiesdebt","$alllordplanetInfo[7]"=>"marriage","$alllordplanetInfo[8]"=>"health","$alllordplanetInfo[9]"=>"lucky,father","$alllordplanetInfo[10]"=>"career","$alllordplanetInfo[11]"=>"savings");
    			$bhavamofstrength =  array_search("$bhavam",$allbhavastrengths);
    			$result["hundredpercentage_information"]=" ";
    			$result['regular_information'] = $bhavamofstrength;
    				
    		}
    		
    	}
       
    	return $result;
 
    }
    
    public function actionHoroscopebhavas($id ,$bhavam)
    {
    	$result = array();
    	$regularInfo = '';
    	$percentageInfo = '';
    	$horoscopeDetails = HoroscopePlanets::find()->select("horoscopedetails.rashiId,horoscopedetails.lagnaLord as lagnaLordinfo,horoscopedetails.rashiName as lagnaRashi,horoscope_planets.*")->innerJoin("horoscopedetails","horoscopedetails.horId = horoscope_planets.horoscopeId")->where("horoscope_planets.userid = $id")->orderBy('horoplanetId ASC')->all();
    	$lagnaRashiNameNew = '';    	
    	if(!empty($horoscopeDetails))
    	{
//          $bhavamInfo = $this->Bhavam($id);
//     		$bhavamStrength = $bhavamInfo[$bhavam-1];
            $bhavastrength = UserBhavasStrengths::find()->where(['userid' => $id])->all();
            $k=array();
            foreach ($bhavastrength as $val)
            {
            $k[]=$val->strengths;
            }
            if(empty($k)){
            	 $bhavamStrength = "0";
            }else{
            	 $bhavamStrength = $k[$bhavam-1];
            }
               		
    		$reshiOrders = $this->getRashiOrderbyLagna($horoscopeDetails[0]->rashiId);
    		$lordOrders = $this->getRashiOrderbyLagnaLord($horoscopeDetails[0]->rashiId);
    		$moonSign = $horoscopeDetails[0]->rashiname;
    		$moonSignOrders = $this->getRashiOrderbyLagnaByname($moonSign);
    		$currentDate = date('Y-m-d');
    		$dailyPlanetsInfo = DailyPlanets::find()->where("DATE(planet_date) = '$currentDate'")->one();
    		$lagnaRashiNameNew = $horoscopeDetails[0]->lagnaRashi;
    		$i = 0;
    		foreach ($horoscopeDetails as $lagnaAnalysis)
    		{
    			$planet = ucfirst(strtolower($lagnaAnalysis->planet));
    			$key = array_search ($lagnaAnalysis->rashiname, $reshiOrders);
    			$pos = $key+1;
    			$lagnaAnalysisData = PredictionByPlanetRaasi::find()->where(['position_id' => $pos])->one();
    
    			if($planet !='Rahu'&& $planet != 'Ketu')
    			{
    				$lordPlanet = $lordOrders[$planet];
    				for($m=0;$m<count($lordPlanet);$m++)
    				{
    					$lordPos = $lordPlanet[$m]+1;
    					if($bhavam == $lordPos)
    					{
    						$lordNewDetails = PredictionLordInOtherLordRaasis::find()->where(['plord_rasiid' => $lordPos])->one();
    						$poscalc = 'position'.$pos;
    						$regularInfo .= $lordNewDetails->$poscalc.' ';
    						$bhavaminfo = 'bhavam'.$bhavam;
    					    $bhaavasreginformation = BhavaDetails::find()->where(['bhava_name' => $bhavaminfo])->one();
    					    if($bhavamStrength == 100)
    						{
    							$lordNewDetailspercentage = StrenghtPredictionlordinotherlord::find()->where(['splord_rasiid' => $lordPos])->one();
    
    							$percentageInfo .= $lordNewDetailspercentage->$poscalc.' ';
    						}
    						
    					}
    					
    				}
    			}
    			$i++;
    		}
    		
    	
    	
    	$result['status'] = 'success';
    	$result['message'] = 'successfully view user Bhavas details';
    	$result["hundredpercentage_information"]=$percentageInfo;
    	//print_r($bhavamStrength);exit;
        $result['percentage'] = $bhavamStrength;
    	$result['regular_information'] = $regularInfo;
    	$result['bhaavasreg_information']= $bhaavasreginformation->information;
    	if($bhavam == 1)
    	{
    		   		
    	    $saticrashisss= Horoscopedetails::find()->select('rashiName')->where(['userid'=> $id])->one();
    	    $lagnaresults=LagnaResults::find()->where(['rashi_name'=> $saticrashisss->rashiName])->one();
    	    //print_r( $lagnaresults->information);exit;
    		$result['lagna_result'] = $lagnaresults->information;
    	    }else{
    		$result['lagna_result'] =  "";
    	}
    	}
    	else {
    		$result['status'] = 'Fail';
    		$result['message'] = 'Horoscope details Not Found';
    	}
    	return $result;
    	 
    }
    public  function search($strenthinfo, $p, $bhavam)
    {
    	$results = array();
    	return $results;
    }
    public function actionHoroscopeanalysisnew($id)
    {
    	/*
    	 * user details
    	 */
    	$Users = Users::find()->where(['id' => $id])->one();
    	$UserDetails = UserDetails::find()->where(['userid' => $id])->one();
    	 
    	$planets = array();
    	$gochara_values = array();
    	$analysisbylagna = array();
    	$analysisbylord = array();
    	 
    	$rashi=array();
    	$lagna_rashi_id = array();
    	
    	/*
    	 * user id based get hrs-planets details Planet,Rasiname
    	 */
    	
    	$hrs_planetas = HoroscopePlanets::find()->where(['userid' => $id])->all();
    	    	    	 
    	foreach($hrs_planetas as $hrs_planeta )
    	{
    		$rashi[] = $hrs_planeta->rashiname; /* we selected planet wise Rasi name */
    
    		$planet = ucfirst(strtolower($hrs_planeta->planet)); /*  Planet name */
    		 
    		$allRashiDetails = Rashi::find()->all();
    		 
    		$rashi_id=Rashi::find()->select('rashiId')->where(['rashiName'=>$hrs_planeta->rashiname])->one();
    		 
    		/*
    		 *  User selected lagna lord ID
    		 */
    		$lagna_rashi_id = Horoscopedetails::find()->where(['horId'=>$hrs_planeta->horoscopeId])->one();
    
    		/*
    		 *Analysis by lord  code
    		 *User selected lagna lord name
    		 */
    		$gochara_rashi_id=Rashi::find()->where(['lord'=>$lagna_rashi_id->lagnaLord])->one();
    		//print_r($gochara_rashi_id);exit();
    		$langnaRashi = $gochara_rashi_id->rashiName;
    		$langnaLord = $gochara_rashi_id->lord;
    		$hrs_planetas1 = HoroscopePlanets::find()->select('rashiname')->where(['planet' => $gochara_rashi_id->lord,'userid' => $id])->one();
    		/*
    		 * rasi ID
    		 */
    		$g_rashi_id=Rashi::find()->select('rashiId')->where(['rashiName'=>$hrs_planetas1->rashiname])->one();
    
    
    		$count = 0;
    		$horoscopeplanets = '';
    		 
    		$position = array();
    		$addingarray = array();
    		$allrashi = array();
    		$newRashiDetails = array();
    		$gocharaposition = array();
    		$ary = array();
    		$gochararray = array();
    
    		 
    
    		foreach ($allRashiDetails as  $rashidetails){
    			if($rashidetails->rashiId < $lagna_rashi_id->rashiId)
    			{
    				$addingarray[] = $rashidetails->rashiId;
    				$lordaddingarray[] = $rashidetails->lord;
    
    			}
    			else{
    				$allrashi[] = $rashidetails->rashiId;/* All rotated rasi's*/
    				$alllords[] = $rashidetails->lord;/* All rotated lord's */
    			}
    		}
    
    
    		/*
    		 * Analysis code  for position
    		 */
    
    		for($i=0; $i<count($addingarray); $i++)
    		{
    			array_push($allrashi, $addingarray[$i]);
    		}
    		 
    		$keynew = array_search ($rashi_id->rashiId, $allrashi);
    		$posnew = $keynew+1;
    		 
    		//$count = count($position)+1;
    		 
    		//     	$PlanetsPositions =PlanetsPositions::find()->where(['position_id'=> $posnew])->one();
    		//     	$horoscopeplanets = $PlanetsPositions->$planet;
    		//     	$analysisbygochara[] = $horoscopeplanets;
    		 
    		/*
    		 * Analysis by lagna  code  for position
    		 */
    		 
    		$PlanetsPositionsLord =PredictionByPlanetRaasi::find()->where(['position_id'=> $posnew])->one();
    		$horoscopeplanetsLord = $PlanetsPositionsLord->$planet;
    		$analysisbylagna[] = $horoscopeplanetsLord;
    		 
    		/*
    		 * Analysis by lord  code
    		 * Analysis by lord of all lords
    		 * get selected first lord position
    		 */
    
    		for($i=0; $i<count($lordaddingarray); $i++)
    		{
    			array_push($alllords, $lordaddingarray[$i]);
    		}
    		$keyold = array_search ($g_rashi_id->rashiId, $allrashi);
    		$posold = $keyold+1;
    		$Glord = PredictionLordInOtherLordRaasis::find()->where(['lord' => "lord1"])->asArray()->one();
    		$value= $Glord['position'.$posold];
    		 
    		$planetOverall = array();
    		$planetOverall[$gochara_rashi_id->lord][] = $value;
    		/*
    		 * for loop start on secont lord
    		 */
    		 
    
    			
    		for($i=1;$i<count($alllords); $i++)
    		{
    			$lord = $alllords[$i]; /* lord name */
    			/*
    			 * $lord Of rasiname
    			 */
    
    			$hrs_lord_planetas = HoroscopePlanets::find()->select('rashiname')->where(['planet' => $lord,'userid' => $id])->one();
    			/*
    			 * $hrs_lord_planetas of RASIID
    			 */
    			$glord_rashi_id = Rashi::find()->select('rashiId')->where(['rashiName'=>$hrs_lord_planetas->rashiname])->one();
    			/*
    			 * Analysis by lord  code  for position
    			 */
    			$key = array_search ($glord_rashi_id->rashiId, $allrashi);
    			$pos = $key+1;
    			$total = $i+1;
    			$congl = 'lord'.$total;
    			$G_newlord = PredictionLordInOtherLordRaasis::find()->where(['lord' =>$congl])->asArray()->one();
    			$planetOverall[$lord][] = $G_newlord['position'.$pos];
    
    			//print_r($planetOverall);exit;
    			 
    		}
    		 
    		/*
    		 * Analysis by gochara
    		 */
    
    		$gocharaaddingarray=array();
    		$gocgaraallrashi = array();
    		$gochraplanetOverall =array();
    		$new_gochara_all_lords = array();
    		 
    		foreach ($allRashiDetails as  $gochararashidetails){
    			if($gochararashidetails->rashiId < $rashi_id->rashiId)
    			{
    				$gocharaaddingarray[] = $gochararashidetails->rashiId;
    
    			}
    			else{
    				$gocgaraallrashi[] = $gochararashidetails->rashiId;/* All rotated rasi's*/
    			}
    		}
    		 
    		for($i=0; $i<count($gocharaaddingarray); $i++)
    		{
    			array_push($gocgaraallrashi, $gocharaaddingarray[$i]);
    		}
    		 
    		$gochara_all_lords= Planets::find()->select('planetName')->orderby('planetId')->asArray()->all();
    		for($i=0;$i<count($gochara_all_lords)-2; $i++)
    		{
    			$new_gochara_all_lords []= $gochara_all_lords[$i];
    		}
    		 
    		$DailyPlanets = DailyPlanets::find()->where(['Like' , 'planet_date', date('Y-m-d')])->one();
    		 
    		 
    		 
    		for($k =0 ;$k< count($new_gochara_all_lords);$k++)
    		{
    
    			$gochararashi_id=$DailyPlanets[$new_gochara_all_lords[$k]['planetName']];
    			$gocharam_rashi_id = Rashi::find()->where(['rashiName'=>$gochararashi_id])->one();
    			$gocharaposition = array_search($gocharam_rashi_id['rashiId'],$gocgaraallrashi);
    			if(!empty($gocharaposition)){
    				$gocharaposition =$gocharaposition+1;
    			}else{
    				$gocharaposition ="";
    			}
    
    			$Gochara_newlord = PlanetsPositions::find()->Select($new_gochara_all_lords[$k]['planetName'])->where(['position_id' =>$gocharaposition])->asArray()->one();
    			$gochraplanetOverall[] = $Gochara_newlord;
        		}
    //	print_r($planetOverall['Jupiter']);exit;
    	}
    	return $this->render('Horoscopeanalisies', [
    			//  'analysisbygochara' => $analysisbygochara,
    			'UserDetails' =>$UserDetails,
    			'rashi' =>$rashi,
    			'lagna_rashi_id' =>$lagna_rashi_id,
    			'Users' =>$Users,
    			'analysisbylagna' =>$analysisbylagna,
    			'gochara_values'=>$gochara_values,
    			 
    			'planetOverall' => $planetOverall,
    			'gochraplanetOverall'=>$gochraplanetOverall
    	]);
    }
    
    
    public function actionUpdate($id)
    {
        $model = new HoroscopePlanets();
        
        $horoplanetDetails = HoroscopePlanets::find()->where(['userid' => $id])->all();
        $digrees = array();
        $strengths = array();
        $nakhatrams = array();
        $rashilist =  array();
        $horoplanetIds = array();
        $shadbalams = array();
        $navamsa_positions = array();
        foreach ($horoplanetDetails as $horplanet)
        {
        	$userid[] = $horplanet->userid;
        	$digrees[] = $horplanet->digrees;
        	$strengths[] = $horplanet->strength;
        	$nakhatrams[] = $horplanet->nakshatram;
        	$rashilist[] = $horplanet->rashiname;
        	$horoplanetIds[] = $horplanet->horoplanetId;
        	$shadbalams[] = $horplanet->shadbalam;
        	$navamsa_positions[] = $horplanet->navamsa_position;
        }
        $model->userid = $id;
        $model->digrees = $digrees;
        $model->strength = $strengths;
        $model->nakshatram = $nakhatrams;
        $model->rashiname = $rashilist;
        $model->horoplanetId = $horoplanetIds;
        $model->shadbalam = $shadbalams;
        $model->navamsa_position = $navamsa_positions;
        
        
        $allRashiDetails = Rashi::find()->all();
        $rashilist = array();
        $userslist = array();
        $nakhatramList = array();
        foreach ($allRashiDetails as $droprashi)
        {
        	$rashilist[$droprashi->rashiName] = $droprashi->rashiName;
        }
        //UserList//
        $allUsers = User::find()->where(['status' => 10,'roleId' => 2])->all();
        foreach ($allUsers as $user)
        {
        	$userslist[$user->id] = $user->username;
        }
        $allnakshtrams = Nakshatrams::find()->all();
        foreach ($allnakshtrams as $nakhatram)
        {
        	$nakhatramList[$nakhatram->nakhatramName] = $nakhatram->nakhatramName;
        }

     if ($model->load(Yii::$app->request->post()) && $model->validate()) {
        	

        	for($j=0; $j < 9; $j++)
        	{
        		
        		$horoscopeplanetIdnew = $model->horoplanetId[$j];
        		$horoplanetModel = HoroscopePlanets::find()->where(['horoplanetId' => $horoscopeplanetIdnew])->one();
        	//	$horoplanetModel->horoscopeId = 0;
        		$horoplanetModel->userid = $model->userid;
        		$horoplanetModel->planet = $model->planet[$j];
        		$horoplanetModel->digrees = $model->digrees[$j];
        		$horoplanetModel->strength = $model->strength[$j];
        		$horoplanetModel->nakshatram = $model->nakshatram[$j];
        		$horoplanetModel->rashiname = $model->rashiname[$j];
        		$horoplanetModel->shadbalam = $model->shadbalam[$j];
        		$horoplanetModel->navamsa_position = $model->navamsa_position[$j];
        		$allrashi = array();
        		$addingarray = array();
        		foreach ($allRashiDetails as $rashidetails)
        		{
        			if($rashidetails->rashiId < $horoplanetModel->rashiname)
        			{
        				$addingarray[] = $rashidetails->lord;
        				
        			}
        			else{
        			        			        				
        			$allrashi[] = $rashidetails->lord;
        			       		
        			}
        			
        		}
        		for($i=0; $i< count($addingarray); $i++)
        		{
        			array_push($allrashi, $addingarray[$i]);
        		}
        
        		$horoplanetModel->lagnaLord =$allrashi[0];
        		$horoplanetModel->dhanaLord =$allrashi[1];
        		$horoplanetModel->kutumbaLord =$allrashi[2];
        		$horoplanetModel->maatruLord =$allrashi[3];
        		$horoplanetModel->putraLord =$allrashi[4];
        		$horoplanetModel->shetruLord =$allrashi[5];
        		$horoplanetModel->kalatraLord =$allrashi[6];
        		$horoplanetModel->shatruLord =$allrashi[7];
        		$horoplanetModel->bhaagyaLord =$allrashi[8];
        		$horoplanetModel->raajayLord =$allrashi[9];
        		$horoplanetModel->laabhaLord =$allrashi[10];
        		$horoplanetModel->vyayaLord =$allrashi[11];
     
        		
        		
        		$horoplanetModel->save();
        	}
             return $this->redirect(['index']);
        }

//         return $this->render('update', [
//             'model' => $model,
//         ]);
        return $this->render('update', [
        		'model' => $model,
        		'rashilist'=>$rashilist,
        		//'planetlist' => $planetlist,
        		'userslist' => $userslist,
        		'nakhatramList' => $nakhatramList
        ]);
    }

    /**
     * Deletes an existing HoroscopePlanets model.
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
     * Finds the HoroscopePlanets model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HoroscopePlanets the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HoroscopePlanets::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionStrengths($rashi,$planet)    
    {
   
    		$query=PlanetStrengths::find()->select($planet)->Where(['rashiName'=>$rashi])->one();
    		
            $trengthsInfo=StrengthsInfo::find()->select('strengthPercentage')->Where(['strengthName'=>$query[$planet]])->one();
         
           return $trengthsInfo['strengthPercentage'];exit();
   
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
    
    public function getRashiOrderbyLagnaLord($lagnaRashiId)
    {
    	$allRashiDetails = Rashi::find()->all();
    	$allrashi = array();
    	$addingarray = array();
    	$planetorderPos = array();
    	foreach ($allRashiDetails as $rashidetails)
    	{
    		if($rashidetails->rashiId < $lagnaRashiId)
    		{
    			$addingarray[] = $rashidetails->lord;
    		}
    		else{
    			$allrashi[] = $rashidetails->lord;
    		}
    	}
    	 
    	for($i=0; $i< count($addingarray); $i++)
    	{
    		array_push($allrashi, $addingarray[$i]);
    	}
    	for($k=0; $k< count($allrashi); $k++)
    	{
    		$planetorderPos[$allrashi[$k]][] = $k;
    	}
    	/* print_r($allrashi);
    	print_r($planetorderPos);
    	exit(); */
    	 
    	//return $planetorderPos.'+'.$pseventhlord;
    	return $planetorderPos;
      
    }
    
    public function getRashiOrderbyLagnaByname($lagngaRashiname)
    {
    	$rashi = Rashi::find()->where(['rashiName'=>$lagngaRashiname])->one();
    	$allRashiDetails = Rashi::find()->all();
    	$allrashi = array();
    	$addingarray = array();
    	foreach ($allRashiDetails as $rashidetails)
    	{
    		if($rashidetails->rashiId < $rashi->rashiId)
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
    public function bhavam($id)
    {
    	$horoscopeDetails = HoroscopePlanets::find()->select("horoscopedetails.rashiId,horoscopedetails.lagnaLord as lagnaLordinfo,horoscopedetails.rashiName as lagnaRashi,horoscope_planets.*")->innerJoin("horoscopedetails","horoscopedetails.horId = horoscope_planets.horoscopeId")->where("horoscope_planets.userid = $id")->orderBy('horoplanetId ASC')->all();
    	// strengths//// planets strengths
    	$lagnarasiid= array();
    	$strengths= array();
    	foreach ($horoscopeDetails as $horplanet)
    	{
    	    $strengths[$horplanet->planet] = $horplanet->strength; 
    	    $lagnarasiid = $horplanet->rashiId;// lagna rasiid
    	}
    	
    		
    	// Lord //
    	$allRashiDetails = Rashi::find()->all();
    	$allrashi = array();
    	$addingarray = array();
    	foreach ($allRashiDetails as $rashidetails)
    	{
    		if($rashidetails->rashiId < $lagnarasiid)
    		{
    			$addingarray[] = $rashidetails->lord;
    		}
    		else{
    			$allrashi[] = $rashidetails->lord;
    		}
    	}
    	
    	for($i=0; $i< count($addingarray); $i++)
    	{
    		array_push($allrashi, $addingarray[$i]);
    	}
    	if (empty($strengths))
    	{
    	$bhavasarray[] = " ";
    	}else{
    	
    	$bhavasarray =array();
		for($i=0;$i<count($allrashi);$i++)
		{
			$bhavasarray[]= $strengths[strtoupper($allrashi[$i])];
		}
    	}
		
		return $bhavasarray;
    	
    
    }
    
    public function actionHome($id)
    {
    	//ini_set('memory_limit', '-1');
/* $date = date_create('2000-01-01');
date_add($date, date_interval_create_from_date_string('19000 days'));
echo date_format($date, 'Y-m-d'); */
    	
    	
    	$usersInfo = Users::find()->select('user.*,user_details.*')->innerJoin('user_details','user.id = user_details.userId')->where(['user.id' => $id])->one();
    	$planetsInfo = Planets::find()->select('planetId,planetName,dasha_years')->asArray()->orderBy('dasha_order ASC')->all();
    	$isdashaid = 0;
    	$previousarry = array();
    	$presntarry = array();
    	for($k=0; $k<count($planetsInfo); $k++)
    	{
    		$planetId = $planetsInfo[$k]['planetId'];
    		$dashaidnew = $usersInfo->dasa_at_birth+1;
    		if($planetId == $dashaidnew)
    		{
    			$isdashaid = 1;
    		}
    		if($isdashaid == 0)
    		{
    			$previousarry[$planetsInfo[$k]['planetName']] = $planetsInfo[$k]['dasha_years'];
    		}
    		else{
    			$presntarry[$planetsInfo[$k]['planetName']] = $planetsInfo[$k]['dasha_years'];
    		}
    		
    		
    	}
    	
    	$filterArray = array_merge($presntarry,$previousarry);
    	$finalAry = array();
    	$p = 0;
    	$prevDate = date('Y-m-d H:i:s');
    	foreach ($filterArray as $k1 => $v1)
    	{
    		if($p == 0)
    		{
    		$finalAry[$p]['from_date']= $usersInfo->dasa_end_date;
    		}
    		else{
    			$pt = $p-1;
    			$finalAry[$p]['from_date'] = $finalAry[$pt]['end_date'];
    		}
    		
    		$nofDays = $v1*365;    		
    		$date = date_create($finalAry[$p]['from_date']);
    		date_add($date, date_interval_create_from_date_string($nofDays.' days'));
    		$endDateconv =  date_format($date, 'Y-m-d H:i:s');
    		$finalAry[$p]['end_date'] = $endDateconv;
    		$prevDate = $endDateconv;
    		$prevDate2 = date('Y-m-d H:i:s');
    		$p2 = 0;
    		foreach ($filterArray as $k2 => $v2)
    		{
    			if($p2 == 0)
    			{
    			$finalAry[$p]['innerDates'][$p2]['from_date'] = $finalAry[$p]['from_date'];
    			}
    			else{
    				$pt2 = $p2-1;
    				$finalAry[$p]['innerDates'][$p2]['from_date'] = $finalAry[$p]['innerDates'][$pt2]['end_date'];
    			}
    			$nofDays2 = round((($v1/120)*$v2)*365);
    			$noOfyears2 = $nofDays2/365;
    			//echo $nofDays2;
    			
    			$date = date_create($finalAry[$p]['innerDates'][$p2]['from_date']);
    			date_add($date, date_interval_create_from_date_string($nofDays2.' days'));
    			$endDateconv2 =  date_format($date, 'Y-m-d H:i:s');
    			$prevDate2 = $endDateconv2;
    			$finalAry[$p]['innerDates'][$p2]['end_date'] = $endDateconv2;
    			
    			$prevDate3 = date('Y-m-d H:i:s');
    			$p3 = 0;
    			foreach ($filterArray as $k3 => $v3)
    			{
    				if($p3 == 0)
    				{
    					$finalAry[$p]['innerDates'][$p2]['innerDates'][$p3]['from_date'] = $finalAry[$p]['innerDates'][$p2]['from_date'];
    				}
    				else{
    					$pt3 = $p3-1;
    					$finalAry[$p]['innerDates'][$p2]['innerDates'][$p3]['from_date'] = $finalAry[$p]['innerDates'][$p2]['innerDates'][$pt3]['end_date'];
    				}
    				$nofDays3 = round((($noOfyears2/120)*$v3)*365);
    				$noOfyears3 = $nofDays3/365;
    				//echo $nofDays3;exit();
    				 
    				$date = date_create($finalAry[$p]['innerDates'][$p2]['innerDates'][$p3]['from_date']);
    				date_add($date, date_interval_create_from_date_string($nofDays3.' days'));
    				$endDateconv3 =  date_format($date, 'Y-m-d H:i:s');
    				$prevDate3 = $endDateconv3;
    				$finalAry[$p]['innerDates'][$p2]['innerDates'][$p3]['end_date'] = $endDateconv3;
    				
    				
    				$prevDate4 = date('Y-m-d H:i:s');
    				$p4 = 0;
    				foreach ($filterArray as $k4 => $v4)
    				{
    					if($p4 == 0)
    					{
    						$finalAry[$p]['innerDates'][$p2]['innerDates'][$p3]['innerDates'][$p4]['from_date'] = $finalAry[$p]['innerDates'][$p2]['innerDates'][$p3]['from_date'];
    					}
    					else{
    						$pt4 = $p4-1;
    						$finalAry[$p]['innerDates'][$p2]['innerDates'][$p3]['innerDates'][$p4]['from_date'] = $finalAry[$p]['innerDates'][$p2]['innerDates'][$p3]['innerDates'][$pt4]['end_date'];
    					}
    					$nofDays4 = round((($noOfyears3/120)*$v4)*365);
    					$noOfyears4 = $nofDays4/365;
    				
    					$date = date_create($finalAry[$p]['innerDates'][$p2]['innerDates'][$p3]['from_date']);
    					date_add($date, date_interval_create_from_date_string($nofDays4.' days'));
    					$endDateconv4 =  date_format($date, 'Y-m-d H:i:s');
    					$prevDate4 = $endDateconv4;
    					$finalAry[$p]['innerDates'][$p2]['innerDates'][$p3]['innerDates'][$p4]['end_date'] = $endDateconv4;
    					
    					
    					
    					$prevDate5 = date('Y-m-d H:i:s');
    					$p5 = 0;
    					foreach ($filterArray as $k5 => $v5)
    					{
    						if($p5 == 0)
    						{
    							$finalAry[$p]['innerDates'][$p2]['innerDates'][$p3]['innerDates'][$p4]['innerDates'][$p5]['from_date'] = $finalAry[$p]['innerDates'][$p2]['innerDates'][$p3]['innerDates'][$p4]['from_date'];
    						}
    						else{
    							$pt5 = $p5-1;
    							$finalAry[$p]['innerDates'][$p2]['innerDates'][$p3]['innerDates'][$p4]['innerDates'][$p5]['from_date'] = $finalAry[$p]['innerDates'][$p2]['innerDates'][$p3]['innerDates'][$p4]['innerDates'][$pt5]['end_date'];
    						}
    						$nofDays5 = round((($noOfyears4/120)*$v5)*365);
    						$noOfyears5 = $nofDays5/365;
    					
    						$date = date_create($finalAry[$p]['innerDates'][$p2]['innerDates'][$p3]['innerDates'][$p4]['innerDates'][$p5]['from_date']);
    						date_add($date, date_interval_create_from_date_string($nofDays5.' days'));
    						$endDateconv5 =  date_format($date, 'Y-m-d H:i:s');
    						$prevDate5 = $endDateconv5;
    						$finalAry[$p]['innerDates'][$p2]['innerDates'][$p3]['innerDates'][$p4]['innerDates'][$p5]['end_date'] = $endDateconv5;
    						
    						
    						
    						$prevDate6 = date('Y-m-d H:i:s');
    						$p6 = 0;
    						foreach ($filterArray as $k6 => $v6)
    						{
    							if($p6 == 0)
    							{
    								$finalAry[$p]['innerDates'][$p2]['innerDates'][$p3]['innerDates'][$p4]['innerDates'][$p5]['innerDates'][$p6]['from_date'] = $finalAry[$p]['innerDates'][$p2]['innerDates'][$p3]['innerDates'][$p4]['innerDates'][$p5]['from_date'];
    							}
    							else{
    								$pt6 = $p6-1;
    								$finalAry[$p]['innerDates'][$p2]['innerDates'][$p3]['innerDates'][$p4]['innerDates'][$p5]['innerDates'][$p6]['from_date'] = $finalAry[$p]['innerDates'][$p2]['innerDates'][$p3]['innerDates'][$p4]['innerDates'][$p5]['innerDates'][$pt6]['end_date'];
    							}
    							$nofDays6 = round((($noOfyears5/120)*$v6)*365);
    							$noOfyears6 = $nofDays6/365;
    								
    							$date = date_create($finalAry[$p]['innerDates'][$p2]['innerDates'][$p3]['innerDates'][$p4]['innerDates'][$p5]['innerDates'][$p6]['from_date']);
    							date_add($date, date_interval_create_from_date_string($nofDays6.' days'));
    							$endDateconv6 =  date_format($date, 'Y-m-d H:i:s');
    							$prevDate6 = $endDateconv6;
    							$finalAry[$p]['innerDates'][$p2]['innerDates'][$p3]['innerDates'][$p4]['innerDates'][$p5]['innerDates'][$p6]['end_date'] = $endDateconv6;
    							$p6++;
    							//echo $nofDays2;exit();
    						    	
    						}
    						$p5++;
    						//echo $nofDays2;exit();
    					
    					}
    					$p4++;
    					//echo $nofDays2;exit();
    				}
    				$p3++;
    				//echo $nofDays2;exit();
    			    
    			}
    			
    			$p2++;
    			//echo $nofDays2;exit();
    			
    		}
    		
    		$p++;
    		
    	}
    	print_r($finalAry);exit();
    }
    
    
    
}
