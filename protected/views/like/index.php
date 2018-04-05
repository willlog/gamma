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

<?php $this->setPageTitle("ESTADÍSTICAS MIS GUSTADOS"); ?>
<section class="content">
	<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'estadistica-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>	
<div id="btnDescargar" ><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/pdf.ico" width="25" height="25" /></div>

<div class="row">
    <div class="col-md-10 alpha omega ">
    <div id="Anio" class="panel  panel-default">
    <div class="panel-heading">
        <i class="fa fa-fw fa-thumbs-o-up"></i> Recursos Gustados Total vs Mis Recursos  
        <div style="float: right;"> 
	        <label>Gráfica: </label>
	    	<select id="ddlLimit" style="width: 150px;">
	        <option value="total">Total</option>
	        <option value="anio">Por años</option>	        	        
	    	</select>
    	</div>  
        <div class="pull-right">
            <div class="btn-group">
                
            </div>
        </div>    
    </div>
    <!-- /.panel-heading -->
    <div id='panel1' class="panel-body"> </div>
    <!-- /.panel-body -->    
    <!-- /.panel-footer -->
</div>
<!-- /.panel -->
</div>
</div>

<div class="row">
<div class="col-md-10 alpha omega ">	
	<div id="Mes" class="panel  panel-default">
	<div class="panel-heading">
	<label>Fecha Inicio: </label>
	<input data-date-format="yyyy/mm/dd" class="fecha"  id="fecha1" type="text" readonly>
	<label>&nbsp&nbsp&nbsp&nbsp Fecha Fin: </label> 
    <input data-date-format="yyyy/mm/dd" class="fecha" id="fecha2" type="text" readonly>&nbsp&nbsp&nbsp&nbsp	
    <div id="btnBuscar" class="btn btn-info">Buscar</div> 
	</div>
    <div class="panel-heading">
        <i class="fa fa-bar-chart-o fa-fw"></i> Recursos Gustados Total vs Mis Recursos por Meses
        <div style="float: right;"> 
	        <label>Tipo de Gráfica: </label>
	    	<select id="ddlTipo" style="width: 150px;">
	        <option value="Line">Líneas</option>
	        <option value="Area">Áreas</option>
	        <option value="Bar">Barras</option>	        	        
	    	</select>
    	</div>             
    </div>
    <!-- /.panel-heading -->
    <div id='panel2' class="panel-body"> </div>

</div>
</div>        
</div>

<div class="row">
<div class="col-md-10 alpha omega ">	
	<div id="Dia" class="panel  panel-default">	
    <div class="panel-heading">
        <i class="fa fa-bar-chart-o fa-fw"></i> Recursos Gustados Total vs Mis Recursos por Días
         <div style="float: right;"> 
	        <label>Tipo de Gráfica: </label>
	    	<select id="ddlTipodia" style="width: 150px;">
	        <option value="Line">Líneas</option>
	        <option value="Area">Áreas</option>
	        <option value="Bar">Barras</option>	        	        
	    	</select>
    	</div>                  
    </div>
    <!-- /.panel-heading -->
    <div id='panel3' class="panel-body"> </div> 
    
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

		function getPDF () {				
					
			html2canvas(document.getElementById("Anio"), {
				onrendered: function (canvas) {
					img2 = canvas.toDataURL("image/png");
				}
			});
			
			html2canvas(document.getElementById("Mes"), {
				onrendered: function (canvas) {
					img3 = canvas.toDataURL("image/png");
				}
			});
			
			html2canvas(document.getElementById("Dia"), {
				onrendered: function (canvas) {
					img4 = canvas.toDataURL("image/png");
				}
			});
			
			var doc = new jsPDF();
			
			var specialElementHandlers={
				'#tblAniosAcciones_filter':function(element, render){return true;}
						
					} 
					
 
		            //doc.addImage(imgData, 'jpeg', 0, 0, 210, 40);
			
			

            doc.text(80, 35, 'RECURSO EDUCATIVO');
            //doc.text(100, 57, 'Tutorias');
			
			//doc.addPage();
			
			doc.fromHTML($("#tblAniosAcciones_filter"),0,0,{
				'elementHandlers':specialElementHandlers
			});
			
			//doc.addImage(img1, 'JPEG', 15 , 60, 180, 70);				
			
			
			doc.addImage(img2, 'PNG', 15 , 60, 180, 120);
			doc.addPage()
			doc.addImage(img3, 'PNG', 15 , 20, 180, 150);
			doc.addPage()
			doc.addImage(img4, 'PNG', 15 , 20, 180, 150);
			doc.save("misgustados.pdf");
		  			
		}

		$.noConflict();		
		jQuery(document).ready(function($){
			"use strict";	
			$("#btnBuscar").on("click",function () {
				var html2='<div class="chart" id="todosvsmismes" style="width:100%; height: 300px;"></div><div class="chart" id="tblMes" ></div>';
				$("#panel2").html('');		
				$("#panel2").html(html2);
				$.ajax({
	        		type: "post",
	        		url: "/gamma/like/JSONgustanmisoapormesrango/",	        		
			        dataType: "json",
			        data: {'fecha1':$("#fecha1").val(), 'fecha2':$("#fecha2").val()},
			        success: function(response, status) { 
			        	var html="<table id='tblMesesGustados' border='1' class='table table-bordered table-striped results'><thead><th>Mes</th><th>Gustados Autor</th><th>Gustados Totales</th><th>Porcentaje (%)</th></thead><tbody>";       	
			        	var b = new Array();
	                               var fila=0;
				                     for (var i = 0; i < response.length; i++) {
				                         html=html+"<tr><td><div class='mes' style='color:blue;'>"+response[i]['mes']+"</div></td><td>"+response[i]['cantidad']+"</td><td>"+response[i]['total']+"</td><td>"+response[i]['porcentaje']+"</td></tr>";
				                         b[fila] = new Array();
				                         b[fila]["y"]=response[i]['mes'];
				                         b[fila]["a"] = response[i]['total'];
				                         b[fila]["b"] = response[i]['cantidad'];				                        			                         		                         
				                         				                        	
				                         fila++;			                        		                        
				                     }		
				        html=html+"</tbody> </table>";	
				        $("#tblMes").html(html);        
			        	
			        	//TIPO DE CHART				        	
			        	if($("#ddlTipo").val()=='Line')
			        	{
			        		var tipo = Morris.Line;
			        	}
			        	if($("#ddlTipo").val()=='Area')
			        	{
			        		var tipo = Morris.Area;
			        	}
			        	if($("#ddlTipo").val()=='Bar')
			        	{
			        		var tipo = Morris.Bar;
			        	}
			        	
		                var bar = new tipo({
		                //var bar = new Morris.Area({
		                    element: 'todosvsmismes',
		                    resize: true,
		                    data: b,
		                    //barColors: 'auto',
		                    xkey: 'y',
		                    ykeys: ['a', 'b'],
		                    //ymax:100,
		                    labels: ['Total', 'Autor'],
		                    fillOpacity: 0.8,
		                    //hideHover: 'auto',
		      				behaveLikeLine: true,
		      				pointFillColors:['#ffffff'],
						    pointStrokeColors: ['black'],
						    //lineColors:['black','red'],
		                    xLabelAngle:90,                    
		                    hideHover: 'auto'
		                });
		                
		                var encabezado="<?php echo "		  					                											              "; ?>";	
						encabezado= encabezado+"<?php echo "SOCIAL MEDIA ACADEMIC NETWORK"; ?>";
						encabezado= encabezado+"<?php echo "						        					        "; ?>";
						encabezado= encabezado+"<?php echo "Total Gustados vs Mis Recursos por Meses"; ?>";
						encabezado= encabezado+"<?php echo "									    "; ?>";
						encabezado= encabezado+"<?php echo "						        		"; ?>";		
						encabezado= encabezado+"Fecha: <?php print(date('m/d/Y h:i:s a', time())); ?>";
						encabezado=encabezado+" Usuario: <?php echo $model->name?>";
						encabezado= encabezado+"<?php echo "						        	          "; ?>";
						encabezado= encabezado+"<?php echo "						        		      "; ?>";											
						encabezado=encabezado+" Desde: "+$("#fecha1").val() + "      Hasta: "+ $("#fecha2").val();
		                
		                var table = $('#tblMesesGustados').DataTable( {
							"paging":   true,
					        "ordering": true,
					        "info":     true,
					        'searching':true,
					        "sDom": 'T<"clear">lfrtip',
					        "tableTools": {
					            "aButtons": [
					            
					            	{
					                	"sButtonText":"<i class='fa fa-files-o fa-lg' data-toggle='tooltip' data-placement='bottom' title='copiar portapapeles'></i>",
					                	"sExtends":     "copy",
					                	"sToolTip": "Copiar portapapeles",
					               },
					                {
					                	"sButtonText":"<i class='fa fa-print fa-lg' data-toggle='tooltip' data-placement='bottom' title='Imprimir tabla'></i>",
					                	"sExtends":     "print",
					                },
					                {
					                    "sExtends":    "collection",
					                    "sButtonText": "<i class='fa fa-floppy-o fa-lg'></i>",
					                    "sToolTip": "Guardar como",
					                    "aButtons":    [ "csv","xls", { "sExtends": "pdf",	                    
			                    										 "sPdfMessage": encabezado, 
			                    										 "sTitle": "                                  UNIVERSIDAD TÉCNICA DE AMBATO",
			                    										 "sFileName":"totalgustadosvsmisreursosfechas.pdf"
							                    						}]
					                }
					            ]
					        }
					        
					    } );			        	
	                	
			        },
			        error: function (response, status) {
			                alert("Error");
			        },
				});
			});
						
			$.ajax({
        		type: "post",
        		url: "/gamma/like/JSONliketodos",	        		
		        dataType: "json",
		        success: function(response, status) { 
		        	var html2='<div class="chart" id="gustadoporanio" style="width:100%; height: 300px;"></div><div class="chart" id="tblTotal" ></div>';
					$("#panel1").html('');		
					$("#panel1").html(html2); 
		        	var html="<table id='tblAniosGustados' border='1' class='table table-bordered table-striped results'><thead><th>Año</th><th>Gustados Autor</th><th>Gustados Totales</th><th>Porcentaje (%)</th></thead><tbody>";      	
		        	var b = new Array();
                               var fila=0;
			                     for (var i = 0; i < response.length; i++) {
			                        html=html+"<tr><td><div class='anios' style='color:blue;' >"+response[i]['anio']+"</div></td><td>"+response[i]['cantidad']+"</td><td>"+response[i]['total']+"</td><td>"+response[i]['porcentaje']+"</td></tr>"; 
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
	                    element: 'gustadoporanio',
	                    resize: true,
	                    data: b,
	                    //barColors: 'auto',
	                    xkey: 'y',
	                    ykeys: ['a', 'b'],
	                    //ymax:100,
	                    labels: ['Total', 'Autor'],
	                    fillOpacity: 0.8,
	                    //hideHover: 'auto',
	      				behaveLikeLine: true,
	      				pointFillColors:['#ffffff'],
					    pointStrokeColors: ['black'],
					    lineColors:['black','red'],
	                    //xLabelAngle:45,                    
	                    hideHover: 'auto'
	                });	
	                
	                var encabezado="<?php echo "		  					                											              "; ?>";	
					encabezado= encabezado+"<?php echo "SOCIAL MEDIA ACADEMIC NETWORK"; ?>";
					encabezado= encabezado+"<?php echo "						        					        "; ?>";
					encabezado= encabezado+"<?php echo "Total Compartidos vs Mis Recursos"; ?>";
					encabezado= encabezado+"<?php echo "									        "; ?>";
					encabezado= encabezado+"<?php echo "						        			 "; ?>";		
					encabezado= encabezado+"Fecha: <?php print(date('m/d/Y h:i:s a', time())); ?>";
					encabezado=encabezado+" Usuario: <?php echo $model->name?>";	
	                
	                var table = $('#tblAniosGustados').DataTable( {
							"paging":   true,
					        "ordering": true,
					        "info":     true,
					        'searching':true,
					        "sDom": 'T<"clear">lfrtip',
					        "tableTools": {
					            "aButtons": [
					            
					            	{
					                	"sButtonText":"<i class='fa fa-files-o fa-lg' data-toggle='tooltip' data-placement='bottom' title='copiar portapapeles'></i>",
					                	"sExtends":     "copy",
					                	"sToolTip": "Copiar portapapeles",
					               },
					                {
					                	"sButtonText":"<i class='fa fa-print fa-lg' data-toggle='tooltip' data-placement='bottom' title='Imprimir tabla'></i>",
					                	"sExtends":     "print",
					                },
					                {
					                    "sExtends":    "collection",
					                    "sButtonText": "<i class='fa fa-floppy-o fa-lg'></i>",
					                    "sToolTip": "Guardar como",
					                    "aButtons":    [ "csv","xls", {"sExtends": "pdf",	                    
			                    										 "sPdfMessage": encabezado, 
			                    										 "sTitle": "                                  UNIVERSIDAD TÉCNICA DE AMBATO",
			                    										 "sFileName":"totalgustadosvsmisreursos.pdf"
							                    						}]
					                }
					            ]
					        }
					        
					    } );			        	
                	
		        },
		        error: function (response, status) {
		                alert("Error");
		        },
			});
			
			$("#ddlLimit").on("change",function () {
				var url1="";
				if($("#ddlLimit").val()=='total')
				{
					url1="/gamma/like/JSONliketodos";
				}
				else
				{
					url1="/gamma/like/JSONlike";
				}
				
				$.ajax({
        		type: "post",
        		url: url1,	        		
		        dataType: "json",
		        success: function(response, status) { 
		        	var html2='<div class="chart" id="gustadoporanio" style="width:100%; height: 300px;"></div><div class="chart" id="tblTotal" ></div>';
					$("#panel1").html('');		
					$("#panel1").html(html2); 
		        	var html="<table id='tblAniosGustados' border='1' class='table table-bordered table-striped results'><thead><th>Año</th><th>Gustados Autor</th><th>Gustados Totales</th><th>Porcentaje (%)</th></thead><tbody>";      	
		        	var b = new Array();
                               var fila=0;
			                     for (var i = 0; i < response.length; i++) {
			                        html=html+"<tr><td><div class='anios' style='color:blue;' >"+response[i]['anio']+"</div></td><td>"+response[i]['cantidad']+"</td><td>"+response[i]['total']+"</td><td>"+response[i]['porcentaje']+"</td></tr>"; 
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
	                    element: 'gustadoporanio',
	                    resize: true,
	                    data: b,
	                    //barColors: 'auto',
	                    xkey: 'y',
	                    ykeys: ['a', 'b'],
	                    //ymax:100,
	                    labels: ['Total', 'Autor'],
	                    fillOpacity: 0.8,
	                    //hideHover: 'auto',
	      				behaveLikeLine: true,
	      				pointFillColors:['#ffffff'],
					    pointStrokeColors: ['black'],
					    lineColors:['black','red'],
	                    //xLabelAngle:45,                    
	                    hideHover: 'auto'
	                });	
	                
	                 var encabezado="<?php echo "		  					                											              "; ?>";	
					encabezado= encabezado+"<?php echo "SOCIAL MEDIA ACADEMIC NETWORK"; ?>";
					encabezado= encabezado+"<?php echo "						        					        "; ?>";
					encabezado= encabezado+"<?php echo "Total Compartidos vs Mis Recursos"; ?>";
					encabezado= encabezado+"<?php echo "									        "; ?>";
					encabezado= encabezado+"<?php echo "						        			 "; ?>";		
					encabezado= encabezado+"Fecha: <?php print(date('m/d/Y h:i:s a', time())); ?>";
					encabezado=encabezado+" Usuario: <?php echo $model->name?>";	
	                
	                var table = $('#tblAniosGustados').DataTable( {
							"paging":   true,
					        "ordering": true,
					        "info":     true,
					        'searching':true,
					        "sDom": 'T<"clear">lfrtip',
					        "tableTools": {
					            "aButtons": [
					            
					            	{
					                	"sButtonText":"<i class='fa fa-files-o fa-lg' data-toggle='tooltip' data-placement='bottom' title='copiar portapapeles'></i>",
					                	"sExtends":     "copy",
					                	"sToolTip": "Copiar portapapeles",
					               },
					                {
					                	"sButtonText":"<i class='fa fa-print fa-lg' data-toggle='tooltip' data-placement='bottom' title='Imprimir tabla'></i>",
					                	"sExtends":     "print",
					                },
					                {
					                    "sExtends":    "collection",
					                    "sButtonText": "<i class='fa fa-floppy-o fa-lg'></i>",
					                    "sToolTip": "Guardar como",
					                    "aButtons":    [ "csv","xls", {"sExtends": "pdf",	                    
			                    										 "sPdfMessage": encabezado, 
			                    										 "sTitle": "                                  UNIVERSIDAD TÉCNICA DE AMBATO",
			                    										 "sFileName":"totalgustadosvsmisreursos.pdf"
							                    						}]
					                }
					            ]
					        }
					        
					    } );			        	
                	
		        },
		        error: function (response, status) {
		                alert("Error");
		        },
			});				
				
			});
			
			$(document).on('click','.mes', function () {
				var html2='<div class="chart" id="todosvsmisdia" style="width:100%; height: 300px;"></div><div class="chart" id="tblDia" ></div>';
				$("#panel3").html('');		
				$("#panel3").html(html2);
				$.ajax({
	        		type: "post",
	        		url: "/gamma/like/JSONgustanmisoapordias/",	        		
			        dataType: "json",
			        data: {'mes':$(this).text()},
			        success: function(response, status) { 
			        	var html="<table id='tblDiasGustados' border='1' class='table table-bordered table-striped results'><thead><th>Día</th><th>Gustados Autor</th><th>Gustados Totales</th><th>Porcentaje (%)</th></thead><tbody>";       	
			        	var b = new Array();
	                               var fila=0;
				                     for (var i = 0; i < response.length; i++) {
				                         html=html+"<tr><td><div class='dia' style='color:blue;'>"+response[i]['dia']+"</div></td><td>"+response[i]['cantidad']+"</td><td>"+response[i]['total']+"</td><td>"+response[i]['porcentaje']+"</td></tr>";
				                         b[fila] = new Array();
				                         b[fila]["y"]=response[i]['dia'];
				                         b[fila]["a"] = response[i]['total'];
				                         b[fila]["b"] = response[i]['cantidad'];                   			                         		                         
				                         				                        	
				                         fila++;
			                        			                        
				                     }		
				        html=html+"</tbody> </table>";	
				        $("#tblDia").html(html);        
			        	
			        	//TIPO DE CHART				        	
			        	if($("#ddlTipodia").val()=='Line')
			        	{
			        		var tipo = Morris.Line;
			        	}
			        	if($("#ddlTipodia").val()=='Area')
			        	{
			        		var tipo = Morris.Area;
			        	}
			        	if($("#ddlTipodia").val()=='Bar')
			        	{
			        		var tipo = Morris.Bar;
			        	}
			        	
		                var bar = new tipo({
		                //var bar = new Morris.Bar({
		                    element: 'todosvsmisdia',
		                    resize: true,
		                    data: b,
		                    //barColors: 'auto',
		                    xkey: 'y',
		                    ykeys: ['a', 'b'],
		                    //ymax:100,
		                    labels: ['Total', 'Autor'],
		                    fillOpacity: 0.8,
		                    //hideHover: 'auto',
		      				behaveLikeLine: true,
		      				pointFillColors:['#ffffff'],
						    pointStrokeColors: ['black'],
						    //lineColors:['black','red'],
		                    xLabelAngle:90,                    
		                    hideHover: 'auto'
		                });	
		                
		                var encabezado="<?php echo "		  					                											              "; ?>";	
						encabezado= encabezado+"<?php echo "SOCIAL MEDIA ACADEMIC NETWORK"; ?>";
						encabezado= encabezado+"<?php echo "						        					        "; ?>";
						encabezado= encabezado+"<?php echo "Total Gustados vs Mis Recursos por Días"; ?>";
						encabezado= encabezado+"<?php echo "									      "; ?>";
						encabezado= encabezado+"<?php echo "						        		 "; ?>";		
						encabezado= encabezado+"Fecha: <?php print(date('m/d/Y h:i:s a', time())); ?>";
						encabezado=encabezado+" Usuario: <?php echo $model->name?>";	
					
		                var table = $('#tblDiasGustados').DataTable( {
							"paging":   true,
					        "ordering": true,
					        "info":     true,
					        'searching':true,
					        "sDom": 'T<"clear">lfrtip',
					        "tableTools": {
					            "aButtons": [
					            
					            	{
					                	"sButtonText":"<i class='fa fa-files-o fa-lg' data-toggle='tooltip' data-placement='bottom' title='copiar portapapeles'></i>",
					                	"sExtends":     "copy",
					                	"sToolTip": "Copiar portapapeles",
					               },
					                {
					                	"sButtonText":"<i class='fa fa-print fa-lg' data-toggle='tooltip' data-placement='bottom' title='Imprimir tabla'></i>",
					                	"sExtends":     "print",
					                },
					                {
					                    "sExtends":    "collection",
					                    "sButtonText": "<i class='fa fa-floppy-o fa-lg'></i>",
					                    "sToolTip": "Guardar como",
					                    "aButtons":    [ "csv","xls", {"sExtends": "pdf",	                    
			                    										 "sPdfMessage": encabezado, 
			                    										 "sTitle": "                                  UNIVERSIDAD TÉCNICA DE AMBATO",
			                    										 "sFileName":"totalgustadosvsmisreursosdias.pdf"
							                    						}]
					                }
					            ]
					        }
					        
					    } );				        	
	                	
			        },
			        error: function (response, status) {
			                alert("Error");
			        },
				});
			});
			
			$('.fecha').datepicker({
					language: "es",

			}); 
			
			$("#btnDescargar").on("click",function () {
					getPDF();
			});

		});
</script>
                        