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
<?php $this->setPageTitle("ESTADÍSTICA RECURSOS EDUCATIVOS"); ?>
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
	<?php echo CHtml::link('Recomendados', array('/article/indexrecomendados/'), array('target'=>'_blank', 'class'=>'btn btn-info btnVistaArticle'));  ?>
	<?php echo CHtml::link('Compartidos', array('/article/indexmascompartidos/'), array('target'=>'_blank', 'class'=>'btn btn-info btnVistaArticle'));  ?>
	<?php echo CHtml::link('Visitados', array('/article/indexmasvisitados/'), array('target'=>'_blank', 'class'=>'btn btn-info btnVistaArticle'));  ?>
	<?php echo CHtml::link('Gustados', array('/article/indexmasgustados/'), array('target'=>'_blank', 'class'=>'btn btn-info btnVistaArticle'));  ?>	
<br>
<br>
<div class="row">
<div class="col-md-11 alpha omega ">	
	<div id="Anio" class="panel  panel-default">
    <div class="panel-heading">
        <i class="fa fa-bar-chart-o fa-fw"></i> Total de Recursos Educativos
        <div style="float: right;"> 
	        <label>Gráfica: </label>
	    	<select id="ddlLimit" style="width: 150px;">
	        <option value="total">Total</option>
	        <option value="anio">Por años</option>	        	        
	    	</select>
    	</div>          
    </div>
    <!-- /.panel-heading -->
    <div id='panel1' class="panel-body"> </div>

</div>
</div>        
    </div>

<div class="row">
<div class="col-md-11 alpha omega ">	
	<div id="Mes" class="panel  panel-default">
	<div class="panel-heading">
	<label>Fecha Inicio: </label>
	<input data-date-format="yyyy/mm/dd" class="fecha"  id="fecha1" type="text" readonly>
	<label>&nbsp&nbsp&nbsp&nbsp Fecha Fin: </label> 
    <input data-date-format="yyyy/mm/dd" class="fecha" id="fecha2" type="text" readonly>&nbsp&nbsp&nbsp&nbsp	
    <div id="btnBuscar" class="btn btn-info">Buscar</div> 
	</div>
    <div class="panel-heading">
        <i class="fa fa-bar-chart-o fa-fw"></i> Total de Recursos Educativos por Meses 
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
<div class="col-md-11 alpha omega ">	
	<div id="Dia" class="panel  panel-default">	
    <div class="panel-heading">
        <i class="fa fa-bar-chart-o fa-fw"></i> Total de Recursos Educativos por Días
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
			doc.save("recursoseducativosgeneral.pdf");
		  			
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
		        		url: "/gamma/article/JSONaototalpormes/",	        		
				        dataType: "json",
				        data: {'mes':$(this).text()},
				        data: {'fecha1':$("#fecha1").val(), 'fecha2':$("#fecha2").val()},
				        success: function(response, status) {				        	 
				        	var html="<table id='tblMesesRecursos' border='1' class='table table-bordered table-striped results'><thead><th>Mes</th><th>Recursos Habilitados</th><th>Recursos Deshabilitados</th><th>Recursos Totales</th></thead><tbody>";       	
				        	var b = new Array();
		                               var fila=0;
					                     for (var i = 0; i < response.length; i++) {
					                         html=html+"<tr><td><div class='mes' style='color:blue;'>"+response[i]['mes']+"</td><td>"+response[i]['habilitado']+"</td><td>"+response[i]['deshabilitado']+"</td><td>"+response[i]['total']+"</td></tr>";
					                         b[fila] = new Array();
					                         b[fila]["y"]=response[i]['mes'];
					                         b[fila]["a"] = response[i]['total'];
					                         b[fila]["b"] = response[i]['habilitado'];
					                         b[fila]["c"] = response[i]['deshabilitado'];                      			                         		                         
					                         					                        	
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
			                //var bar = new $("#ddlTipo").val()({			                	
			                    element: 'todosvsmismes',
			                    resize: true,
			                    data: b,
			                    //barColors: 'auto',
			                    xkey: 'y',
			                    ykeys: ['a', 'b','c'],
			                    //ymax:50,
			                    labels: ['Total', 'Habilitados', 'Deshabilitados'],
			                    fillOpacity: 0.8,
			                    //hideHover: 'auto',
			      				behaveLikeLine: true,
			      				pointFillColors:['#ffffff'],
							    pointStrokeColors: ['black'],
							    //lineColors:['black','red'],
			                    //xLabelAngle:90,                    
			                    //hideHover: 'auto'
			                });	
			                
			                var encabezado="<?php echo "		  					                											              "; ?>";	
							encabezado= encabezado+"<?php echo "SOCIAL MEDIA ACADEMIC NETWORK"; ?>";
							encabezado= encabezado+"<?php echo "							       					        "; ?>";
							encabezado= encabezado+"<?php echo "Recursos Educativo por Meses"; ?>";
							encabezado= encabezado+"<?php echo "							        					        "; ?>";
							encabezado= encabezado+"<?php echo "							        			 "; ?>";		
							encabezado= encabezado+"Fecha: <?php print(date('m/d/Y h:i:s a', time())); ?>";
							encabezado=encabezado+" Desde: "+$("#fecha1").val() + "      Hasta: "+ $("#fecha2").val();						
							
			                var table = $('#tblMesesRecursos').DataTable( {
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
						                    "aButtons":    [ "csv","xls", {
														                    "sExtends": "pdf",		                    
														                    "sPdfMessage": encabezado,														                    
														                    "sTitle": "                                  UNIVERSIDAD TÉCNICA DE AMBATO",
													                    	"sFileName":"recursoseducativospormeses.pdf"
															                }, ]
						                }
						            ]
						        }
						        
						    } );		        	
		                	
				        },
				        error: function (response, status) {
				                alert("Error");
				        },
					});			  
			})		
			
				$.ajax({
	        		type: "post",
	        		url: "/gamma/article/JSONaototal/",	        		
			        dataType: "json",
			        success: function(response, status) { 
			        	var html2='<div class="chart" id="estadistica" style="width:100%; height: 300px;"></div><div class="chart" id="tblEstadistica" ></div>';
						$("#panel1").html('');		
						$("#panel1").html(html2);  
			        	var html="<table id='tblAniosRecursos' border='1' class='table table-bordered table-striped results'><thead><th>Año</th><th>Habilitados</th><th>Deshabilitados</th><th>Total</th></thead><tbody>";     	
			        	var b = new Array();
	                               var fila=0;
				                     for (var i = 0; i < response.length; i++) {
				                         html=html+"<tr><td><div class='anios' style='color:blue;'>"+"Todos"+"</div></td><td>"+response[i]['activos']+"</td><td>"+response[i]['desactivos']+"</td><td>"+response[i]['total']+"</td></tr>";
				                         b[fila] = new Array();
				                         b[fila]["y"]=response[i]['anio'];
				                         b[fila]["a"]=response[i]['total'];
				                         b[fila]["b"] = response[i]['activos'];   
				                         b[fila]["c"] = response[i]['desactivos'];                  
				                        	
				                         fila++;
			                        			                        
				                     }	
				    html=html+"</tbody> </table>";	
			        $("#tblEstadistica").html(html);	        
			        	
			        	//BAR CHART
	                var bar = new Morris.Bar({
	                    element: 'estadistica',
	                    //resize: true,
	                    data: b,	                    
	                    xkey: 'y',
	                    ykeys: ['a','b', 'c'],
	                    //ymax:50,
	                    labels: ['Total','Habilitados', 'Deshabilitados'],
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
					encabezado= encabezado+"<?php echo "							       					        "; ?>";
					encabezado= encabezado+"<?php echo "Recursos Educativos Total"; ?>";
					encabezado= encabezado+"<?php echo "							        					        "; ?>";
					encabezado= encabezado+"<?php echo "							        			 "; ?>";		
					encabezado= encabezado+"Fecha: <?php print(date('m/d/Y h:i:s a', time())); ?>";					
	                
	                var table = $('#tblAniosRecursos').DataTable( {
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
						                    "aButtons":    [ "csv","xls", {
														                    "sExtends": "pdf",		                    
														                    "sPdfMessage": encabezado,														                    
														                    "sTitle": "                                  UNIVERSIDAD TÉCNICA DE AMBATO",
													                    	"sFileName":"recursoseducativostotal.pdf"
															                }, ]
						                }
						            ]
						        }
						        
						    } );				        	
	                	
			        },
			        error: function (response, status) {
			                alert("Error");
			        },
				});	
				
				//Articulos creados por mes de un determinado año
				$(document).on('click','.mes', function () {
					var html2='<div class="chart" id="todosvsmisdia" style="width:100%; height: 300px;"></div><div class="chart" id="tblDia" ></div>';
					$("#panel3").html('');		
					$("#panel3").html(html2);
					$.ajax({
		        		type: "post",
		        		url: "/gamma/article/JSONaototalpordias/",	        		
				        dataType: "json",
				        data: {'mes':$(this).text()},
				        success: function(response, status) { 
				        	var html="<table id='tblDiasRecursos' border='1' class='table table-bordered table-striped results'><thead><th>Día</th><th>Recursos Habilitados</th><th>Recursos Deshabilitados</th><th>Recursos Totales</th></thead><tbody>";       	
				        	var b = new Array();
		                               var fila=0;
					                     for (var i = 0; i < response.length; i++) {
					                         html=html+"<tr><td><div class='dia' style='color:blue;'>"+response[i]['dia']+"</td><td>"+response[i]['habilitado']+"</td><td>"+response[i]['deshabilitado']+"</td><td>"+response[i]['total']+"</td></tr>";
					                         b[fila] = new Array();
					                         b[fila]["y"]=response[i]['dia'];
					                         b[fila]["a"] = response[i]['total'];
					                         b[fila]["b"] = response[i]['habilitado'];	
					                         b[fila]["c"] = response[i]['deshabilitado'];				                         				                        			                         		                         
					                         					                        	
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
			                    ykeys: ['a','b','c'],
			                    //ymax:50,
			                    labels: ['Total','Habilitados','Deshabilitados'],
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
							encabezado= encabezado+"<?php echo "							       					        "; ?>";
							encabezado= encabezado+"<?php echo "Recursos Educativos por Días"; ?>";
							encabezado= encabezado+"<?php echo "							        					        "; ?>";
							encabezado= encabezado+"<?php echo "							        			 "; ?>";		
							encabezado= encabezado+"Fecha: <?php print(date('m/d/Y h:i:s a', time())); ?>";
					
			                var table = $('#tblDiasRecursos').DataTable( {
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
						                    "aButtons":    [ "csv","xls", {
														                    "sExtends": "pdf",		                    
														                    "sPdfMessage": encabezado,														                    
														                    "sTitle": "                                  UNIVERSIDAD TÉCNICA DE AMBATO",
													                    	"sFileName":"recursoseducativostotal.pdf"
															                } ]
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
				
				$("#ddlLimit").on("change",function () {
					var url1="";
					if($("#ddlLimit").val()=='total')
					{
						url1="/gamma/article/JSONaototal/";
					}
					else
					{
						url1="/gamma/article/JSONaototalporanio/";
					}	
									
					$.ajax({        		
					type: "post",
	        		url: url1,	        		
			        dataType: "json",
			        success: function(response, status) {
			        	var html2='<div class="chart" id="estadistica" style="width:100%; height: 300px;"></div><div class="chart" id="tblEstadistica" ></div>';
						$("#panel1").html('');		
						$("#panel1").html(html2);    
			        	var html="<table id='tblAniosRecursos' border='1' class='table table-bordered table-striped results'><thead><th>Año</th><th>Habilitados</th><th>Deshabilitados</th><th>Total</th></thead><tbody>";     	
			        	var b = new Array();
	                               var fila=0;
				                     for (var i = 0; i < response.length; i++) {
				                         html=html+"<tr><td><div class='anios' style='color:blue;'>"+response[i]['anio']+"</div></td><td>"+response[i]['activos']+"</td><td>"+response[i]['desactivos']+"</td><td>"+response[i]['total']+"</td></tr>";
				                         b[fila] = new Array();
				                         b[fila]["y"]=response[i]['anio'];
				                         b[fila]["a"]=response[i]['total'];
				                         b[fila]["b"] = response[i]['activos'];   
				                         b[fila]["c"] = response[i]['desactivos'];                  
				                        	
				                         fila++;
			                        			                        
				                     }	
				    html=html+"</tbody> </table>";	
			        $("#tblEstadistica").html(html);	        
			        	
			        //BAR CHART
	                var bar = new Morris.Bar({
	                    element: 'estadistica',
	                    resize: true,
	                    data: b,	                    
	                    xkey: 'y',
	                    ykeys: ['a','b','c'],
	                    //ymax:50,
	                    labels: ['Total','Habilitados','Deshabilitados'],
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
					encabezado= encabezado+"<?php echo "							       					        "; ?>";
					encabezado= encabezado+"<?php echo "Recursos Educativos por Años"; ?>";
					encabezado= encabezado+"<?php echo "							        					        "; ?>";
					encabezado= encabezado+"<?php echo "							        			 "; ?>";		
					encabezado= encabezado+"Fecha: <?php print(date('m/d/Y h:i:s a', time())); ?>";				
	                
	                var table = $('#tblAniosRecursos').DataTable( {
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
						                    "aButtons":    [ "csv","xls", {
														                    "sExtends": "pdf",		                    
														                    "sPdfMessage": encabezado,														                    
														                    "sTitle": "                                  UNIVERSIDAD TÉCNICA DE AMBATO",
													                    	"sFileName":"recursoseducativosporanios.pdf"
															                }, ]
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