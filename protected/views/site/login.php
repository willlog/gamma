<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title>SOMAN | Log in</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <script type="text/javascript" src="//connect.facebook.net/en_US/sdk.js"></script>
        <!-- bootstrap 3.0.2 -->
        <link href="<?php echo Yii::app()->theme->baseUrl;?>/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        
        <!-- font Awesome -->
        <link href="<?php echo Yii::app()->theme->baseUrl;?>/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?php echo Yii::app()->theme->baseUrl;?>/css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="bg-black">
    	
    	<script>
			// Load the SDK asynchronously
		  (function(d, s, id) {
		    var js, fjs = d.getElementsByTagName(s)[0];
		    if (d.getElementById(id)) return;
		    js = d.createElement(s); js.id = id;
		    js.src = "//connect.facebook.net/en_US/sdk.js";
		    fjs.parentNode.insertBefore(js, fjs);
		  }(document, 'script', 'facebook-jssdk'));			   
		</script>

        <div class="form-box" id="login-box">
            <div class="header">Inicio de Sesión</div>
            <form action="../../index.html" method="post">
                <div class="body bg-gray">
                    <div class="form-group">
                    	<?php echo $form->labelEx($model,'username'); ?>
						<?php echo $form->textField($model,'username', array('class'=>'form-control', 'placeholder'=>'Correo Electrónico')); ?>
						<?php echo $form->error($model,'username', array('style'=>'color:red')); ?>
                        <!--<input type="text" name="userid" class="form-control" placeholder="User ID"/>-->
                    </div>
                    <div class="form-group">
                    	<?php echo $form->labelEx($model,'password'); ?>
						<?php echo $form->passwordField($model,'password', array('class'=>'form-control','placeholder'=>'Contraseña')); ?>
						<?php echo $form->error($model,'password', array('style'=>'color:red')); ?>
                        <!--<input type="password" name="password" class="form-control" placeholder="Password"/>-->
                    </div>          
                    <div class="form-group">
                    	<?php echo $form->checkBox($model,'rememberMe'); ?>
						<?php echo $form->label($model,'rememberMe'); ?>
						<?php echo $form->error($model,'rememberMe'); ?>                        
                    </div>
                </div>
                <div class="footer">      
                	<?php echo CHtml::submitButton('Ingresar', array('class'=>'btn bg-olive btn-block', 'style'=>'background-color: #FF9900')); ?>                                                         
                    <!--<button type="submit" class="btn bg-olive btn-block">Sign me in</button>-->                   
                                      
                    <a href="<?php echo Yii::app()->createUrl("site/recuperarpassword"); ?>">
						Olvide mi contraseña
					</a>
					<br>
					<?php echo CHtml::link('Registrate',array('site/registro')); ?>                   
                </div>
            </form>			
            <div class="margin text-center">
                <span>Ingresa utilizando una red social</span>
                <br/>
                <button href="#" id="login" class="btn bg-light-blue btn-circle"><i class="fa fa-facebook"></i></button>                               
                <!--<button class="btn bg-aqua btn-circle"><i class="fa fa-twitter"></i></button>-->
                <!--<button class="btn bg-red btn-circle"><i class="fa fa-google-plus"></i></button>-->
				
            </div>
            
            <div id="prueba" ></div>
            
        </div>	
	
        <!-- jQuery 2.0.2 -->
        <script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
        <!--Conexion Facebook -->
        <script src="<?php echo Yii::app()->theme->baseUrl;?>/js/main.js"></script>
	
    </body>
</html>

<?php $this->endWidget(); ?>
