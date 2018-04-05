 <link href="<?php echo Yii::app()->theme->baseUrl;?>/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        
<!-- font Awesome -->
<link href="<?php echo Yii::app()->theme->baseUrl;?>/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<!-- Theme style -->
<link href="<?php echo Yii::app()->theme->baseUrl;?>/css/AdminLTE.css" rel="stylesheet" type="text/css" />
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap-datepicker3.css" rel="stylesheet" type="text/css" />

<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/bootstrap-datepicker.js"></script>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'solicitud-form',
	'action'=>'/redsocial/site/updatesolicitud',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

  
</div>
<div class="form-box" id="login-box">
            <div class="header">Solicitud de Activación</div>
            	<div id="sms" class="body bg-gray">
            								
							<?php echo $form->hiddenField($model,'id',array('disabled'=>'true','size'=>60,'maxlength'=>255,'class'=>"form-control")); ?>						
													
							<?php echo $form->hiddenField($model,'uid',array('disabled'=>'true','size'=>60,'maxlength'=>255,'class'=>"form-control")); ?>
							
						
				   <div class="form-group">
						<div class="input-group">
							<?php echo $form->labelEx($model,'firstname',array('class' =>'input-group-addon')); ?>
							<?php echo $form->textField($model,'firstname',array('disabled'=>'true','size'=>60,'maxlength'=>255,'class'=>"form-control")); ?>
							
						</div>
					</div>
				
					<div class="form-group">
						<div class="input-group">
							<?php echo $form->labelEx($model,'lastname',array('class' =>'input-group-addon')); ?>
							<?php echo $form->textField($model,'lastname',array('disabled'=>'true','size'=>60,'maxlength'=>255,'class'=>"form-control")); ?>
							
						</div>
					</div>
				
					<div class="form-group">
						<div class="input-group">
							<?php echo $form->labelEx($model,'fechaNac',array('class' =>'input-group-addon')); ?>
							<?php echo $form->textField($model,'fechaNac',array('disabled'=>'true','class'=>"form-control",'data-date-format'=>"yyyy/mm/dd")); ?>
							
						</div>		
					</div>
					
					<div class="form-group">
						<div class="input-group">
							<?php echo $form->labelEx($model,'email',array('class' =>'input-group-addon')); ?>
							<?php echo $form->textField($model,'email',array('disabled'=>'true','size'=>30,'maxlength'=>255,'class'=>"form-control")); ?>			
						</div>
					</div>
	
            		<?php echo CHtml::ajaxButton(
						    $label = 'Solicitar',
						    $url = "updatesolicitud",
						   
						    $ajaxOptions=array (
						        'type'=>'POST',
						   		'data'=>array('id'=>'js:$("#User_id").val()'),     
						        'success'=>'function(html){ 
						        				
						        				jQuery("#sms").html(html);
						        				
						        							
						        			}'
						        ), 
						    $htmlOptions=array ('class'=>'btn bg-olive btn-block', 'style'=>'background-color: #FF9900')
						    );
						?>
            		
        		</div>
    		
		</div>	
<?php $this->endWidget(); ?>