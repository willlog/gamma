<!-- jQuery 2.0.2 -->
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/datatables/dataTables.tableTools.css" rel="stylesheet" type="text/css" />
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap-datepicker3.css" rel="stylesheet" type="text/css" />
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/bootstrap-datepicker.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/dataTables.bootstrap.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/dataTables.tableTools.js"></script>

<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/html2canvas.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/html2canvas.svg.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jspdf.js"></script>
<?php $this->setPageTitle("MENSAJE"); ?>
<section class="content">
<input id ="myid" value="<?php echo Yii::app()->user->getId();?>" hidden="hidden"/>
<div class="row">
    <div class="col-md-11 alpha omega ">
    <div id="recursoeducativo" class="panel  panel-default">
    <div class="panel-heading">
        <i class="fa fa-envelope-o"></i> MENSAJE RECIBIDO    
        <div class="pull-right">
            <div class="btn-group">
                
            </div>
        </div>    
    </div>
    <!-- /.panel-heading -->
    <div class="panel-body"> 
    <table  width="100%">
		<thead>		
		</thead>		
		<tbody>
		<?php foreach ($dataProvider as $key => $value) { ?>
			<tr>		
				<td width="50px"><label>De: </label></td>		
				<td><input id="user" type="email" class="form-control" name="emailto" value="<?php echo $value['name']; ?>" disabled>
					<input id ="userid" value="<?php echo $value['idsend']; ?>" hidden="hidden" />
				</td>
			</tr>
			<tr>		
				<td width="50px"><label>Asunto: </label></td>		
				<td><input id="subject" type="email" class="form-control" name="emailto" value="<?php echo $value['subject']; ?>" disabled></td>
			</tr>
			<tr>		
				<td width="50px"><label>Fecha: </label></td>		
				<td id="estid"><input id="user" type="email" class="form-control" name="emailto" value="<?php echo $value['datesend']; ?>" disabled></td>
			</tr>
			<tr>		
				<td width="50px"><label></label></td>		
				<td></td>
			</tr>
			<tr>		
				<td width="40px"></td>						
				<td bgcolor="#E6E6E6"><div id='panel1' class="panel-body"><?php echo $value['text']; ?> </div></td>
			</tr>
			<tr>			
								
			</tr>
		<?php } ?>		
		</tbody>
	</table> 
	<br>
	<div class="box-footer clearfix">
        <button class="pull-right btn btn-default" id="btnResponder"><i class="fa fa-mail-reply"></i> Responder </button>
    </div>
    <!-- /.panel-body -->    
    <!-- /.panel-footer -->
    <br>
    
    <div id='pnlResponder' class="panel-body"></div>   
     

<!-- /.panel -->


</div>
</div>

<!-- /.panel-body -->
    
<!-- /.panel-footer -->

</section><!-- /.content -->

<script type="text/javascript">
		
$.noConflict();

jQuery(document).ready(function($){		
		$("#lkbDetalle").on("click",function () {
			var html2='<div class="chart" id="detalle" style="width:100%; height: 100px;"></div><div class="chart" ></div>';
			$("#panel1").html('');		
			$("#panel1").html(html2);
					
			$.ajax({				
				type: "post",
        		url: "/gamma/user/JSONdetallenotificacion/"+$("#artid").val(),        			        		
		        dataType: "json",		        
		        success: function(response, status) {
		        	
		        	var html=null; 
			        html="<table id='tblMesesAcciones' border='1' class='table table-bordered table-striped results'><thead><th>Detalle</th></thead><tbody>";	
			        
			        var fila=0;
                     for (var i = 0; i < response.length; i++) {
                     html=html+"<tr><td>"+response[i]['mensaje']+"</td></tr>";                                               			                         		                         
                     				                        	
                     fila++;	        		
		        	}
		        	html=html+"</tbody> </table>";
		        	
		        	$("#detalle").html(html); 	
		        	
		        	$("#estid").html('leido');	
		        	
		        },
		         error: function (response, status) {
				    alert("Error");
				},
			});			  
		});	
		
		$("#btnResponder").on("click",function () {
			var html="";
			html = "<table width='100%'><thead></thead><tbody><tr><td width='50px'></td><td ><textarea id='txtMensaje' rows='4' cols='150'></textarea></td></tr></tbody></table> <br>"+
						"<div class='box-footer clearfix'><button id='btnEnviar' class='pull-right btn btn-default' >Enviar <i class='fa fa-arrow-circle-right'></i></button></div>";
			$("#pnlResponder").html(html);
			
			$("#btnEnviar").on("click",function () {									
				$.ajax({				
        		type: "POST",        		
        		url: "/gamma/user/JSONenviarmensaje/",        		
				data: {'idsend':$("#myid").val(), 'idreceive':$("#userid").val(), 'subject':$("#subject").val(), "text":$("#txtMensaje").val()},				
	        		success: function(response, status) {	        	
			        	$("#txtMensaje").val("");			        	     	
			        },
			        error: function (response, status) {		            
			            $("#txtMensaje").val("");	    
			        },
				});						
			});							
		});	
		
			
});
</script>  