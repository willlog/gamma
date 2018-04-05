<?php
/* @var $this AuthitemController */
/* @var $model Authitem */
/* @var $form CActiveForm */
?>


<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.min.js"></script>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'authitem-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

<div  class="box-body">
		
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

	
	

	<div class="form-group">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>20,'maxlength'=>64,'class'=>'form-control')); ?>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->textField($model,'type',array('class'=>'form-control')); ?>
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>2, 'cols'=>20,'class'=>'form-control')); ?>
		



	<div class="form-group btn-group margin">
		<?php echo CHtml::ajaxButton(
		    $label = 'Guardar',
		    $url = "js:$('#authitem-form').attr('action')", 
		    $ajaxOptions=array (
		        'type'=>'POST',
		        'success'=>'function(html){ 
		        							$("#btnRefresRol").trigger( "click" );
		        							jQuery("#rolcontenido").html(html); 
		        			}'
		        ), 
		    $htmlOptions=array ('class'=>'btn btn-success ')
		    );
		?>
		<div id="btnrolcancel" class="btn btn-info ">Cancelar</div>
		<script type="text/javascript">
		    $(function() {
				"use strict";  
		        $('#btnrolcancel').on('click', function() {
				 
				    $("#rolcontenido").html("");
				       
				});
		    });
		</script>

	</div>
</div>
<?php $this->endWidget(); ?>
