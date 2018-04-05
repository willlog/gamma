<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap-datepicker3.css" rel="stylesheet" type="text/css" />
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/bootstrap-datepicker.js"></script>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'category-form',
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

	<div class="form-group">
		<div class="input-group">
			<?php echo $form->labelEx($model,'name',array('class' =>'input-group-addon')); ?>
			<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255,'class'=>"form-control")); ?>
			
		</div>
	</div>

	<div class="form-group">
		<div class="input-group">
			<?php echo $form->labelEx($model,'description',array('class' =>'input-group-addon')); ?>
			<?php echo $form->textField($model,'description',array('size'=>60,'maxlength'=>255,'class'=>"form-control")); ?>
			
		</div>
	</div>	
	
	<div class="modal-footer clearfix">
		<button type="button" class="btn btn-default" id="btnCacelarAddUser" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>

		<?php echo CHtml::ajaxButton(
		    $label = 'Guardar',
		    $url = "js:$('#category-form').attr('action')", 
		    $ajaxOptions=array (
		        'type'=>'POST',
		        'success'=>'function(html){ 
		        				
		        		jQuery("#cntAddCategoriasTotal").html(html); 
								
						$.ajax({
		        		type: "GET",
		        		url: "indexs/",
		        		success: function(response, status) {
		        			$("#tblOpcionesDeUsuarios").html(response);
				        },
				        error: function (response, status) {
				                alert("Error");
				        },
					});
		        							
		        			}'
		        ), 
		    $htmlOptions=array ('class'=>'btn btn-success pull-left ')
		    );
		?>

		
	</div>
<?php $this->endWidget(); ?>

