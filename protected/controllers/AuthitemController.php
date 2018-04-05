<?php

class AuthitemController extends Controller
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
				'actions'=>array('index','indexa','view'),
				'roles'=>array('admin'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'roles'=>array('admin'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
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
		
		$a=$this->loadModel($id);
		
		$this->render('view',array(
			'model'=>$a,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$this->layout=false;
		$model=new Authitem;
		$items = '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <b>Correcto!</b> Rol guardado correctamente.
                                    </div>';
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Authitem']))
		{
			$model->attributes=$_POST['Authitem'];
			if($model->save()){
				$this->layout=false;
				header('Content-type: application/json');
				
				echo CJavaScript::jsonEncode($items);
				Yii::app()->end(); 


				$this->redirect(array('view','id'=>$model->name));
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
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <b>Correcto!</b> Rol guardado correctamente.
                                    </div>';

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Authitem']))
		{
			$model->attributes=$_POST['Authitem'];
			if($model->save())
				$this->layout=false;
				header('Content-type: application/json');
				
				echo CJavaScript::jsonEncode($items);
				Yii::app()->end(); 
				$this->redirect(array('view','id'=>$model->name));
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
		$items = '<div class="alert alert-danger alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <b>Correcto!</b> Rol eliminado correctamente.
                                    </div>';
		
		$this->loadModel($id)->delete();
		$this->layout=false;
		header('Content-type: application/json');
		
		echo CJavaScript::jsonEncode($items);
		Yii::app()->end(); 
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$data = Authitem::model()->findAll();
		$dataProvider=new CActiveDataProvider('Authitem');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,'data'=>$data
		));
	}
	
	public function actionIndexa()
	{
		$this->layout=false;
		$data = Authitem::model()->findAll();
		
		$this->render('indexa',array('data'=>$data
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Authitem('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Authitem']))
			$model->attributes=$_GET['Authitem'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Authitem the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Authitem::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Authitem $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='authitem-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
