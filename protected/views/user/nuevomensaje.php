<!-- jQuery 2.0.2 -->
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/datatables/dataTables.tableTools.css" rel="stylesheet" type="text/css" />
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/bootstrap-datepicker.js"></script>
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap-datepicker3.css" rel="stylesheet" type="text/css" />
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/dataTables.bootstrap.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/dataTables.tableTools.js"></script>

<script src="js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
<script src="js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
<script src="js/plugins/jqueryKnob/jquery.knob.js" type="text/javascript"></script>
<script src="/gamma/themes/classic/js/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>

<section class="content">
   
<div class="col-sm-12">
	
	<div class="table-responsive" id="tableArticles">	
		
		<div class="box box-info">
		<input id ="userid" value="0" hidden="hidden"/>
		<input id ="myid" value="<?php echo Yii::app()->user->getId();?>" hidden="hidden"/>
		<div class="box-header" style="cursor: move;">
		    <i class="fa fa-envelope"></i>
		    <h3 class="box-title">Mensaje</h3>		   
		</div>
		<div class="box-body">
		    <form action="#" method="post">
		        <div class="form-group">		        	
		        	Para: <label id="lblUser"></label>	        	
		        	<input id="user" type="email" class="form-control" name="emailto" placeholder="Para:" >		            
		            <div id="contenidoDeUser">						
					</div>
		        </div>
		        <div class="form-group">
		            <input id="subject" type="text" class="form-control" name="subject" placeholder="Asunto:">
		        </div>
		        <div>
		            <ul class="wysihtml5-toolbar">                            	
		
		<li>
		  <div class="bootstrap-wysihtml5-insert-image-modal modal fade">
		    <div class="modal-dialog">
		      <div class="modal-content">
		        <div class="modal-header">
		          <a class="close" data-dismiss="modal">×</a>
		          <h3>Insert image</h3>
		        </div>
		        <div class="modal-body">
		          <input value="http://" class="bootstrap-wysihtml5-insert-image-url form-control">
		        </div>
		        <div class="modal-footer">
		          <a class="btn btn-default" data-dismiss="modal">Cancel</a>
		          <a class="btn btn-primary" data-dismiss="modal">Insert image</a>
		        </div>
		      </div>
		    </div>
		  </div>
		 
		</li>
		</ul>
		<input id="text" type="text"  name="subject" placeholder="Mensaje" style="width: 100%; height: 125px;">
		<!--<textarea  style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid rgb(221, 221, 221); padding: 10px; display: none;" ></textarea><input type="hidden"  value="1"><iframe allowtransparency="true" frameborder="0" width="0" height="0" marginwidth="0" marginheight="0" style="display: inline-block; background-color: rgb(255, 255, 255); border-collapse: separate; border-color: rgb(221, 221, 221); border-style: solid; border-width: 1px; clear: none; float: none; margin: 0px; outline: rgb(0, 0, 0) none 0px; outline-offset: 0px; padding: 10px; position: static; top: auto; left: auto; right: auto; bottom: auto; z-index: auto; vertical-align: top; text-align: start; box-shadow: none; border-radius: 0px; width: 100%; height: 125px;"></iframe>-->
		            </div>
		        </form>
		    </div>
		    <div class="box-footer clearfix">
		        <button class="pull-right btn btn-default" id="sendEmail">Enviar <i class="fa fa-arrow-circle-right"></i></button>
		    </div>
		</div>

	            
	</div><!-- /.box-body -->
 </div>	
 
</section><!-- /.content -->





<script type="text/javascript">

$.noConflict();			
	jQuery(document).ready(function($){
		"use strict";	
		$("#sendEmail").on("click",function () {
			$.ajax({				
        		type: "POST",        		
        		url: "JSONenviarmensaje/",        		
				data: {'idsend':$("#myid").val(), 'idreceive':$("#userid").val(), 'subject':$("#subject").val(), 'text':$("#text").val()},				
        		success: function(response, status) {	        	
		        	$("#user").val("");
		        	$("#subject").val("");	
		        	$("#text").val("");      	
		        },
		        error: function (response, status) {		            
		            $("#user").val("");
		          	$("#subject").val("");	 
		        	$("#text").val("");     
		        },
			});
			
		});
		
		$("#user").keyup(function () {	
			if($("#user").val()=="")	
			{
				$("#contenidoDeUser").html("");
			}	
			$.ajax({				
				type: "GET",
        		url: "indexbuscarusuarios/"+$("#user").val(),
        		success: function(response, status) {
        			
		        	//$("#contenidoDeUser").html(response);
		        	$("#contenidoDeUser").html(response);
		        },
		        error: function (response, status) {
		                //alert("Error");
		        },		        
			});			
		});
	});
</script> 