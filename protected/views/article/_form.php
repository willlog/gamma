<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'article-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
	//'enableClientValidation'=>true,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),	
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
			<?php echo $form->labelEx($model,'title',array('class' =>'input-group-addon')); ?>
			<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255,'class'=>"form-control")); ?>
		</div>
	</div>
	
	<div class="form-group">
		<div class="input-group">
			<?php echo $form->labelEx($model,'description',array('class' =>'input-group-addon')); ?>
			<?php echo $form->textArea($model,'description',array('size'=>60,'maxlength'=>255,'class'=>"form-control",'rows' => 6, 'cols' => 50)); ?>
			 
		</div>
	</div>

	<div class="form-group">		
		<strong style="color: red" class='text-info'><?php echo $msg; ?></strong>
		<div class="input-group">
			<?php echo $form->labelEx($model,'url',array('class' =>'input-group-addon')); ?>
			<?php echo $form->textField($model,'url',array('size'=>60,'maxlength'=>255,'class'=>"form-control")); ?>
		</div>
	</div>	
	<div class="form-group">
		<div class="input-group">
			<?php echo $form->labelEx($model,'state',array('class' =>'input-group-addon')); ?>
			<?php echo $form->dropDownList($model,'state',array('create'=>'Habilitado', 'disable'=>'Deshabilitado'), array('class'=>'form-control')); ?>
			
		</div>
	</div>
	
	<div class="form-group">
		<div class="input-group">		
			<?php 
		        echo $form->labelEx($model, 'picture');
		        echo $form->fileField($model, 'picture', array('type'=>'file','class'=>"form-control"));
		        echo $form->error($model, 'picture');
		    ?>		
	</div>
	</div>	

	<div class="form-group">
		<div class="input-group">
			
			<?php echo $form->hiddenField($model,'valores',array('size'=>60,'type'=>'hidden','maxlength'=>255,'class'=>"form-control")); ?>
		</div>
	</div>

	

	<div class="row">
		<div class="box box-primary">
            <div class="box-header">
                <div class="btn-group">
	            	<div class=' btn bg-navy' ><i class="fa  fa-check-square-o"></i> Asignada</div>
	            	<div class=' btn btn-danger'><i class="fa  fa-square-o"></i>No Asignada</div>
                </div>
            </div>
            <div class="box-body">
            	 <h4 class="box-title">Categorías</h4>
                <!-- the events -->
                
                <div id='external-events'>
                	<?php foreach ($data as $key => $value) { ?>

                		<div class='external-event bg-red btnCategoriasarticle' value="<?php echo $value->id; ?>"> <?php echo $value->name; ?></div>
                	<?php } ?>                                        
                    
                    
                    <p>
                       <div id="jsonatvle"></div> 
                    </p>
                </div>
            
            <div class="row buttons">
		
	</div>
            </div><!-- /.box-body -->
        </div><!-- /. box -->
	</div>

	<?php $this->endWidget(); ?>
	<div class="modal-footer clearfix">
		<button type="button" class="btn btn-default" id="btnCacelarAddCategoria" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
		
		<?php echo CHtml::htmlButton('Guardar',array(
	                'id'=> 'post-submit-btn', // button id
	                'class'=>'btn btn-success pull-left',
	            ));
	    ?>
		<script type="text/javascript">
		function uploadImage() {
	        $("#Article_picture").click();
	        return false;        
			}
		</script>
	</div>






</div><!-- form -->


<script type="text/javascript">
    $(function() {
		"use strict";

		var jsonObj = $('#Article_valores').val();
		var ponervalores=jsonObj.split(",");

		$(".btnCategoriasarticle").each(function(){
   			  		

	        var valorASumar=$(this).attr("value");

	        for (var i = 0; i < ponervalores.length; i++) {
	        	if(ponervalores[i]==valorASumar){
	        		$(this).removeClass();
   			  		$(this).addClass('btn external-event bg-navy btnCategoriasarticle');
	        	}
	        	
	        };
	        
	    });

		

	$('#post-submit-btn').on('click', function () {
	    var formData = new FormData($("#article-form")[0]);
	    $.ajax({
	        url: $('#article-form').attr('action'),
	        type: 'POST',
	        data: formData,
	        beforeSend: function() {
	            // do some loading options
	        },
	        success: function (data) {
	            // on success do some validation or refresh the content div to display the uploaded images 
	            //alert(data);
	            $("#cntAddArticlesTotal").html(data);
	            $.ajax({
	        		type: "GET",
	        		url: "indexs/",
	        		success: function(response, status) {
	        			$("#tableArticles").html(response);
			        },
			        error: function (response, status) {
			                alert("Error");
			        },
				});
	        },
	 
	        complete: function() {
	            // success alerts
	        },
	 
	        error: function (data) {
	          
	        },
	        cache: false,
	        contentType: false,
	        processData: false
	    });
	 
	    return false;
	});



		
		$('.btnCategoriasarticle').on('click', function () {
			 // var myClass = $(this).attr("class");
			  if ($(this).hasClass("bg-red")) {
   			  	$(this).removeClass();
   			  	$(this).addClass('btn external-event bg-navy btnCategoriasarticle');
   			  }else{
   			  	$(this).removeClass();
   			  	$(this).addClass("external-event bg-red btnCategoriasarticle");
   			  };
   			  var indice=0;
   			  var resultado=[];
   			  $(".btnCategoriasarticle").each(function(){
   			  		
   			  		var prueba = $(this).attr("class");

			        var valorASumar=$(this).attr("value");
			        if ($(this).hasClass("bg-navy")) {
			        	resultado[indice]=valorASumar;
			        	indice=indice+1;
			    	};
			   });
				
   			   $('#Article_valores').val(resultado);
   			  

   				
		});
	});
</script>


