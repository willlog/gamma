<?php

class ArticleController extends Controller
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
				'actions'=>array('JSONMasrecomendadostotal'),
				'users'=>array('*'),
			),
			
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('indexconsultageneralcategoria','indexbuscarcategoria','indexgeneralbuscarfecha','indexgeneralbuscar','indexbuscar','index','view','indexs', 'create','update', 'delete', 'upload','Indexconsultageneral','Indexrecomendados','Indexmascompartidos','Indexmasvisitados','Indexmasgustados','Indextodosoabuscarfecha','Indexmisoabuscarfecha','Indextodosoabuscarcategoria','Indexbuscarcategoriatodos','Indexbuscarusuariotodos','Indextodosoabuscarusuario','Indexbuscarcategoriamis','Indexmisoabuscarcategoria'),
				'users'=>array('@'),
			),			
			//Permisos para los gráficos estadísticos
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('Indexmisoa','Indextodosoa','Estadisticaoa','Totaloavsmisoa','JSONoasharevisitlike','JSONoaactivosdesactivos', 'JSONoacreadospormi',  'JSONevolucion', 'JSONaototalporaniovsmisoa','JSONsharevisitlikeoaporanio', 'JSONevolucionanio', 'JSONaototalpormesvsmisoa','JSONevolucionrango','Estadisticageneral','JSONaototalporanio','JSONaototalpormes','JSONaototal','JSONMascompartidostotal','JSONMasvisitadostotal','JSONMasgustadostotal','JSONMasrecomendadosrango','JSONMascompartidosrango','JSONMasvisitadosrango','JSONMasgustadosrango','JSONevoluciondias','JSONaototalpordias'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','indexgeneral', 'indexgenerals'),
				'roles'=>array('admin'),
			),
			array('deny',  // deny all users
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
		
		$sql = "SELECT 'compartido' as accion, COUNT(share.id) as cantidad FROM article, share Where article.id =share.article and article.id=".$id." 
					UNION ALL 
					SELECT 'visitado' as accion, COUNT(visit.id) as cantidad FROM article, visit Where article.id =visit.article and article.id=".$id." 
					UNION ALL 
					SELECT 'gustado' as accion, COUNT(like.id) as cantidad FROM article,`like` Where article.id =`like`.article and article.id=".$id."";
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

		$model=new Article();
		$items = '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <b>Correcto!</b> Artículo guardado correctamente.
                                    </div>';

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$msg='';
        
        //Para manejar la imagen
        $path_picture= realpath(Yii::app()->getBasePath()."/../images")."/";

		$idu=Yii::app()->user->id;
		$uid = rand(0, 99999);
		$rnd = rand(0,99);
		if(isset($_POST['Article']))
		{
			//print_r($_POST['Article']);        	
			$model->attributes=$_POST['Article'];			
						
			$model->creator=$idu;	
			$model->createdAt = new CDbExpression('NOW()');
			$model->image=$path_picture;
			
			$num=(int) Article::model()->countByAttributes(array('url'=>trim($model->url)));
			
			if($num>0)
			{
				$msg='Ya existe un recurso con la misma dirección url';				
			}
			
			else
			{			
				if($model->validate()){
					//Asignarle la ruta de la imagen
					$uploadedFile=CUploadedFile::getInstance($model,'picture');			
					//$uploadedFile=$model->picture;	
					//print_r('upload'.$uploadedFile);		
					//$fileName = "{$rnd}-{$uploadedFile}";				
						
					if(!empty($uploadedFile))  // check if uploaded file is set or not
		            {
		            	$filename = $rnd.$uid.'_'.$uploadedFile->getName();
		                //$uploadedFile->saveAs(Yii::app()->basePath.'/../banner/'.$fileName);  // image will uplode to rootDirectory/banner/	                
		                //$uploadedFile->saveAs($path_picture.$fileName);
		                $model->image= 'content/image/'.$filename;
						
						if($model->save()){
							$uploadedFile->saveAs('/var/www/html/sigma/content/image/'.$filename);
							$val=$model->valores;
				        	$porciones = explode(",", $val);
				        	
				        	foreach ($porciones as $key => $value) {
				        		$model1=new ArticleCategoriesCategoryArticles;
							    $model1->category_articles = $value;
							    $model1->article_categories = $model->id;
							    $model1->save();
		
				        	}					
		
							$this->layout=false;
							header('Content-type: application/json');
							
							echo CJavaScript::jsonEncode($items);
							Yii::app()->end(); 
		
							//$this->redirect(array('create','id'=>$model->id));
							//$this->redirect('index');
						}
										
		            }
									
					
				}
			}
		}
		

		$data = Category::model()->findAll();

		$this->render('create',array(
			'model'=>$model,
			'data'=>$data, 'msg'=>$msg
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
		//Mensaje de actualización correcta
		$model=$this->loadModel($id);
		$items = '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <b>Correcto!</b> Artículo actualizado correctamente.
                                    </div>';
		$msg='';
		//Generar el path para el guardado de la imagen
		//$path_picture=realpath(Yii::app()->getBasePath()."/../images")."/";
		//Generar un numero randomico para añadir al nombre de la imagen 
		$rnd = rand(0,99999);	

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		//Si los datos del articulo son enviados por POST
		if(isset($_POST['Article']))
		{
			//Se toma los datos de la vista y se asigna al modelo		
			$model->attributes=$_POST['Article'];	
			//Tomar la fecha actual de creación del artículo	
			$model->updatedAt = new CDbExpression('NOW()');			
			//$p='C:\xampp\htdocs\yii\redsocial'.$model->image;
			//print_r($p);
			//unlink($p);			
			
			$num=(int) Article::model()->countByAttributes(array('url'=>trim($model->url)));
			$numupdt=(int) Article::model()->countByAttributes(array('url'=>trim($model->url),'id'=>$id));
			
			if($num>0)
			{
			
				if($numupdt>0)
				{
					
					//Instanciar la imagen de la vista
					$uploadedFile = CUploadedFile::getInstance($model, 'picture');
								
					if(!empty($uploadedFile))  // Si la imagen no esta vacia
		        	{
		        			        		
		        		//unlink('/home/sigma/sigma/'.$model->image);
		        		//Añadir el numero randomico a la imagen y guardarla				
						$filename = $rnd.'_'.$uploadedFile->getName();							
						//Asignar el path de la imagen al atributo image del modelo				
						$model->image = 'content/image/'.$filename;						
						//print_r('Llego hasta aqui, Archivo: '.$filename);
						//Yii::app()->end();							
						//Guardar la imagen			
						$uploadedFile->saveAs('/var/www/html/sigma/content/image/'.$filename);
						
					}	
					
					//if($model->validate()){
					if($model->save())
					{
						
						$this->layout=false;
						header('Content-type: application/json');
	
						ArticleCategoriesCategoryArticles::model()->deleteAllByAttributes(array(
						    'article_categories'=>$model->id,
						));
					}
					
					$val=$model->valores;
		        	$porciones = explode(",", $val);
		        	
		        	foreach ($porciones as $key => $value) {
		        		$model1=new ArticleCategoriesCategoryArticles;
					    $model1->category_articles = $value;
					    $model1->article_categories = $model->id;
					    $model1->save();
		        	}
											
					echo CJavaScript::jsonEncode($items);
					Yii::app()->end(); 
								
				}
				else
				{
					$msg='Ya existe un recurso con la misma dirección url';							
					
				}		
				
					
			}
			else
			{
				//Instanciar la imagen de la vista
				$uploadedFile = CUploadedFile::getInstance($model, 'picture');
							
				if(!empty($uploadedFile))  // Si la imagen no esta vacia
	        	{
	        		//unlink(Yii::app()->basePath.'/..'.$model->image);
	        		//Añadir el numero randomico a la imagen y guardarla				
					$filename = $rnd.'_'.$uploadedFile->getName();	
					//Asignar el path de la imagen al atributo image del modelo				
					$model->image = 'content/image/'.$filename;					
					//Guardar la imagen			
					$uploadedFile->saveAs('/var/www/html/sigma/content/image/'.$filename);
					
				}	
				
				//if($model->validate()){
				if($model->save())
				{
					
					$this->layout=false;
					header('Content-type: application/json');

					ArticleCategoriesCategoryArticles::model()->deleteAllByAttributes(array(
					    'article_categories'=>$model->id,
					));
				}
				
				$val=$model->valores;
	        	$porciones = explode(",", $val);
	        	
	        	foreach ($porciones as $key => $value) {
	        		$model1=new ArticleCategoriesCategoryArticles;
				    $model1->category_articles = $value;
				    $model1->article_categories = $model->id;
				    $model1->save();
	        	}
										
				echo CJavaScript::jsonEncode($items);
				Yii::app()->end(); 
			}

		}
	
			$cadena="";
			$datos=ArticleCategoriesCategoryArticles::model()->findAllByAttributes(array('article_categories'=>$id),array('order'=>'id DESC'));
	
			foreach ($datos as $key => $value) {
				$cadena=$cadena.$value->category_articles.",";
			}
	
		$model->valores=$cadena;

		$data = Category::model()->findAll();

		$this->render('update',array(
			'model'=>$model,'data'=>$data, 'msg'=>$msg
		));

		
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$model=$this->loadModel($id);		
		Article::model()->deleteByPK($id);
		//$this->loadModel($id)->delete();
		if($model->image!=NULL)
		try
		{
			//unlink('/home/sigma/sigma/'.$model->image);
		}	
		catch (Exception $e)
		{				
		}
		$items = '<div class="alert alert-danger alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <b>Correcto!</b> Artículo eliminado correctamente.
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
		$id=Yii::app()->user->id;		
		$dataProvider=Article::model()->findAll(
		array("condition"=>"creator = $id","order"=>"id"));		
		
		$model=User::model()->findByPk(array('id'=>$id));
				
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'model'=>$model
	));
	}
	
	public function actionIndexgeneral()
	{
		$sql = "SELECT article.id, article.title, article.createdAt, user.name
				FROM article, user
				WHERE user.id=article.creator";
					
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();
		
		//$dataProvider = Article::model()->findAll();		
		$this->render('indexgeneral',array(
			'dataProvider'=>$dataProvider,
		));		

	}
	
	public function actionIndexrecomendados()
	{		
		$this->render('indexrecomendados');

	}
	
	public function actionIndexmascompartidos()
	{		
		$this->render('indexmascompartidos');

	}
	
	public function actionIndexmasvisitados()
	{		
		$this->render('indexmasvisitados');

	}
	
	public function actionIndexmasgustados()
	{		
		$this->render('indexmasgustados');

	}
	
	public function actionIndexgeneralbuscar($id)
	{
		$this->layout=false;
		
		//$dataProvider = Article::model()->findAllByAttributes(array('creator'=>$id));
		
		$sql="SELECT article.id, article.title, article.createdAt, user.name
			FROM article, user
			WHERE user.id=article.creator and user.id =".$id."";		
		
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();
				
		$this->render('indexgeneralbuscar',array(
			'dataProvider'=>$dataProvider,
		));

	}

	public function actionIndextodosoabuscarusuario($id)
	{
		$this->layout=false;		
		
		$sql = "SELECT article.id, article.title, article.url, user.id as uid, user.name, article.createdAt, 0 as share, 0 as visit, 0 as likes 
				FROM article, user
				WHERE user.id=article.creator and user.id=".$id."";
					
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();
		
		$sqlshare="SELECT article.id, COUNT(share.id) as share
				FROM article, share 
				WHERE article.id=share.article 
				GROUP BY article.id";
				
		$dbCommand = Yii::app()->db->createCommand($sqlshare);
		$dataShare =$dbCommand->queryAll();
				
				
		$sqlVisit="SELECT article.id, COUNT(visit.id) as visit
				FROM article, visit 
				WHERE article.id=visit.article
				GROUP BY article.id";
				
		$dbCommand = Yii::app()->db->createCommand($sqlVisit);
		$dataVisit =$dbCommand->queryAll();
		
		$sqlLike="SELECT article.id, COUNT(`like`.id) as likes
				FROM article, `like` 
				WHERE article.id=`like`.article 
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
		
		foreach ($dataProvider as $key => $value) {
			$dataProvider[$key]['recomendado']= 0.5*$dataProvider[$key]['share']+0.3*$dataProvider[$key]['visit']+0.2*$dataProvider[$key]['likes'];				
		}
		
		$ordenar=array();
		
		foreach ($dataProvider as $key => $value) {
			$ordenar[$key]= $value['recomendado'];				
		}
		
		array_multisort($ordenar, SORT_DESC, $dataProvider);		
		
		$model=User::model()->findByPk(array('id'=>$id));
				
		$this->render('indextodosoabuscarusuario',array(
			'dataProvider'=>$dataProvider,
			'model'=>$model
		));

	}
	
	//Para buscar las estadisticas de los articulos por un rango de fechas (pagina principal indextodosoa)
	public function actionIndextodosoabuscarfecha()
	{	
		$this->layout=false;
		
		$id=Yii::app()->user->id;
		
		$sql = "SELECT article.id, article.title, article.url, user.id as uid, user.name, article.createdAt, 0 as share, 0 as visit, 0 as likes 
				FROM article, user
				WHERE user.id=article.creator and article.createdAt>='".$_GET['fecha1']."' and article.createdAt<='".$_GET['fecha2']."'";
					
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();
		
		$sqlshare="SELECT article.id, COUNT(share.id) as share
				FROM article, share 
				WHERE article.id=share.article 
				GROUP BY article.id";
				
		$dbCommand = Yii::app()->db->createCommand($sqlshare);
		$dataShare =$dbCommand->queryAll();
				
				
		$sqlVisit="SELECT article.id, COUNT(visit.id) as visit
				FROM article, visit 
				WHERE article.id=visit.article
				GROUP BY article.id";
				
		$dbCommand = Yii::app()->db->createCommand($sqlVisit);
		$dataVisit =$dbCommand->queryAll();
		
		$sqlLike="SELECT article.id, COUNT(`like`.id) as likes
				FROM article, `like` 
				WHERE article.id=`like`.article 
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
		
		foreach ($dataProvider as $key => $value) {
			$dataProvider[$key]['recomendado']= 0.5*$dataProvider[$key]['share']+0.3*$dataProvider[$key]['visit']+0.2*$dataProvider[$key]['likes'];				
		}
		
		$ordenar=array();
		
		foreach ($dataProvider as $key => $value) {
			$ordenar[$key]= $value['recomendado'];				
		}
		
		array_multisort($ordenar, SORT_DESC, $dataProvider);		
				
		$this->render('indextodosoabuscarfecha',array(
			'dataProvider'=>$dataProvider,
		));

	}

	//Para buscar las estadisticas de los articulos por una categoria (pagina principal indextodosoa)
	public function actionIndextodosoabuscarcategoria($id)
	{	
		$this->layout=false;			
		
		$dataProvider1 = ArticleCategoriesCategoryArticles::model()->findAllByAttributes(array('category_articles'=>$id),array('select'=>'distinct article_categories'));
		
		$ids="";
		foreach ($dataProvider1 as $key => $value) {
			if($key==0)
			{
				$ids=$ids."'".$value->article_categories."'";
			}
			else 
			{				
				$ids=$ids.','."'".$value->article_categories."'";
			}
			
		}			
		
		$sql = "SELECT article.id, article.title, article.url, user.id as uid, user.name, article.createdAt, 0 as share, 0 as visit, 0 as likes 
				FROM article, user
				WHERE user.id=article.creator and article.id IN (".$ids.")";
					
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();
		
		$sqlshare="SELECT article.id, COUNT(share.id) as share
				FROM article, share 
				WHERE article.id=share.article 
				GROUP BY article.id";
				
		$dbCommand = Yii::app()->db->createCommand($sqlshare);
		$dataShare =$dbCommand->queryAll();
				
				
		$sqlVisit="SELECT article.id, COUNT(visit.id) as visit
				FROM article, visit 
				WHERE article.id=visit.article
				GROUP BY article.id";
				
		$dbCommand = Yii::app()->db->createCommand($sqlVisit);
		$dataVisit =$dbCommand->queryAll();
		
		$sqlLike="SELECT article.id, COUNT(`like`.id) as likes
				FROM article, `like` 
				WHERE article.id=`like`.article 
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
		
		foreach ($dataProvider as $key => $value) {
			$dataProvider[$key]['recomendado']= 0.5*$dataProvider[$key]['share']+0.3*$dataProvider[$key]['visit']+0.2*$dataProvider[$key]['likes'];				
		}
		
		$ordenar=array();
		
		foreach ($dataProvider as $key => $value) {
			$ordenar[$key]= $value['recomendado'];				
		}
		
		array_multisort($ordenar, SORT_DESC, $dataProvider);
		
		$model=Category::model()->findByPk(array('id'=>$id));					
				
		$this->render('indextodosoabuscarcategoria',array(
			'dataProvider'=>$dataProvider,
			'model'=>$model
		));

	}

	//Para buscar las estadisticas de mis articulos por una categoria (pagina principal indexmisoa)
	public function actionIndexmisoabuscarcategoria($id)
	{	
		$this->layout=false;
		
		$uid=Yii::app()->user->id;
		
		$sql="SELECT DISTINCT article_categories__category_articles.article_categories
			FROM article_categories__category_articles, article, user
			WHERE article_categories__category_articles.article_categories=article.id and article.creator=user.id and user.id =".$uid." and article_categories__category_articles.category_articles=".$id."";
				
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider1 =$dbCommand->queryAll();			
		
		//$dataProvider1 = ArticleCategoriesCategoryArticles::model()->findAllByAttributes(array('category_articles'=>$id),array('select'=>'distinct article_categories'));
		
		$ids="";
		foreach ($dataProvider1 as $key => $value) {
			if($key==0)
			{
				$ids=$ids."'".$value['article_categories']."'";
			}
			else 
			{				
				$ids=$ids.','."'".$value['article_categories']."'";
			}
			
		}			
		
		$sql = "SELECT article.id, article.title, article.url, user.id as uid, user.name, article.createdAt, 0 as share, 0 as visit, 0 as likes 
				FROM article, user
				WHERE user.id=article.creator and article.id IN (".$ids.")";
					
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();
		
		$sqlshare="SELECT article.id, COUNT(share.id) as share
				FROM article, share 
				WHERE article.id=share.article 
				GROUP BY article.id";
				
		$dbCommand = Yii::app()->db->createCommand($sqlshare);
		$dataShare =$dbCommand->queryAll();
				
				
		$sqlVisit="SELECT article.id, COUNT(visit.id) as visit
				FROM article, visit 
				WHERE article.id=visit.article
				GROUP BY article.id";
				
		$dbCommand = Yii::app()->db->createCommand($sqlVisit);
		$dataVisit =$dbCommand->queryAll();
		
		$sqlLike="SELECT article.id, COUNT(`like`.id) as likes
				FROM article, `like` 
				WHERE article.id=`like`.article 
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
		
		foreach ($dataProvider as $key => $value) {
			$dataProvider[$key]['recomendado']= 0.5*$dataProvider[$key]['share']+0.3*$dataProvider[$key]['visit']+0.2*$dataProvider[$key]['likes'];				
		}
		
		$ordenar=array();
		
		foreach ($dataProvider as $key => $value) {
			$ordenar[$key]= $value['recomendado'];				
		}
		
		array_multisort($ordenar, SORT_DESC, $dataProvider);		
		
		$model=Category::model()->findByPk(array('id'=>$id));
		
		$this->render('indexmisoabuscarcategoria',array(
			'dataProvider'=>$dataProvider,
			'model'=>$model
		));

	}
	
	//Para buscar los articulos por un rango de fechas (pagina principal indexgeneral)
	public function actionIndexgeneralbuscarfecha()
	{	
		$this->layout=false;		
			
		$sql="SELECT article.id, article.title, article.createdAt, user.name
			FROM article, user
			WHERE user.id=article.creator and article.createdAt>='".$_GET['fecha1']."' and article.createdAt<='".$_GET['fecha2']."'";			
		
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();
		
		/*$dataProvider = Article::model()->findAll(
										  array(
												'condition'=>'createdAt like :buscar',
												'params'=>array(':buscar'=>"%$id%")
										  )
									);*/
		
		
		$this->render('indexgeneralbuscar',array(
			'dataProvider'=>$dataProvider,
		));

	}

	public function actionIndexconsultageneral($id)
	{
		$this->layout=false;
		$dataProvider = Article::model()->findAllByAttributes(array('condition'=>'createdAt'==$id));
		print_r($dataProvider);			
		$this->render('indexgeneral',array(
			'dataProvider'=>$dataProvider,
		));
		
	}
	
	public function actionIndexconsultageneralcategoria($id)
	{
		$arrayName = array();
		
	
		$this->layout=false;
		$dataProvider1 = ArticleCategoriesCategoryArticles::model()->findAllByAttributes(array('category_articles'=>$id),array('select'=>'distinct article_categories'));
		
		$ids="";
		foreach ($dataProvider1 as $key => $value) {
			if($key==0)
			{
				$ids=$ids."'".$value->article_categories."'";
			}
			else 
			{				
				$ids=$ids.','."'".$value->article_categories."'";
			}
			
		}
		
		//print_r($ids);
		
		/*foreach ($dataProvider1 as $key => $value) {
			$arrayName[$key]=$value->article_categories;
		}*/		
		
		
		//$dataProvider = Article::model()->findAllByAttributes(array('id'=>$arrayName));	
			
		$sql="SELECT article.id, article.title, article.createdAt, user.name
			FROM article, user
			WHERE user.id=article.creator and article.id IN (".$ids.")";		
		
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();		
			
		$this->render('indexgeneralbuscar',array(
			'dataProvider'=>$dataProvider			
		));		
		
	}
	
	
	public function actionIndexbuscar($name)
	{
		$this->layout=false;
		/*$dataProvider = User::model()->findAll(
										  array(
												'condition'=>'name like :buscar',
												'limit' => 3,
												'params'=>array(':buscar'=>"%$name%")
										  )
										);*/
										
		$sql="SELECT user.id, user.name
			FROM user
			WHERE user.name like '%".$name."%'
			limit 3";		
		
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();
		
		
		$this->render('indexbuscar',array(
			'dataProvider'=>$dataProvider,
		));		
	}
	
	
	public function actionIndexbuscarusuariotodos($name)
	{
		$this->layout=false;
		/*$dataProvider = User::model()->findAll(
										  array(
												'condition'=>'name like :buscar',
												'limit' => 3,
												'params'=>array(':buscar'=>"%$name%")
										  )
										);*/
										
		$sql="SELECT user.id, user.name
			FROM user
			WHERE user.name like '%".$name."%'
			limit 3";		
		
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();
		
		
		$this->render('indexbuscarusuariotodos',array(
			'dataProvider'=>$dataProvider,
		));		
	}
	
	public function actionIndexbuscarcategoria($name)
	{
		$this->layout=false;
		$dataProvider = Category::model()->findAll(
										  array(
												'condition'=>'name like :buscar',
												'limit' => 3,
												'params'=>array(':buscar'=>"%$name%")
										  )
										);
		
		
		$this->render('indexbuscarcategoria',array(
			'dataProvider'=>$dataProvider,
		));	
		
	}
	
	
	public function actionIndexbuscarcategoriatodos($name)
	{
		$this->layout=false;
		$dataProvider = Category::model()->findAll(
										  array(
												'condition'=>'name like :buscar',
												'limit' => 3,
												'params'=>array(':buscar'=>"%$name%")
										  )
										);
		
		
		$this->render('indexbuscarcategoriatodos',array(
			'dataProvider'=>$dataProvider,
		));	
		
	}
	
	public function actionIndexbuscarcategoriamis($name)
	{
		$this->layout=false;
		$dataProvider = Category::model()->findAll(
										  array(
												'condition'=>'name like :buscar',
												'limit' => 3,
												'params'=>array(':buscar'=>"%$name%")
										  )
										);
		
		
		$this->render('indexbuscarcategoriamis',array(
			'dataProvider'=>$dataProvider,
		));	
		
	}

	
	

	public function actionIndexs()
	{
		$this->layout=false;
		
		$id=Yii::app()->user->id;		
		$dataProvider=Article::model()->findAll(
		array("condition"=>"creator = $id","order"=>"id"));
		$this->render('indexs',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	public function actionIndexgenerals()
	{
		$this->layout=false;
		
		$sql = "SELECT article.id, article.title, article.createdAt, user.name
				FROM article, user
				WHERE user.id=article.creator";
					
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();
		
		//$dataProvider = Article::model()->findAll();		
		$this->render('indexgenerals',array(
			'dataProvider'=>$dataProvider,
		));	
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Article('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Article']))
			$model->attributes=$_GET['Article'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Article the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Article::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	public function actionUpload()
    {		
		Yii::import("ext.EAjaxUpload.qqFileUploader");	
        //$folder='images/';// folder for uploaded files
        $folder='images/';// folder for uploaded files
        $allowedExtensions = array("jpg","png","doc","pdf");//array("jpg","jpeg","gif","exe","mov" and etc...
        $sizeLimit = 5* 1024 * 1024;// maximum file size in bytes

        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        $result = $uploader->handleUpload($folder);		
        $result=htmlspecialchars(json_encode($result), ENT_NOQUOTES);		
        echo $result;// it's array
	}

	/**
	 * Performs the AJAX validation.
	 * @param Article $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='Article-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	/**
	 Reportes y gráficos de los artículos (Objetos de Apendizaje OA)
	 */
	 
	 //MIS ARTICULOS
	 //Pagina de index de mis OA por relevancia
	 public function actionIndexmisoa()
	 {
	 	$id=Yii::app()->user->id;
		
		$sql = "SELECT article.id, article.title, article.url, article.createdAt, 0 as share, 0 as visit, 0 as likes FROM article WHERE article.creator=".$id."";
					
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();
		
		$sqlshare="SELECT article.id, COUNT(share.id) as share
				FROM article, share 
				WHERE article.id=share.article and article.creator=".$id."
				GROUP BY article.id";
				
		$dbCommand = Yii::app()->db->createCommand($sqlshare);
		$dataShare =$dbCommand->queryAll();
				
				
		$sqlVisit="SELECT article.id, COUNT(visit.id) as visit
				FROM article, visit 
				WHERE article.id=visit.article and article.creator=".$id."
				GROUP BY article.id";
				
		$dbCommand = Yii::app()->db->createCommand($sqlVisit);
		$dataVisit =$dbCommand->queryAll();
		
		$sqlLike="SELECT article.id, COUNT(`like`.id) as likes
				FROM article, `like` 
				WHERE article.id=`like`.article and article.creator=".$id."
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
		
		$model=User::model()->findByAttributes(
		    array('id'=>$id)
		);					
		
		$this->render('indexmisoa',array(
			'dataProvider'=>$dataProvider,
			'model'=>$model
		));
		 
	 }	

	//Pagina de busqueda por rango de fechas de mis oa (pagina principal indexmisoa)
	 public function actionIndexmisoabuscarfecha()
	 {
	 	$this->layout=false;
			
	 	$id=Yii::app()->user->id;
		
		$sql = "SELECT article.id, article.title, article.url, article.createdAt, 0 as share, 0 as visit, 0 as likes FROM article WHERE article.creator=".$id." and article.createdAt>='".$_GET['fecha1']."' and article.createdAt<='".$_GET['fecha2']."'";
					
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();
		
		$sqlshare="SELECT article.id, COUNT(share.id) as share
				FROM article, share 
				WHERE article.id=share.article and article.creator=".$id."
				GROUP BY article.id";
				
		$dbCommand = Yii::app()->db->createCommand($sqlshare);
		$dataShare =$dbCommand->queryAll();
				
				
		$sqlVisit="SELECT article.id, COUNT(visit.id) as visit
				FROM article, visit 
				WHERE article.id=visit.article and article.creator=".$id."
				GROUP BY article.id";
				
		$dbCommand = Yii::app()->db->createCommand($sqlVisit);
		$dataVisit =$dbCommand->queryAll();
		
		$sqlLike="SELECT article.id, COUNT(`like`.id) as likes
				FROM article, `like` 
				WHERE article.id=`like`.article and article.creator=".$id."
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
		
		$this->render('indexmisoabuscarfecha',array(
			'dataProvider'=>$dataProvider,
		));
		 
	 }	

	public function actionEstadisticaoa($id)
	{
		$model=Article::model()->findByAttributes(
		    array('id'=>$id)
		);	
		
		$sql = "SELECT category.id, category.name
				FROM category, article_categories__category_articles
				WHERE category.id=article_categories__category_articles.category_articles and article_categories__category_articles.article_categories=".$id."";
					
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();	
		
		$sql = "SELECT user.id, user.name
				FROM user
				WHERE user.id=".$model->creator."";
					
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataAutor =$dbCommand->queryAll();
			
				  
		$this->render('estadisticaoa', array('model'=> $model, 'dataProvider'=>$dataProvider, 'dataAutor'=>$dataAutor));	
				
	}
	
	public function actionTotaloavsmisoa()
	{				  
		$this->render('totaloavsmisoa');				
	}
	
	public function actionEstadisticageneral()
	{				  
		$this->render('estadisticageneral');				
	}

	 //Pagina de index de mis OA por relevancia
	 public function actionIndextodosoa()
	 {
	 	$id=Yii::app()->user->id;
		
		$sql = "SELECT article.id, article.title, article.url, user.id as uid, user.name, article.createdAt, 0 as share, 0 as visit, 0 as likes 
				FROM article, user
				WHERE user.id=article.creator";
					
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();
		
		$sqlshare="SELECT article.id, COUNT(share.id) as share
				FROM article, share 
				WHERE article.id=share.article 
				GROUP BY article.id";
				
		$dbCommand = Yii::app()->db->createCommand($sqlshare);
		$dataShare =$dbCommand->queryAll();
				
				
		$sqlVisit="SELECT article.id, COUNT(visit.id) as visit
				FROM article, visit 
				WHERE article.id=visit.article
				GROUP BY article.id";
				
		$dbCommand = Yii::app()->db->createCommand($sqlVisit);
		$dataVisit =$dbCommand->queryAll();
		
		$sqlLike="SELECT article.id, COUNT(`like`.id) as likes
				FROM article, `like` 
				WHERE article.id=`like`.article 
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
		
		foreach ($dataProvider as $key => $value) {
			$dataProvider[$key]['recomendado']= 0.5*$dataProvider[$key]['share']+0.3*$dataProvider[$key]['visit']+0.2*$dataProvider[$key]['likes'];				
		}
		
		$ordenar=array();
		
		foreach ($dataProvider as $key => $value) {
			$ordenar[$key]= $value['recomendado'];				
		}
		
		array_multisort($ordenar, SORT_DESC, $dataProvider);		
		
		$this->render('indextodosoa',array(
			'dataProvider'=>$dataProvider,
		));
		 
	 }
	 
	 //Cantidad de mis articulos publicados vs total publicados
	public function actionJSONoacreadospormi()
	{
		$this->layout=FALSE;
		header('Content-type: application/json');
		
		$id=Yii::app()->user->id;
		
		$sql = "SELECT YEAR(article.createdAt) as anio, Count(article.id) as cantidad 
				FROM article 
				GROUP BY YEAR(article.createdAt)";
					
		$dbCommand = Yii::app()->db->createCommand($sql);
		$datostodos =$dbCommand->queryAll();
		
		$sqls = "SELECT YEAR(article.createdAt) as anio, Count(article.id) as cantidad 
				FROM article 
				WHERE article.creator=".$id."
				GROUP BY YEAR(article.createdAt)";  	
		$dbCommand = Yii::app()->db->createCommand($sqls);
		$datosmis = $dbCommand->queryAll();		
		
		foreach ($datostodos as $key => $value) {
			foreach ($datosmis as $key1 => $value1) {
				
				if ($value['anio']===$value1['anio']) {
					$datostodos[$key]['total']=$value1['cantidad'];
				} 
							
			}			
		}
		
		foreach ($datostodos as $key => $value) {
			foreach ($datosmis as $key1 => $value1) {
				
				if ($value['anio']===$value1['anio']) {
					$datostodos[$key]['total']=$value1['cantidad'];
				} 
							
			}			
		}
		
		echo json_encode($datostodos);
		Yii::app()->end();			
	}	 
	 
	//Para sacar los share, visit y likes de un OA (Todos los tiempos)
	public function actionJSONoasharevisitlike($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');
		
		$sql = "SELECT 'compartidos' as label, COUNT(share.id) as value FROM article, share Where article.id =share.article and article.id=".$id." 
					UNION ALL 
					SELECT 'visitas' as label, COUNT(visit.id) as value FROM article, visit Where article.id =visit.article and article.id=".$id." 
					UNION ALL 
					SELECT 'gustados' as label, COUNT(like.id) as value FROM article,`like` Where article.id =`like`.article and article.id=".$id."";
					
		$dbCommand = Yii::app()->db->createCommand($sql);
		$datos =$dbCommand->queryAll();
		
		echo json_encode($datos);
		
		Yii::app()->end();		
	}
	
	//Para mostrar la evolución en el tiempo de un articulo (share-visit-like por mes) (AUN NO UTILIZADO)	
	public function actionJSONevolucion($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');	
		
		$sql="SELECT Date_format(visit.createdAt,'%Y-%m') as mes, 0 as share, 0 as visit, 0 as likes
				FROM visit
				Where visit.article=".$id."
				GROUP BY YEAR(visit.createdAt), MONTH(visit.createdAt)
				UNION
				SELECT Date_format(share.createdAt,'%Y-%m') as mes, 0 as share, 0 as visit, 0 as likes
				FROM share
				Where share.article=".$id."
				GROUP BY YEAR(share.createdAt), MONTH(share.createdAt)
				UNION
				SELECT Date_format(`like`.`createdAt`,'%Y-%m') as mes, 0 as share, 0 as visit, 0 as likes
				FROM `like`
				Where `like`.article=".$id."
				GROUP BY YEAR(`like`.`createdAt`), MONTH(`like`.`createdAt`)";
				
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();	
		
		$sqlShare = "SELECT Date_format(share.createdAt,'%Y-%m') as mes, COUNT(share.id) as share 
				FROM share, article 
				WHERE article.id = share.article AND article.id=".$id."
				GROUP BY YEAR(share.createdAt), MONTH(share.createdAt)";
					
		$dbCommand = Yii::app()->db->createCommand($sqlShare);
		$dataShare =$dbCommand->queryAll();	
		
		$sqlVisit = "SELECT Date_format(visit.createdAt,'%Y-%m') as mes, COUNT(visit.id) as visit 
				FROM visit, article 
				WHERE article.id = visit.article AND article.id=".$id."
				GROUP BY YEAR(visit.createdAt), MONTH(visit.createdAt)";
					
		$dbCommand = Yii::app()->db->createCommand($sqlVisit);
		$dataVisit =$dbCommand->queryAll();	
		
		$sqlLike = "SELECT Date_format(`like`.createdAt,'%Y-%m') as mes, COUNT(`like`.id) as likes 
				FROM `like`, article 
				WHERE article.id = `like`.article AND article.id=".$id."
				GROUP BY YEAR(`like`.createdAt), MONTH(`like`.createdAt)";
					
		$dbCommand = Yii::app()->db->createCommand($sqlLike);
		$dataLike =$dbCommand->queryAll();	
		
		
		foreach ($dataProvider as $key => $value) {
			foreach ($dataShare as $key1 => $value1) {
				
				if ($value['mes']===$value1['mes']) {
					$dataProvider[$key]['share']=$value1['share'];
				} 
							
			}			
		}
		
		foreach ($dataProvider as $key => $value) {
			foreach ($dataVisit as $key1 => $value1) {
				
				if ($value['mes']===$value1['mes']) {
					$dataProvider[$key]['visit']=$value1['visit'];
				} 
							
			}			
		}
		
		foreach ($dataProvider as $key => $value) {
			foreach ($dataLike as $key1 => $value1) {
				
				if ($value['mes']===$value1['mes']) {
					$dataProvider[$key]['likes']=$value1['likes'];
				} 
							
			}			
		}		
		
		echo json_encode($dataProvider);
		
		Yii::app()->end();	
	}
	
	//Para mostrar la evolución en el tiempo de un articulo en un año determinado (share-visit-like por mes) 	
	public function actionJSONevolucionanio($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');	
		
		$sql="SELECT Date_format(visit.createdAt,'%Y-%m') as mes, 0 as share, 0 as visit, 0 as likes
				FROM visit
				Where YEAR(visit.createdAt)=".$_POST['anio']." and visit.article=".$id."
				GROUP BY YEAR(visit.createdAt), MONTH(visit.createdAt)
				UNION
				SELECT Date_format(share.createdAt,'%Y-%m') as mes, 0 as share, 0 as visit, 0 as likes
				FROM share
				Where YEAR(share.createdAt)=".$_POST['anio']." and share.article=".$id."
				GROUP BY YEAR(share.createdAt), MONTH(share.createdAt)
				UNION
				SELECT Date_format(`like`.`createdAt`,'%Y-%m') as mes, 0 as share, 0 as visit, 0 as likes
				FROM `like`
				Where YEAR(`like`.createdAt)=".$_POST['anio']." and `like`.article=".$id."
				GROUP BY YEAR(`like`.`createdAt`), MONTH(`like`.`createdAt`)";
				
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();	
		
		$sqlShare = "SELECT Date_format(share.createdAt,'%Y-%m') as mes, COUNT(share.id) as share 
				FROM share, article 
				WHERE article.id = share.article AND article.id=".$id."
				GROUP BY YEAR(share.createdAt), MONTH(share.createdAt)";
					
		$dbCommand = Yii::app()->db->createCommand($sqlShare);
		$dataShare =$dbCommand->queryAll();	
		
		$sqlVisit = "SELECT Date_format(visit.createdAt,'%Y-%m') as mes, COUNT(visit.id) as visit 
				FROM visit, article 
				WHERE article.id = visit.article AND article.id=".$id."
				GROUP BY YEAR(visit.createdAt), MONTH(visit.createdAt)";
					
		$dbCommand = Yii::app()->db->createCommand($sqlVisit);
		$dataVisit =$dbCommand->queryAll();	
		
		$sqlLike = "SELECT Date_format(`like`.createdAt,'%Y-%m') as mes, COUNT(`like`.id) as likes 
				FROM `like`, article 
				WHERE article.id = `like`.article AND article.id=".$id."
				GROUP BY YEAR(`like`.createdAt), MONTH(`like`.createdAt)";
					
		$dbCommand = Yii::app()->db->createCommand($sqlLike);
		$dataLike =$dbCommand->queryAll();	
		
		
		foreach ($dataProvider as $key => $value) {
			foreach ($dataShare as $key1 => $value1) {
				
				if ($value['mes']===$value1['mes']) {
					$dataProvider[$key]['share']=$value1['share'];
				} 
							
			}			
		}
		
		foreach ($dataProvider as $key => $value) {
			foreach ($dataVisit as $key1 => $value1) {
				
				if ($value['mes']===$value1['mes']) {
					$dataProvider[$key]['visit']=$value1['visit'];
				} 
							
			}			
		}
		
		foreach ($dataProvider as $key => $value) {
			foreach ($dataLike as $key1 => $value1) {
				
				if ($value['mes']===$value1['mes']) {
					$dataProvider[$key]['likes']=$value1['likes'];
				} 
							
			}			
		}		
		
		echo json_encode($dataProvider);
		
		Yii::app()->end();	
	}
	
	//Para mostrar la evolución en el tiempo de un articulo en un mes determinado (share-visit-like por mes) 	
	public function actionJSONevoluciondias($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');	
		
		$sql="SELECT Date_format(visit.createdAt,'%Y-%m-%d') as dia, 0 as share, 0 as visit, 0 as likes
				FROM visit
				Where visit.createdAt LIKE '".$_POST['mes']."%' and visit.article=".$id."
				GROUP BY Date_format(visit.createdAt,'%Y-%m-%d')
				UNION
				SELECT Date_format(share.createdAt,'%Y-%m-%d') as dia, 0 as share, 0 as visit, 0 as likes
				FROM share
				Where share.createdAt LIKE '".$_POST['mes']."%' and share.article=".$id."
				GROUP BY Date_format(share.createdAt,'%Y-%m-%d')
				UNION
				SELECT Date_format(`like`.`createdAt`,'%Y-%m-%d') as dia, 0 as share, 0 as visit, 0 as likes
				FROM `like`
				Where `like`.createdAt LIKE '".$_POST['mes']."%' and `like`.article=".$id."
				GROUP BY Date_format(`like`.createdAt,'%Y-%m-%d')";
				
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();	
		
		$sqlShare = "SELECT Date_format(share.createdAt,'%Y-%m-%d') as dia, COUNT(share.id) as share 
				FROM share, article 
				WHERE article.id = share.article AND share.createdAt LIKE '".$_POST['mes']."%' AND article.id=".$id."
				GROUP BY Date_format(share.createdAt,'%Y-%m-%d')";
					
		$dbCommand = Yii::app()->db->createCommand($sqlShare);
		$dataShare =$dbCommand->queryAll();	
				
		$sqlVisit = "SELECT Date_format(visit.createdAt,'%Y-%m-%d') as dia, COUNT(visit.id) as visit 
				FROM visit, article 
				WHERE article.id = visit.article AND visit.createdAt LIKE '".$_POST['mes']."%' AND article.id=".$id."
				GROUP BY Date_format(visit.createdAt,'%Y-%m-%d')";
					
		$dbCommand = Yii::app()->db->createCommand($sqlVisit);
		$dataVisit =$dbCommand->queryAll();	
		
		$sqlLike = "SELECT Date_format(`like`.createdAt,'%Y-%m-%d') as dia, COUNT(`like`.id) as likes 
				FROM `like`, article 
				WHERE article.id = `like`.article AND `like`.createdAt LIKE '".$_POST['mes']."%' AND article.id=".$id."
				GROUP BY Date_format(`like`.createdAt,'%Y-%m-%d')";
					
		$dbCommand = Yii::app()->db->createCommand($sqlLike);
		$dataLike =$dbCommand->queryAll();	
		
		
		foreach ($dataProvider as $key => $value) {
			foreach ($dataShare as $key1 => $value1) {
				
				if ($value['dia']===$value1['dia']) {
					$dataProvider[$key]['share']=$value1['share'];
				} 
							
			}			
		}
		
		foreach ($dataProvider as $key => $value) {
			foreach ($dataVisit as $key1 => $value1) {
				
				if ($value['dia']===$value1['dia']) {
					$dataProvider[$key]['visit']=$value1['visit'];
				} 
							
			}			
		}
		
		foreach ($dataProvider as $key => $value) {
			foreach ($dataLike as $key1 => $value1) {
				
				if ($value['dia']===$value1['dia']) {
					$dataProvider[$key]['likes']=$value1['likes'];
				} 
							
			}			
		}		
		
		echo json_encode($dataProvider);
		
		Yii::app()->end();	
	}
	
	//Para mostrar la evolución en el tiempo de un articulo en un rango de fechas (share-visit-like por mes) 	
	public function actionJSONevolucionrango($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');	
		
		$sql="SELECT Date_format(visit.createdAt,'%Y-%m') as mes, 0 as share, 0 as visit, 0 as likes
				FROM visit
				Where visit.createdAt>='".$_POST['fecha1']."' and visit.createdAt<='".$_POST['fecha2']."' and visit.article=".$id."
				GROUP BY YEAR(visit.createdAt), MONTH(visit.createdAt)
				UNION
				SELECT Date_format(share.createdAt,'%Y-%m') as mes, 0 as share, 0 as visit, 0 as likes
				FROM share
				Where share.createdAt>='".$_POST['fecha1']."' and share.createdAt<='".$_POST['fecha2']."' and share.article=".$id."
				GROUP BY YEAR(share.createdAt), MONTH(share.createdAt)
				UNION
				SELECT Date_format(`like`.`createdAt`,'%Y-%m') as mes, 0 as share, 0 as visit, 0 as likes
				FROM `like`
				Where `like`.createdAt>='".$_POST['fecha1']."' and `like`.createdAt<='".$_POST['fecha2']."' and `like`.article=".$id."
				GROUP BY YEAR(`like`.`createdAt`), MONTH(`like`.`createdAt`)";
				
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();	
		
		$sqlShare = "SELECT Date_format(share.createdAt,'%Y-%m') as mes, COUNT(share.id) as share 
				FROM share, article 
				WHERE article.id = share.article AND article.id=".$id."
				GROUP BY YEAR(share.createdAt), MONTH(share.createdAt)
				ORDER BY YEAR(share.createdAt), MONTH(share.createdAt)";
					
		$dbCommand = Yii::app()->db->createCommand($sqlShare);
		$dataShare =$dbCommand->queryAll();	
		
		$sqlVisit = "SELECT Date_format(visit.createdAt,'%Y-%m') as mes, COUNT(visit.id) as visit 
				FROM visit, article 
				WHERE article.id = visit.article AND article.id=".$id."
				GROUP BY YEAR(visit.createdAt), MONTH(visit.createdAt)
				ORDER BY YEAR(visit.createdAt), MONTH(visit.createdAt)";
					
		$dbCommand = Yii::app()->db->createCommand($sqlVisit);
		$dataVisit =$dbCommand->queryAll();	
		
		$sqlLike = "SELECT Date_format(`like`.createdAt,'%Y-%m') as mes, COUNT(`like`.id) as likes 
				FROM `like`, article 
				WHERE article.id = `like`.article AND article.id=".$id."
				GROUP BY YEAR(`like`.createdAt), MONTH(`like`.createdAt)
				ORDER BY YEAR(`like`.createdAt), MONTH(`like`.createdAt)";
					
		$dbCommand = Yii::app()->db->createCommand($sqlLike);
		$dataLike =$dbCommand->queryAll();	
		
		
		foreach ($dataProvider as $key => $value) {
			foreach ($dataShare as $key1 => $value1) {
				
				if ($value['mes']===$value1['mes']) {
					$dataProvider[$key]['share']=$value1['share'];
				} 
							
			}			
		}
		
		foreach ($dataProvider as $key => $value) {
			foreach ($dataVisit as $key1 => $value1) {
				
				if ($value['mes']===$value1['mes']) {
					$dataProvider[$key]['visit']=$value1['visit'];
				} 
							
			}			
		}
		
		foreach ($dataProvider as $key => $value) {
			foreach ($dataLike as $key1 => $value1) {
				
				if ($value['mes']===$value1['mes']) {
					$dataProvider[$key]['likes']=$value1['likes'];
				} 
							
			}			
		}		
		
		echo json_encode($dataProvider);
		
		Yii::app()->end();	
	}
	
	//Para sacar las estadisticas de los objetos creados por año vs mis objetos creados por año
	
	public function actionJSONaototalporaniovsmisoa()
	{
		$this->layout=FALSE;
		header('Content-type: application/json');
			
		$id=Yii::app()->user->id;
		
		$sql="SELECT YEAR(article.createdAt) as anio, COUNT(article.id) as total, 0 as cantidad
			 FROM article
			 GROUP BY YEAR(article.createdAt)";		
				
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataTotal =$dbCommand->queryAll();	
		
		$sqlmis="SELECT YEAR(article.createdAt) as anio, COUNT(article.id) as cantidad
				FROM article
				WHERE article.creator=".$id."
				GROUP BY YEAR(article.createdAt)";		
				
		$dbCommand = Yii::app()->db->createCommand($sqlmis);
		$dataMisoa =$dbCommand->queryAll();
		
		foreach ($dataTotal as $key => $value) {
			foreach ($dataMisoa as $key1 => $value1) {
				
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
	
	//Para sacar las estadisticas de los objetos creados por mes de un determinado año vs mis objetos creados por año
	
	public function actionJSONaototalpormesvsmisoa($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');
			
		$uid=Yii::app()->user->id;
		
		$sql="SELECT Date_format(article.createdAt,'%Y-%m') as mes, COUNT(article.id) as total, 0 as cantidad
			FROM article
			WHERE YEAR(article.createdAt)=".$id."
			GROUP BY YEAR(article.createdAt), MONTH(article.createdAt)";			
				
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataTotal =$dbCommand->queryAll();	
		
		
		
		$sqlmis="SELECT Date_format(article.createdAt,'%Y-%m') as mes, COUNT(article.id) as cantidad
				FROM article
				WHERE article.creator=".$uid." and YEAR(article.createdAt)=".$id."
				GROUP BY YEAR(article.createdAt), MONTH(article.createdAt)";		
				
		$dbCommand = Yii::app()->db->createCommand($sqlmis);
		$dataMisoa =$dbCommand->queryAll();
		
		foreach ($dataTotal as $key => $value) {
			foreach ($dataMisoa as $key1 => $value1) {
				
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
	
	//Para sacar los share, visit y likes de un artículo, agrupado por años
	
	public function actionJSONsharevisitlikeoaporanio($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');		
		
		$sql="SELECT YEAR(share.createdAt) as anio, 0 as compartido, 0 as visitado, 0 as gustado
				FROM share
				WHERE share.article=".$id."
				GROUP BY YEAR(share.createdAt)
				UNION
				SELECT YEAR(visit.createdAt) as anio, 0 as compartido, 0 as visitado, 0 as gustado
				FROM visit
				WHERE visit.article=".$id."
				GROUP BY YEAR(visit.createdAt)
				UNION
				SELECT YEAR(`like`.createdAt) as anio, 0 as compartido, 0 as visitado, 0 as gustado
				FROM `like`
				WHERE `like`.article=".$id."
				GROUP BY YEAR(`like`.createdAt)";		
				
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataTotal =$dbCommand->queryAll();	
		
		
		
		$sqlshare="SELECT YEAR(share.createdAt) as anio, COUNT(share.id) as compartido
					FROM share
					WHERE share.article=".$id."
					GROUP BY YEAR(share.createdAt)";		
				
		$dbCommand = Yii::app()->db->createCommand($sqlshare);
		$dataShare =$dbCommand->queryAll();
		
		$sqlvisit="SELECT YEAR(visit.createdAt) as anio, COUNT(visit.id) as visitado
					FROM visit
					WHERE visit.article=".$id."
					GROUP BY YEAR(visit.createdAt)";		
				
		$dbCommand = Yii::app()->db->createCommand($sqlvisit);
		$dataVisit =$dbCommand->queryAll();
		
		$sqllike="SELECT YEAR(`like`.createdAt) as anio, COUNT(`like`.id) as gustado
					FROM `like`
					WHERE `like`.article=".$id."
					GROUP BY YEAR(`like`.createdAt)";		
				
		$dbCommand = Yii::app()->db->createCommand($sqllike);
		$dataLike =$dbCommand->queryAll();
		
		foreach ($dataTotal as $key => $value) {
			foreach ($dataShare as $key1 => $value1) {
				
				if ($value['anio']===$value1['anio']) {
					$dataTotal[$key]['compartido']=$value1['compartido'];
				} 
							
			}			
		}
		
		foreach ($dataTotal as $key => $value) {
			foreach ($dataVisit as $key1 => $value1) {
				
				if ($value['anio']===$value1['anio']) {
					$dataTotal[$key]['visitado']=$value1['visitado'];
				} 
							
			}			
		}
		
		foreach ($dataTotal as $key => $value) {
			foreach ($dataLike as $key1 => $value1) {
				
				if ($value['anio']===$value1['anio']) {
					$dataTotal[$key]['gustado']=$value1['gustado'];
				} 
							
			}			
		}		
	
		echo json_encode($dataTotal);		
		Yii::app()->end();		
				
	}
	
	//Para sacar las estadisticas del total de objetos, total de activos y total de desactivos 	
	public function actionJSONaototal()
	{
		$this->layout=FALSE;
		header('Content-type: application/json');	
		
		$sql="SELECT 'Total | Habilitados | Deshabilitados' as anio, COUNT(article.id) as total
			FROM article";
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataTotal =$dbCommand->queryAll();
			
			
		$sql=" SELECT 'Habilitados' as anio, COUNT(article.id) as activos
			FROM article
			WHERE article.state <>'disable'";
			
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataActivo =$dbCommand->queryAll();
			
		$sql="SELECT 'Deshabilitados' as anio, COUNT(article.id) as desactivos
			FROM article
			WHERE article.state ='disable'";
			
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataDesactivo =$dbCommand->queryAll();		
				
		foreach ($dataTotal as $key => $value) {
			foreach ($dataActivo as $key1 => $value1) {
				$dataTotal[$key]['activos']=$value1['activos'];						
			}			
		}
		
		foreach ($dataTotal as $key => $value) {
			foreach ($dataDesactivo as $key1 => $value1) {
				$dataTotal[$key]['desactivos']=$value1['desactivos'];						
			}			
		}				
		
		echo json_encode($dataTotal);		
		Yii::app()->end();		
	}
	
	//Para sacar las estadisticas de los objetos creados por año 	
	public function actionJSONaototalporanio()
	{
		$this->layout=FALSE;
		header('Content-type: application/json');	
		
		$sql="SELECT YEAR(article.createdAt) as anio, COUNT(article.id) as total, 0 as activos, 0 as desactivos
			 FROM article
			 GROUP BY YEAR(article.createdAt)";		
				
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataTotal =$dbCommand->queryAll();	
		
		$sql="SELECT YEAR(article.createdAt) as anio, COUNT(article.id) as activos
			FROM article
			WHERE article.state <>'disable'
			GROUP BY YEAR(article.createdAt)";		
				
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataActivo =$dbCommand->queryAll();
		
		$sql="SELECT YEAR(article.createdAt) as anio, COUNT(article.id) as desactivos
			FROM article
			WHERE article.state ='disable'
			GROUP BY YEAR(article.createdAt)";		
				
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataDesactivo =$dbCommand->queryAll();	
		
		foreach ($dataTotal as $key => $value) {
			foreach ($dataActivo as $key1 => $value1) {
				
				if ($value['anio']===$value1['anio']) {
					$dataTotal[$key]['activos']=$value1['activos'];
				} 
							
			}			
		}
		
		foreach ($dataTotal as $key => $value) {
			foreach ($dataDesactivo as $key1 => $value1) {
				
				if ($value['anio']===$value1['anio']) {
					$dataTotal[$key]['desactivos']=$value1['desactivos'];
				} 
							
			}			
		}	
		
		echo json_encode($dataTotal);		
		Yii::app()->end();		
	}
	
	//Para sacar las estadisticas de los objetos creados por mes de un determinado año vs mis objetos creados por año
	
	public function actionJSONaototalpormes()
	{
		$this->layout=FALSE;
		header('Content-type: application/json');
			
		$uid=Yii::app()->user->id;
		
		$sql="SELECT Date_format(article.createdAt,'%Y-%m') as mes, COUNT(article.id) as total, 0 as habilitado, 0 as deshabilitado
			FROM article
			WHERE article.createdAt>='".$_POST['fecha1']."' and article.createdAt<='".$_POST['fecha2']."'
			GROUP BY YEAR(article.createdAt), MONTH(article.createdAt)";			
				
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataTotal =$dbCommand->queryAll();	
		
		$sql="SELECT Date_format(article.createdAt,'%Y-%m') as mes, COUNT(article.id) as total
			FROM article
			WHERE article.state<>'disable' and article.createdAt>='".$_POST['fecha1']."' and article.createdAt<='".$_POST['fecha2']."'
			GROUP BY YEAR(article.createdAt), MONTH(article.createdAt)";			
				
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataHabilitado =$dbCommand->queryAll();	
		
		$sql="SELECT Date_format(article.createdAt,'%Y-%m') as mes, COUNT(article.id) as total
			FROM article
			WHERE article.state='disable' and article.createdAt>='".$_POST['fecha1']."' and article.createdAt<='".$_POST['fecha2']."'
			GROUP BY YEAR(article.createdAt), MONTH(article.createdAt)";			
				
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataDeshabilitado =$dbCommand->queryAll();	
		
		foreach ($dataTotal as $key => $value) {
			foreach ($dataHabilitado as $key1 => $value1) {
				
				if ($value['mes']===$value1['mes']) {
					$dataTotal[$key]['habilitado']=$value1['total'];
				} 
							
			}			
		}
		
		foreach ($dataTotal as $key => $value) {
			foreach ($dataDeshabilitado as $key1 => $value1) {
				
				if ($value['mes']===$value1['mes']) {
					$dataTotal[$key]['deshabilitado']=$value1['total'];
				} 
							
			}			
		}	
		
		echo json_encode($dataTotal);		
		Yii::app()->end();		
				
	}
	
	//Para sacar las estadisticas de los objetos creados por dias de un determinado mes 
	
	public function actionJSONaototalpordias()
	{
		$this->layout=FALSE;
		header('Content-type: application/json');
			
		$uid=Yii::app()->user->id;
		
		$sql="SELECT Date_format(article.createdAt,'%Y-%m-%d') as dia, COUNT(article.id) as total, 0 as habilitado, 0 as deshabilitado
			FROM article
			WHERE article.createdAt LIKE '".$_POST['mes']."%' 
			GROUP BY Date_format(article.createdAt,'%Y-%m-%d')";			
				
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataTotal =$dbCommand->queryAll();	
		
		$sql="SELECT Date_format(article.createdAt,'%Y-%m-%d') as dia, COUNT(article.id) as total, 0 as cantidad
			FROM article
			WHERE article.state<>'disable' and article.createdAt LIKE '".$_POST['mes']."%' 
			GROUP BY Date_format(article.createdAt,'%Y-%m-%d')";			
				
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataHabilitado =$dbCommand->queryAll();	
		
		$sql="SELECT Date_format(article.createdAt,'%Y-%m-%d') as dia, COUNT(article.id) as total, 0 as cantidad
			FROM article
			WHERE article.state='disable' and article.createdAt LIKE '".$_POST['mes']."%' 
			GROUP BY Date_format(article.createdAt,'%Y-%m-%d')";			
				
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataDeshabilitado =$dbCommand->queryAll();
		
		foreach ($dataTotal as $key => $value) {
			foreach ($dataHabilitado as $key1 => $value1) {
				
				if ($value['dia']===$value1['dia']) {
					$dataTotal[$key]['habilitado']=$value1['total'];
				} 
							
			}			
		}
		
		foreach ($dataTotal as $key => $value) {
			foreach ($dataDeshabilitado as $key1 => $value1) {
				
				if ($value['dia']===$value1['dia']) {
					$dataTotal[$key]['deshabilitado']=$value1['total'];
				} 
							
			}			
		}				
		
		echo json_encode($dataTotal);		
		Yii::app()->end();		
				
	}
	
	//Para el grafico de recomendados de todos los artículos
	public function actionJSONMasrecomendadostotal()
	{
		$this->layout=FALSE;
		header('Content-type: application/json');
		
		$sql = "SELECT article.id, article.title, article.url, user.id as uid, user.name, article.createdAt, 0 as share, 0 as visit, 0 as likes 
				FROM article, user
				WHERE user.id=article.creator";
					
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();
		
		$sqlshare="SELECT article.id, COUNT(share.id) as share
				FROM article, share 
				WHERE article.id=share.article 
				GROUP BY article.id";
				
		$dbCommand = Yii::app()->db->createCommand($sqlshare);
		$dataShare =$dbCommand->queryAll();
				
				
		$sqlVisit="SELECT article.id, COUNT(visit.id) as visit
				FROM article, visit 
				WHERE article.id=visit.article
				GROUP BY article.id";
				
		$dbCommand = Yii::app()->db->createCommand($sqlVisit);
		$dataVisit =$dbCommand->queryAll();
		
		$sqlLike="SELECT article.id, COUNT(`like`.id) as likes
				FROM article, `like` 
				WHERE article.id=`like`.article 
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

	//Para el grafico de recomendados en un rango de fechas
	public function actionJSONMasrecomendadosrango()
	{
		$this->layout=FALSE;
		header('Content-type: application/json');
		
		$sql = "SELECT article.id, article.title, article.url, user.id as uid, user.name, article.createdAt, 0 as share, 0 as visit, 0 as likes 
				FROM article, user
				WHERE user.id=article.creator and article.createdAt<='".$_POST['fecha2']."'";
					
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();	
		
		$sqlshare="SELECT article.id, COUNT(share.id) as share
				FROM article, share 
				WHERE article.id=share.article and share.createdAt>='".$_POST['fecha1']."' and share.createdAt<='".$_POST['fecha2']."' 
				GROUP BY article.id";
				
		$dbCommand = Yii::app()->db->createCommand($sqlshare);
		$dataShare =$dbCommand->queryAll();
				
				
		$sqlVisit="SELECT article.id, COUNT(visit.id) as visit
				FROM article, visit 
				WHERE article.id=visit.article and visit.createdAt>='".$_POST['fecha1']."' and visit.createdAt<='".$_POST['fecha2']."'
				GROUP BY article.id";
				
		$dbCommand = Yii::app()->db->createCommand($sqlVisit);
		$dataVisit =$dbCommand->queryAll();
		
		$sqlLike="SELECT article.id, COUNT(`like`.id) as likes
				FROM article, `like` 
				WHERE article.id=`like`.article and `like`.createdAt>='".$_POST['fecha1']."' and `like`.createdAt<='".$_POST['fecha2']."' 
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

	//Para el grafico de mas compartidos de todos los artículos
	public function actionJSONMascompartidostotal()
	{
		$this->layout=FALSE;
		header('Content-type: application/json');
		
		$sql = "SELECT article.id, article.title, article.url, user.id as uid, user.name, article.createdAt, 0 as share 
				FROM article, user
				WHERE user.id=article.creator";
					
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();
		
		$sqlshare="SELECT article.id, COUNT(share.id) as share
				FROM article, share 
				WHERE article.id=share.article 
				GROUP BY article.id";
				
		$dbCommand = Yii::app()->db->createCommand($sqlshare);
		$dataShare =$dbCommand->queryAll();	
				
		foreach ($dataProvider as $key => $value) {
			foreach ($dataShare as $key1 => $value1) {
				
				if ($value['id']===$value1['id']) {
					$dataProvider[$key]['share']=$value1['share'];
				} 
							
			}			
		}	
		
		$ordenar=array();
		
		foreach ($dataProvider as $key => $value) {
			$ordenar[$key]= $value['share'];				
		}
		
		array_multisort($ordenar, SORT_DESC, $dataProvider);		
		
		echo json_encode($dataProvider);		
		Yii::app()->end();
		
	}
	
	//Para el grafico de mas compartidos de un rango de fechas
	public function actionJSONMascompartidosrango()
	{
		$this->layout=FALSE;
		header('Content-type: application/json');
		
		$sql = "SELECT article.id, article.title, article.url, user.id as uid, user.name, article.createdAt, 0 as share 
				FROM article, user
				WHERE user.id=article.creator and article.createdAt<='".$_POST['fecha2']."'";
					
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();
		
		$sqlshare="SELECT article.id, COUNT(share.id) as share
				FROM article, share 
				WHERE article.id=share.article and share.createdAt>='".$_POST['fecha1']."' and share.createdAt<='".$_POST['fecha2']."' 
				GROUP BY article.id";
				
		$dbCommand = Yii::app()->db->createCommand($sqlshare);
		$dataShare =$dbCommand->queryAll();	
				
		foreach ($dataProvider as $key => $value) {
			foreach ($dataShare as $key1 => $value1) {
				
				if ($value['id']===$value1['id']) {
					$dataProvider[$key]['share']=$value1['share'];
				} 
							
			}			
		}	
		
		$ordenar=array();
		
		foreach ($dataProvider as $key => $value) {
			$ordenar[$key]= $value['share'];				
		}
		
		array_multisort($ordenar, SORT_DESC, $dataProvider);		
		
		echo json_encode($dataProvider);		
		Yii::app()->end();
		
	}
	
	//Para el grafico de mas compartidos de todos los artículos
	public function actionJSONMasvisitadostotal()
	{
		$this->layout=FALSE;
		header('Content-type: application/json');
		
		$sql = "SELECT article.id, article.title, article.url, user.id as uid, user.name, article.createdAt, 0 as visit 
				FROM article, user
				WHERE user.id=article.creator";
					
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();
		
		$sqlvisit="SELECT article.id, COUNT(visit.id) as visit
				FROM article, visit 
				WHERE article.id=visit.article 
				GROUP BY article.id";
				
		$dbCommand = Yii::app()->db->createCommand($sqlvisit);
		$dataVisit =$dbCommand->queryAll();	
				
		foreach ($dataProvider as $key => $value) {
			foreach ($dataVisit as $key1 => $value1) {
				
				if ($value['id']===$value1['id']) {
					$dataProvider[$key]['visit']=$value1['visit'];
				} 
							
			}			
		}	
		
		$ordenar=array();
		
		foreach ($dataProvider as $key => $value) {
			$ordenar[$key]= $value['visit'];				
		}
		
		array_multisort($ordenar, SORT_DESC, $dataProvider);		
		
		echo json_encode($dataProvider);		
		Yii::app()->end();
		
	}
	
	//Para el grafico de mas visitados de un rango de fechas
	public function actionJSONMasvisitadosrango()
	{
		$this->layout=FALSE;
		header('Content-type: application/json');
		
		$sql = "SELECT article.id, article.title, article.url, user.id as uid, user.name, article.createdAt, 0 as visit 
				FROM article, user
				WHERE user.id=article.creator and article.createdAt<='".$_POST['fecha2']."'";
					
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();
		
		$sqlvisit="SELECT article.id, COUNT(visit.id) as visit
				FROM article, visit 
				WHERE article.id=visit.article and visit.createdAt>='".$_POST['fecha1']."' and visit.createdAt<='".$_POST['fecha2']."' 
				GROUP BY article.id";
				
		$dbCommand = Yii::app()->db->createCommand($sqlvisit);
		$dataVisit =$dbCommand->queryAll();	
				
		foreach ($dataProvider as $key => $value) {
			foreach ($dataVisit as $key1 => $value1) {
				
				if ($value['id']===$value1['id']) {
					$dataProvider[$key]['visit']=$value1['visit'];
				} 
							
			}			
		}	
		
		$ordenar=array();
		
		foreach ($dataProvider as $key => $value) {
			$ordenar[$key]= $value['visit'];				
		}
		
		array_multisort($ordenar, SORT_DESC, $dataProvider);		
		
		echo json_encode($dataProvider);		
		Yii::app()->end();
		
	}
	
	//Para el grafico de mas gustados de todos los artículos
	public function actionJSONMasgustadostotal()
	{
		$this->layout=FALSE;
		header('Content-type: application/json');
		
		$sql = "SELECT article.id, article.title, article.url, user.id as uid, user.name, article.createdAt, 0 as likes 
				FROM article, user
				WHERE user.id=article.creator";
					
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();
		
		$sqllike="SELECT article.id, COUNT(`like`.id) as likes
				FROM article, `like` 
				WHERE article.id=`like`.article 
				GROUP BY article.id";
				
		$dbCommand = Yii::app()->db->createCommand($sqllike);
		$dataLike =$dbCommand->queryAll();	
				
		foreach ($dataProvider as $key => $value) {
			foreach ($dataLike as $key1 => $value1) {
				
				if ($value['id']===$value1['id']) {
					$dataProvider[$key]['likes']=$value1['likes'];
				} 
							
			}			
		}	
		
		$ordenar=array();
		
		foreach ($dataProvider as $key => $value) {
			$ordenar[$key]= $value['likes'];				
		}
		
		array_multisort($ordenar, SORT_DESC, $dataProvider);		
		
		echo json_encode($dataProvider);		
		Yii::app()->end();
		
	}
	
	//Para el grafico de mas gustados en un rango de fechas
	public function actionJSONMasgustadosrango()
	{
		$this->layout=FALSE;
		header('Content-type: application/json');
		
		$sql = "SELECT article.id, article.title, article.url, user.id as uid, user.name, article.createdAt, 0 as likes 
				FROM article, user
				WHERE user.id=article.creator and article.createdAt<='".$_POST['fecha2']."'";
					
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();
		
		$sqllike="SELECT article.id, COUNT(`like`.id) as likes
				FROM article, `like` 
				WHERE article.id=`like`.article and `like`.createdAt>='".$_POST['fecha1']."' and `like`.createdAt<='".$_POST['fecha2']."' 
				GROUP BY article.id";
				
		$dbCommand = Yii::app()->db->createCommand($sqllike);
		$dataLike =$dbCommand->queryAll();	
				
		foreach ($dataProvider as $key => $value) {
			foreach ($dataLike as $key1 => $value1) {
				
				if ($value['id']===$value1['id']) {
					$dataProvider[$key]['likes']=$value1['likes'];
				} 
							
			}			
		}	
		
		$ordenar=array();
		
		foreach ($dataProvider as $key => $value) {
			$ordenar[$key]= $value['likes'];				
		}
		
		array_multisort($ordenar, SORT_DESC, $dataProvider);		
		
		echo json_encode($dataProvider);		
		Yii::app()->end();
		
	}
	
	
}
