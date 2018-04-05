<?php

class UserController extends Controller
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
				'actions'=>array('index','indexs','indexa','indexc','view','create','update','updates', 'admin','delete', 'Confignotificaciones','JSONactualizarnotificacion', 'valornotificacion', 'JSONUpdatevalornotificacion', 'JSONUpdatevalornotificacion'),
				'roles'=>array('admin'),
				//'roles'=>array('admin'),
				
			),
			
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('Indexconfig','updateconf','updateconfpass','imagen', 'Indextodosautores', 'Estadisticaautor','JSONoaactivosdesactivos','JSONaototalporaniovsautoroa','JSONaototalpormesvsautoroa','JSONmascompartidosautor','Compartidosautor','Visitadosautor','JSONmasvisitadosautor','Gustadosautor','JSONmasgustadosautor','Recomendadosautor','JSONrecomendadosautor','JSONaototalpormesvsautoroarango','Mihistorial','Autorporcategoria','JSONpublicacionesporautorcategoria','JSONtotalvsautoroa','JSONaototalvsautoroa', 'Indexautorbuscarfecha','JSONaototalpormesvsautoroadias','JSONrecomendadosautorrango','JSONpublicacionesporautorcategoriarango','JSONmasvisitadosautorrango','JSONmasgustadosautorrango','JSONmascompartidosautorrango','JSONautoresporrelevancia','Indexnotificaciones', 'Vernotificacion', 'Confignotificacionesusuario', 'Valornotificacionusuario', 'JSONdetallenotificacion', 'JSONUpdatevalornotificacionusuario', 'Indexmensajes', 'Indexmensajesenviados', 'NuevoMensaje', 'Indexbuscarusuarios', 'JSONenviarmensaje','JSONcompartirnotificacion','Vermensaje', 'Vermensajeenviado','JSONeliminarnotificacion'),
				'users'=>array('@'),
				
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
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}
	
	

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$this->layout=false;
		$model=new User;
		$items = '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">Ã—</button>
                                        <b>Correcto!</b> Usuario guardado correctamente.
                                    </div>';

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			//Tomar los datos de la vista
			$model->attributes=$_POST['User'];
			//Asignar los atributos que no estan en la vista
			$model->name=$model->firstname.$model->lastname;
			$model->provider='SOMAN';
			$model->uid=rand(0, 99999);	
			$model->estadoCuenta='activa';
			//Encriptar la contraseÃ±a	
			$model->password=sha1($model->password);
			//Tomar la fecha actual
			$model->createdAt=new CDbExpression('NOW()');	
			//Validar el modelo 
			if($model->validate())
			{
				//Guardar
				if($model->save())
				{								
					//Asignar el rol de usuario
					Yii::app()->authManager->assign('user', $model->id);
					//Enviar el email									
					/*$email = new EnviarEmail;
							
						$subject = "CUENTA CREADA ";
						$subject.= Yii::app()->name;
						$message = "Su cuenta en GAMMA ha sido creada por el administrador";						
						
						$email->Enviar_Email
								(
									array(Yii::app()->params['adminEmail'], Yii::app()->name), 
									array($model->email, $model->name),
									$subject, 
									$message
								);*/
									
					$this->layout=false;
					header('Content-type: application/json');	
					//Mostrar el mensaje de exito									
					echo CJavaScript::jsonEncode($items);	
					//Terminar la aplicaciÃ³n
					Yii::app()->end();				
				}
			}
			
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
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">Ã—</button>
                                        <b>Correcto!</b> Usuario guardado correctamente.
                                    </div>';

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		//$estado1 = $model->estadoCuenta;
		if(isset($_POST['User']))
		{			
			$model->attributes=$_POST['User'];			
			$model->updatedAt=new CDbExpression('NOW()');
			
			$conexion = Yii::app()->db;			
			
			$consulta = "SELECT name, email from user WHERE ";
			$consulta.="id=".$id." and password='".$model->password."'";
			
			$resultado = $conexion->createCommand($consulta);
			$filas = $resultado->query();
			$existe = false;
			
			foreach($filas as $fila)
			{
				$existe=true;
			}
			
			if($existe==false)
			{
				$model->password=sha1($model->password);
			}					
			
			if($model->validate()){
				if($model->save()){
					/*$estado2=$model->estadoCuenta;
					if($estado1==='solicitada' && $estado2==='activa')	
					{
						$email = new EnviarEmail;
							
						$subject = "ActivaciÃ³n cuenta ";
						$subject.= Yii::app()->name;
						$message = "Su cuenta ha sido activada por el administrador";
						
						
						$email->Enviar_Email(
								array(Yii::app()->params['adminEmail'], Yii::app()->name), 
								array($model->email, $model->name),
								$subject, 
								$message
								);	
					}*/
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

	public function actionUpdates($id)
	{
		
		User::model()->updateByPk($id, array(
		  'status'=>$_POST['stado'],
		));		
		
		$model=User::model()->findByPk($id);
		
		/*if($_POST['stado']=='editor'||$_POST['stado']=='cancel')
		{
		//Enviar email
		$email = new EnviarEmail;
							
		$subject = "CAMBIO DE ESTADO DE CUENTA ";
		$subject.= Yii::app()->name;
		$message = "Su cuenta ha sido ".$_POST['stado']." por el administrador";
		
		
		$email->Enviar_Email(
				array(Yii::app()->params['adminEmail'], Yii::app()->name), 
				array($model->email, $model->name),
				$subject, 
				$message
				);
		}*/	
		
		$solicitud=User::model()->countByAttributes(array(
                        'status'=>'consumer'
                       
                ));
		$activada=User::model()->countByAttributes(array(
                        'status'=>'editor'
                       
                ));
		$cancelada=User::model()->countByAttributes(array(
                        'status'=>'cancel'
                       
                ));

		$this->layout=false;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		
		$array = array(
		    "sol" => $solicitud,
		    "act" => $activada,
		    "can" => $cancelada,
		);
		echo CJavaScript::jsonEncode($array);
		
	}

	/*public function actionUpdates($id)
	{
		
		User::model()->updateByPk($id, array(
		  'estadoCuenta'=>$_POST['stado'],
		));		
		
		$model=User::model()->findByPk($id);
		
		if($_POST['stado']=='activa'||$_POST['stado']=='cancelada')
		{
		//Enviar email
		$email = new EnviarEmail;
							
		$subject = "CAMBIO DE ESTADO DE CUENTA ";
		$subject.= Yii::app()->name;
		$message = "Su cuenta ha sido ".$_POST['stado']." por el administrador";
		
		
		$email->Enviar_Email(
				array(Yii::app()->params['adminEmail'], Yii::app()->name), 
				array($model->email, $model->name),
				$subject, 
				$message
				);
		}	
		
		$solicitud=User::model()->countByAttributes(array(
                        'estadoCuenta'=>'solicitada'
                       
                ));
		$activada=User::model()->countByAttributes(array(
                        'estadoCuenta'=>'activa'
                       
                ));
		$cancelada=User::model()->countByAttributes(array(
                        'estadoCuenta'=>'cancelada'
                       
                ));

		$this->layout=false;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		
		$array = array(
		    "sol" => $solicitud,
		    "act" => $activada,
		    "can" => $cancelada,
		);
		echo CJavaScript::jsonEncode($array);
		
	}*/
	
	public function actionUpdateconf()
	{
		$this->layout=false;
		$id=Yii::app()->user->getId();
		$model=$this->loadModel($id);
		$items = '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">Ã—</button>
                                        <b>Correcto!</b> Datos cambiados correctamente.
                                    </div>';

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			
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

		$this->render('updateconf',array(
			'model'=>$model,
		));
	}

	public function actionUpdateconfpass()
	{
		$this->layout=false;
		$id=Yii::app()->user->getId();
		$model=$this->loadModel($id);
		$items = '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">Ã—</button>
                                        <b>Correcto!</b> ContraseÃ±a cambiada correctamente.
                                    </div>';

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);


		if(isset($_POST['User']))
		{
			$activada=User::model()->countByAttributes(array(
                        'password'=>$_POST['User']['passworda']
                       
                ));
			

			$model->attributes=$_POST['User'];
			if($activada!=0){
				if($_POST['User']['passwordn']==$_POST['User']['password'] && strlen(trim($_POST['User']['passwordn']))>0 && strlen(trim($_POST['User']['password']))>0){
					if($model->validate()){
						$model->password=sha1($model->password);
						if($model->save()){
							
							$this->layout=false;
							header('Content-type: application/json');
							
							echo CJavaScript::jsonEncode($items);
							Yii::app()->end(); 

							
						}
					}
				}else{
					$items = 'e';		
	                $this->layout=false;
					header('Content-type: application/json');
					
					echo CJavaScript::jsonEncode($items);
					Yii::app()->end(); 	

				}
				
			}else{
				$items = '';		
                $this->layout=false;
				header('Content-type: application/json');
				
				echo CJavaScript::jsonEncode($items);
				Yii::app()->end(); 	
			}
			
		}
		$model->password="";
		$this->render('updateconfpass',array(
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
		Authassignment::model()->deleteByPk(array('itemname'=>'user', 'userid'=>$id));
		/*$sql = "DELETE FROM authassignment
				WHERE userid=".$id."";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dbCommand->queryAll();*/
		
		$solicitud=User::model()->countByAttributes(array(
                        'status'=>'consumer'
                       
                ));
		$activada=User::model()->countByAttributes(array(
                        'status'=>'editor'
                       
                ));
		$cancelada=User::model()->countByAttributes(array(
                        'status'=>'cancel'
                       
                ));

		$this->layout=false;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		
		$array = array(
		    "sol" => $solicitud,
		    "act" => $activada,
		    "can" => $cancelada,
		);
		echo CJavaScript::jsonEncode($array);

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		/*if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));*/

	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$solicitud=User::model()->countByAttributes(array(
                        'status'=>'consumer'
                       
                ));
		$activada=User::model()->countByAttributes(array(
                        'status'=>'editor'
                       
                ));
		$cancelada=User::model()->countByAttributes(array(
                        'status'=>'cancel'
                       
                ));

		$dataProvider=User::model()->findAllByAttributes(
		    array('status'=>'consumer')
		);

		$this->render('index',array(
			'dataProvider'=>$dataProvider,'solicitada'=>$solicitud,'activada'=>$activada,'cancelada'=>$cancelada,
		));

	}
	
	public function actionIndexs()
	{
		$this->layout=false;
		$dataProvider=User::model()->findAllByAttributes(
		    array('status'=>'consumer')
		);	
		$this->render('indexs',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionIndexa()
	{
		$this->layout=false;
		$dataProvider=User::model()->findAllByAttributes(
		    array('status'=>'editor')
		);	
		$this->render('indexa',array(
			'dataProvider'=>$dataProvider,
		));
	}
	public function actionIndexc()
	{
		$this->layout=false;
		$dataProvider=User::model()->findAllByAttributes(
		    array('status'=>'cancel')
		);	
		$this->render('indexc',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	public function actionIndexconfig()
	{
		

		$dataProvider=User::model()->findByAttributes(
		    array('id'=>Yii::app()->user->getId())
		);
		

		$this->render('indexconfig',array(
			'dataProvider'=>$dataProvider,
		));

	}

	public function actionImagen()
    {
    	$this->layout=false;
        $model = new ImagenForm();
		$user=$this->loadModel(Yii::app()->user->getId());
        if(isset($_POST['ImagenForm']))
        {                
            if(isset($_FILES) and $_FILES['ImagenForm']['error']['foto']==0)
             {
                $uf = CUploadedFile::getInstance($model, 'foto');
				$rnd = rand(0,99999);				
				$name = Yii::app()->user->getId().$rnd.$uf->getName();
                if($uf->getExtensionName() == "jpg" || $uf->getExtensionName() == "png" ||
                $uf->getExtensionName() == "jpeg" || $uf->getExtensionName()== "gif")
                {
                	//unlink(Yii::app()->basePath);
                	                	 
	                  $uf->saveAs(Yii::getPathOfAlias('webroot').'/images/'.$name);
	                  
	                
	                  	User::model()->updateByPk(Yii::app()->user->getId(), array(
						    'image' => '/gamma/images/'.$name,
						  
						));
	
						
						Yii::app()->user->setState('foto','/gamma/images/'.$name);
	                  
	                  $this->redirect(array('indexconfig'));					  
	
	                }else{
	                    $this->redirect(array('indexconfig'));
	                }
	                
	             }
				$this->redirect(array('indexconfig'));
        }
       
        $this->render('imagen',array('model'=>$model));
    }
	

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return User the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param User $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}	
	
	//PARA ESTADISTICAS
	public function actionJSONmasrecomendados()
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
	
	//Relevancia de los autores
	public function actionIndextodosautores()
	{
		$id=Yii::app()->user->id;
		
		$sql = "SELECT user.id, user.name, user.image, user.createdAt, 0 as cantidad 
				FROM user";
									
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();	
		
		$sql = "SELECT user.id, user.name, user.createdAt, Count(article.id) as cantidad 
				FROM user, article
				WHERE user.id = article.creator
				GROUP BY user.id";
									
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataCantidad =$dbCommand->queryAll();
		
		foreach ($dataProvider as $key => $value) {
				foreach ($dataCantidad as $key1 => $value1) {
					
					if ($value['id']===$value1['id']) {
						$dataProvider[$key]['cantidad']=$value1['cantidad'];
					} 
								
				}			
			}	
		
		foreach ($dataProvider as $keyd => $valued) 
		{			
			$sql = "SELECT article.id, 0 as share, 0 as visit, 0 as likes 
					FROM article
					Where article.creator=".$valued['id']."";
																		
			$dbCommand = Yii::app()->db->createCommand($sql);
			$dataArticle =$dbCommand->queryAll();			
							
			
			$sqlshare="SELECT article.id, COUNT(share.id) as share
				FROM article, share 
				WHERE article.id=share.article and article.creator=".$valued['id']."
				GROUP BY article.id";
				
			$dbCommand = Yii::app()->db->createCommand($sqlshare);
			$dataShare =$dbCommand->queryAll();	
			
			$sqlVisit="SELECT article.id, COUNT(visit.id) as visit
				FROM article, visit 
				WHERE article.id=visit.article and article.creator=".$valued['id']."
				GROUP BY article.id";
				
			$dbCommand = Yii::app()->db->createCommand($sqlVisit);
			$dataVisit =$dbCommand->queryAll();
			
			$sqlLike="SELECT article.id, COUNT(`like`.id) as likes
					FROM article, `like` 
					WHERE article.id=`like`.article and article.creator=".$valued['id']."
					GROUP BY article.id";
							
			$dbCommand = Yii::app()->db->createCommand($sqlLike);
			$dataLike =$dbCommand->queryAll();
			
			foreach ($dataArticle as $key => $value) {
				foreach ($dataShare as $key1 => $value1) {
					
					if ($value['id']===$value1['id']) {
						$dataArticle[$key]['share']=$value1['share'];
					} 
								
				}			
			}			
			
			foreach ($dataArticle as $key => $value) {
				foreach ($dataVisit as $key1 => $value1) {
					
					if ($value['id']===$value1['id']) {
						$dataArticle[$key]['visit']=$value1['visit'];
					} 
								
				}			
			}
			
			
			
			foreach ($dataArticle as $key => $value) {
				foreach ($dataLike as $key1 => $value1) {
					
					if ($value['id']===$value1['id']) {
						$dataArticle[$key]['likes']=$value1['likes'];
					} 
								
				}			
			}
			
			
			
			$suma=0;
			foreach ($dataArticle as $key => $value) {
				$dataArticle[$key]['recomendado']= 0.5*$dataArticle[$key]['share']+0.3*$dataArticle[$key]['visit']+0.2*$dataArticle[$key]['likes'];
				$suma=$suma+$dataArticle[$key]['recomendado'];				
								
			}			
			
			$dataProvider[$keyd]['relevancia']=$suma;		
						
		}

		$ordenar=array();
		
		foreach ($dataProvider as $key => $value) {
			$ordenar[$key]= $value['relevancia'];				
		}
		
		array_multisort($ordenar, SORT_DESC, $dataProvider);
		
		$this->render('indextodosautores',array(
			'dataProvider'=>$dataProvider
		));
	}

	//JSON los autores mas relevantes
	public function actionJSONautoresporrelevancia()
	{
		$this->layout=FALSE;
		header('Content-type: application/json');
		
		$id=Yii::app()->user->id;
		
		$sql = "SELECT user.id, user.image, user.name, user.createdAt, 0 as cantidad 
				FROM user";
									
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();	
		
		$sql = "SELECT user.id, user.name, user.createdAt, Count(article.id) as cantidad 
				FROM user, article
				WHERE user.id = article.creator
				GROUP BY user.id";
									
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataCantidad =$dbCommand->queryAll();
		
		foreach ($dataProvider as $key => $value) {
				foreach ($dataCantidad as $key1 => $value1) {
					
					if ($value['id']===$value1['id']) {
						$dataProvider[$key]['cantidad']=$value1['cantidad'];
					} 
								
				}			
			}	
		
		foreach ($dataProvider as $keyd => $valued) 
		{			
			$sql = "SELECT article.id, 0 as share, 0 as visit, 0 as likes 
					FROM article
					Where article.creator=".$valued['id']."";
																		
			$dbCommand = Yii::app()->db->createCommand($sql);
			$dataArticle =$dbCommand->queryAll();			
							
			
			$sqlshare="SELECT article.id, COUNT(share.id) as share
				FROM article, share 
				WHERE article.id=share.article and article.creator=".$valued['id']."
				GROUP BY article.id";
				
			$dbCommand = Yii::app()->db->createCommand($sqlshare);
			$dataShare =$dbCommand->queryAll();	
			
			$sqlVisit="SELECT article.id, COUNT(visit.id) as visit
				FROM article, visit 
				WHERE article.id=visit.article and article.creator=".$valued['id']."
				GROUP BY article.id";
				
			$dbCommand = Yii::app()->db->createCommand($sqlVisit);
			$dataVisit =$dbCommand->queryAll();
			
			$sqlLike="SELECT article.id, COUNT(`like`.id) as likes
					FROM article, `like` 
					WHERE article.id=`like`.article and article.creator=".$valued['id']."
					GROUP BY article.id";
							
			$dbCommand = Yii::app()->db->createCommand($sqlLike);
			$dataLike =$dbCommand->queryAll();
			
			foreach ($dataArticle as $key => $value) {
				foreach ($dataShare as $key1 => $value1) {
					
					if ($value['id']===$value1['id']) {
						$dataArticle[$key]['share']=$value1['share'];
					} 
								
				}			
			}			
			
			foreach ($dataArticle as $key => $value) {
				foreach ($dataVisit as $key1 => $value1) {
					
					if ($value['id']===$value1['id']) {
						$dataArticle[$key]['visit']=$value1['visit'];
					} 
								
				}			
			}
			
			
			
			foreach ($dataArticle as $key => $value) {
				foreach ($dataLike as $key1 => $value1) {
					
					if ($value['id']===$value1['id']) {
						$dataArticle[$key]['likes']=$value1['likes'];
					} 
								
				}			
			}
			
			
			
			$suma=0;
			foreach ($dataArticle as $key => $value) {
				$dataArticle[$key]['recomendado']= 0.5*$dataArticle[$key]['share']+0.3*$dataArticle[$key]['visit']+0.2*$dataArticle[$key]['likes'];
				$suma=$suma+$dataArticle[$key]['recomendado'];				
								
			}			
			
			$dataProvider[$keyd]['relevancia']=$suma;		
						
		}

		$ordenar=array();
		
		foreach ($dataProvider as $key => $value) {
			$ordenar[$key]= $value['relevancia'];				
		}
		
		array_multisort($ordenar, SORT_DESC, $dataProvider);
		
		echo json_encode($dataProvider);
		
		Yii::app()->end();	
	}

	//Relevancia de los autores por rango de fecha (pagina principal indextodosautores)
	public function actionIndexautorbuscarfecha()
	{
		$this->layout=FALSE;
		
		$id=Yii::app()->user->id;
		
		$sql = "SELECT user.id, user.name, user.createdAt, 0 as cantidad, 0 as relevancia 
				FROM user
				WHERE user.createdAt>='".$_GET['fecha1']."' and user.createdAt<='".$_GET['fecha2']."'";
									
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();	
		
		$sql = "SELECT user.id, user.name, user.createdAt, Count(article.id) as cantidad 
				FROM user, article
				WHERE user.id = article.creator
				GROUP BY user.id";
									
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataCantidad =$dbCommand->queryAll();
		
		foreach ($dataProvider as $key => $value) {
				foreach ($dataCantidad as $key1 => $value1) {
					
					if ($value['id']===$value1['id']) {
						$dataProvider[$key]['cantidad']=$value1['cantidad'];
					} 
								
				}			
			}	
		
		foreach ($dataProvider as $keyd => $valued) 
		{			
			$sql = "SELECT article.id, 0 as share, 0 as visit, 0 as likes 
					FROM article
					Where article.creator=".$valued['id']."";
																		
			$dbCommand = Yii::app()->db->createCommand($sql);
			$dataArticle =$dbCommand->queryAll();			
							
			
			$sqlshare="SELECT article.id, COUNT(share.id) as share
				FROM article, share 
				WHERE article.id=share.article and article.creator=".$valued['id']."
				GROUP BY article.id";
				
			$dbCommand = Yii::app()->db->createCommand($sqlshare);
			$dataShare =$dbCommand->queryAll();	
			
			$sqlVisit="SELECT article.id, COUNT(visit.id) as visit
				FROM article, visit 
				WHERE article.id=visit.article and article.creator=".$valued['id']."
				GROUP BY article.id";
				
			$dbCommand = Yii::app()->db->createCommand($sqlVisit);
			$dataVisit =$dbCommand->queryAll();
			
			$sqlLike="SELECT article.id, COUNT(`like`.id) as likes
					FROM article, `like` 
					WHERE article.id=`like`.article and article.creator=".$valued['id']."
					GROUP BY article.id";
							
			$dbCommand = Yii::app()->db->createCommand($sqlLike);
			$dataLike =$dbCommand->queryAll();
			
			foreach ($dataArticle as $key => $value) {
				foreach ($dataShare as $key1 => $value1) {
					
					if ($value['id']===$value1['id']) {
						$dataArticle[$key]['share']=$value1['share'];
					} 
								
				}			
			}			
			
			foreach ($dataArticle as $key => $value) {
				foreach ($dataVisit as $key1 => $value1) {
					
					if ($value['id']===$value1['id']) {
						$dataArticle[$key]['visit']=$value1['visit'];
					} 
								
				}			
			}
			
			
			
			foreach ($dataArticle as $key => $value) {
				foreach ($dataLike as $key1 => $value1) {
					
					if ($value['id']===$value1['id']) {
						$dataArticle[$key]['likes']=$value1['likes'];
					} 
								
				}			
			}
			
			
			
			$suma=0;
			foreach ($dataArticle as $key => $value) {
				$dataArticle[$key]['recomendado']= 0.5*$dataArticle[$key]['share']+0.3*$dataArticle[$key]['visit']+0.2*$dataArticle[$key]['likes'];
				$suma=$suma+$dataArticle[$key]['recomendado'];				
								
			}			
			
			$dataProvider[$keyd]['relevancia']=$suma;		
						
		}

		$ordenar=array();
		
		foreach ($dataProvider as $key => $value) {
			$ordenar[$key]= $value['relevancia'];				
		}
		
		array_multisort($ordenar, SORT_DESC, $dataProvider);
		
		$this->render('indexautorbuscarfecha',array(
			'dataProvider'=>$dataProvider
		));
	}
	
	//Para cargar la pagina de estadÃ­stica del autor
	public function actionEstadisticaautor($id)
	{
		$model=User::model()->findByAttributes(
		    array('id'=>$id)
		);	
		
		$sql = "SELECT 'Cantidad' as accion, Count(article.id) as cantidad 
				FROM article
				WHERE article.creator=".$id."";				
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();
		
		$sql = "SELECT 'Habilitados' as estado, COUNT(article.id) as cantidad FROM article Where article.state <>'disable' and article.creator=".$id."					 
				UNION ALL 
				SELECT 'Deshabilitados' as estado, COUNT(article.id) as cantidad FROM article Where article.state ='disable' and article.creator=".$id."";				
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider1 =$dbCommand->queryAll();
				  
		$this->render('estadisticaautor', array('model'=> $model, 'dataProvider'=>$dataProvider, 'dataProvider1'=>$dataProvider1));	
				
	}

	//Para cargar la pagina de mis estadÃ­sticas como autor
	public function actionMihistorial()
	{
		$id = Yii::app()->user->id;
		$model=User::model()->findByAttributes(
		    array('id'=>$id)
		);	
		
		$sql = "SELECT 'Cantidad' as accion, Count(article.id) as cantidad 
				FROM article
				WHERE article.creator=".$id."";				
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();
		
		$sql = "SELECT 'Habilitados' as estado, COUNT(article.id) as cantidad FROM article Where article.state <>'disable' and article.creator=".$id."					 
				UNION ALL 
				SELECT 'Deshabilitados' as estado, COUNT(article.id) as cantidad FROM article Where article.state ='disable' and article.creator=".$id."";				
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider1 =$dbCommand->queryAll();
				  
		$this->render('mihistorial', array('model'=> $model, 'dataProvider'=>$dataProvider, 'dataProvider1'=>$dataProvider1));	
				
	}

	//Para cargar la pagina de mas recomendados de un autor
	public function actionRecomendadosautor($id)
	{
		$model=User::model()->findByAttributes(
		    array('id'=>$id)
		);	
		
		$sql = "SELECT 'Cantidad' as accion, Count(article.id) as cantidad 
				FROM article
				WHERE article.creator=".$id."";				
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();
		
		$sql = "SELECT 'Habilitados' as estado, COUNT(article.id) as cantidad FROM article Where article.state <>'disable' and article.creator=".$id."					 
				UNION ALL 
				SELECT 'Deshabilitados' as estado, COUNT(article.id) as cantidad FROM article Where article.state ='disable' and article.creator=".$id."";				
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider1 =$dbCommand->queryAll();
				  
		$this->render('recomendadosautor', array('model'=> $model, 'dataProvider'=>$dataProvider, 'dataProvider1'=>$dataProvider1));	
				
	}

	//Para cargar la pagina de mas compartidos de un autor
	public function actionCompartidosautor($id)
	{
		$model=User::model()->findByAttributes(
		    array('id'=>$id)
		);	
		
		$sql = "SELECT 'Cantidad' as accion, Count(article.id) as cantidad 
				FROM article
				WHERE article.creator=".$id."";				
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();
		
		$sql = "SELECT 'Habilitados' as estado, COUNT(article.id) as cantidad FROM article Where article.state <>'disable' and article.creator=".$id."					 
				UNION ALL 
				SELECT 'Deshabilitados' as estado, COUNT(article.id) as cantidad FROM article Where article.state ='disable' and article.creator=".$id."";				
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider1 =$dbCommand->queryAll();
				  
		$this->render('compartidosautor', array('model'=> $model, 'dataProvider'=>$dataProvider, 'dataProvider1'=>$dataProvider1));	
				
	}
	
	//Para cargar la pagina de mas visitados de un autor
	public function actionVisitadosautor($id)
	{
		$model=User::model()->findByAttributes(
		    array('id'=>$id)
		);	
		
		$sql = "SELECT 'Cantidad' as accion, Count(article.id) as cantidad 
				FROM article
				WHERE article.creator=".$id."";				
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();
		
		$sql = "SELECT 'Habilitados' as estado, COUNT(article.id) as cantidad FROM article Where article.state <>'disable' and article.creator=".$id."					 
				UNION ALL 
				SELECT 'Deshabilitados' as estado, COUNT(article.id) as cantidad FROM article Where article.state ='disable' and article.creator=".$id."";				
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider1 =$dbCommand->queryAll();
				  
		$this->render('visitadosautor', array('model'=> $model, 'dataProvider'=>$dataProvider, 'dataProvider1'=>$dataProvider1));	
				
	}

	//Para cargar la pagina de mas gustados de un autor
	public function actionGustadosautor($id)
	{
		$model=User::model()->findByAttributes(
		    array('id'=>$id)
		);	
		
		$sql = "SELECT 'Cantidad' as accion, Count(article.id) as cantidad 
				FROM article
				WHERE article.creator=".$id."";				
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();
		
		$sql = "SELECT 'Habilitados' as estado, COUNT(article.id) as cantidad FROM article Where article.state <>'disable' and article.creator=".$id."					 
				UNION ALL 
				SELECT 'Deshabilitado' as estado, COUNT(article.id) as cantidad FROM article Where article.state ='disable' and article.creator=".$id."";				
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider1 =$dbCommand->queryAll();
				  
		$this->render('gustadosautor', array('model'=> $model, 'dataProvider'=>$dataProvider, 'dataProvider1'=>$dataProvider1));	
				
	}

	//Para cargar la pagina de estadÃ­sticas del autor por categoria
	public function actionAutorporcategoria($id)
	{
		$model=User::model()->findByAttributes(
		    array('id'=>$id)
		);	
		
		$sql = "SELECT 'Cantidad' as accion, Count(article.id) as cantidad 
				FROM article
				WHERE article.creator=".$id."";				
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();
		
		$sql = "SELECT 'Habilitados' as estado, COUNT(article.id) as cantidad FROM article Where article.state <>'disable' and article.creator=".$id."					 
				UNION ALL 
				SELECT 'Deshabilitados' as estado, COUNT(article.id) as cantidad FROM article Where article.state ='disable' and article.creator=".$id."";				
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider1 =$dbCommand->queryAll();
				  
		$this->render('autorporcategoria', array('model'=> $model, 'dataProvider'=>$dataProvider, 'dataProvider1'=>$dataProvider1));	
				
	}
	
	//Para sacar los activados y desactivados de un OA (Todos los tiempos)
	public function actionJSONoaactivosdesactivos($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');
		
		$sql = "SELECT 'Habilitados' as label, COUNT(article.id) as value FROM article Where article.state <>'disable' and article.creator=".$id."					 
				UNION ALL 
				SELECT 'Deshabilitados' as label, COUNT(article.id) as value FROM article Where article.state ='disable' and article.creator=".$id."";
					
		$dbCommand = Yii::app()->db->createCommand($sql);
		$datos =$dbCommand->queryAll();
		
		echo json_encode($datos);
		
		Yii::app()->end();		
	}
	
	//Para sacar las estadisticas de todos los objetos creados vs objetos de un autor	
	public function actionJSONtotalvsautoroa($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');		
		
		$sql="SELECT 'Total' as anio, COUNT(article.id) as total, 0 as cantidad
			 FROM article";		
				
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataTotal =$dbCommand->queryAll();	
		
		$sqlmis="SELECT 'Total' as anio, COUNT(article.id) as cantidad
				FROM article
				WHERE article.creator=".$id."";		
				
		$dbCommand = Yii::app()->db->createCommand($sqlmis);
		$dataMisoa =$dbCommand->queryAll();
		
		foreach ($dataTotal as $key => $value) {
			foreach ($dataMisoa as $key1 => $value1) {			
					$dataTotal[$key]['cantidad']=$value1['cantidad'];			 
							
			}			
		}
		
		foreach ($dataTotal as $key => $value) {
			$dataTotal[$key]['porcentaje']=round($value['cantidad']/$value['total']*100,2);					
		}
		
		echo json_encode($dataTotal);		
		Yii::app()->end();		
	}
	
	//Para sacar las estadisticas del total de objetos creados vs total de objetos creados de una autor	
	public function actionJSONaototalvsautoroa($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');		
		
		$sql="SELECT 'Total' as anio, COUNT(article.id) as total, 0 as cantidad
			 FROM article";		
				
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataTotal =$dbCommand->queryAll();	
		
		$sqlmis="SELECT 'Total' as anio, COUNT(article.id) as cantidad
				FROM article
				WHERE article.creator=".$id."";		
				
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
	
	//Para sacar las estadisticas de los objetos creados por aÃ±o vs objetos creados por aÃ±o de una autor	
	public function actionJSONaototalporaniovsautoroa($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');		
		
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

	//Para sacar las estadisticas de los objetos creados por mes de un determinado aÃ±o vs objetos creados por aÃ±o de un autor	
	public function actionJSONaototalpormesvsautoroa($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');	
		
		$sql="SELECT Date_format(article.createdAt,'%Y-%m') as mes, COUNT(article.id) as total, 0 as cantidad
			FROM article
			WHERE YEAR(article.createdAt)=".$_POST['anio']."
			GROUP BY YEAR(article.createdAt), MONTH(article.createdAt)";
			
			
				
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataTotal =$dbCommand->queryAll();	
		
		
		
		$sqlmis="SELECT Date_format(article.createdAt,'%Y-%m') as mes, COUNT(article.id) as cantidad
				FROM article
				WHERE article.creator=".$id." and YEAR(article.createdAt)=".$_POST['anio']."
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
	
	//Para sacar las estadisticas de los objetos creados por mes de un rango de fechas de un autor	
	public function actionJSONaototalpormesvsautoroarango($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');			
		
		$sql="SELECT Date_format(article.createdAt,'%Y-%m') as mes, COUNT(article.id) as total, 0 as cantidad
				FROM article
				WHERE article.createdAt>='".$_POST['fecha1']."' and article.createdAt<='".$_POST['fecha2']."'
				GROUP BY YEAR(article.createdAt), mes";		
			
				
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataTotal =$dbCommand->queryAll();	
		
		$sqlmis="SELECT Date_format(article.createdAt,'%Y-%m') as mes, COUNT(article.id) as cantidad
				FROM article
				WHERE article.creator=".$id." and article.createdAt>='".$_POST['fecha1']."' and article.createdAt<='".$_POST['fecha2']."'
				GROUP BY YEAR(article.createdAt), mes";		
				
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

	//Para sacar las estadisticas de los objetos creados por dias de un mes de un autor	
	public function actionJSONaototalpormesvsautoroadias($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');			
		
		$sql="SELECT Date_format(article.createdAt,'%Y-%m-%d') as dia, COUNT(article.id) as total, 0 as cantidad
				FROM article
				WHERE article.createdAt LIKE '".$_POST['mes']."%' 
				GROUP BY Date_format(article.createdAt,'%Y-%m-%d')";		
			
				
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataTotal =$dbCommand->queryAll();	
		
		$sqlmis="SELECT Date_format(article.createdAt,'%Y-%m-%d') as dia, COUNT(article.id) as cantidad
				FROM article
				WHERE article.creator=".$id." and article.createdAt LIKE '".$_POST['mes']."%' 
				GROUP BY Date_format(article.createdAt,'%Y-%m-%d')";		
				
		$dbCommand = Yii::app()->db->createCommand($sqlmis);
		$dataMisoa =$dbCommand->queryAll();
		
		foreach ($dataTotal as $key => $value) {
			foreach ($dataMisoa as $key1 => $value1) {
				
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
	
	//Para obtener los articulos recomendados de un determinado autor
	public function actionJSONrecomendadosautor($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');	
			
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
		
		echo json_encode($dataProvider);		
		Yii::app()->end();								
	}

	//Para obtener los articulos recomendados de un determinado autor en un rango de fechas
	public function actionJSONrecomendadosautorrango($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');	
			
		$sql = "SELECT article.id, article.title, article.url, article.createdAt, 0 as share, 0 as visit, 0 as likes 
				FROM article 
				WHERE article.createdAt<='".$_POST['fecha2']."' AND article.creator=".$id."";
					
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();	
		
		$sqlshare="SELECT article.id, COUNT(share.id) as share
				FROM article, share 
				WHERE article.id=share.article and share.createdAt>='".$_POST['fecha1']."' and share.createdAt<='".$_POST['fecha2']."' and article.creator=".$id."
				GROUP BY article.id";
				
		$dbCommand = Yii::app()->db->createCommand($sqlshare);
		$dataShare =$dbCommand->queryAll();
				
				
		$sqlVisit="SELECT article.id, COUNT(visit.id) as visit
				FROM article, visit 
				WHERE article.id=visit.article and visit.createdAt>='".$_POST['fecha1']."' and visit.createdAt<='".$_POST['fecha2']."' and article.creator=".$id."
				GROUP BY article.id";
				
		$dbCommand = Yii::app()->db->createCommand($sqlVisit);
		$dataVisit =$dbCommand->queryAll();
		
		$sqlLike="SELECT article.id, COUNT(`like`.id) as likes
				FROM article, `like` 
				WHERE article.id=`like`.article and `like`.createdAt>='".$_POST['fecha1']."' and `like`.createdAt<='".$_POST['fecha2']."' and article.creator=".$id."
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
	
	//Para obtener los articulos mas compartidos de un determinado autor
	public function actionJSONmascompartidosautor($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');	
		
		$sql = "SELECT article.title, article.url, COUNT(share.user) as cantidad
				FROM share, article 
				WHERE article.id=share.article and article.creator=".$id."
				GROUP BY article.id
				ORDER BY COUNT(share.user) DESC
				limit 50";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataCompartido = $dbCommand->queryAll();
		
		echo json_encode($dataCompartido);		
		Yii::app()->end();						
	}
	
	//Para obtener los articulos mas compartidos de un determinado autor en un rango de fechas
	public function actionJSONmascompartidosautorrango($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');	
		
		$sql = "SELECT article.title, article.url, COUNT(share.user) as cantidad
				FROM share, article 
				WHERE article.id=share.article and article.creator=".$id." and share.createdAt>='".$_POST['fecha1']."' and share.createdAt<='".$_POST['fecha2']."'
				GROUP BY article.id
				ORDER BY COUNT(share.user) DESC
				limit 50";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataCompartido = $dbCommand->queryAll();
		
		echo json_encode($dataCompartido);		
		Yii::app()->end();						
	}
	
	//Para obtener los articulos mas visitados de un determinado autor
	public function actionJSONmasvisitadosautor($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');	
		
		$sql = "SELECT article.title, article.url, COUNT(visit.user) as cantidad
				FROM visit, article 
				WHERE article.id=visit.article and article.creator=".$id."
				GROUP BY article.id
				ORDER BY COUNT(visit.user) DESC
				limit 50";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataCompartido = $dbCommand->queryAll();
		
		echo json_encode($dataCompartido);		
		Yii::app()->end();						
	}
	
	//Para obtener los articulos mas visitados de un determinado autor por rango de fechas
	public function actionJSONmasvisitadosautorrango($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');	
		
		$sql = "SELECT article.title, article.url, COUNT(visit.user) as cantidad
				FROM visit, article 
				WHERE article.id=visit.article and article.creator=".$id." and visit.createdAt>='".$_POST['fecha1']."' and visit.createdAt<='".$_POST['fecha2']."'
				GROUP BY article.id
				ORDER BY COUNT(visit.user) DESC
				limit 50";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataCompartido = $dbCommand->queryAll();
		
		echo json_encode($dataCompartido);		
		Yii::app()->end();						
	}
	
	//Para obtener los articulos mas gustados de un determinado autor
	public function actionJSONmasgustadosautor($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');	
		
		$sql = "SELECT article.title, article.url, COUNT(`like`.user) as cantidad
				FROM `like`, article 
				WHERE article.id=`like`.article and article.creator=".$id."
				GROUP BY article.id
				ORDER BY COUNT(`like`.user) DESC
				limit 50";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataCompartido = $dbCommand->queryAll();
		
		echo json_encode($dataCompartido);		
		Yii::app()->end();						
	}
	
	//Para obtener los articulos mas gustados de un determinado autor en un rango de fechas
	public function actionJSONmasgustadosautorrango($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');	
		
		$sql = "SELECT article.title, article.url, COUNT(`like`.user) as cantidad
				FROM `like`, article 
				WHERE article.id=`like`.article and article.creator=".$id." and `like`.createdAt>='".$_POST['fecha1']."' and `like`.createdAt<='".$_POST['fecha2']."'
				GROUP BY article.id
				ORDER BY COUNT(`like`.user) DESC
				limit 50";  	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataCompartido = $dbCommand->queryAll();
		
		echo json_encode($dataCompartido);		
		Yii::app()->end();						
	}
	
	//Para obtener los articulos publicados de un autor por categoria vs los articulos publicados de una categoria
	public function actionJSONpublicacionesporautorcategoria($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');	
		
		$sql = "SELECT category.id, category.name, COUNT(article.id) as total, 0 as cantidad
				FROM category, article, article_categories__category_articles
				WHERE category.id = article_categories__category_articles.category_articles and article_categories__category_articles.article_categories = article.id
				GROUP BY category.id
				ORDER BY COUNT(article.id) DESC"; 
				 	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataCategory = $dbCommand->queryAll();		
		
		$sql = "SELECT category.id, category.name, COUNT(article.id) as cantidad  
				FROM category, article, article_categories__category_articles, user
				WHERE category.id = article_categories__category_articles.category_articles and article_categories__category_articles.article_categories=article.id and article.creator=user.id and user.id=".$id."
				GROUP BY category.id"; 
				 	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataUser = $dbCommand->queryAll();
		
		foreach ($dataCategory as $key => $value) {
			foreach ($dataUser as $key1 => $value1) {
				
				if ($value['id']===$value1['id']) {
					$dataCategory[$key]['cantidad']=$value1['cantidad'];
				} 
							
			}			
		}
		
		foreach ($dataCategory as $key => $value) {
			$dataCategory[$key]['porcentaje']=round($value['cantidad']/$value['total']*100,2);									
		}
		
		foreach ($dataCategory as $key => $value) {
			$ordenar[$key]= $value['total'];				
		}
		
		array_multisort($ordenar, SORT_DESC, $dataCategory);
		
		echo json_encode($dataCategory);		
		Yii::app()->end();		
								
	}
	
	//Para obtener los articulos publicados de un autor por categoria vs los articulos publicados de una categoria
	public function actionJSONpublicacionesporautorcategoriarango($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');	
		
		$sql = "SELECT category.id, category.name, COUNT(article.id) as total, 0 as cantidad
				FROM category, article, article_categories__category_articles
				WHERE category.id = article_categories__category_articles.category_articles and article_categories__category_articles.article_categories = article.id and article.createdAt>='".$_POST['fecha1']."' and article.createdAt<='".$_POST['fecha2']."' 
				GROUP BY category.id
				ORDER BY COUNT(article.id) DESC"; 
				 	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataCategory = $dbCommand->queryAll();		
		
		$sql = "SELECT category.id, category.name, COUNT(article.id) as cantidad  
				FROM category, article, article_categories__category_articles, user
				WHERE category.id = article_categories__category_articles.category_articles and article_categories__category_articles.article_categories=article.id and article.creator=user.id and user.id=".$id." and article.createdAt>='".$_POST['fecha1']."' and article.createdAt<='".$_POST['fecha2']."'
				GROUP BY category.id"; 
				 	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataUser = $dbCommand->queryAll();
		
		foreach ($dataCategory as $key => $value) {
			foreach ($dataUser as $key1 => $value1) {
				
				if ($value['id']===$value1['id']) {
					$dataCategory[$key]['cantidad']=$value1['cantidad'];
				} 
							
			}			
		}
		
		foreach ($dataCategory as $key => $value) {
			$dataCategory[$key]['porcentaje']=round($value['cantidad']/$value['total']*100,2);									
		}
		
		$cantidad=0;
		foreach ($dataCategory as $key => $value) {
			$ordenar[$key]= $value['total'];
			$cantidad=1;				
		}
		
		if($cantidad===1)
		{
			array_multisort($ordenar, SORT_DESC, $dataCategory);
		}
		
		echo json_encode($dataCategory);		
		Yii::app()->end();		
								
	}


	///NOTIFICACIONES Y MENSAJES
	public function actionIndexnotificaciones()
	{
		$id=Yii::app()->user->id;
		
		$sql = "SELECT * from notificaciones where userid=".$id."";
					
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();		
		
		//Yii::app()->user->setState('numero', 0);
		
		$this->render('indexnotificaciones', array('dataProvider'=>$dataProvider));
	}

	//Para configurar la lista de tipos de notificaciones existentes por cada usuario
	public function actionConfignotificacionesusuario()
	{
		$id=Yii::app()->user->id;
		
		$sql = "SELECT * from tipo_notificacion_usuario where userid=".$id."";
					
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();		
		
		//Yii::app()->user->setState('numero', 0);
		
		$this->render('confignotificacionesusuario', array('dataProvider'=>$dataProvider));
		//$this->render('confignotificacionesusuario');
	}

	//Para definir el valor del tipo de notificacion 
	public function actionValornotificacionusuario($id)
	{		
		$sql = "SELECT * from tipo_notificacion_usuario where id=".$id."";
					
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();	
		
		$this->render('valornotificacionusuario', array('dataProvider'=>$dataProvider));
	}

	public function actionIndexmensajes()
	{
		$id=Yii::app()->user->id;
		
		$sql = "SELECT message.id, user.name, message.subject, message.datesend from message, user where user.id = message.idsend and idreceive=".$id."";
					
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();		
		
		//Yii::app()->user->setState('numero', 0);
		
		$this->render('indexmensajes', array('dataProvider'=>$dataProvider));
	}

	//Para ver los mensajes que envï¿½o
	public function actionIndexmensajesenviados()
	{
		$id=Yii::app()->user->id;
		
		$sql = "SELECT message.id, user.name, message.subject, message.datesend from message, user where user.id = message.idreceive and idsend=".$id."";
					
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();		
		
		//Yii::app()->user->setState('numero', 0);
		
		$this->render('indexmensajesenviados', array('dataProvider'=>$dataProvider));
	}

	public function actionNuevoMensaje()
	{	
		//Yii::app()->user->setState('numero', 0);
		
		$this->render('nuevomensaje');
	}

	//Para buscar los usuarios
	public function actionIndexbuscarusuarios($name)
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
		
		
		$this->render('indexbuscarusuarios',array(
			'dataProvider'=>$dataProvider,
		));		
	}

	public function actionJSONenviarmensaje()
	{
		$this->layout=FALSE;
		header('Content-type: application/json');		
		
		$conexion = Yii::app()->db;	
		
		$idsend=$_POST['idsend']; 
		$idreceive = $_POST['idreceive'];
		$subject = $_POST['subject'];
		$text = $_POST['text'];
		$fecha = new CDbExpression('NOW()');
		
		//print_r($fecha);
		//Yii::app()->end();	
						
		$consulta = "INSERT INTO `message`(`idsend`, `idreceive`, `datesend`, `datereceive`, `subject`, `text`)";
		$consulta.=" VALUES($idsend,$idreceive, $fecha, $fecha, '$subject', '$text')";
				
		$resultado = $conexion->createCommand($consulta)->execute();
		
					
						
		//$sql = "Select * from notificaciones where idNotificacion=1";
		//$dbCommand = Yii::app()->db->createCommand($sql);
		//$dataArticle = $dbCommand->queryAll();
		
		//echo json_encode($dataArticle);	
		Yii::app()->end();		
	}

	//Para sacar la lista de tipos de notificaciones existentes
	public function actionConfignotificaciones()
	{
		$id=Yii::app()->user->id;
		
		$sql = "SELECT * from tipo_notificacion";
					
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();		
		
		//Yii::app()->user->setState('numero', 0);
		
		$this->render('confignotificaciones', array('dataProvider'=>$dataProvider));
	}

	//Para definir el valor del tipo de notificacion 
	public function actionValornotificacion($id)
	{		
		$sql = "SELECT * from tipo_notificacion where id=".$id."";
					
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();	
		
		$this->render('valornotificacion', array('dataProvider'=>$dataProvider));
	}

	public function actionVernotificacion($id)
	{				
		$sql = "SELECT *
				FROM notificaciones
				WHERE idNotificacion=".$id."";
					
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();				
				  
		$this->render('vernotificacion', array('dataProvider'=>$dataProvider));				
	}

	//Para actualizar el valor del tipo de noticiaciï¿½n por usuario.	
	public function actionJSONUpdatevalornotificacionusuario($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');		
		
		$conexion = Yii::app()->db;	
		
		$consulta = "Update tipo_notificacion_usuario set valor=".$_POST['valor']." where id=".$id."";
		$resultado = $conexion->createCommand($consulta)->execute();
		//$dataArticle = $dbCommand->queryAll();
		print_r('Valor');
		Yii::app()->end();			
	}

	//Para actualizar el valor del tipo de noticiaciï¿½n	
	public function actionJSONUpdatevalornotificacion($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');	
		
		$conexion = Yii::app()->db;		
				
		$consulta = "Update tipo_notificacion set valor=".$_POST['valor']." where id=".$id."";
		$resultado = $conexion->createCommand($consulta)->execute();
		
		$sql = "Select id from user";
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();
				
		$sql = "Select action from tipo_notificacion where id='".$id."'";
		$dbCommand = Yii::app()->db->createCommand($sql);
		$Accion =$dbCommand->queryScalar();
		
		$sql = "Select texto from tipo_notificacion where id='".$id."'";
		$dbCommand = Yii::app()->db->createCommand($sql);
		$Texto =$dbCommand->queryScalar();
		
		$sql = "Select valor from tipo_notificacion where id='".$id."'";
		$dbCommand = Yii::app()->db->createCommand($sql);
		$Valor =$dbCommand->queryScalar();
		
		
		$conexion1 = Yii::app()->db;
		
		foreach ($dataProvider as $key => $value) 
		{		
			$sql = "Select count(*) from tipo_notificacion_usuario where userid=".$value['id']." and action='".$Accion."'";
			$dbCommand = Yii::app()->db->createCommand($sql);
			$existe =$dbCommand->queryScalar();
									
			if($existe==='0')
			{
				$idu = $value['id'];
				$mensaje = $Texto;
				$valor = $Valor;
				$action = $Accion;
			
				$consulta = "INSERT INTO tipo_notificacion_usuario(`userid`,`texto`, `valor`, `action`)";
				$consulta.=" VALUES($idu, '$Texto', $Valor, '$Accion')";					
						
				$resultado = $conexion1->createCommand($consulta)->execute();				
			}			
		}
				
		print_r($Accion);
		Yii::app()->end();				
	}

	//Para sacar el detalle de la notificaciï¿½n	
	public function actionJSONdetallenotificacion($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');
		
		//Actualizar el estado de la notificaciï¿½n a leido.
		$conexion = Yii::app()->db;	
		
		$consulta = "Update notificaciones Set estado='leido' where idNotificacion=".$id."";
		$resultado = $conexion->createCommand($consulta)->execute();
		
		//CODIGO PARA LAS NOTIFICACIONES
		$userid=Yii::app()->user->getId();
		//Para consultar el nï¿½mero de notificaciones
		$sqlNumero = "SELECT count(*) FROM notificaciones where estado='enviado' and userid = '".$userid."'";
			
		$dbCommand = Yii::app()->db->createCommand($sqlNumero);
		$dataNumero =$dbCommand->queryScalar();
		//$this->setState('data', json_encode($dataNotificaciones));		
		Yii::app()->user->setState('numero', $dataNumero);
		//Para mostrar las notificaciones del usuario
		$sqlNotificaciones = "SELECT * FROM notificaciones where estado='enviado' and userid = '".$userid."'";
			
		$dbCommand = Yii::app()->db->createCommand($sqlNotificaciones);
		$dataNotificaciones =$dbCommand->queryAll();
		//$this->setState('data', json_encode($dataNotificaciones));
		//$this->setState('data', $dataNotificaciones);
		Yii::app()->user->setState('data', $dataNotificaciones);
			
		//Seleccionar el tipo de notificaciï¿½n en base al campo action
		$sql = "SELECT notificaciones.`action` 
				FROM notificaciones
				Where idNotificacion =".$id."";				
		$dbCommand = Yii::app()->db->createCommand($sql);
		$action =$dbCommand->queryScalar();
		
		//Segï¿½n el tipo de notificaciï¿½n sacar el detalla			
		switch ($action) {
			case 'nopublican':
				$sql = "Select DATEDIFF(NOW(), max(article.createdAt)) 
						from article";
				$dbCommand = Yii::app()->db->createCommand($sql);
				$numerodias =$dbCommand->queryScalar();
				
				$sql = "Select article.id, article.title, article.createdAt, user.name 
						From article, user 
						Where article.creator = user.id Having max(article.createdAt)";	
				$dbCommand = Yii::app()->db->createCommand($sql);
				$dataArticle = $dbCommand->queryAll();
				
				foreach ($dataArticle as $key => $value) 
				{
					$dataArticle[$key]['dias']=$numerodias;
					$dataArticle[$key]['mensaje'] = utf8_encode("Ningún usuario ha publicado en <b>".$numerodias.
					' dias </b>, el último artículo publicado fue <b>'.utf8_decode($dataArticle[$key]['title']). '</b>, por el usuario <b>'.utf8_decode($dataArticle[$key]['name']).'</b>');									
				}
				
				echo json_encode($dataArticle);		
				Yii::app()->end();					
				
			break;
				
			case 'noacciones':
				
				$sql = "Select articleid from notificaciones where idNotificacion =".$id."";
				$dbCommand = Yii::app()->db->createCommand($sql);
				$idarticulo =$dbCommand->queryScalar();
				
				$sql = "Select article.id, article.title, article.createdAt from article where id=".$idarticulo."";
				$dbCommand = Yii::app()->db->createCommand($sql);
				$dataArticle = $dbCommand->queryAll();

				$sql = "Select Count(share.id) from share where share.article=".$idarticulo."";	
				$dbCommand = Yii::app()->db->createCommand($sql);
				$numshares = $dbCommand->queryScalar();				
				
				if($numshares>0)
				{
					$sql = "Select max(share.createdAt) as shares from share where share.article=".$idarticulo."";
					$dbCommand = Yii::app()->db->createCommand($sql);
					$shares = $dbCommand->queryScalar();
					$mensajeshare='El último compartido fue el '.$shares.'. ';
									
				}
				else {
					$mensajeshare='No se ha compartido ninguna vez. ';
					$shares='';
									
				}

				$sql = "Select Count(visit.id) from visit where visit.article=".$idarticulo."";	
				$dbCommand = Yii::app()->db->createCommand($sql);
				$numvisits = $dbCommand->queryScalar();	

				if($numvisits>0)
				{
					$sql = "Select max(visit.createdAt) as visits from visit where visit.article=".$idarticulo."";
					$dbCommand = Yii::app()->db->createCommand($sql);
					$visits = $dbCommand->queryScalar();
					$mensajevisit='La última visita fue el '.$visits.'. ';	
					
				}
				else {	
					$mensajevisit='No ha sido visitado ninguna vez. ';
					$visits='';											
				}				
							
				$sql = "Select Count(`like`.id) from `like` where `like`.article=".$idarticulo."";	
				$dbCommand = Yii::app()->db->createCommand($sql);
				$numlikes = $dbCommand->queryScalar();
				
				if($numlikes>0)
				{
					$sql = "Select max(`like`.createdAt) as likes from `like` where `like`.article=".$idarticulo."";
					$dbCommand = Yii::app()->db->createCommand($sql);
					$likes = $dbCommand->queryScalar();
					$mensajelike='El último me gusta fue el '.$likes.'. ';					
				}
				else {	
					
					$mensajelike='No ha recibido ningún me gusta. ';
					$likes='';				
				}

				$sql = "Select valor from tipo_notificacion_usuario where action='noacciones' and userid='".Yii::app()->user->getId()."'";
				$dbCommand = Yii::app()->db->createCommand($sql);	
				$dias = $dbCommand->queryScalar();			
				
				foreach ($dataArticle as $key => $value) 
				{

					$dataArticle[$key]['shares']=$shares;
					$dataArticle[$key]['visits']=$visits;
					$dataArticle[$key]['likes']=$likes;					
					
					$dataArticle[$key]['mensaje'] = utf8_encode('Su artículo <b>'.utf8_decode($dataArticle[$key]['title']).
					'</b>, publicado el <b>'.$dataArticle[$key]['createdAt'].'</b>, no ha sido utilizado hace más de <b>'.$dias.' días. </br>'.$mensajeshare.$mensajevisit.$mensajelike);
				}	
				
				echo json_encode($dataArticle);		
				Yii::app()->end();		
										
			break;
				
			case 'nopublicas':
				$sql = "Select DATEDIFF(NOW(), max(article.createdAt)) 
						from article
						Where article.creator=".Yii::app()->user->getId()."";
				$dbCommand = Yii::app()->db->createCommand($sql);
				$numerodias =$dbCommand->queryScalar();				
				
				$sql = "Select article.id, article.title, article.createdAt, user.name 
						From article, user 
						Where article.creator = user.id and user.id=".Yii::app()->user->getId()." 
						Having max(article.createdAt)";	
				$dbCommand = Yii::app()->db->createCommand($sql);
				$dataArticle = $dbCommand->queryAll();		
				
				
				foreach ($dataArticle as $key => $value) 
				{
					$dataArticle[$key]['dias']=$numerodias;	
					$dataArticle[$key]['mensaje'] = utf8_encode('No has publicado en <b>'.$numerodias.
					' días </b>, tu último artículo publicado fue <b>'.utf8_decode($dataArticle[$key]['title']). '</b>, el <b>'.$dataArticle[$key]['createdAt'].'</b>');								
				}			
							
				echo json_encode($dataArticle);		
				Yii::app()->end();
							
			break;			
				
			case 'shares':
			
			$sql = "Select articleid from notificaciones where idNotificacion =".$id."";
			$dbCommand = Yii::app()->db->createCommand($sql);
			$idarticulo =$dbCommand->queryScalar();	
			
			$sql = "Select article.id, article.title, article.createdAt, COUNT(share.id) as shares from article, share where share.article = article.id and article.id=".$idarticulo." Group By article.id";
			$dbCommand = Yii::app()->db->createCommand($sql);
			$dataArticle = $dbCommand->queryAll();	
			
			foreach ($dataArticle as $key => $value) 
			{					
				$dataArticle[$key]['mensaje'] = utf8_encode('El artículo <b>'.utf8_decode($dataArticle[$key]['title']).
				'</b> publicado el <b>'.$dataArticle[$key]['createdAt']. '</b>, ha alcanzado <b>'.$dataArticle[$key]['shares'].' compartidos</b>');								
			}	

			echo json_encode($dataArticle);		
			Yii::app()->end();
			
			break;
				
			case 'visits':
			
			$sql = "Select articleid from notificaciones where idNotificacion =".$id."";
			$dbCommand = Yii::app()->db->createCommand($sql);
			$idarticulo =$dbCommand->queryScalar();	
			
			$sql = "Select article.id, article.title, article.createdAt, COUNT(visit.id) as visits from article, visit where visit.article = article.id and article.id=".$idarticulo." Group By article.id";
			$dbCommand = Yii::app()->db->createCommand($sql);
			$dataArticle = $dbCommand->queryAll();
			
			
			foreach ($dataArticle as $key => $value) 
			{					
				$dataArticle[$key]['mensaje'] = utf8_encode('El artículo <b>'.utf8_decode($dataArticle[$key]['title']).
				'</b> publicado el <b>'.$dataArticle[$key]['createdAt']. '</b>, ha alcanzado <b>'.$dataArticle[$key]['visits'].' visitas</b>');								
			}

			echo json_encode($dataArticle);		
			Yii::app()->end();	
			
			break;
				
			case 'likes':
			
			$sql = "Select articleid from notificaciones where idNotificacion =".$id."";
			$dbCommand = Yii::app()->db->createCommand($sql);
			$idarticulo =$dbCommand->queryScalar();	
			
			$sql = "Select article.id, article.title, article.createdAt, COUNT(`like`.id) as likes from article, `like` where `like`.article = article.id and article.id=".$idarticulo." Group By article.id";
			$dbCommand = Yii::app()->db->createCommand($sql);
			$dataArticle = $dbCommand->queryAll();
						
			foreach ($dataArticle as $key => $value) 
			{					
				$dataArticle[$key]['mensaje'] = utf8_encode('El artículo <b>'.utf8_decode($dataArticle[$key]['title']).
				'</b> publicado el <b>'.$dataArticle[$key]['createdAt']. '</b>, ha alcanzado <b>'.$dataArticle[$key]['likes'].' gustados</b>');								
			}

			echo json_encode($dataArticle);		
			Yii::app()->end();			
			
			break;
			
			
			default:
				
				break;
		}
		
		
		$sql="SELECT YEAR(article.createdAt) as anio, COUNT(article.id) as total, 0 as cantidad
			 FROM notificaciones
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

	//Para ver el mensaje recibido
	public function actionVermensaje($id)
	{
		$sql = "SELECT user.name, message.idsend, message.subject, message.text, message.datesend
				FROM message, user 
				WHERE message.idsend=user.id and message.id=".$id."";
					
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();				
				  
		$this->render('vermensaje', array('dataProvider'=>$dataProvider));					
	}

	//Para ver el mensaje enviado
	public function actionVermensajeenviado($id)
	{
		$sql = "SELECT user.name, message.idreceive, message.subject, message.text, message.datesend
				FROM message, user 
				WHERE message.idreceive=user.id and message.id=".$id."";
					
		$dbCommand = Yii::app()->db->createCommand($sql);
		$dataProvider =$dbCommand->queryAll();				
				  
		$this->render('vermensajeenviado', array('dataProvider'=>$dataProvider));					
	}

	//Para compartir una notificaciï¿½n
	public function actionJSONcompartirnotificacion()
	{
		$this->layout=FALSE;
		header('Content-type: application/json');		
		
		$conexion = Yii::app()->db;	
					
		$idsend=$_POST['idsend']; 
		$idreceive = $_POST['idreceive'];
		$subject = $_POST['subject'];
		$text = $_POST['text'];
		$action = $_POST['action'];
		$id=$_POST['id'];
		$fecha = new CDbExpression('NOW()');
		
		//Segï¿½n el tipo de notificaciï¿½n sacar el detalla			
		switch ($action) {
			case 'nopublican':
				$sql = "Select DATEDIFF(NOW(), max(article.createdAt)) 
						from article";
				$dbCommand = Yii::app()->db->createCommand($sql);
				$numerodias =$dbCommand->queryScalar();
				
				$sql = "Select article.id, article.title, article.createdAt, user.name 
						From article, user 
						Where article.creator = user.id Having max(article.createdAt)";	
				$dbCommand = Yii::app()->db->createCommand($sql);
				$dataArticle = $dbCommand->queryAll();
				
				foreach ($dataArticle as $key => $value) 
				{
					//$dataArticle[$key]['dias']=$numerodias;
					$mensaje = utf8_encode('Ningún usuario ha publicado en <b>'.$numerodias.
					' días </b>, el último artículo publicado fue <b>'.utf8_decode($dataArticle[$key]['title']). '</b>, por el usuario <b>'.$dataArticle[$key]['name'].'</b>');														
				}					
				
			break;
				
			case 'noacciones':
				
				$sql = "Select articleid from notificaciones where idNotificacion =".$id."";
				$dbCommand = Yii::app()->db->createCommand($sql);
				$idarticulo =$dbCommand->queryScalar();
				
				$sql = "Select article.id, article.title, article.createdAt from article where id=".$idarticulo."";
				$dbCommand = Yii::app()->db->createCommand($sql);
				$dataArticle = $dbCommand->queryAll();				
				
				$sql = "Select max(share.createdAt) as shares from share where share.article=".$idarticulo."";
				$dbCommand = Yii::app()->db->createCommand($sql);
				$shares = $dbCommand->queryScalar();
				
				
				$sql = "Select max(visit.createdAt) as visits from visit where visit.article=".$idarticulo."";
				$dbCommand = Yii::app()->db->createCommand($sql);
				$visits = $dbCommand->queryScalar();
				
				$sql = "Select max(`like`.createdAt) as likes from `like` where `like`.article=".$idarticulo."";
				$dbCommand = Yii::app()->db->createCommand($sql);
				$likes = $dbCommand->queryScalar();			
				
				foreach ($dataArticle as $key => $value) 
				{
					$mensaje = utf8_encode('Su artículo <b>'.$dataArticle[$key]['title'].
					'</b>, publicado el <b>'.utf8_decode($dataArticle[$key]['createdAt']).'</b>, no ha sido utilizado en <b>'.'x '.'días. </br> El último compartido fue el '.$shares.'. La última visita fue el '.$visits.'. El último me gusta fue el '.$likes);						
				}					
										
			break;
				
			case 'nopublicas':
				$sql = "Select DATEDIFF(NOW(), max(article.createdAt)) 
						from article
						Where article.creator=".Yii::app()->user->getId()."";
				$dbCommand = Yii::app()->db->createCommand($sql);
				$numerodias =$dbCommand->queryScalar();				
				
				$sql = "Select article.id, article.title, article.createdAt, user.name 
						From article, user 
						Where article.creator = user.id and user.id=".Yii::app()->user->getId()." 
						Having max(article.createdAt)";	
				$dbCommand = Yii::app()->db->createCommand($sql);
				$dataArticle = $dbCommand->queryAll();		
				
				
				foreach ($dataArticle as $key => $value) 
				{						
					$mensaje = utf8_encode('No has publicado en <b>'.$numerodias.
					' días </b>, tu último artículo publicado fue <b>'.utf8_decode($dataArticle[$key]['title']). '</b>, el <b>'.$dataArticle[$key]['createdAt'].'</b>');													
				}		
							
			break;	
			
			case 'shares':
			
			$sql = "Select articleid from notificaciones where idNotificacion =".$id."";
			$dbCommand = Yii::app()->db->createCommand($sql);
			$idarticulo =$dbCommand->queryScalar();	
			
			$sql = "Select article.id, article.title, article.createdAt, COUNT(share.id) as shares from article, share where share.article = article.id and article.id=".$idarticulo." Group By article.id";
			$dbCommand = Yii::app()->db->createCommand($sql);
			$dataArticle = $dbCommand->queryAll();	
			
			foreach ($dataArticle as $key => $value) 
			{					
				$mensaje = utf8_encode('El artículo <b>'.$dataArticle[$key]['title'].
				'</b> publicado el <b>'.utf8_decode($dataArticle[$key]['createdAt']). '</b>, ha alcanzado <b>'.$dataArticle[$key]['shares'].' compartidos</b>');								
			}
			
			break;
				
			case 'visits':
			
			$sql = "Select articleid from notificaciones where idNotificacion =".$id."";
			$dbCommand = Yii::app()->db->createCommand($sql);
			$idarticulo =$dbCommand->queryScalar();	
			
			$sql = "Select article.id, article.title, article.createdAt, COUNT(visit.id) as visits from article, visit where visit.article = article.id and article.id=".$idarticulo." Group By article.id";
			$dbCommand = Yii::app()->db->createCommand($sql);
			$dataArticle = $dbCommand->queryAll();
			
			
			foreach ($dataArticle as $key => $value) 
			{					
				$mensaje = utf8_encode('El artículo <b>'.$dataArticle[$key]['title'].
				'</b> publicado el <b>'.$dataArticle[$key]['createdAt']. '</b>, ha alcanzado <b>'.utf8_decode($dataArticle[$key]['visits']).' visitas</b>');								
			}			
			
			break;
				
			case 'likes':
			
			$sql = "Select articleid from notificaciones where idNotificacion =".$id."";
			$dbCommand = Yii::app()->db->createCommand($sql);
			$idarticulo =$dbCommand->queryScalar();	
			
			$sql = "Select article.id, article.title, article.createdAt, COUNT(`like`.id) as likes from article, `like` where `like`.article = article.id and article.id=".$idarticulo." Group By article.id";
			$dbCommand = Yii::app()->db->createCommand($sql);
			$dataArticle = $dbCommand->queryAll();
						
			foreach ($dataArticle as $key => $value) 
			{					
				$mensaje = utf8_encode('El artículo <b>'.$dataArticle[$key]['title'].
				'</b> publicado el <b>'.utf8_decode($dataArticle[$key]['createdAt']). '</b>, ha alcanzado <b>'.$dataArticle[$key]['likes'].' gustados</b>');								
			}
					
			break;
			
			default:
				
			break;
		}
				
						
		$consulta = "INSERT INTO `message`(`idsend`, `idreceive`, `datesend`, `datereceive`, `subject`, `text`)";
		$consulta.=" VALUES($idsend,$idreceive, $fecha, $fecha, '$subject', '$mensaje')";
				
		$resultado = $conexion->createCommand($consulta)->execute();	
		
		//echo json_encode($dataArticle);	
		Yii::app()->end();		
	}

	//Para eliminar una notificaci?n
	public function actionJSONeliminarnotificacion($id)
	{
		$this->layout=FALSE;
		header('Content-type: application/json');		
		
		$conexion = Yii::app()->db;	
		
		$consulta = "Delete from notificaciones where idNotificacion=".$id."";
		$resultado = $conexion->createCommand($consulta)->execute();

		$sqlNumero = "SELECT count(*) FROM notificaciones where estado='enviado' and userid = '".$userid."'";
			
		$dbCommand = Yii::app()->db->createCommand($sqlNumero);
		$dataNumero =$dbCommand->queryScalar();
		//$this->setState('data', json_encode($dataNotificaciones));		
		Yii::app()->user->setState('numero', $dataNumero);
		
		Yii::app()->end();	
	}


}
