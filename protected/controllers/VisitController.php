<?php

class VisitController extends Controller
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
				'actions'=>array( 'JSONvisit', 'JSONVisitAnios', 'JSONvisitporcategoria','JSON50masvisitadosporanio','JSON50menosvisitadosporanio', 'JSONtodosvisitadospormes','JSONmasvisitados', 'JSONusuariosmasutilizanmisoa','JSONvisitanmisoapormes','JSONtodosvisitadospormesrango','JSONvisitanmisoapormesrango','JSONVisittodos','JSONvisittotal','JSONvisitanmisoapordias','JSONtodosvisitadospordias'),
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
		
		$sql = "SELECT DISTINCT YEAR(createdAt) as anio FROM `visit` ORDER BY YEAR(createdAt) ASC"; 
		$dataProvider = Yii::app()->db->createCommand($sql)->queryAll();		
		$this->render('index',array('model'=>$model,'dataProvider'=>$dataProvider, ));		
	}
	
	public function actionIndexgeneral()
	{
		$sql = "SELECT DISTINCT YEAR(createdAt) as anio FROM `visit` ORDER BY YEAR(createdAt) ASC"; 
		$dataProvider = Yii::app()->db->createCommand($sql)->queryAll();		
		$this->render('indexgeneral',array('dataProvider'=>$dataProvider, ));				
	}
	
	public function actionJSONvisittotal()
	{
		$this->layout=FALSE;
		header('Content-type: application/json');
				
		$sql = "SELECT 'Total' as anio, Count(`visit`.`id`) as total, 0 as cantidad 
				FROM `visit`";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$datosVisit = $dbCommand->queryAll();
		
		$idu=Yii::app()->user->id;
		
		$sql = "SELECT 'Total' as anio, Count(visit.id) as cantidad 
				FROM visit, article 
				WHERE article.id = visit.article and article.creator=".$idu."";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$datosVisitme = $dbCommand->queryAll();		
		
		foreach ($datosVisit as $key => $value) {
			foreach ($datosVisitme as $key1 => $value1) {
				
				if ($value['anio']===$value1['anio']) {
					$datosVisit[$key]['cantidad']=$value1['cantidad'];
				} 
							
			}			
		}

		foreach ($datosVisit as $key => $value) {
			$datosVisit[$key]['porcentaje']=round($value['cantidad']/$value['total']*100,2);					
		}
		echo json_encode($datosVisit);
		//echo json_encode($datosVisitme);
		Yii::app()->end();
	}
	
	public function actionJSONvisit()
	{
		$this->layout=FALSE;
		header('Content-type: application/json');
				
		$sql = "SELECT YEAR(`visit`.`createdAt`) as anio, Count(`visit`.`id`) as total, 0 as cantidad 
				FROM `visit` 
				GROUP BY YEAR(`visit`.`createdAt`)";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$datosVisit = $dbCommand->queryAll();
		
		$idu=Yii::app()->user->id;
		
		$sql = "SELECT YEAR(visit.createdAt) as anio, Count(visit.id) as cantidad 
				FROM visit, article 
				WHERE article.id = visit.article and article.creator=".$idu."
				GROUP BY YEAR(visit.createdAt)";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$datosVisitme = $dbCommand->queryAll();		
		
		foreach ($datosVisit as $key => $value) {
			foreach ($datosVisitme as $key1 => $value1) {
				
				if ($value['anio']===$value1['anio']) {
					$datosVisit[$key]['cantidad']=$value1['cantidad'];
				} 
							
			}			
		}

		foreach ($datosVisit as $key => $value) {
			$datosVisit[$key]['porcentaje']=round($value['cantidad']/$value['total']*100,2);					
		}
		echo json_encode($datosVisit);
		//echo json_encode($datosVisitme);
		Yii::app()->end();
	}
	
	/*public function actionJSONVisit()
	{
		$this->layout=FALSE;
		header('Content-type: application/json');	
		
		$sql = "SELECT YEAR(`visit`.`createdAt`) as anio, Count(`visit`.`id`) as cantidad 
				FROM `visit` 
				GROUP BY YEAR(`visit`.`createdAt`)";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$datosVisit = $dbCommand->queryAll();
		
		echo json_encode($datosVisit);
		Yii::app()->end();			
	}*/
	
	public function actionJSONVisittodos()
	{
		$this->layout=FALSE;
		header('Content-type: application/json');	
		
		$sql = "SELECT 'Todos' as anio, Count(`visit`.`id`) as cantidad 
				FROM `visit`";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$datosVisit = $dbCommand->queryAll();
		
		echo json_encode($datosVisit);
		Yii::app()->end();			
	}
	
	public function actionJSONVisitAnios()
	{
		$this->layout=FALSE;
		header('Content-type: application/json');	
		
		$sql = "SELECT YEAR(`visit`.`createdAt`) as anio, Count(`visit`.`id`) as cantidad 
				FROM `visit` 
				GROUP BY YEAR(`visit`.`createdAt`)";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$datosVisit = $dbCommand->queryAll();
		
		echo json_encode($datosVisit);
		Yii::app()->end();			
	}
	
	public function actionJSONvisitporcategoria($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');
		
		$data=array();
		
		$sql = "SELECT `category`.`name` as label, Count(`visit`.`id`) as value 
				FROM `visit`, `article`,`article_categories__category_articles`, `category` 
				WHERE `visit`.`article`= `article`.`id` AND `article`.`id` = `article_categories__category_articles`.`article_categories` AND `article_categories__category_articles`.`category_articles`= `category`.`id` AND YEAR(`visit`.`createdAt`)= ".$id." GROUP BY YEAR(`visit`.`createdAt`), `category`.`id`";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$datosShare = $dbCommand->queryAll();
		
		echo json_encode($datosShare);
		Yii::app()->end();	
	}
	
	public function actionJSON50masvisitadosporanio()
	{
		$this->layout=FALSE;
		header('Content-type: application/json');
		
		$data=array();
		
		$sql = "SELECT `article`.`title` as article, COUNT(`visit`.`id`) as cantidad
				FROM `visit`, `article` 
				WHERE `article`.`id`= `visit`.`article`
				GROUP BY `article`.`id`
				ORDER BY COUNT(`visit`.`id`) DESC
				limit 30";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$datosVisit = $dbCommand->queryAll();
		
		echo json_encode($datosVisit);
		Yii::app()->end();		
	}
	
	public function actionJSON50menosvisitadosporanio()
	{
		$this->layout=FALSE;
		header('Content-type: application/json');
		
		$data=array();
		
		$sql = "SELECT `article`.`title` as article, COUNT(`visit`.`id`) as cantidad
				FROM `visit`, `article` 
				WHERE `article`.`id`= `visit`.`article`
				GROUP BY `article`.`id`
				ORDER BY COUNT(`visit`.`id`) ASC
				limit 30";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$datosShare = $dbCommand->queryAll();
		
		echo json_encode($datosShare);
		Yii::app()->end();		
	}

	public function actionJSONtodosvisitadospormes($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');			
		
		$sql = "SELECT Date_format(visit.createdAt,'%Y-%m') as mes, COUNT(visit.id) as visitado
				FROM visit 
				WHERE YEAR(visit.createdAt)=".$id."
				GROUP BY MONTH(visit.`createdAt`)";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$datosShare = $dbCommand->queryAll();
		
		echo json_encode($datosShare);		
		Yii::app()->end();				
	}
	
	public function actionJSONtodosvisitadospordias()
	{
		$this->layout=FALSE;
		header('Content-type: application/json');			
		
		$sql = "SELECT Date_format(visit.createdAt,'%Y-%m-%d') as dia, COUNT(visit.id) as visitado
				FROM visit 
				WHERE visit.createdAt LIKE '".$_POST['mes']."%'
				GROUP BY Date_format(visit.createdAt,'%Y-%m-%d')";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$datosShare = $dbCommand->queryAll();
		
		echo json_encode($datosShare);		
		Yii::app()->end();				
	}
	
	public function actionJSONtodosvisitadospormesrango()
	{
		$this->layout=FALSE;
		header('Content-type: application/json');			
		
		$sql = "SELECT Date_format(visit.createdAt,'%Y-%m') as mes, COUNT(visit.id) as visitado
				FROM visit 
				WHERE visit.createdAt>='".$_POST['fecha1']."' and visit.createdAt<='".$_POST['fecha2']."'
				GROUP BY YEAR(visit.`createdAt`), MONTH(visit.`createdAt`)";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$datosShare = $dbCommand->queryAll();
		
		echo json_encode($datosShare);		
		Yii::app()->end();				
	}

	//ESTADISTICAS POR USUARIO
	
	public function actionJSONmasvisitados()
	{
		$this->layout=FALSE;
		header('Content-type: application/json');
		
		$id=Yii::app()->user->id;		
		
		$sql = "SELECT article.title, article.url, COUNT(visit.user) as cantidad
				FROM visit, article 
				WHERE article.id=visit.article and article.creator=".$id."
				GROUP BY article.id
				ORDER BY COUNT(visit.user) DESC
				limit 5";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataCompartido = $dbCommand->queryAll();
		
		echo json_encode($dataCompartido);		
		Yii::app()->end();
	}
	
	
	//Usuarios que mas utilizan mis OA
	
	public function actionJSONusuariosmasutilizanmisoa()
	{
		$this->layout=FALSE;
		header('Content-type: application/json');
		
		$data=array();
		
		$id=Yii::app()->user->id;
		
		$sql = "SELECT user.name as nombre, COUNT(visit.user) as visitas
				FROM visit, user, article 
				WHERE user.id=visit.user and article.id=visit.article and article.creator=".$id."
				GROUP BY user.name
				ORDER BY COUNT(visit.user) DESC";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$datosShare = $dbCommand->queryAll();
		
		echo json_encode($datosShare);
		Yii::app()->end();		
	}
	
	public function actionJSONvisitanmisoapormes($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');
		
		$idu=Yii::app()->user->id;	
		
		$sql = "SELECT Date_format(visit.`createdAt`,'%Y-%m') as mes, COUNT(visit.id) as total, 0 as cantidad 
				FROM visit, article 
				WHERE article.id = visit.article AND YEAR(visit.createdAt)=".$id."  
				GROUP BY YEAR(visit.createdAt), MONTH(`visit`.`createdAt`)";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataTotal = $dbCommand->queryAll();
		
		$sqlmis = "SELECT Date_format(visit.`createdAt`,'%Y-%m') as mes, COUNT(visit.id) as cantidad 
				FROM visit, article 
				WHERE article.id = visit.article AND YEAR(visit.createdAt)=".$id." AND article.creator=".$idu." 
				 GROUP BY YEAR(visit.createdAt), MONTH(`visit`.`createdAt`)";  	
		$dbCommand = Yii::app()->db->createCommand($sqlmis);
		$dataVisit = $dbCommand->queryAll();
		
		foreach ($dataTotal as $key => $value) {
			foreach ($dataVisit as $key1 => $value1) {
				
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
	
	public function actionJSONvisitanmisoapormesrango()
	{
		$this->layout=FALSE;
		header('Content-type: application/json');
		
		$idu=Yii::app()->user->id;	
		
		$sql = "SELECT Date_format(visit.`createdAt`,'%Y-%m') as mes, COUNT(visit.id) as total, 0 as cantidad 
				FROM visit, article 
				WHERE article.id = visit.article AND visit.createdAt>='".$_POST['fecha1']."' AND visit.createdAt<='".$_POST['fecha2']."'   
				GROUP BY YEAR(visit.createdAt), MONTH(`visit`.`createdAt`)";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataTotal = $dbCommand->queryAll();
		
		$sqlmis = "SELECT Date_format(visit.`createdAt`,'%Y-%m') as mes, COUNT(visit.id) as cantidad 
				FROM visit, article 
				WHERE article.id = visit.article AND visit.createdAt>='".$_POST['fecha1']."' AND visit.createdAt<='".$_POST['fecha2']."' AND article.creator=".$idu." 
				GROUP BY YEAR(visit.createdAt), MONTH(`visit`.`createdAt`)";  	
		$dbCommand = Yii::app()->db->createCommand($sqlmis);
		$dataVisit = $dbCommand->queryAll();
		
		foreach ($dataTotal as $key => $value) {
			foreach ($dataVisit as $key1 => $value1) {
				
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
	
	public function actionJSONvisitanmisoapordias()
	{
		$this->layout=FALSE;
		header('Content-type: application/json');
		
		$idu=Yii::app()->user->id;	
		
		$sql = "SELECT Date_format(visit.`createdAt`,'%Y-%m-%d') as dia, COUNT(visit.id) as total, 0 as cantidad 
				FROM visit, article 
				WHERE article.id = visit.article AND visit.createdAt LIKE '".$_POST['mes']."%'   
				GROUP BY Date_format(visit.createdAt,'%Y-%m-%d')"; 	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataTotal = $dbCommand->queryAll();
		
		$sqlmis = "SELECT Date_format(visit.`createdAt`,'%Y-%m-%d') as dia, COUNT(visit.id) as cantidad 
				FROM visit, article 
				WHERE article.id = visit.article AND visit.createdAt LIKE '".$_POST['mes']."%' AND article.creator=".$idu." 
				GROUP BY Date_format(visit.createdAt,'%Y-%m-%d')";   	
		$dbCommand = Yii::app()->db->createCommand($sqlmis);
		$dataVisit = $dbCommand->queryAll();
		
		foreach ($dataTotal as $key => $value) {
			foreach ($dataVisit as $key1 => $value1) {
				
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

}  

?>