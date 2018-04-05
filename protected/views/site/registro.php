<?php 
$this->pageTitle = 'Formulario de Registro';

$this->breadcrumbs = array('registro');

 ?>
	
<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">        
        <title>SOMAN | Registration Page</title>
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
 
        <div class="form-box" id="login-box">
            <div class="header">Registro de Usuario</div>
            <?php
					$form = $this->beginWidget('CActiveForm', array(
					'method'=>'post',
					'action'=>Yii::app()->createUrl('site/registro'),
					'id'=>'form',
					'enableClientValidation'=>true,
					'enableAjaxValidation'=>true,
					'clientOptions'=>array(
						'validateOnSubmit'=>true,
						),
					));
				  	?>	

            <form action="../../index.html" method="post">
            	   <body class="bg-black">
			    
                <div class="body bg-gray">
                	<strong class='text-info'><?php echo $msg; ?></strong>
                    <!--<div class="form-group">
                    	
                    	<?php
						//echo $form->labelEx($model, 'Usuario *');
						//echo $form->textField($model, 'name', array('class'=>'form-control', 'placeholder'=>'Usuario'));
						//echo $form->error($model, 'name', array('style'=>'color:red'));
						?>                        
                    </div>-->
                    <div class="form-group">
                    	<?php
						echo $form->labelEx($model, 'Nombre *');
						echo $form->textField($model, 'firstname', array('class'=>'form-control', 'placeholder'=>'Nombre'));
						echo $form->error($model, 'firstname', array('style'=>'color:red'));
						?>                        
                    </div>
                    <div class="form-group">
                    	<?php
						echo $form->labelEx($model, 'Apellido *');
						echo $form->textField($model, 'lastname', array('class'=>'form-control', 'placeholder'=>'Apellido'));
						echo $form->error($model, 'lastname', array('style'=>'color:red'));
						?>                        
                    </div>
                    <div class="form-group">
                    	<?php
						echo $form->labelEx($model, 'F. Nacimiento *');
						?>
						<br>
						<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
				    		'model' => $model,
				    		'attribute' => 'birthday',				    		
				    		//'class'=>  'form-control', 
				    		//'placeholder'=>'Fecha Nacimiento', 		
				    		'htmlOptions' => array(										    		
										    		'constraitInput'=>'false',										    												    		
										       		'size' => '50',         // textField size
										        	'maxlength' => '10',    // textField maxlength
										        	'class'=>'form-control',
										        	'placeholder'=>'Fecha Nacimiento'
										        	
						    ),
						    'options'=>array(
											    'dateFormat'=>'yy-mm-dd',
											    'yearRange'=>'-70:+0',
												'changeYear'=>'true',
												'defaultDate'=>'1960-01-01'
											),
						));
						?>	
						<?php						
						echo $form->error($model, 'birthday', array('style'=>'color:red'));
						?>                        
                    </div>
                    <div class="form-group">
                    	<?php
						echo $form->labelEx($model, 'Genero *');
						echo $form->dropDownList($model,'gender',array('male'=>'Masculino', 'female'=>'Femenino'), array('class'=>'form-control'));
						echo $form->error($model, 'gender', array('style'=>'color:red'));
						?>                       
                    </div>                    
                    <div class="form-group">
                    	<?php
						echo $form->labelEx($model, 'Email *');
						echo $form->textField($model, 'email', array('class'=>'form-control', 'placeholder'=>'Email'));
						echo $form->error($model, 'email', array('style'=>'color:red'));
						?>                      
                    </div>
                    <div class="form-group">                    	
						<?php
						echo $form->labelEx($model, 'Contrasenia *');
						echo $form->passwordField($model, 'password', array('class'=>'form-control', 'placeholder'=>'Contraseña'));
						echo $form->error($model, 'password', array('style'=>'color:red'));
						?>                     
                    </div>
                    
                      <div class="form-group">                    	
						<?php
						echo $form->labelEx($model, 'Repetir Contrasenia *');
						echo $form->passwordField($model, 'repetir_password',array('class'=>'form-control', 'placeholder'=>'Repetir Contraseña'));
						echo $form->error($model, 'repetir_password', array('style'=>'color:red'));
						?>                     
                    </div>
                </div>
                <div class="footer">     
                	<?php
					echo CHTml::submitButton("Registrarme", array('class'=>'btn bg-olive btn-block'));
					?> 
                    <?php echo CHtml::link('Tengo una cuenta',array('site/login')); ?>               
                </div>
                
            </form>
<?php $this->endWidget();  ?>
           
        </div>
        <!-- jQuery 2.0.2 -->
        <script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.min.js"></script>

    </body>
</html>


