
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/bootstrap-datepicker.js"></script>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'imagen-form',
	'enableClientValidation'=>true,
        'htmlOptions'=>array('enctype'=>'multipart/form-data'),
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>	

	<div class="form-group">
		<div class="input-group">
			<?php echo $form->labelEx($model,'foto',array('class' =>'input-group-addon')); ?>
			<?php echo $form->fileField($model,'foto',array('size'=>60,'maxlength'=>255,'class'=>"form-control")); ?>
			
		</div>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Subir Imagen',array('class' => 'btn btn-primary	' )); ?>
		<button type="button" class="btn btn-default" id="btnCacelarFoto" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>

		<script type="text/javascript">
			 $(function() {
				"use strict";  
		        $('#btnCacelarFoto').on('click', function() {
				 
				        	$("#contImage").html("");
				        
				});
		    });
		</script>

	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
<?php if(Yii::app()->user->hasFlash("imagen")){?>
<div class="flash-success">    
    <?php echo CHtml::image(Yii::app()->request->baseUrl."".Yii::app()->user->getFlash("imagen"));?>    
</div>
<?php }?>