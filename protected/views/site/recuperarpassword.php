<?php 
$this->pageTitle='Recuperar Password';

$this->breadcrumbs=array('Recuperar password');

 ?>
	<?php
	$form=$this->beginWidget('CActiveForm',
	array(
			'method'=>'POST',
			'action'=>Yii::app()->createUrl('site/recuperarpassword'),
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'ValidateOnSubmit'=>true,			
			),	
		));	
	  ?>	
	  

<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title>SOMAN | Recuperar Password</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
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

        <div class="form-box" id="login-box">
            <div class="header">Recuperar Contraseña</div>
            <form action="../../index.html" method="post">
                <div class="body bg-gray">
                	<label style="color: red"><?php echo $msg; ?></label>                	
                    <!--<div class="form-group">                    	
                    	<?php
					  	echo $form->LabelEx($model, 'name');	  
						echo $form->textField($model, 'name', array('class'=>'form-control', 'placeholder'=>'Usuario'));
						echo $form->error($model, 'name', array('style'=>'color:red'));	
					  	?>                        
                    </div>-->
                    <div class="form-group">
                    	<?php
					  	echo $form->LabelEx($model, 'email');	  
						echo $form->textField($model, 'email', array('class'=>'form-control', 'placeholder'=>'Email'));
						echo $form->error($model, 'email', array('style'=>'color:red'));	
					  	?>                        
                    </div>
                    <div class="form-group">
                    	<?php
					  	 echo $form->labelEx($model, 'captcha'); 
						 echo $form->textField($model, 'captcha', array('class'=>'form-control', 'placeholder'=>'Código'));
						  ?> 
						  <br>
						  <?php 
					  	 $this->widget('CCaptcha', array('buttonLabel'=>'Actualizar código'));		 
					  	 ?>                        
                    </div>
                    <?php echo $form->error($model, 'captcha', array('style'=>'color:red')) ?>
                </div>
                <div class="footer">  
                	<?php echo CHtml::submitButton('Recuperar', array('class'=>'btn bg-olive btn-block'));?>
      
                    <a href="login.html" class="text-center">Iniciar Sesión</a>
                </div>
            </form>           
        </div>
        <!-- jQuery 2.0.2 -->
        <script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.min.js"></script>

    </body>
</html>
<?php $this->endwidget();?>


