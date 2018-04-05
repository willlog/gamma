
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap-datepicker3.css" rel="stylesheet" type="text/css" />

<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/bootstrap-datepicker.js"></script>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-formpass',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<div id="contEditarUserConfpassError"></div>
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
	

			<!--<label class="input-group-addon required" for="User_password" type="hidden">Contraseña Actual--> 
			<span class="required" type="hidden">*</span></label>			
			<input size="60" maxlength="255" class="form-control" name="User[passworda]" id="User_passworda" type="hidden" value="">			
	
	<div class="form-group">
	<div class="input-group">
			<label class="input-group-addon required" for="User_password">Contraseña Nueva 
			<span class="required">*</span></label>			
			<input size="60" maxlength="255" class="form-control" name="User[passwordn]" id="User_passwordn" type="password" value="">			
	</div>
	</div>
	<div class="form-group">
		<div class="input-group">
			<?php echo $form->labelEx($model,'Confirmar Contraseña *',array('class' =>'input-group-addon')); ?>
			<?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>255,'class'=>"form-control")); ?>
			
		</div>
	</div>

	
	<div class="modal-footer clearfix">
		<button type="button" class="btn btn-default" id="btnCacelarAddUserConfPass" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>

		<?php echo CHtml::ajaxButton(
		    $label = 'Guardar',
		    $url = "js:$('#user-formpass').attr('action')", 
		    $ajaxOptions=array (
		        'type'=>'POST',
		        'success'=>'function(html){ 
		        				if(html.length>1){
		        					jQuery("#contEditarUserConfpass").html(html); 

		        				}else if(html.length==1){
		        					sms="<div class=\"alert alert-danger alert-dismissable\"><i class=\"fa fa-check\"></i><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button><b>Correcto!</b> Las contraseñas nuevas no coinside o estan vacia.</div>";
		        					jQuery("#contEditarUserConfpassError").html(sms); 
		        				}else{
		        					sms="<div class=\"alert alert-warning alert-dismissable\"><i class=\"fa fa-check\"></i><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button><b>Error!</b> Contraseña actual no coinside o esta vacia.</div>";
		        					jQuery("#contEditarUserConfpassError").html(sms); 
		        				}
		        				
		        				
		        							
		        			}'
		        ), 
		    $htmlOptions=array ('class'=>'btn btn-success pull-left ')
		    );
		?>
		<script type="text/javascript">
			 $(function() {
				"use strict";  
		        $('#btnCacelarAddUserConfPass').on('click', function() {
				 
				        	$("#contEditarUserConfpass").html("");
				      
				});
		    });
		</script>
		
	</div>

<?php $this->endWidget(); ?>






