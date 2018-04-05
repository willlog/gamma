<?php

class SiteController extends Controller
{
	public function accessRules()
	{
		return array(			
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index'),
				'roles'=>array('admin','user'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{		
		return array(			
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),		
			
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'	
		
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
		
		$msg="Hola mundo";
		$this->render('index',array('msg'=>$msg,'dataProvider'=>$dataProvider));
	}
	
	public function actionsolicitud($id)
	{
		$this->layout="//layouts/login";
		
		$numusuarioconsulta=User::model()->countByAttributes(array('uid'=>$id,'estadoCuenta'=>'consulta'));
		
		//echo CJavaScript::jsonEncode($numusuarioconsulta);
		//Yii::app()->end(); 
		if($numusuarioconsulta!=='0')
		{
		$conexion = Yii::app()->db;
									
		$consulta = "Select id FROM user WHERE estadoCuenta='consulta' and uid='".$id."'";		
		
		
		$resultado=$conexion->createCommand($consulta)->query();
				
		$resultado->bindColumn(1, $uid);
		
		
		
		while($resultado->read()!==false)
		{					
			$uid=$uid;					
		} 
		
		$model=User::model()->findByAttributes(
		    array('id'=>$uid)
		);	
		
		$this->render('solicitud',array(
			'model'=>$model,
		));
		}
		
		

	}
	
	public function actionUpdatesolicitud()
	{
		
		$items = '<br/><div class="alert alert-success alert-dismissable">										
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <b>Correcto!</b> Cuenta solicitada correctamente, el administrador revisará su cuenta.
                                    </div>';
		$numusuarioconsulta=User::model()->countByAttributes(array('id'=>$_POST["id"],'estadoCuenta'=>'consulta'));
		if($numusuarioconsulta!=='0')
		{			
			if(isset($_POST["id"]))
			{	
				$model=User::model()->findByPk(
				    $_POST["id"]
				);	
				
				$model->estadoCuenta = 'solicitada';
				
				$model->update();
				$this->layout=false;
				header('Content-type: application/json');
				
				echo CJavaScript::jsonEncode($items);
				Yii::app()->end();				
			}
		}
		
	}
	

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$this->layout="//layouts/login"; //Comente esta linea y aumente la siguiente
		//$this->layout="//layouts/colum1";
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}	
		
		// display the login form
		$this->render('login',array('model'=>$model));
	}
	
	public function actionLoginfacebook()
	{
		$model=new LoginForm;		
		
		$numusuario=User::model()->countByAttributes(array('email'=>$_POST['email']));
		
		if($numusuario!=='0')
		{
			$numusuarioconsulta=User::model()->countByAttributes(array('email'=>$_POST['email'],'status'=>'consumer'));
			$numusuariocancelado=User::model()->countByAttributes(array('email'=>$_POST['email'],'status'=>'cancel'));
			$numusuarioactiva=User::model()->countByAttributes(array('email'=>$_POST['email'],'status'=>'editor'));			
							
			
			if($numusuarioconsulta!=='0')
			{
				//Consta en sigma pero falta activar por administrador
				print_r('1');							
				Yii::app()->end();
			}
			
			if($numusuariocancelado!=='0')
			{
				//Cuenta cancelada por el administrador
				print_r('3');							
				Yii::app()->end();
			}			
			//print_r($numusuarioactiva);
			
			if($numusuarioactiva!='0')
			{
				
			if($model->loginfacebook($_POST['email']))
			{			
					
					$conexion = Yii::app()->db;
									
					$consulta = "Select id FROM user WHERE email='".$_POST['email']."'";
					$resultado=$conexion->createCommand($consulta)->query();
							
					$resultado->bindColumn(1, $id);
					
					
					while($resultado->read()!==false)
					{					
						$id=$id;					
					} 
					
					$consulta = "SELECT Count(*) FROM AuthAssignment WHERE userid='".$id."'";
					$resultado=$conexion->createCommand($consulta)->query();
										
					$resultado->bindColumn(1, $asig);
					
					while($resultado->read()!==false)
					{					
						$asig=$asig;					
					} 
					
					if($asig==='0')
					{
						Yii::app()->authManager->assign('user', $id);						
					}				
					
					print_r('2');							
					Yii::app()->end();
					
					//print_r('Usted esta habilitado para ingresar');
					//$this->redirect(Yii::app()->user->returnUrl);
					//$this->redirect(array('index'));				
				}			
				
				//$this->redirect(Yii::app()->user->returnUrl);
			}
		
		}	
		else 
		{
			print_r('0');							
			Yii::app()->end();			
		}
		
		//echo CJavaScript::jsonEncode($model);
		//Yii::app()->end();
		//$this->render('index');
	}
	
	public function actionRegistro()
	{
		$this->layout="//layouts/login";
		$model = new ValidarRegistro;
		$msg = '';
		
		if(isset($_POST['ajax'])&& $_POST['ajax']==='form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();			
		}			
		
		if(isset($_POST['ValidarRegistro']))
		{
			$model->attributes= $_POST['ValidarRegistro'];			
			
			if(!$model->validate())
			{
				$model->addError('repetir_password', 'Error al enviar el formulario');
			}	
			else
			{
				//Guardar el usuario
				$guardar = new ConsultasDB;
				$guardar->guardar_usuario($model->firstname.$model->lastname, $model->gender, $model->firstname, $model->lastname, $model->birthday,  $model->email, $model->password);
				
				//Enviar email		
				
				$subject = "Creación de cuenta en ".Yii::app()->name."";
				$message =  "Su cuenta ha sido creada en SOMAN y esta esperando activación por el administrador.";			
				
				$mail = new EnviarEmail;
				$mail -> Enviar_Email(
						array(Yii::app()->params['adminEmail'], Yii::app()->name),
						//array($model->email, $model->name),
						array($model->email, $model->firstname),
						$subject,
						$message		
				);
				
				//$model->name='';
				$model->firstname='';
				$model->lastname='';
				$model->birthday='';
				$model->email='';
				$model->password='';
				$model->repetir_password='';	
				
				
				$msg='Su cuenta ha sido creada y esta esperando activacion';	
				
			}		

		}
		$this->render('registro', array('model'=>$model, 'msg'=>$msg));		
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		//$this->redirect(Yii::app()->homeUrl);
		$this->redirect(array('login'));
	}
	
	public function actionRecuperarpassword()
	{
		$this->layout="//layouts/login";
		$model = new RecuperarPassword;
		$msg = '';
				
		if(isset($_POST["RecuperarPassword"]))
		{
			$model->attributes = $_POST['RecuperarPassword'];
			if(!$model->validate())
			{
				$msg="<strong class='text-error'>Error al enviar al formulario</strong>";				
			}
			else 
			{
				$conexion = Yii::app()->db;
				$id="";
				//Consulta y envia el email
				/*$consulta = "SELECT name, email from user WHERE ";
				$consulta.="name='".$model->name."' AND email='".$model->email."'";*/
				
				$consulta = "SELECT name, email from user WHERE ";
				$consulta.="email='".$model->email."'";
				
				$resultado = $conexion->createCommand($consulta);
				$filas = $resultado->query();
				$existe = false;
				
				foreach($filas as $fila)
				{
					$existe=true;
				}
				
				/*$consulta = "Select id FROM user WHERE name='".$model->name."' AND email='".$model->email."'";*/
				$consulta = "Select id FROM user WHERE email='".$model->email."'";
				$resultado=$conexion->createCommand($consulta)->query();
				
				$resultado->bindColumn(1, $id);
				
				while($resultado->read()!==false)
				{
					$id=$id;
				} 
		
				
				if($existe===true)
				{
					$password=rand(0, 99999);
					
					$consulta="Update user
								Set user.password='".sha1($password)."' 
								Where user.id=".$id."";										
				
					/*$consulta = "SELECT password from user WHERE ";
					$consulta.="name='".$model->name."' AND email='".$model->email."'";*/
					
					$resultado = $conexion->createCommand($consulta)->query();					
					
					$email = new EnviarEmail;
					
					$subject = "Has solicitado recuperar tu password en ";
					$subject.= Yii::app()->name;
					$message = "Bienvenido: ".$model->name." su usuario es ".$model->email." su contraseña es: ";
					$message.=$password;
					
					$email->Enviar_Email(
							array(Yii::app()->params['adminEmail'], Yii::app()->name), 
							array($model->email, $model->name),
							$subject, 
							$message
							);	
							
					$msg = "<strong class='text-error'> Se ha enviado un correo a tu email</strong>";
							
					$model->name='';
					$model->email='';
					$model->captcha='';					
				}
				else {
					
					$msg = "<strong class='text-error'> Error, email no existe</strong>";
				}				  
			}
		}
		
		$this->render('recuperarpassword', array('model'=>$model, 'msg'=>$msg));		
	}
}