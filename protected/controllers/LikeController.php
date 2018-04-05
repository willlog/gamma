<?php
    class LikeController extends Controller
    {
    	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}
	
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','Indexgeneral'),
				'users'=>array('@'),
			),
			//Permisos para los gráficos estadísticos
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array( 'JSONlike', 'JSONgustadosporanios', 'JSON50masgustadosporanio', 'JSON50menosgustadosporanio', 'JSONtodosgustadospormes', 'JSONMasgustados','JSONusuariosmasgustanmisoa','JSONgustanmisoapormes','JSONtodosgustadospormesrango','JSONgustanmisoapormesrango','JSONgustadostodos','JSONliketodos','JSONgustanmisoapordias','JSONtodosgustadospordias'),
				'users'=>array('@'),
			),						
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
    	public function actionIndex()
		{
			$id= Yii::app()->user->id;
		
			$model=User::model()->findByPk($id);
			
			$sql = "SELECT DISTINCT YEAR(createdAt) as anio FROM `like` ORDER BY YEAR(createdAt) ASC"; 
			$dataProvider = Yii::app()->db->createCommand($sql)->queryAll(); 
			$this->render('index',array('model'=>$model,'dataProvider'=>$dataProvider, ));
		}
		
		public function actionIndexgeneral()
		{
			$sql = "SELECT DISTINCT YEAR(createdAt) as anio FROM `like` ORDER BY YEAR(createdAt) ASC"; 
			$dataProvider = Yii::app()->db->createCommand($sql)->queryAll(); 
			$this->render('indexgeneral',array( 'dataProvider'=>$dataProvider, ));
		}
		
		public function actionJSONliketodos()
		{			
			$this->layout=FALSE;
			header('Content-type: application/json');
					
			$sql = "SELECT 'Todos' as anio, Count(`like`.`id`) as total, 0 as cantidad 
					FROM `like`";  	
			$dbCommand = Yii::app()->db->createCommand($sql);
			$datosLike = $dbCommand->queryAll();
			
			$idu=Yii::app()->user->id;
			
			$sql = "SELECT 'Todos' as anio, Count(`like`.id) as cantidad 
					FROM `like`, article 
					WHERE article.id = `like`.article and article.creator=".$idu."";  	
			$dbCommand = Yii::app()->db->createCommand($sql);
			$datosLikeme = $dbCommand->queryAll();		
			
			foreach ($datosLike as $key => $value) {
				foreach ($datosLikeme as $key1 => $value1) {
					
					if ($value['anio']===$value1['anio']) {
						$datosLike[$key]['cantidad']=$value1['cantidad'];
					} 
								
				}			
			}
	
			foreach ($datosLike as $key => $value) {
				$datosLike[$key]['porcentaje']=round($value['cantidad']/$value['total']*100,2);					
			}
			echo json_encode($datosLike);			
			Yii::app()->end();
		}
		
		public function actionJSONlike()
		{			
			$this->layout=FALSE;
			header('Content-type: application/json');
					
			$sql = "SELECT YEAR(`like`.`createdAt`) as anio, Count(`like`.`id`) as total, 0 as cantidad 
					FROM `like` 
					GROUP BY YEAR(`like`.`createdAt`)";  	
			$dbCommand = Yii::app()->db->createCommand($sql);
			$datosLike = $dbCommand->queryAll();
			
			$idu=Yii::app()->user->id;
			
			$sql = "SELECT YEAR(`like`.createdAt) as anio, Count(`like`.id) as cantidad 
					FROM `like`, article 
					WHERE article.id = `like`.article and article.creator=".$idu."
					GROUP BY YEAR(`like`.createdAt)";  	
			$dbCommand = Yii::app()->db->createCommand($sql);
			$datosLikeme = $dbCommand->queryAll();		
			
			foreach ($datosLike as $key => $value) {
				foreach ($datosLikeme as $key1 => $value1) {
					
					if ($value['anio']===$value1['anio']) {
						$datosLike[$key]['cantidad']=$value1['cantidad'];
					} 
								
				}			
			}
	
			foreach ($datosLike as $key => $value) {
				$datosLike[$key]['porcentaje']=round($value['cantidad']/$value['total']*100,2);					
			}
			echo json_encode($datosLike);			
			Yii::app()->end();
		}
		
		public function actionJSONgustadostodos()
		{
			$this->layout=FALSE;
			header('Content-type: application/json');
			
			$data=array();
			
			$sql = "SELECT 'Todos' as anio, Count(`like`.`id`) as cantidad 
					FROM `like`";  	
			$dbCommand = Yii::app()->db->createCommand($sql);
			$datosShare = $dbCommand->queryAll();
			
			echo json_encode($datosShare);
			Yii::app()->end();			
		}

		public function actionJSONgustadosporanios()
		{
			$this->layout=FALSE;
			header('Content-type: application/json');
			
			$data=array();
			
			$sql = "SELECT YEAR(`like`.`createdAt`) as anio, Count(`like`.`id`) as cantidad 
					FROM `like` 
					GROUP BY YEAR(`like`.`createdAt`)";  	
			$dbCommand = Yii::app()->db->createCommand($sql);
			$datosShare = $dbCommand->queryAll();
			
			echo json_encode($datosShare);
			Yii::app()->end();			
		}

		public function actionJSON50masgustadosporanio()
		{
			$this->layout=FALSE;
			header('Content-type: application/json');
			
			$data=array();
			
			$sql = "SELECT `article`.`title` as article, COUNT(`like`.`id`) as cantidad
					FROM `like`, `article` 
					WHERE `article`.`id`= `like`.`article`
					GROUP BY `article`.`id`
					ORDER BY COUNT(`like`.`id`) DESC
					limit 30";  	
			$dbCommand = Yii::app()->db->createCommand($sql);
			$datosShare = $dbCommand->queryAll();
			
			echo json_encode($datosShare);
			Yii::app()->end();		
		}

		public function actionJSON50menosgustadosporanio()
		{
			$this->layout=FALSE;
			header('Content-type: application/json');
			
			$data=array();
			
			$sql = "SELECT `article`.`title` as article, COUNT(`like`.`id`) as cantidad
					FROM `like`, `article` 
					WHERE `article`.`id`= `like`.`article`
					GROUP BY `article`.`id`
					ORDER BY COUNT(`like`.`id`) ASC
					limit 30";  	
			$dbCommand = Yii::app()->db->createCommand($sql);
			$datosShare = $dbCommand->queryAll();
			
			echo json_encode($datosShare);
			Yii::app()->end();		
		}

		public function actionJSONtodosgustadospormes($id)
		{
			$this->layout=FALSE;
			header('Content-type: application/json');
			
			$idu=Yii::app()->user->id;	
			
			$sql = "SELECT Date_format(`like`.createdAt,'%Y-%m') as mes, COUNT(`like`.id) as gustado
					FROM `like`
					WHERE YEAR(`like`.createdAt)=".$id."
					GROUP BY MONTH(`like`.`createdAt`)";  	
			$dbCommand = Yii::app()->db->createCommand($sql);
			$datosShare = $dbCommand->queryAll();
			
			echo json_encode($datosShare);		
			Yii::app()->end();				
		}
		
		public function actionJSONtodosgustadospordias()
		{
			$this->layout=FALSE;
			header('Content-type: application/json');
			
			$idu=Yii::app()->user->id;	
			
			$sql = "SELECT Date_format(`like`.createdAt,'%Y-%m-%d') as dia, COUNT(`like`.id) as gustado
					FROM `like`
					WHERE `like`.createdAt LIKE '".$_POST['mes']."%'
					GROUP BY Date_format(`like`.createdAt,'%Y-%m-%d')";  	
			$dbCommand = Yii::app()->db->createCommand($sql);
			$datosShare = $dbCommand->queryAll();
			
			echo json_encode($datosShare);		
			Yii::app()->end();				
		}
		
		public function actionJSONtodosgustadospormesrango()
		{
			$this->layout=FALSE;
			header('Content-type: application/json');
			
			$idu=Yii::app()->user->id;	
			
			$sql = "SELECT Date_format(`like`.createdAt,'%Y-%m') as mes, COUNT(`like`.id) as gustado
					FROM `like`
					WHERE `like`.createdAt>='".$_POST['fecha1']."' and `like`.createdAt<='".$_POST['fecha2']."'
					GROUP BY YEAR(`like`.`createdAt`), MONTH(`like`.`createdAt`)";  	
			$dbCommand = Yii::app()->db->createCommand($sql);
			$datosShare = $dbCommand->queryAll();
			
			echo json_encode($datosShare);		
			Yii::app()->end();				
		}

		//ESTADISTICAS POR USUARIO
		
		public function actionJSONmasgustados()
		{
			$this->layout=FALSE;
			header('Content-type: application/json');
			
			$id=Yii::app()->user->id;		
			
			$sql = "SELECT article.title, article.url, COUNT(`like`.user) as cantidad
					FROM `like`, article 
					WHERE article.id=`like`.article and article.creator=".$id."
					GROUP BY article.id
					ORDER BY COUNT(`like`.user) DESC
					limit 5";  	
			$dbCommand = Yii::app()->db->createCommand($sql);
			$dataCompartido = $dbCommand->queryAll();
			
			echo json_encode($dataCompartido);		
			Yii::app()->end();
		}
	
	//Usuarios que mas utilizan mis OA
	
		public function actionJSONusuariosmasgustanmisoa()
		{
			$this->layout=FALSE;
			header('Content-type: application/json');
			
			$data=array();
			
			$id=Yii::app()->user->id;
			
			$sql = "SELECT user.name as nombre, COUNT(`like`.user) as gustados
					FROM `like`, user, article 
					WHERE user.id=`like`.user and article.id=`like`.article and article.creator=".$id."
					GROUP BY user.name
					ORDER BY COUNT(`like`.user) DESC";  	
			$dbCommand = Yii::app()->db->createCommand($sql);
			$datosShare = $dbCommand->queryAll();
			
			echo json_encode($datosShare);
			Yii::app()->end();		
		}
		
	public function actionJSONgustanmisoapormes($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');
		
		$idu=Yii::app()->user->id;	
		
		$sql = "SELECT Date_format(`like`.`createdAt`,'%Y-%m') as mes, COUNT(`like`.id) as total, 0 as cantidad 
				FROM `like`, article 
				WHERE article.id = `like`.article AND YEAR(`like`.createdAt)=".$id."  
				GROUP BY YEAR(`like`.createdAt), MONTH(`like`.`createdAt`)";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataTotal = $dbCommand->queryAll();
		
		$sqlmis = "SELECT Date_format(`like`.`createdAt`,'%Y-%m') as mes, COUNT(`like`.id) as cantidad 
				FROM `like`, article 
				WHERE article.id = `like`.article AND YEAR(`like`.createdAt)=".$id." AND article.creator=".$idu." 
				 GROUP BY YEAR(`like`.createdAt), MONTH(`like`.`createdAt`)";  	
		$dbCommand = Yii::app()->db->createCommand($sqlmis);
		$dataLike = $dbCommand->queryAll();
		
		foreach ($dataTotal as $key => $value) {
			foreach ($dataLike as $key1 => $value1) {
				
				if ($value['mes']===$value1['mes']) {
					$dataTotal[$key]['cantidad']=$value1['cantidad'];
				} 
							
			}			
		}

		foreach ($dataTotal as $key => $value) {
			$dataTotal[$key]['porcentaje']=round($value['cantidad']/$value['total']*100,2);					
		}		
		
		echo json_encode($dataTotal);		
		Yii::app()->end();				
	}	
	
	public function actionJSONgustanmisoapordias()
	{
		$this->layout=FALSE;
		header('Content-type: application/json');
		
		$idu=Yii::app()->user->id;	
		
		$sql = "SELECT Date_format(`like`.`createdAt`,'%Y-%m-%d') as dia, COUNT(`like`.id) as total, 0 as cantidad 
				FROM `like`, article 
				WHERE article.id = `like`.article AND `like`.createdAt LIKE '".$_POST['mes']."%'   
				GROUP BY Date_format(`like`.createdAt,'%Y-%m-%d')"; 	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataTotal = $dbCommand->queryAll();
		
		$sqlmis = "SELECT Date_format(`like`.`createdAt`,'%Y-%m-%d') as dia, COUNT(`like`.id) as cantidad 
				FROM `like`, article 
				WHERE article.id = `like`.article AND `like`.createdAt LIKE '".$_POST['mes']."%' AND article.creator=".$idu." 
				GROUP BY Date_format(`like`.createdAt,'%Y-%m-%d')";    	
		$dbCommand = Yii::app()->db->createCommand($sqlmis);
		$dataLike = $dbCommand->queryAll();
		
		foreach ($dataTotal as $key => $value) {
			foreach ($dataLike as $key1 => $value1) {
				
				if ($value['dia']===$value1['dia']) {
					$dataTotal[$key]['cantidad']=$value1['cantidad'];
				} 
							
			}			
		}

		foreach ($dataTotal as $key => $value) {
			$dataTotal[$key]['porcentaje']=round($value['cantidad']/$value['total']*100,2);					
		}		
		
		echo json_encode($dataTotal);		
		Yii::app()->end();				
	}	
	
	public function actionJSONgustanmisoapormesrango()
	{
		$this->layout=FALSE;
		header('Content-type: application/json');
		
		$idu=Yii::app()->user->id;	
		
		$sql = "SELECT Date_format(`like`.`createdAt`,'%Y-%m') as mes, COUNT(`like`.id) as total, 0 as cantidad 
				FROM `like`, article 
				WHERE article.id = `like`.article AND `like`.createdAt>='".$_POST['fecha1']."' AND `like`.createdAt<='".$_POST['fecha2']."'  
				GROUP BY YEAR(`like`.createdAt), MONTH(`like`.`createdAt`)";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataTotal = $dbCommand->queryAll();
		
		$sqlmis = "SELECT Date_format(`like`.`createdAt`,'%Y-%m') as mes, COUNT(`like`.id) as cantidad 
				FROM `like`, article 
				WHERE article.id = `like`.article AND `like`.createdAt>='".$_POST['fecha1']."' AND `like`.createdAt<='".$_POST['fecha2']."' AND article.creator=".$idu." 
				 GROUP BY YEAR(`like`.createdAt), MONTH(`like`.`createdAt`)";  	
		$dbCommand = Yii::app()->db->createCommand($sqlmis);
		$dataLike = $dbCommand->queryAll();
		
		foreach ($dataTotal as $key => $value) {
			foreach ($dataLike as $key1 => $value1) {
				
				if ($value['mes']===$value1['mes']) {
					$dataTotal[$key]['cantidad']=$value1['cantidad'];
				} 
							
			}			
		}

		foreach ($dataTotal as $key => $value) {
			$dataTotal[$key]['porcentaje']=round($value['cantidad']/$value['total']*100,2);					
		}		
		
		echo json_encode($dataTotal);		
		Yii::app()->end();				
	}			
		
    }
?>