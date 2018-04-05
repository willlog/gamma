<?php

class CategoryController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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
				'actions'=>array('index','view','indexs','create','update','admin','delete'),
				'roles'=>array('admin'),
			),
			//Permisos para los gráficos estadísticos
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array( 'Estadisticacategoria', 'Todascategoria','JSONoaporcategoriaeneltiempo', 'JSONoaporcategoriamesenelanio','JSONoaporcategoriaanio','JSONoaactivosdesactivosporcategoria','recomendadoscategoria','JSONrecomendadoscategoria','Compartidoscategoria','JSONmascompartidoscategoria','Visitadoscategoria','JSONmasvisitadoscategoria','Gustadoscategoria','JSONmasgustadoscategoria','JSONoaporcategoriamesrango','Estadisticageneral','JSONpublicacionesporcategoria','JSONoaporcategoria','JSONoaporcategoriapordias','JSONpublicacionesporcategoriarango','JSONrecomendadoscategoriarango','JSONmascompartidoscategoriarango','JSONmasvisitadoscategoriarango','JSONmasgustadoscategoriarango'),
				'users'=>array('@'),
			),	
					
			array('allow',  // deny all users
				'users'=>array('*'),
			),
		);
		
		
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->layout=false;
		
		$sql = "SELECT YEAR(article.createdAt) as anio, COUNT(article.id) as cantidad
				FROM article, article_categories__category_articles
				WHERE article.id = article_categories__category_articles.article_categories and article_categories__category_articles.category_articles=".$id."
				GROUP BY YEAR(article.createdAt)";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$datos = $dbCommand->queryAll();
		json_encode($datos);
		
		
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'datos'=>$datos
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$this->layout=false;
		$model=new Category();
		$items = '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <b>Correcto!</b> Categoria guardada correctamente.
                                    </div>';

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Category']))
		{
			$model->attributes=$_POST['Category'];
			$model->createdAt = new CDbExpression('NOW()');
			//if($model->validate())
			//{
				if($model->save())
				{
					$this->layout=false;
					header('Content-type: application/json');
					echo CJavaScript::jsonEncode($items);
					Yii::app()->end(); 
					//$this->redirect(array('view','id'=>$model->id));
				}
			//}			
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$this->layout=false;
		$model=$this->loadModel($id);
		$items = '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <b>Correcto!</b> Categoria guardada correctamente.
                                    </div>';

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Category']))
		{
			$model->attributes=$_POST['Category'];				
			$model->updatedAt = new CDbExpression('NOW()');
			if($model->validate()){
				if($model->save()){
					
					$this->layout=false;
					header('Content-type: application/json');
					
					echo CJavaScript::jsonEncode($items);
					Yii::app()->end(); 

					$this->redirect(array('view','id'=>$model->id));
				}
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();
		
		$items = '<div class="alert alert-danger alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <b>Correcto!</b> Categoría eliminada correctamente.
                                    </div>';

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        $this->layout=false;
		header('Content-type: application/json');
		
		echo CJavaScript::jsonEncode($items);
		Yii::app()->end(); 
		
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider = Category::model()->findAll();		
		//$dataProvider=new CActiveDataProvider('Category');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionCatalogo($name)
        {
		$this->layout=false;
		header("Content-Type: application/json", true);
		header('Access-Control-Allow-Origin: *');  

                $sql = "SELECT * FROM category where upper(name) like upper('%".$name."%')";

                $dbCommand = Yii::app()->db->createCommand($sql);
                $dataEstado =$dbCommand->queryAll();

                echo json_encode($dataEstado);
		
                Yii::app()->end();
                
	}

	public function actionCategorianube()
        {
		$this->layout=false;
		header("Content-Type: application/json", true);
		header('Access-Control-Allow-Origin: *');  

           		$sql = "SELECT category.name FROM category,article_categories__category_articles where category.id=article_categories__category_articles.category_articles";

                $dbCommand = Yii::app()->db->createCommand($sql);
                $dataEstado =$dbCommand->queryAll();

                echo json_encode($dataEstado);

                Yii::app()->end();
                
	}

	public function actionDescription($table)
        {
		$this->layout=false;
		header("Content-Type: application/json", true);
		header('Access-Control-Allow-Origin: *');  

           		$sql = "DESCRIBE ".$table.";";

                $dbCommand = Yii::app()->db->createCommand($sql);
                $dataEstado =$dbCommand->queryAll();

                echo json_encode($dataEstado);

                Yii::app()->end();
                
	}

	public function actionCorreo()
    {
		
		$this->layout=false;
		header("Content-Type: application/json", true);
		header('Access-Control-Allow-Origin: *');

		Yii::import('application.extensions.phpmailer.JPhpMailer'); 

		$mail = new JPhpMailer;
		$mail->IsSMTP();
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = '465';
		$mail->SMTPSecure = 'SSL';
		$mail->SMTPAuth = true;
		$mail->Username = 'mgsgerman20@gmail.com';
		$mail->Password = '.Amwprg23will';
		$mail->SetFrom('mgsgerman20@gmail.com', 'Falcon');
		$mail->Subject = 'Welcome to Hazel Eyes';
		$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
		$mail->MsgHTML('JUST A TEST!');
		$mail->AddAddress('german20@ymail.com', 'Falcon CK');
		$mail->Send();

		Yii::app()->end();

	}

	public function actionAutorcategoria($id)
        {
		$this->layout=false;
		header("Content-Type: application/json", true);
		header('Access-Control-Allow-Origin: *');  

                $sql = "SELECT user.*,article_categories__category_articles.category_articles FROM article,article_categories__category_articles,user WHERE article.id=article_categories__category_articles.article_categories AND article_categories__category_articles.category_articles=".$id." and user.id=article.creator group by uid";

                $dbCommand = Yii::app()->db->createCommand($sql);
                $dataEstado =$dbCommand->queryAll();

                echo json_encode($dataEstado);
		
                Yii::app()->end();
                
	}


	public function actionArticulocategoriautor($idu,$idc=null)
        {
		$this->layout=false;
		header("Content-Type: application/json", true);
		header('Access-Control-Allow-Origin: *');  

                $sql = "SELECT article.*,user.name FROM article,article_categories__category_articles,user WHERE article.id=article_categories__category_articles.article_categories AND article_categories__category_articles.category_articles=".$idc." aND user.id=article.creator AND user.id=".$idu."";

                $dbCommand = Yii::app()->db->createCommand($sql);
                $dataEstado =$dbCommand->queryAll();

                echo json_encode($dataEstado);
		
                Yii::app()->end();
                
	}

	
	public function actionIndexs()
	{
		$this->layout=false;

		$dataProvider = Category::model()->findAll();
		$this->render('indexs',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Category('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Category']))
			$model->attributes=$_GET['Category'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Category the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Category::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Category $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='category-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	//PARA ESTADISTICAS	
	//Pagina de index todas las categorias con algunos datos estadísticos 
	 public function actionTodascategoria()
	 {
	 	$id=Yii::app()->user->id;
		
		$sql = "SELECT category.id, category.name, category.description, category.createdAt, COUNT(article.id) as cantidad 
				FROM category, article_categories__category_articles, article
				WHERE category.id = article_categories__category_articles.category_articles and article_categories__category_articles.article_categories=article.id 
				GROUP BY category.id
				ORDER BY COUNT(article.id) DESC";
					
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();		
		
		$this->render('todascategoria',array(
			'dataProvider'=>$dataProvider,
		));
		 
	 }
	 
	//Para inicializar la pagina de estadísticas de la categoría 	
	public function actionEstadisticacategoria($id)
	{
		$model=Category::model()->findByAttributes(
		    array('id'=>$id)
		);	
		
		$sql = "SELECT 'Artículos' as articulos, COUNT(article.id) as cantidad 
				FROM category, article_categories__category_articles, article
				WHERE category.id = article_categories__category_articles.category_articles and article_categories__category_articles.article_categories=article.id and category.id=".$id."
				GROUP BY category.id
				ORDER BY (article.id) DESC";
					
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();
		
		$sql = "SELECT 'Habilitados' as estado, COUNT(article.id) as cantidad
				FROM article, article_categories__category_articles
				WHERE article.id =  article_categories__category_articles.article_categories and article.state<>'disable' and article_categories__category_articles.category_articles=".$id."
				UNION ALL
				SELECT 'Deshabilitados' as estado, COUNT(article.id) as cantidad
				FROM article, article_categories__category_articles
				WHERE article.id =  article_categories__category_articles.article_categories and article.state='disable' and article_categories__category_articles.category_articles=".$id."";
					
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataEstado =$dbCommand->queryAll();		
				  
		$this->render('estadisticacategoria', array('model'=> $model, 'dataProvider'=>$dataProvider, 'dataEstado'=>$dataEstado));	
				
	}
	
	public function actionEstadisticageneral()
	{	
				  
		$this->render('estadisticageneral');	
				
	}
	
	//Para inicializar la pagina de recomendados de una categoría 	
	public function actionRecomendadoscategoria($id)
	{
		$model=Category::model()->findByAttributes(
		    array('id'=>$id)
		);	
		
		$sql = "SELECT 'Artículos' as articulos, COUNT(article.id) as cantidad 
				FROM category, article_categories__category_articles, article
				WHERE category.id = article_categories__category_articles.category_articles and article_categories__category_articles.article_categories=article.id and category.id=".$id."
				GROUP BY category.id
				ORDER BY (article.id) DESC";
					
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();
		
		$sql = "SELECT 'Habilitados' as estado, COUNT(article.id) as cantidad
				FROM article, article_categories__category_articles
				WHERE article.id =  article_categories__category_articles.article_categories and article.state<>'disable' and article_categories__category_articles.category_articles=".$id."
				UNION ALL
				SELECT 'Deshabilitados' as estado, COUNT(article.id) as cantidad
				FROM article, article_categories__category_articles
				WHERE article.id =  article_categories__category_articles.article_categories and article.state='disable' and article_categories__category_articles.category_articles=".$id."";
					
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataEstado =$dbCommand->queryAll();		
				  
		$this->render('recomendadoscategoria', array('model'=> $model, 'dataProvider'=>$dataProvider, 'dataEstado'=>$dataEstado));	
				
	}
	
	//Para inicializar la pagina de compartidos de una categoría 	
	public function actionCompartidoscategoria($id)
	{
		$model=Category::model()->findByAttributes(
		    array('id'=>$id)
		);	
		
		$sql = "SELECT 'Artículos' as articulos, COUNT(article.id) as cantidad 
				FROM category, article_categories__category_articles, article
				WHERE category.id = article_categories__category_articles.category_articles and article_categories__category_articles.article_categories=article.id and category.id=".$id."
				GROUP BY category.id
				ORDER BY (article.id) DESC";
					
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();
		
		$sql = "SELECT 'Habilitados' as estado, COUNT(article.id) as cantidad
				FROM article, article_categories__category_articles
				WHERE article.id =  article_categories__category_articles.article_categories and article.state<>'disable' and article_categories__category_articles.category_articles=".$id."
				UNION ALL
				SELECT 'Deshabilitados' as estado, COUNT(article.id) as cantidad
				FROM article, article_categories__category_articles
				WHERE article.id =  article_categories__category_articles.article_categories and article.state='disable' and article_categories__category_articles.category_articles=".$id."";
					
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataEstado =$dbCommand->queryAll();		
				  
		$this->render('compartidoscategoria', array('model'=> $model, 'dataProvider'=>$dataProvider, 'dataEstado'=>$dataEstado));	
				
	}
	
	//Para inicializar la pagina de visitados de una categoría 	
	public function actionVisitadoscategoria($id)
	{
		$model=Category::model()->findByAttributes(
		    array('id'=>$id)
		);	
		
		$sql = "SELECT 'Artículos' as articulos, COUNT(article.id) as cantidad 
				FROM category, article_categories__category_articles, article
				WHERE category.id = article_categories__category_articles.category_articles and article_categories__category_articles.article_categories=article.id and category.id=".$id."
				GROUP BY category.id
				ORDER BY (article.id) DESC";
					
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();
		
		$sql = "SELECT 'Habilitados' as estado, COUNT(article.id) as cantidad
				FROM article, article_categories__category_articles
				WHERE article.id =  article_categories__category_articles.article_categories and article.state<>'disable' and article_categories__category_articles.category_articles=".$id."
				UNION ALL
				SELECT 'Deshabilitados' as estado, COUNT(article.id) as cantidad
				FROM article, article_categories__category_articles
				WHERE article.id =  article_categories__category_articles.article_categories and article.state='disable' and article_categories__category_articles.category_articles=".$id."";
					
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataEstado =$dbCommand->queryAll();		
				  
		$this->render('visitadoscategoria', array('model'=> $model, 'dataProvider'=>$dataProvider, 'dataEstado'=>$dataEstado));	
				
	}
	
	//Para inicializar la pagina de visitados de una categoría 	
	public function actionGustadoscategoria($id)
	{
		$model=Category::model()->findByAttributes(
		    array('id'=>$id)
		);	
		
		$sql = "SELECT 'Artículos' as articulos, COUNT(article.id) as cantidad 
				FROM category, article_categories__category_articles, article
				WHERE category.id = article_categories__category_articles.category_articles and article_categories__category_articles.article_categories=article.id and category.id=".$id."
				GROUP BY category.id
				ORDER BY (article.id) DESC";
					
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();
		
		$sql = "SELECT 'Habilitados' as estado, COUNT(article.id) as cantidad
				FROM article, article_categories__category_articles
				WHERE article.id =  article_categories__category_articles.article_categories and article.state<>'disable' and article_categories__category_articles.category_articles=".$id."
				UNION ALL
				SELECT 'Deshabilitados' as estado, COUNT(article.id) as cantidad
				FROM article, article_categories__category_articles
				WHERE article.id =  article_categories__category_articles.article_categories and article.state='disable' and article_categories__category_articles.category_articles=".$id."";
					
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataEstado =$dbCommand->queryAll();		
				  
		$this->render('gustadoscategoria', array('model'=> $model, 'dataProvider'=>$dataProvider, 'dataEstado'=>$dataEstado));	
				
	}
	
	//Para sacar los activados y desactivados de un OA (Todos los tiempos)
	public function actionJSONoaactivosdesactivosporcategoria($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');
		
		$sql = "SELECT 'Habilitados' as estado, COUNT(article.id) as cantidad
				FROM article, article_categories__category_articles
				WHERE article.id =  article_categories__category_articles.article_categories and article.state<>'disable' and article_categories__category_articles.category_articles=".$id."
				UNION ALL
				SELECT 'Deshabilitados' as estado, COUNT(article.id) as cantidad
				FROM article, article_categories__category_articles
				WHERE article.id =  article_categories__category_articles.article_categories and article.state='disable' and article_categories__category_articles.category_articles=".$id."";
					
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataEstado =$dbCommand->queryAll();		
		
		echo json_encode($dataEstado);
		
		Yii::app()->end();		
	}	
	
	//Para el grafico de numero de articulos totales de una categoria
	public function actionJSONoaporcategoria($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');
		
		$sql="SELECT 'Todos | Categoría' as anio, COUNT(article.id) as total, 0 as cantidad 
				FROM article";		
				
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataTotal =$dbCommand->queryAll();	
				
		$sql="SELECT 'Todos | Categoría' as anio, COUNT(article.id) as cantidad 
				FROM category, article_categories__category_articles, article 
				WHERE category.id = article_categories__category_articles.category_articles and article_categories__category_articles.article_categories = article.id and category.id=".$id."";		
				
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataCategoria =$dbCommand->queryAll();		
		
		foreach ($dataTotal as $key => $value) {
			foreach ($dataCategoria as $key1 => $value1) {							
					$dataTotal[$key]['cantidad']=$value1['cantidad'];															
			}			
		}
		
		foreach ($dataTotal as $key => $value) {			
			$dataTotal[$key]['porcentaje']=round($value['cantidad']/$value['total']*100,2);
		}
				
		echo json_encode($dataTotal);		
		Yii::app()->end();		
	}
	
	//Para el grafico de numero de articulos en los diferentes años
	public function actionJSONoaporcategoriaanio($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');
		
		$sql="SELECT YEAR(article.createdAt) as anio, COUNT(article.id) as total, 0 as cantidad 
				FROM article 
				GROUP BY YEAR(article.createdAt)";		
				
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataTotal =$dbCommand->queryAll();	
				
		$sql="SELECT YEAR(article.createdAt) as anio, COUNT(article.id) as cantidad 
				FROM category, article_categories__category_articles, article 
				WHERE category.id = article_categories__category_articles.category_articles and article_categories__category_articles.article_categories = article.id and category.id=".$id." 
				GROUP BY YEAR(article.createdAt)";		
				
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataCategoria =$dbCommand->queryAll();		
		
		foreach ($dataTotal as $key => $value) {
			foreach ($dataCategoria as $key1 => $value1) {
				
				if ($value['anio']===$value1['anio']) {
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
	
	//Para el grafico de numero de articulos en los meses de un año determinado
	public function actionJSONoaporcategoriamesenelanio($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');		
		
		
		$sql="Select Date_format(article.createdAt,'%Y-%m') as mes, COUNT(article.id) as total, 0 as cantidad 
				FROM article 
				WHERE YEAR(article.createdAt)=".$_POST['anio']." 
				GROUP BY YEAR(article.createdAt), MONTH(article.createdAt)";		
				
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataTotal =$dbCommand->queryAll();	
		
				
		$sql="SELECT Date_format(article.createdAt,'%Y-%m') as mes, COUNT(article.id) as cantidad 
				FROM category, article_categories__category_articles, article
				WHERE category.id = article_categories__category_articles.category_articles and article_categories__category_articles.article_categories = article.id and YEAR(article.createdAt)=".$_POST['anio']." and category.id=".$id."
				GROUP BY YEAR(article.createdAt), MONTH(article.createdAt)";	
								
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataCategoria =$dbCommand->queryAll();		
		
			
		
		foreach ($dataTotal as $key => $value) {
			foreach ($dataCategoria as $key1 => $value1) {
				
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

	//Para el grafico de numero de articulos en los meses de un año determinado
	public function actionJSONoaporcategoriamesrango($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');		
		
		
		$sql="Select Date_format(article.createdAt,'%Y-%m') as mes, COUNT(article.id) as total, 0 as cantidad 
				FROM article 
				WHERE article.createdAt>='".$_POST['fecha1']."' and article.createdAt<='".$_POST['fecha2']."'
				GROUP BY YEAR(article.createdAt), MONTH(article.createdAt)";		
				
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataTotal =$dbCommand->queryAll();	
		
				
		$sql="SELECT Date_format(article.createdAt,'%Y-%m') as mes, COUNT(article.id) as cantidad 
				FROM category, article_categories__category_articles, article
				WHERE category.id = article_categories__category_articles.category_articles and article_categories__category_articles.article_categories = article.id and article.createdAt>='".$_POST['fecha1']."' and article.createdAt<='".$_POST['fecha2']."' and category.id=".$id."				
				GROUP BY YEAR(article.createdAt), MONTH(article.createdAt)";	
								
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataCategoria =$dbCommand->queryAll();		
		
			
		
		foreach ($dataTotal as $key => $value) {
			foreach ($dataCategoria as $key1 => $value1) {
				
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
	
	//Para el grafico de numero de articulos en los dias de un mes determinado
	public function actionJSONoaporcategoriapordias($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');		
		
		
		$sql="Select Date_format(article.createdAt,'%Y-%m-%d') as dia, COUNT(article.id) as total, 0 as cantidad 
				FROM article 
				WHERE article.createdAt LIKE'".$_POST['mes']."%'
				GROUP BY Date_format(article.createdAt,'%Y-%m-%d')";		
				
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataTotal =$dbCommand->queryAll();	
		
				
		$sql="SELECT Date_format(article.createdAt,'%Y-%m-%d') as dia, COUNT(article.id) as cantidad 
				FROM category, article_categories__category_articles, article
				WHERE category.id = article_categories__category_articles.category_articles and article_categories__category_articles.article_categories = article.id and article.createdAt LIKE '".$_POST['mes']."%' and category.id=".$id."				
				GROUP BY Date_format(article.createdAt,'%Y-%m-%d')";	
								
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataCategoria =$dbCommand->queryAll();		
		
			
		
		foreach ($dataTotal as $key => $value) {
			foreach ($dataCategoria as $key1 => $value1) {
				
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
	
	//Para el grafico de numero de articulos en el tiempo (NO UTILIZADO AUN)
	public function actionJSONoaporcategoriaeneltiempo($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');
				
		$sql="SELECT Date_format(article.createdAt,'%Y-%m') as mes, COUNT(article.id) as cantidad 
				FROM category, article_categories__category_articles, article
				WHERE category.id = article_categories__category_articles.category_articles and article_categories__category_articles.article_categories = article.id and category.id=".$id."
				GROUP BY YEAR(article.createdAt), MONTH(article.createdAt)";		
				
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataCategoria =$dbCommand->queryAll();		
		
		echo json_encode($dataCategoria);		
		Yii::app()->end();		
	}
	
	//Para obtener los articulos recomendados de una categoria 
	public function actionJSONrecomendadoscategoria($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');	
			
		$sql = "SELECT article.id, article.title, user.name as autor, article.url, article.createdAt, 0 as share, 0 as visit, 0 as likes 
				FROM article, category, article_categories__category_articles, user 
				WHERE category.id=article_categories__category_articles.category_articles and article_categories__category_articles.article_categories=article.id and user.id = article.creator and category.id=".$id."";
					
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();
		
		$sqlshare="SELECT article.id, COUNT(share.id) as share
				FROM article, category, article_categories__category_articles, share 
				WHERE category.id=article_categories__category_articles.category_articles and article_categories__category_articles.article_categories=article.id and article.id = share.article and category.id=".$id."
				GROUP BY article.id";
				
		$dbCommand = Yii::app()->db->createCommand($sqlshare);
		$dataShare =$dbCommand->queryAll();
				
				
		$sqlVisit="SELECT article.id, COUNT(visit.id) as visit
				FROM article, category, article_categories__category_articles, visit 
				WHERE category.id=article_categories__category_articles.category_articles and article_categories__category_articles.article_categories=article.id and article.id = visit.article and category.id=".$id."				
				GROUP BY article.id";
				
		$dbCommand = Yii::app()->db->createCommand($sqlVisit);
		$dataVisit =$dbCommand->queryAll();
		
		$sqlLike="SELECT article.id, COUNT(`like`.id) as likes
				FROM article, category, article_categories__category_articles, `like` 
				WHERE category.id=article_categories__category_articles.category_articles and article_categories__category_articles.article_categories=article.id and article.id = `like`.article and category.id=".$id."
				GROUP BY article.id";
						
		$dbCommand = Yii::app()->db->createCommand($sqlLike);
		$dataLike =$dbCommand->queryAll();
				
		foreach ($dataProvider as $key => $value) {
			foreach ($dataShare as $key1 => $value1) {
				
				if ($value['id']===$value1['id']) {
					$dataProvider[$key]['share']=$value1['share'];
				} 
							
			}			
		}
		
		foreach ($dataProvider as $key => $value) {
			foreach ($dataVisit as $key1 => $value1) {
				
				if ($value['id']===$value1['id']) {
					$dataProvider[$key]['visit']=$value1['visit'];
				} 
							
			}			
		}
		
		foreach ($dataProvider as $key => $value) {
			foreach ($dataLike as $key1 => $value1) {
				
				if ($value['id']===$value1['id']) {
					$dataProvider[$key]['likes']=$value1['likes'];
				} 
							
			}			
		}
		
		foreach ($dataProvider as $key => $value) {
			$dataProvider[$key]['recomendado']= 0.5*$dataProvider[$key]['share']+0.3*$dataProvider[$key]['visit']+0.2*$dataProvider[$key]['likes'];				
		}		
		
		$ordenar=array();
		
		foreach ($dataProvider as $key => $value) {
			$ordenar[$key]= $value['recomendado'];				
		}
		
		array_multisort($ordenar, SORT_DESC, $dataProvider);
		
		echo json_encode($dataProvider);		
		Yii::app()->end();								
	}


	//Para obtener los articulos recomendados de una categoria en un rango de fechas
	public function actionJSONrecomendadoscategoriarango($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');	
			
		$sql = "SELECT article.id, article.title, user.name as autor, article.url, article.createdAt, 0 as share, 0 as visit, 0 as likes 
				FROM article, category, article_categories__category_articles, user 
				WHERE category.id=article_categories__category_articles.category_articles and article_categories__category_articles.article_categories=article.id and user.id = article.creator and article.createdAt<='".$_POST['fecha2']."' and category.id=".$id."";
					
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();
		
		$sqlshare="SELECT article.id, COUNT(share.id) as share
				FROM article, category, article_categories__category_articles, share 
				WHERE category.id=article_categories__category_articles.category_articles and article_categories__category_articles.article_categories=article.id and article.id = share.article and share.createdAt>='".$_POST['fecha1']."' and share.createdAt<='".$_POST['fecha2']."' and category.id=".$id."
				GROUP BY article.id";
				
		$dbCommand = Yii::app()->db->createCommand($sqlshare);
		$dataShare =$dbCommand->queryAll();
				
				
		$sqlVisit="SELECT article.id, COUNT(visit.id) as visit
				FROM article, category, article_categories__category_articles, visit 
				WHERE category.id=article_categories__category_articles.category_articles and article_categories__category_articles.article_categories=article.id and article.id = visit.article and visit.createdAt>='".$_POST['fecha1']."' and visit.createdAt<='".$_POST['fecha2']."' and category.id=".$id."				
				GROUP BY article.id";
				
		$dbCommand = Yii::app()->db->createCommand($sqlVisit);
		$dataVisit =$dbCommand->queryAll();
		
		$sqlLike="SELECT article.id, COUNT(`like`.id) as likes
				FROM article, category, article_categories__category_articles, `like` 
				WHERE category.id=article_categories__category_articles.category_articles and article_categories__category_articles.article_categories=article.id and article.id = `like`.article and `like`.createdAt>='".$_POST['fecha1']."' and `like`.createdAt<='".$_POST['fecha2']."' and category.id=".$id."
				GROUP BY article.id";
						
		$dbCommand = Yii::app()->db->createCommand($sqlLike);
		$dataLike =$dbCommand->queryAll();
				
		foreach ($dataProvider as $key => $value) {
			foreach ($dataShare as $key1 => $value1) {
				
				if ($value['id']===$value1['id']) {
					$dataProvider[$key]['share']=$value1['share'];
				} 
							
			}			
		}
		
		foreach ($dataProvider as $key => $value) {
			foreach ($dataVisit as $key1 => $value1) {
				
				if ($value['id']===$value1['id']) {
					$dataProvider[$key]['visit']=$value1['visit'];
				} 
							
			}			
		}
		
		foreach ($dataProvider as $key => $value) {
			foreach ($dataLike as $key1 => $value1) {
				
				if ($value['id']===$value1['id']) {
					$dataProvider[$key]['likes']=$value1['likes'];
				} 
							
			}			
		}
		
		foreach ($dataProvider as $key => $value) {
			$dataProvider[$key]['recomendado']= 0.5*$dataProvider[$key]['share']+0.3*$dataProvider[$key]['visit']+0.2*$dataProvider[$key]['likes'];				
		}		
		
		$ordenar=array();
		
		foreach ($dataProvider as $key => $value) {
			$ordenar[$key]= $value['recomendado'];				
		}
		
		array_multisort($ordenar, SORT_DESC, $dataProvider);
		
		echo json_encode($dataProvider);		
		Yii::app()->end();								
	}

	//Para obtener los articulos mas compartidos de una determinada categoría
	public function actionJSONmascompartidoscategoria($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');	
		
		$sql = "SELECT article.id, article.title, user.name as autor, article.url, article.createdAt, COUNT(share.id) as share
				FROM article, category, article_categories__category_articles, share, user 
				WHERE category.id=article_categories__category_articles.category_articles and article_categories__category_articles.article_categories=article.id and article.id = share.article and user.id = article.creator and category.id=".$id."				
				GROUP BY article.id				
				ORDER BY COUNT(share.id) DESC"; 
				 	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataCompartido = $dbCommand->queryAll();
		
		echo json_encode($dataCompartido);		
		Yii::app()->end();						
	}
	
	//Para obtener los articulos mas compartidos de una determinada categoría en un rango de fechas
	public function actionJSONmascompartidoscategoriarango($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');	
		
		$sql = "SELECT article.id, article.title, user.name as autor, article.url, article.createdAt, COUNT(share.id) as share
				FROM article, category, article_categories__category_articles, share, user 
				WHERE category.id=article_categories__category_articles.category_articles and article_categories__category_articles.article_categories=article.id and article.id = share.article and user.id = article.creator and share.createdAt>='".$_POST['fecha1']."' and share.createdAt<='".$_POST['fecha2']."' and category.id=".$id."				
				GROUP BY article.id				
				ORDER BY COUNT(share.id) DESC"; 
				 	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataCompartido = $dbCommand->queryAll();
		
		echo json_encode($dataCompartido);		
		Yii::app()->end();						
	}
	
	//Para obtener los articulos mas compartidos de una determinada categoría
	public function actionJSONmasvisitadoscategoria($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');	
		
		$sql = "SELECT article.id, article.title, user.name as autor, article.url, article.createdAt, COUNT(visit.id) as visit
				FROM article, category, article_categories__category_articles, visit, user 
				WHERE category.id=article_categories__category_articles.category_articles and article_categories__category_articles.article_categories=article.id and article.id = visit.article and user.id = article.creator and category.id=".$id."				
				GROUP BY article.id				
				ORDER BY COUNT(visit.id) DESC"; 
				 	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataVisitado = $dbCommand->queryAll();
		
		echo json_encode($dataVisitado);		
		Yii::app()->end();						
	}
	
	//Para obtener los articulos mas visitados de una determinada categoría en un rango de fechas
	public function actionJSONmasvisitadoscategoriarango($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');	
		
		$sql = "SELECT article.id, article.title, user.name as autor, article.url, article.createdAt, COUNT(visit.id) as visit
				FROM article, category, article_categories__category_articles, visit, user 
				WHERE category.id=article_categories__category_articles.category_articles and article_categories__category_articles.article_categories=article.id and article.id = visit.article and user.id = article.creator and visit.createdAt>='".$_POST['fecha1']."' and visit.createdAt<='".$_POST['fecha2']."' and category.id=".$id."				
				GROUP BY article.id				
				ORDER BY COUNT(visit.id) DESC"; 
				 	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataVisitado = $dbCommand->queryAll();
		
		echo json_encode($dataVisitado);		
		Yii::app()->end();						
	}
	
	//Para obtener los articulos mas compartidos de una determinada categoría
	public function actionJSONmasgustadoscategoria($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');	
		
		$sql = "SELECT article.id, article.title, user.name as autor, article.url, article.createdAt, COUNT(`like`.id) as likes
				FROM article, category, article_categories__category_articles, `like`, user 
				WHERE category.id=article_categories__category_articles.category_articles and article_categories__category_articles.article_categories=article.id and article.id = `like`.article and user.id = article.creator and category.id=".$id."				
				GROUP BY article.id				
				ORDER BY COUNT(`like`.id) DESC"; 
				 	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataGustado = $dbCommand->queryAll();
		
		echo json_encode($dataGustado);		
		Yii::app()->end();						
	}
	
	//Para obtener los articulos mas compartidos de una determinada categoría en un rango de fechas
	public function actionJSONmasgustadoscategoriarango($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');	
		
		$sql = "SELECT article.id, article.title, user.name as autor, article.url, article.createdAt, COUNT(`like`.id) as likes
				FROM article, category, article_categories__category_articles, `like`, user 
				WHERE category.id=article_categories__category_articles.category_articles and article_categories__category_articles.article_categories=article.id and article.id = `like`.article and user.id = article.creator and `like`.createdAt>='".$_POST['fecha1']."' and `like`.createdAt<='".$_POST['fecha2']."' and category.id=".$id."				
				GROUP BY article.id				
				ORDER BY COUNT(`like`.id) DESC"; 
				 	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataGustado = $dbCommand->queryAll();
		
		echo json_encode($dataGustado);		
		Yii::app()->end();						
	}
	
	//Para obtener los articulos creados de todas las categorias
	public function actionJSONpublicacionesporcategoria()
	{
		$this->layout=FALSE;
		header('Content-type: application/json');	
		
		$sql = "SELECT category.id, category.name, COUNT(article.id) as cantidad
				FROM category, article, article_categories__category_articles
				WHERE category.id = article_categories__category_articles.category_articles and article_categories__category_articles.article_categories = article.id
				GROUP BY category.id
				ORDER BY COUNT(article.id) DESC"; 
				 	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataCategory = $dbCommand->queryAll();
		
		echo json_encode($dataCategory);		
		Yii::app()->end();						
	}
	
	//Para obtener los articulos creados todas las categorías en un rango de fechas
	public function actionJSONpublicacionesporcategoriarango()
	{
		$this->layout=FALSE;
		header('Content-type: application/json');	
		
		$sql = "SELECT category.id, category.name, COUNT(article.id) as cantidad
				FROM category, article, article_categories__category_articles
				WHERE category.id = article_categories__category_articles.category_articles and article_categories__category_articles.article_categories = article.id and article.createdAt>='".$_POST['fecha1']."' and article.createdAt<='".$_POST['fecha2']."'
				GROUP BY category.id
				ORDER BY COUNT(article.id) DESC"; 
				 	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataCategory = $dbCommand->queryAll();
		
		echo json_encode($dataCategory);		
		Yii::app()->end();						
	}
	
	
	
	
}
