<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap-datepicker3.css" rel="stylesheet" type="text/css" />
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/bootstrap-datepicker.js"></script>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	
	<?php if (!empty($model->errors)) { ?>
		<div class="alert alert-warning alert-dismissable">
                                        <i class="fa fa-warning"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <b>Alertas! </b>   <?php $c=0; foreach ($model->errors as $key => $value) {
															if($c==0)
																echo ($value[0]);
															$c++;
														} ?>
                                    </div>


	<?php }  ?>

	<!--<div class="form-group">
		<div class="input-group">
			<?php echo $form->labelEx($model,'provider',array('class' =>'input-group-addon')); ?>
			<?php echo $form->textField($model,'provider',array('size'=>60,'maxlength'=>255,'class'=>"form-control")); ?>
			
		</div>
	</div>-->

	<!--<div class="form-group">
		<div class="input-group">
			<?php echo $form->labelEx($model,'uid',array('class' =>'input-group-addon')); ?>
			<?php echo $form->textField($model,'uid',array('size'=>60,'maxlength'=>255,'class'=>"form-control")); ?>
			
		</div>
	</div>-->

	<!--<div class="form-group">
		<div class="input-group">
			<?php echo $form->labelEx($model,'name',array('class' =>'input-group-addon')); ?>
			<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255,'class'=>"form-control")); ?>
			
		</div>
	</div>-->
	
	<div class="form-group">
		<div class="input-group">
			<?php echo $form->labelEx($model,'firstname',array('class' =>'input-group-addon')); ?>
			<?php echo $form->textField($model,'firstname',array('size'=>60,'maxlength'=>255,'class'=>"form-control")); ?>
			
		</div>
	</div>

	<div class="form-group">
		<div class="input-group">
			<?php echo $form->labelEx($model,'lastname',array('class' =>'input-group-addon')); ?>
			<?php echo $form->textField($model,'lastname',array('size'=>60,'maxlength'=>255,'class'=>"form-control")); ?>
			
		</div>
	</div>

	<div class="form-group">
		<div class="input-group">
			<?php echo $form->labelEx($model,'birthday',array('class' =>'input-group-addon')); ?>
			<?php echo $form->textField($model,'birthday',array('class'=>"form-control",'data-date-format'=>"yyyy/mm/dd", 'readonly'=>'true')); ?>
			
		</div>
		<script type="text/javascript">
		    $(function() {
				"use strict";
				$('#User_birthday').datepicker({
					language: "es",

				});  
			});
		</script>
	</div>


	<div class="form-group">
		<div class="input-group">
			<?php echo $form->labelEx($model,'gender',array('class' =>'input-group-addon')); ?>
			<?php echo $form->dropDownList($model,'gender',array('male'=>'Masculino', 'female'=>'Femenino'), array('class'=>'form-control')); ?>
			
		</div>
	</div>

	<div class="form-group">
		<div class="input-group">
			<?php echo $form->labelEx($model,'email',array('class' =>'input-group-addon')); ?>
			<?php echo $form->textField($model,'email',array('size'=>30,'maxlength'=>255,'class'=>"form-control")); ?>
			
		</div>
	</div>

	<!--<div class="form-group">
		<div class="input-group">
			<?php echo $form->labelEx($model,'profileUrl',array('class' =>'input-group-addon')); ?>
			<?php echo $form->textField($model,'profileUrl',array('size'=>45,'maxlength'=>45,'class'=>"form-control")); ?>
			
		</div>
	</div>-->

	<div class="form-group">
		<div class="input-group">
			<?php echo $form->labelEx($model,'password',array('class' =>'input-group-addon')); ?>
			<?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>255,'class'=>"form-control")); ?>
			
		</div>
	</div>	

	<div class="modal-footer clearfix">
		<button type="button" class="btn btn-default" id="btnCacelarAddUser" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>

		<?php echo CHtml::ajaxButton(
		    $label = 'Guardar',
		    $url = "js:$('#user-form').attr('action')", 
		    $ajaxOptions=array (
		        'type'=>'POST',
		        'success'=>'function(html){ 
		        				
		        				jQuery("#cntContenidoDeAddUserFull").html(html); 
		        							
		        			}'
		        ), 
		    $htmlOptions=array ('class'=>'btn btn-success pull-left ')
		    );
		?>

		
	</div>

<?php $this->endWidget(); ?>