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

<div class="row">
    <div class="col-md-11 alpha omega ">
    <div id="recursoeducativo" class="panel  panel-default">
    <div class="panel-heading">
        <i class="fa fa-fw fa-book"></i> DEFINIR VALOR NOTIFICACIÓN    
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
				<td width="130px"><label>Tipo Notificación: </label></td>		
				<td><input id="user" type="email" class="form-control" name="emailto" value="<?php echo $value['texto']; ?>" disabled></td>
			</tr>
			<tr>		
				<td width="130px"><label>Valor Notificación: </label></td>		
				<td><input type="text" name="subject" id="subject" value="<?php echo $value['valor']; ?>" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"></td>
			</tr>		
			<tr>		
				<td width="130px"></td>		
				<td></td>
			</tr>
			<tr>		
				<td width="130px"></td>						
				<td><?php echo CHtml::link('Guardar', array(), array('id'=>'btnGuardar', 'class'=>'btn btn-info btnVistaArticle'));  ?></td>				
				<input id ="artid" value="<?php echo $value['id']?>" hidden="hidden"/>				
			</tr>
		<?php } ?>		
		</tbody>
	</table> 
	<br>
	<div id='panel1' class="panel-body"> </div>       
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
			        html="<table id='tblMesesAcciones' border='1' class='table table-bordered table-striped results'><thead><th>Detalle</th></thead><tbody>";	
			        
			        var fila=0;
                     for (var i = 0; i < response.length; i++) {
                     html=html+"<tr><td>"+response[i]['mensaje']+"</td></tr>";                                               			                         		                         
                     				                        	
                     fila++;	        		
		        	}
		        	html=html+"</tbody> </table>";
		        	
		        	$("#detalle").html(html); 	
		        	
		        },
		         error: function (response, status) {
				    alert("Error");
				},
			});			  
		});	
		
		$("#btnGuardar").on("click",function () {			
			$.ajax({				
                    type: "POST",
                    data:{'valor':$("#subject").val()},
                    url: "/gamma/user/JSONUpdatevalornotificacionusuario/"+$("#artid").val(),
                    success: function(response, status) {
                    	alert('Hola');                      
                    },
                    error: function (response, status) {
                        //alert('Error');
                    },
            });				
		});	
});
</script>  