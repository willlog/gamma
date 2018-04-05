<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.min.js"></script>

<div  class="box-body">
	<?php
	/* @var $this AuthitemController */
	/* @var $model Authitem */

	$this->breadcrumbs=array(
		'Authitems'=>array('index'),
		$model->name,
	);

	$this->menu=array(
		array('label'=>'List Authitem', 'url'=>array('index')),
		array('label'=>'Create Authitem', 'url'=>array('create')),
		array('label'=>'Update Authitem', 'url'=>array('update', 'id'=>$model->name)),
		array('label'=>'Delete Authitem', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->name),'confirm'=>'Are you sure you want to delete this item?')),
		array('label'=>'Manage Authitem', 'url'=>array('admin')),
	);
	?>
	<?php $this->widget('zii.widgets.CDetailView', array(
		'htmlOptions'=> array('class' =>'table table-bordered'),
		'data'=>$model,
		'attributes'=>array(
			'name',
			'type',
			'description',
			
		),
	)); ?>
	<div class="btn-group margin">
			<button class="btn" id="btnEditarDatosRol" value="<?php echo $model->name ?>"><i class="fa fa-edit fa-lg"></i></button>
			<button class="btn" data-toggle="modal" data-target="#compose-modal"><i class="fa fa-trash-o"></i></button>
	</div>

	<div class="modal fade " id="compose-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-trash-o"></i> Eliminar rol <?php echo $model->name; ?></h4>
                    </div>
                    <div class="modal-body">
                    	<h4> Esta segura que desea eliminar el rol <span class="label label-success"><?php echo $model->name; ?></span> </h4><hr> 
                    </div>
                    <div class="modal-footer clearfix">

                        <button id="btnEliminarRol" type="button" class="btn btn-danger" value="<?php echo $model->name ?>" data-dismiss="modal"><i class="fa fa-times"></i> Eliminar</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

	<script type="text/javascript">
		    $(function() {
				"use strict"; 
				
		        $('#btnEditarDatosRol').on('click', function() {
				 	
				   // $("#rolcontenido").html($(this).attr("value"));
				    $.ajax({
		        		type: "GET",
		        		url: "update/"+$(this).attr("value"),
		        		success: function(response, status) {
				        	$("#rolcontenido").html(response);
				        },
				        error: function (response, status) {
				                alert("Error");
				        },
					});
				       
				});

				$('#btnEliminarRol').on('click', function() {
				 	
				   // $("#rolcontenido").html($(this).attr("value"));
				    $.ajax({
		        		type: "POST",
		        		url: "delete/"+$(this).attr("value"),
		        		success: function(response, status) {
		        			$("#btnRefresRol").trigger( "click" );
				        	$("#rolcontenido").html(response);
				        },
				        error: function (response, status) {
				                alert("Error");
				        },
					});
				       
				});
		    });
		</script>
</div>	