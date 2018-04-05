<?php 
class ShareController extends Controller
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
				'actions'=>array('index','Indexgeneral', 'indexrecomendados'),
				'users'=>array('@'),
			),
			//Permisos para los gráficos estadísticos
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array( 'JSONshare', 'JSONsharetodos','JSONsharemisarticulos', 'JSONshareporcategoria', 'JSONshareporcategoriames', 'JSON50mascompartidosporanio', 'JSON50menoscompartidosporanio','JSON20mascompartidosporusuario','JSON20menoscompartidosporusuario', 'JSONConsultarporanio','JSONpublicacioneseneltiempo','JSONtodoscompartidospormes','JSONcomparativacompartidovisitadogustado','JSONmascompartidos','JSONusuariosmascompartenmisoa','JSONcompartenmisoapormes','JSONcompartenmisoapormesarticulo','JSONarticulosvecescompartidasenanio','JSONrecomendados','JSONtodoscompartidospormesrango','JSONcompartenmisoapormesrango','JSONsharetodosporanio','JSONsharetodosarticulos','JSONcompartenmisoapordias','JSONtodoscompartidospordias'),
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
		
		$sql = "SELECT DISTINCT YEAR(createdAt) as anio FROM `share` ORDER BY YEAR(createdAt) ASC"; 
		$dataProvider = Yii::app()->db->createCommand($sql)->queryAll(); 
		$id=Yii::app()->user->id;
		$sql = "SELECT id, title FROM article WHERE article.creator=".$id."";
		$dataArticle = Yii::app()->db->createCommand($sql)->queryAll(); 
		$this->render('index',array( 'model'=>$model,'dataProvider'=>$dataProvider,'dataArticle'=>$dataArticle)); 
	}
	
	public function actionIndexgeneral()
	{
		//$this->render("index");
		$sql = "SELECT DISTINCT YEAR(createdAt) as anio FROM `share` ORDER BY YEAR(createdAt) ASC"; 
		$dataProvider = Yii::app()->db->createCommand($sql)->queryAll(); 
		$this->render('indexgeneral',array( 'dataProvider'=>$dataProvider, )); 
	}
	
	public function actionIndexrecomendados()
	{
		//$this->render("index");
		$sql = "SELECT DISTINCT YEAR(createdAt) as anio FROM `share` ORDER BY YEAR(createdAt) ASC"; 
		$dataProvider = Yii::app()->db->createCommand($sql)->queryAll(); 
		$this->render('indexrecomendados',array( 'dataProvider'=>$dataProvider, )); 
	}
	
	//Comparativo de compartidos total vs mis articulos(por años)
	public function actionJSONshare()
	{
		$this->layout=FALSE;
		header('Content-type: application/json');	
		
		$idu=Yii::app()->user->id;
		$sql = "SELECT YEAR(`share`.`createdAt`) as anio, Count(`share`.`id`) as cantidad 
				FROM `share` 
				GROUP BY YEAR(`share`.`createdAt`)";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$datosShare = $dbCommand->queryAll();
		
		$sqls = "SELECT YEAR(share.createdAt) as anio, Count(share.id) as cantidad 
				FROM share, article 
				WHERE article.id = share.article and article.creator=".$idu."
				GROUP BY YEAR(share.createdAt)";  	
		$dbCommand = Yii::app()->db->createCommand($sqls);
		$datosShares = $dbCommand->queryAll();
		
		
		//echo json_encode($datosShares);
		
		foreach ($datosShare as $key => $value) {
			foreach ($datosShares as $key1 => $value1) {
				
				if ($value['anio']===$value1['anio']) {
					$datosShare[$key]['total']=$value1['cantidad'];
				} 
							
			}			
		}
		echo json_encode($datosShare);
		Yii::app()->end();			
	}
	
	
	//Total de artículos compartidos (por años)
	public function actionJSONsharetodos()
	{
		$this->layout=FALSE;
		header('Content-type: application/json');	
		
		$idu=Yii::app()->user->id;
		$sql = "SELECT 'Todos' as anio, Count(`share`.`id`) as cantidad 
				FROM `share`";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$datosShare = $dbCommand->queryAll();		
		
		echo json_encode($datosShare);
		Yii::app()->end();			
	}
	
	//Total de artículos compartidos (por años)
	public function actionJSONsharetodosporanio()
	{
		$this->layout=FALSE;
		header('Content-type: application/json');	
		
		$idu=Yii::app()->user->id;
		$sql = "SELECT YEAR(`share`.`createdAt`) as anio, Count(`share`.`id`) as cantidad 
				FROM `share` 
				GROUP BY YEAR(`share`.`createdAt`)";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$datosShare = $dbCommand->queryAll();		
		
		echo json_encode($datosShare);
		Yii::app()->end();			
	}
	
	public function actionJSONsharetodosarticulos()
	{
		$this->layout=FALSE;
		header('Content-type: application/json');
				
		$sql = "SELECT 'Todos' as anio, Count(share.id) as total, 0 as cantidad 
				FROM share";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$datosShare = $dbCommand->queryAll();
		
		$idu=Yii::app()->user->id;
		
		$sql = "SELECT 'Todos' as anio, Count(share.id) as cantidad 
				FROM share, article 
				WHERE article.id = share.article and article.creator=".$idu."";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$datosShareme = $dbCommand->queryAll();		
		
		foreach ($datosShare as $key => $value) {
			foreach ($datosShareme as $key1 => $value1) {
				
				if ($value['anio']===$value1['anio']) {
					$datosShare[$key]['cantidad']=$value1['cantidad'];
				} 
							
			}			
		}

		foreach ($datosShare as $key => $value) {
			$datosShare[$key]['porcentaje']=round($value['cantidad']/$value['total']*100,2);					
		}
		echo json_encode($datosShare);		
		Yii::app()->end();		
	}
	
	public function actionJSONsharemisarticulos()
	{
		$this->layout=FALSE;
		header('Content-type: application/json');
				
		$sql = "SELECT YEAR(share.createdAt) as anio, Count(share.id) as total, 0 as cantidad 
				FROM share 
				GROUP BY YEAR(share.createdAt)";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$datosShare = $dbCommand->queryAll();
		
		$idu=Yii::app()->user->id;
		
		$sql = "SELECT YEAR(share.createdAt) as anio, Count(share.id) as cantidad 
				FROM share, article 
				WHERE article.id = share.article and article.creator=".$idu."
				GROUP BY YEAR(share.createdAt)";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$datosShareme = $dbCommand->queryAll();		
		
		foreach ($datosShare as $key => $value) {
			foreach ($datosShareme as $key1 => $value1) {
				
				if ($value['anio']===$value1['anio']) {
					$datosShare[$key]['cantidad']=$value1['cantidad'];
				} 
							
			}			
		}

		foreach ($datosShare as $key => $value) {
			$datosShare[$key]['porcentaje']=round($value['cantidad']/$value['total']*100,2);					
		}
		echo json_encode($datosShare);		
		Yii::app()->end();		
	}
	
	public function actionJSONshareporcategoria($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');
		
		$data=array();
		
		$sql = "SELECT `category`.`name` as label, Count(`share`.`id`) as value 
				FROM `share`, `article`,`article_categories__category_articles`, `category` 
				WHERE `share`.`article`= `article`.`id` AND `article`.`id` = `article_categories__category_articles`.`article_categories` AND `article_categories__category_articles`.`category_articles`= `category`.`id` AND YEAR(`share`.`createdAt`)= ".$id." GROUP BY YEAR(`share`.`createdAt`), `category`.`id`";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$datosShare = $dbCommand->queryAll();
		
		echo json_encode($datosShare);
		Yii::app()->end();	
	}
	
	public function actionJSONshareporcategoriames($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');
		
		$data=array();
		
		$sql = "SELECT Date_format(`share`.`createdAt`,'%Y-%M') as mes,`category`.`name` as label, Count(`share`.`id`) as value 
				FROM `share`, `article`,`article_categories__category_articles`, `category` 
				WHERE `share`.`article`= `article`.`id` AND `article`.`id` = `article_categories__category_articles`.`article_categories` AND `article_categories__category_articles`.`category_articles`= `category`.`id` AND YEAR(`share`.`createdAt`)= ".$id." GROUP BY MONTH(`share`.`createdAt`), `category`.`id`";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$datosShare = $dbCommand->queryAll();
		
		echo json_encode($datosShare);
		Yii::app()->end();	
	}
	
	public function actionJSON50mascompartidosporanio($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');
		
		$data=array();
		
		$sql = "SELECT `article`.`title` as article, COUNT(`share`.`id`) as cantidad
				FROM `share`, `article` 
				WHERE `article`.`id`= `share`.`article` AND YEAR(`share`.`createdAt`)=".$id." 
				GROUP BY `article`.`id`
				ORDER BY COUNT(`share`.`id`) DESC
				limit 30";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$datosShare = $dbCommand->queryAll();
		
		echo json_encode($datosShare);
		Yii::app()->end();		
	}
	
	public function actionJSON50menoscompartidosporanio($id)
	{
		$this->layout=FALSE;
		$idu=Yii::app()->user->id;
		header('Content-type: application/json');
		
		$data=array();
		
		$sql = "SELECT `article`.`title` as article, COUNT(`share`.`id`) as cantidad
				FROM `share`, `article` 
				WHERE `article`.`id`= `share`.`article` AND YEAR(`share`.`createdAt`)=".$id."        
				GROUP BY `article`.`id`
				ORDER BY COUNT(`share`.`id`) ASC
				limit 30";    	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$datosShare = $dbCommand->queryAll();
		
		echo json_encode($datosShare);
		Yii::app()->end();		
	}
	
	//Por Usuario especifico
	public function actionJSON20mascompartidosporusuario($id)
	{
		$this->layout=FALSE;
		$idu=Yii::app()->user->id;
		header('Content-type: application/json');
		
		$data=array();
		
		$sql =  "SELECT `article`.`title` as article, COUNT(`share`.`id`) as cantidad
				FROM `share`, `article` 
				WHERE `article`.`id`= `share`.`article` AND YEAR(`share`.`createdAt`)=".$id." and article.creator=".$idu."        
				GROUP BY `article`.`id`
				ORDER BY COUNT(`share`.`id`) DESC
				limit 20";   	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$datosShare = $dbCommand->queryAll();
		
		echo json_encode($datosShare);
		Yii::app()->end();		
	}
	
	public function actionJSON20menoscompartidosporusuario($id)
	{
		$this->layout=FALSE;
		$idu=Yii::app()->user->id;
		header('Content-type: application/json');
		
		$data=array();
		
		$sql =  "SELECT `article`.`title` as article, COUNT(`share`.`id`) as cantidad
				FROM `share`, `article` 
				WHERE `article`.`id`= `share`.`article` AND YEAR(`share`.`createdAt`)=".$id." and article.creator=".$idu."        
				GROUP BY `article`.`id`
				ORDER BY COUNT(`share`.`id`) ASC
				limit 20";   	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$datosShare = $dbCommand->queryAll();
		
		echo json_encode($datosShare);
		Yii::app()->end();		
	}
	
	public function actionJSONConsultarporanio($anio)
	{
		$this->layout =FALSE;	
		header('Content-type: application/json');
	}
	
	public function actionJSONpublicacioneseneltiempo()
	{
		$this->layout=FALSE;
		header('Content-type: application/json');
		
		$data=array();
		
		$sql = "SELECT YEAR(createdAt) as anio, COUNT(article.id) as value 
				FROM article 
				GROUP BY YEAR(createdAt) 
				ORDER BY YEAR(createdAt) ASC";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$datosShare = $dbCommand->queryAll();
		
		echo json_encode($datosShare);
		Yii::app()->end();			
	}
	
	//Total de compartidos por meses de un determinado año
	public function actionJSONtodoscompartidospormes($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');
		
		$idu=Yii::app()->user->id;	
		
		$sql = "SELECT Date_format(share.createdAt,'%Y-%m') as mes, COUNT(share.id) as compartido
				FROM `share` 
				WHERE YEAR(share.createdAt)=".$id."
				GROUP BY MONTH(share.`createdAt`)";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$datosShare = $dbCommand->queryAll();
		
		echo json_encode($datosShare);		
		Yii::app()->end();				
	}
	
	//Total de compartidos por dias de un determinado mes
	public function actionJSONtodoscompartidospordias()
	{
		$this->layout=FALSE;
		header('Content-type: application/json');
		
		$idu=Yii::app()->user->id;	
		
		$sql = "SELECT Date_format(share.createdAt,'%Y-%m-%d') as dia, COUNT(share.id) as compartido
				FROM `share` 
				WHERE share.createdAt LIKE '".$_POST['mes']."%'
				GROUP BY Date_format(share.createdAt,'%Y-%m-%d')";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$datosShare = $dbCommand->queryAll();
		
		echo json_encode($datosShare);		
		Yii::app()->end();				
	}
	
	//Total de compartidos por meses de un rango de fechas
	public function actionJSONtodoscompartidospormesrango()
	{
		$this->layout=FALSE;
		header('Content-type: application/json');			
		
		$sql = "SELECT Date_format(share.createdAt,'%Y-%m') as mes, COUNT(share.id) as compartido
				FROM `share` 
				WHERE share.createdAt>='".$_POST['fecha1']."' and share.createdAt<='".$_POST['fecha2']."'
				GROUP BY MONTH(share.`createdAt`)";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$datosShare = $dbCommand->queryAll();
		
		echo json_encode($datosShare);		
		Yii::app()->end();				
	}
	
	//Comparativa entre compartidos, share y likes de un determinado artículo
	public function actionJSONcomparativacompartidovisitadogustado($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');		
		
		$anio = '2016';
		$sql = "SELECT Date_format(share.createdAt,'%Y-%m') as mes, COUNT(share.id) as compartido
				FROM `share` 
				WHERE YEAR(share.createdAt)=".$anio." AND share.article=".$id."
				GROUP BY MONTH(share.`createdAt`)";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$datosShare = $dbCommand->queryAll();
		
		$sql = "SELECT Date_format(visit.createdAt,'%Y-%m') as mes, COUNT(visit.id) as visitado
				FROM `visit` 
				WHERE YEAR(visit.createdAt)=".$anio." AND visit.article=".$id."
				GROUP BY MONTH(visit.`createdAt`)";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$datosVisit = $dbCommand->queryAll();
		
		$sql = "SELECT Date_format(`like`.createdAt,'%Y-%m') as mes, COUNT(`like`.id) as gustado
				FROM `like` 
				WHERE YEAR(`like`.createdAt)=".$anio." AND `like`.article=".$id."
				GROUP BY MONTH(`like`.`createdAt`)";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$datosLike = $dbCommand->queryAll();
		echo json_encode($datosShare);
		foreach ($datosShare as $key => $value) {
			foreach ($datosVisit as $key1 => $value1) {
				
				if ($value['mes']===$value1['mes']) {
					$datosShare[$key]['visitado']=$value1['visitado'];
				} 
							
			}			
		}
		
		foreach ($datosShare as $key => $value) {
			foreach ($datosLike as $key1 => $value1) {
				
				if ($value['mes']===$value1['mes']) {
					$datosShare[$key]['gustado']=$value1['gustado'];
				} 
							
			}			
		}
		
		echo json_encode($datosShare);
		//echo json_encode($datosVisit);
		//echo json_encode($datosLike);		
		Yii::app()->end();				
	}
	
	//ESTADISTICAS POR USUARIO
	
	public function actionJSONmascompartidos()
	{
		$this->layout=FALSE;
		header('Content-type: application/json');
		
		$id=Yii::app()->user->id;		
		
		$sql = "SELECT article.title, article.url, COUNT(share.user) as cantidad
				FROM share, article 
				WHERE article.id=share.article and article.creator=".$id."
				GROUP BY article.id
				ORDER BY COUNT(share.user) DESC
				limit 5";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataCompartido = $dbCommand->queryAll();
		
		echo json_encode($dataCompartido);		
		Yii::app()->end();
	}
	
	//Usuarios que mas utilizan mis OA	
	public function actionJSONusuariosmascompartenmisoa($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');
		
		//$id=Yii::app()->user->id;		
		
		$sql = "SELECT user.name as nombre, COUNT(share.user) as compartidos
				FROM share, user, article 
				WHERE user.id=share.user and article.id=share.article and article.creator=".$id."
				GROUP BY user.name
				ORDER BY COUNT(share.user) DESC";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$datosusuarios = $dbCommand->queryAll();
		
		echo json_encode($datosusuarios);
		
		Yii::app()->end();				
	}
	
	public function actionJSONcompartenmisoapormes($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');
		
		$idu=Yii::app()->user->id;	
		
		$sql = "SELECT Date_format(share.createdAt,'%Y-%m') as mes, COUNT(share.id) as total, 0 as cantidad 
				FROM share, article 
				WHERE article.id = share.article AND YEAR(share.createdAt)=".$id."  
				GROUP BY YEAR(share.createdAt), MONTH(share.createdAt)";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataTotal = $dbCommand->queryAll();
		
		$sqlmis = "SELECT Date_format(share.createdAt,'%Y-%m') as mes, COUNT(share.id) as cantidad 
				FROM share, article 
				WHERE article.id = share.article AND YEAR(share.createdAt)=".$id." AND article.creator=".$idu." 
				 GROUP BY YEAR(share.createdAt), MONTH(share.createdAt)";  	
		$dbCommand = Yii::app()->db->createCommand($sqlmis);
		$dataShare = $dbCommand->queryAll();
		
		foreach ($dataTotal as $key => $value) {
			foreach ($dataShare as $key1 => $value1) {
				
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
	
	public function actionJSONcompartenmisoapordias()
	{
		$this->layout=FALSE;
		header('Content-type: application/json');
		
		$idu=Yii::app()->user->id;	
		
		$sql = "SELECT Date_format(share.createdAt,'%Y-%m-%d') as dia, COUNT(share.id) as total, 0 as cantidad 
				FROM share, article 
				WHERE article.id = share.article AND share.createdAt LIKE '".$_POST['mes']."%'   
				GROUP BY Date_format(share.createdAt,'%Y-%m-%d')";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataTotal = $dbCommand->queryAll();
		
		$sqlmis = "SELECT Date_format(share.createdAt,'%Y-%m-%d') as dia, COUNT(share.id) as cantidad 
				FROM share, article 
				WHERE article.id = share.article AND share.createdAt LIKE '".$_POST['mes']."%' AND article.creator=".$idu." 
				GROUP BY Date_format(share.createdAt,'%Y-%m-%d')";  	
		$dbCommand = Yii::app()->db->createCommand($sqlmis);
		$dataShare = $dbCommand->queryAll();
		
		foreach ($dataTotal as $key => $value) {
			foreach ($dataShare as $key1 => $value1) {
				
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
	
	public function actionJSONcompartenmisoapormesrango()
	{
		$this->layout=FALSE;
		header('Content-type: application/json');
		
		$idu=Yii::app()->user->id;	
		
		$sql = "SELECT Date_format(share.createdAt,'%Y-%m') as mes, COUNT(share.id) as total, 0 as cantidad 
				FROM share, article 
				WHERE article.id = share.article AND share.createdAt>='".$_POST['fecha1']."' and share.createdAt<='".$_POST['fecha2']."'   
				GROUP BY YEAR(share.createdAt), MONTH(share.createdAt)";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataTotal = $dbCommand->queryAll();
		
		$sqlmis = "SELECT Date_format(share.createdAt,'%Y-%m') as mes, COUNT(share.id) as cantidad 
				FROM share, article 
				WHERE article.id = share.article AND share.createdAt>='".$_POST['fecha1']."' AND share.createdAt<='".$_POST['fecha2']."' AND article.creator=".$idu." 
				 GROUP BY YEAR(share.createdAt), MONTH(share.createdAt)";  	 
		$dbCommand = Yii::app()->db->createCommand($sqlmis);
		$dataShare = $dbCommand->queryAll();
		
		foreach ($dataTotal as $key => $value) {
			foreach ($dataShare as $key1 => $value1) {
				
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
	
	public function actionJSONcompartenmisoapormesarticulo($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');
		
		$idu=Yii::app()->user->id;	
		
		$sql = "SELECT Date_format(`share`.`createdAt`,'%Y-%m') as mes, COUNT(share.id) as compartido 
				FROM share, article 
				WHERE article.id = share.article AND YEAR(share.createdAt)=".$id." AND article.id=".$article." 
				 GROUP BY MONTH(`share`.`createdAt`)";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$datosShare = $dbCommand->queryAll();
		
		echo json_encode($datosShare);		
		Yii::app()->end();				
	}
	
	//Titulo de mis articulos compartidos y el número de compartidos que poseen por año
	public function actionJSONarticulosvecescompartidasenanio($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');
		
		$idu=Yii::app()->user->id;	
		
		$sql = "SELECT article.id, article.title, COUNT(share.id) as compartido
				FROM share, article 
				WHERE article.id = share.article AND YEAR(share.createdAt)=".$id." AND article.creator=".$idu."
				GROUP BY article.id
				ORDER BY COUNT(share.id) DESC";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$datosShare = $dbCommand->queryAll();
		
		echo json_encode($datosShare);		
		Yii::app()->end();				
	}
	
	
	//ARTICULOS RECOMENDADOS
	public function actionJSONrecomendados()
	{
		$this->layout=FALSE;
		header('Content-type: application/json');		
		
		$sql = "SELECT article.id, article.title, Count(share.id) as compartido
				FROM share, article 
				WHERE article.id=share.article
				GROUP BY article.id
				ORDER BY article.id ASC";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$datosShare = $dbCommand->queryAll();
		
		$sql = "SELECT article.id, article.title, Count(visit.id) as visitado 
				FROM visit, article 
				WHERE article.id=visit.article
				GROUP BY article.id
				ORDER BY article.id ASC";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$datosVisit = $dbCommand->queryAll();
		
		$sql = "SELECT article.id, article.title, Count(`like`.id) as gustado 
				FROM `like`, article 
				WHERE article.id=`like`.article
				GROUP BY article.id
				ORDER BY article.id ASC";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$datosLike = $dbCommand->queryAll();
		
		
		//echo json_encode($datosShares);
		
		foreach ($datosShare as $key => $value) {
			foreach ($datosVisit as $key1 => $value1) {
				
				if ($value['id']===$value1['id']) {
					$datosShare[$key]['visitado']=$value1['visitado'];
				} 
							
			}			
		}
		
		foreach ($datosShare as $key => $value) {
			foreach ($datosLike as $key1 => $value1) {
				
				if ($value['id']===$value1['id']) {
					$datosShare[$key]['gustado']=$value1['gustado'];
				} 
							
			}			
		}
		
		foreach ($datosShare as $key => $value) {
			$datosShare[$key]['recomendado']= 0.5*$datosShare[$key]['compartido']+0.3*$datosShare[$key]['visitado'];				
		}
		
		echo json_encode($datosShare);
		Yii::app()->end();			
	}
	
	
}
 ?>	