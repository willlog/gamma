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
<?php $this->setPageTitle("NOTIFICACIÓN"); ?>
<section class="content">
<input id ="myid" value="<?php echo Yii::app()->user->getId();?>" hidden="hidden"/>
<input id ="userid" value="0" hidden="hidden"/>
<div class="row">
    <div class="col-md-11 alpha omega ">
    <div id="recursoeducativo" class="panel  panel-default">
    <div class="panel-heading">
        <i class="fa fa-warning"></i> NOTIFICACIÓN    
        <div class="pull-right">
            <div class="btn-group">
                
            </div>
        </div>    
    </div>
    <!-- /.panel-heading -->
    <div class="panel-body"> 
    <table width="100%">
		<thead>		
		</thead>		
		<tbody>
		<?php foreach ($dataProvider as $key => $value) { ?>
			<tr>		
				<td width="90px"><label>Notificación: </label></td>		
				<td><input id="notif" type="email" class="form-control" name="emailto" value="<?php echo $value['texto']; ?>" disabled></td>
			</tr>
			<tr>		
				<td width="90px"><label>Tipo: </label></td>		
				<td><input id="action" type="email" class="form-control" name="emailto" value="<?php echo $value['action']; ?>" disabled></td>
			</tr>
			<tr>		
				<td width="90px"><label>Estado: </label></td>		
				<td ><input id="estid" type="email" class="form-control" name="emailto" value="<?php echo $value['estado']; ?>" disabled></td>
			</tr>
			<tr>		
				<td width="90px"><label>Fecha: </label></td>		
				<td><input id="fecha" type="email" class="form-control" name="emailto" value="<?php echo $value['fechaHora']; ?>" disabled></td>
			</tr>
			<tr>		
				<td width="90px"></td>		
				<td></td>
			</tr>
			<tr>		
				<!--<td width="90px"><div id="lkbLeido" style='color:blue'>Leido</div></td>-->		
				<td><div id="lkbDetalle" style='color:blue'>Detalle</div></td>
				<input id ="artid" value="<?php echo $value['idNotificacion']?>" hidden="hidden"/>				
			</tr>
		<?php } ?>	
			<tr>		
				<td width="90px"> </td>		
				<td><div id='panel1' class="panel-body"> </div></td>
			</tr>	
		</tbody>
	</table> 
		
	<div class="box-footer clearfix">
        <button class="pull-right btn btn-default" id="btnCompartir"><i class="fa fa-mail-reply"></i> Compartir </button>
    </div>
    <div id='pnlUsuario' class="panel-body"></div>	    
    </div>	
    <!-- /.panel-body -->    
    <!-- /.panel-footer -->
    
</div>
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
			        html="<table id='tblMesesAcciones' border='1' class='table table-bordered table-striped results'><thead><th>Detalle</th></thead><tbody>"
							
			        
			        var fila=0;
                     for (var i = 0; i < response.length; i++) {
                     html=html+"<tr><td>"+response[i]['mensaje']+"</td></tr>";                                               			                         		                         
                     				                        	
                     fila++;	        		
		        	}
		        	html=html+"</tbody> </table>";
		        	
		        	$("#detalle").html(html); 	
		        	
		        	$("#estid").value('leido');	      	
		        	
				        	
		        },
		         error: function (response, status) {
				    alert("Error");
				},
			});			
			
					  
		});	
		
		$("#lkbLeido").on("click",function () {
			$.ajax({
				type: "post",
        		url: "/gamma/user/JSONactualizarnotificacion/"+$("#artid").val(),        			        		
		        dataType: "json",		        
		        success: function(response, status) {
		        	$("#estid").value('leido');	        		        		        	
		        },
		        
		        error: function (response, status) {
				    alert("Error");
				},	
				
			});						
		});	
		
		
		$("#btnCompartir").on("click",function () {			
			var html2="<div class='form-group'>"+		        	
		        	"Para: <label id='lblUser'></label>"+	        	
		        	"<input id='user' type='email' class='form-control' name='emailto' placeholder='Para:' >"+		            
		            "<div id='contenidoDeUser'>"+						
					"</div>"+
		        	"</div>"+
		        	"<div class='box-footer clearfix'>"+
		        	"<button class='pull-right btn btn-default' id='btnEnviar'>Enviar <i class='fa fa-arrow-circle-right'></i></button>"+
		    		"</div>";
			$("#pnlUsuario").html('');		
			$("#pnlUsuario").html(html2);
			
			$("#user").keyup(function () {	
				if($("#user").val()=="")	
				{
					$("#contenidoDeUser").html("");
				}	
				$.ajax({				
					type: "GET",
	        		url: "/gamma/user/indexbuscarusuarios/"+$("#user").val(),
	        		success: function(response, status) {
	        			
			        	//$("#contenidoDeUser").html(response);
			        	$("#contenidoDeUser").html(response);
			        },
			        error: function (response, status) {
			                //alert("Error");
			        },		        
				});			
			});
			
			$("#btnEnviar").on("click",function () {				
				$.ajax({				
	        		type: "POST",        		
	        		url: "/gamma/user/JSONcompartirnotificacion/",        		
					data: {'idsend':$("#myid").val(), 'idreceive':$("#userid").val(), 'subject':'Notificación compartida', 'text':$("#notif").val(), 'action':$("#action").val(), 'id':$("#artid").val()},				
		        		success: function(response, status) {	        	
				        	$("#user").val("");
				        	$("#lblUser").text("");					        	     	
				        },
				        error: function (response, status) {		            
				            $("#user").val("");
				        	$("#lblUser").text("");			    
				        },
				});		
			});
		});
	
});
</script>  
       