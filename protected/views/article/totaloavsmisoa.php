<!-- jQuery 2.0.2 -->
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.min.js"></script>
<section class="content">
	<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'estadistica-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>	

<div class="row">
    <div class="col-md-12 alpha omega ">
    <div id="R42962530259779691" class="panel  panel-default">
    <div class="panel-heading">
        <i class="fa fa-fw fa-book"></i> Total de Articulos Publicados vs Mis Artículos   
        <div class="pull-right">
            <div class="btn-group">
                
            </div>
        </div>    
    </div>
    <!-- /.panel-heading -->
    <div class="panel-body">
    	<div class="chart" id="todosvsmis" style="height: 200px;"></div>
    	<div class="chart" id="tblTotal" ></div> 	  
        
    </div>
    <!-- /.panel-body -->    
    <!-- /.panel-footer -->
</div>
<!-- /.panel -->


</div>
</div>
<div class="row">
<div class="col-md-12 alpha omega ">	
	<div class="panel  panel-default">
    <div class="panel-heading">
        <i class="fa fa-bar-chart-o fa-fw"></i> Artículos Publicados por Mes            
    </div>
    <!-- /.panel-heading -->
     <div id='panel1' class="panel-body"> </div>
</div>
</div>

        
    </div>
    <!-- /.panel-body -->
    
    <!-- /.panel-footer -->
</div>
</div>
</section><!-- /.content -->
<?php $this->endWidget(); ?>

<script type="text/javascript">

		$(function() {
			"use strict";				
			$.ajax({
        		type: "post",
        		url: "/gamma/article/JSONaototalporaniovsmisoa",	        		
		        dataType: "json",
		        success: function(response, status) {  
		        	var html="<table border='1' class='table table-mailbox results'><thead><th>Año</th><th>Mis Publicaciones</th><th>Total Publicados</th><th>Porcentaje (%)</th></thead><tbody>";      	
		        	var b = new Array();
                               var fila=0;
			                     for (var i = 0; i < response.length; i++) {
			                        html=html+"<tr><td><div class='anios' style='color:blue;'>"+response[i]['anio']+"</div></td><td>"+response[i]['cantidad']+"</td><td>"+response[i]['total']+"</td><td>"+response[i]['porcentaje']+"</td><tr>"; 
			                         b[fila] = new Array();
			                         b[fila]["y"]=response[i]['anio'];
			                         b[fila]["a"] = response[i]['total'];
			                         b[fila]["b"] = response[i]['cantidad'];				                        			                         		                         
			                         
			                        	
			                         fila++;
		                        			                        
			                     }
			         html=html+"</tbody> </table>";	
			         $("#tblTotal").html(html);	        
		        	
		        	//BAR CHART
	                var bar = new Morris.Bar({
	                    element: 'todosvsmis',
	                    resize: true,
	                    data: b,
	                    //barColors: 'auto',
	                    xkey: 'y',
	                    ykeys: ['a', 'b'],
	                    ymax:50,
	                    labels: ['Total', 'Mis artículos'],
	                    fillOpacity: 0.8,
	                    //hideHover: 'auto',
	      				behaveLikeLine: true,
	      				pointFillColors:['#ffffff'],
					    pointStrokeColors: ['black'],
					    lineColors:['black','red'],
	                    //xLabelAngle:45,                    
	                    hideHover: 'auto'
	                });			        	
                	
		        },
		        error: function (response, status) {
		                alert("Error");
		        },
			});
			
			//Articulos creados por mes de un determinado año
			$(document).on('click','.anios', function () {
				var html2='<div class="chart" id="todosvsmismes" style="width:100%; height: 200px;"></div><div class="chart" id="tblMes" ></div>';
				$("#panel1").html('');		
				$("#panel1").html(html2);
				$.ajax({
	        		type: "post",
	        		url: "/gamma/article/JSONaototalpormesvsmisoa/"+$(this).text(),	        		
			        dataType: "json",
			        success: function(response, status) { 
			        	var html="<table border='1' class='table table-mailbox results'><thead><th>Mes</th><th>Mis Publicaciones</th><th>Total Publicados</th><th>Porcentaje (%)</th></thead><tbody>";       	
			        	var b = new Array();
	                               var fila=0;
				                     for (var i = 0; i < response.length; i++) {
				                         html=html+"<tr><td><a href='#'>"+response[i]['mes']+"</a></td><td>"+response[i]['cantidad']+"</td><td>"+response[i]['total']+"</td><td>"+response[i]['porcentaje']+"</td><tr>";
				                         b[fila] = new Array();
				                         b[fila]["y"]=response[i]['mes'];
				                         b[fila]["a"] = response[i]['total'];
				                         b[fila]["b"] = response[i]['cantidad'];				                        			                         		                         
				                         
				                        	
				                         fila++;
			                        			                        
				                     }		
				        html=html+"</tbody> </table>";	
				        $("#tblMes").html(html);        
			        	
			        	//BAR CHART
		                var bar = new Morris.Bar({
		                    element: 'todosvsmismes',
		                    resize: true,
		                    data: b,
		                    //barColors: 'auto',
		                    xkey: 'y',
		                    ykeys: ['a', 'b'],
		                    ymax:50,
		                    labels: ['Total', 'Mis artículos'],
		                    fillOpacity: 0.8,
		                    //hideHover: 'auto',
		      				behaveLikeLine: true,
		      				pointFillColors:['#ffffff'],
						    pointStrokeColors: ['black'],
						    lineColors:['black','red'],
		                    //xLabelAngle:45,                    
		                    hideHover: 'auto'
		                });			        	
	                	
			        },
			        error: function (response, status) {
			                alert("Error");
			        },
				});
			});

		});
</script>
