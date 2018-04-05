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
<?php $this->setPageTitle("RECURSOS MÁS COMPARTIDOS"); ?>
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
<div class="col-md-11 alpha omega ">	
	<div id="Anio" class="panel  panel-default">
    <div  class="panel-heading">    	
        <i class="fa fa-bar-chart-o fa-fw"></i> Mas Compartidos de Todos los Tiempos 
        
        <div style="float: right;"> 
	        <label>Top: </label>
	    	<select id="ddlLimit">
	        <option>5</option>
	        <option>10</option>
	        <option>15</option>	        
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
        <i class="fa fa-bar-chart-o fa-fw"></i> Mas Compartidos por Fechas 
        
        <div style="float: right;"> 
	        <label>Top: </label>
	    	<select id="ddlLimitmes">
	        <option>5</option>
	        <option>10</option>
	        <option>15</option>	        
	    	</select>
    	</div>   
        
    </div>  
     
   
    <!-- /.panel-heading -->
    <div id='panel2' class="panel-body"> </div>

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
			
			doc.save("mascompartidos.pdf");
		  			
		}

		$.noConflict();		
		jQuery(document).ready(function($){	
			"use strict";				
				$.ajax({					
	        		type: "post",
	        		url: "/gamma/article/JSONMascompartidostotal/",	        		
			        dataType: "json",
			        success: function(response, status) {   
			        	var html2='<div class="chart" id="estadistica" style="width:100%; height: 300px;"></div><div class="chart" id="tblEstadistica" ></div>';
						$("#panel1").html('');		
						$("#panel1").html(html2);
			        	var html="<table id='tblTotalCompartidos' border='1' class='table table-bordered table-striped results'><thead><th>Título</th><th>Creador</th><th>Compartidos</th></thead><tbody>";     	
			        	var b = new Array();
	                               var fila=0;
				                     for (var i = 0; i < response.length; i++) {
				                         html=html+"<tr><td><a href='"+response[i]['url']+"' target='_blank'>"+response[i]['title']+"</a></td><td>"+response[i]['name']+"</a></td><td>"+response[i]['share']+"</td></tr>";
				                         b[fila] = new Array();
				                         b[fila]["y"]=response[i]['title'];
				                         b[fila]["a"] = response[i]['share'];       			                         		                         
				                         				                        	
				                         fila++;
				                         
				                         if(i==$("#ddlLimit").val()-1)
				                         {
				                         	i=response.length;
				                         }
				                         			                        			                        
				                     }	
				    html=html+"</tbody> </table>";	
			        $("#tblEstadistica").html(html);	        
			        	
			        	//BAR CHART
	                var bar = new Morris.Bar({
	                    element: 'estadistica',
	                    resize: true,
	                    data: b,
	                    //barColors: 'auto',
	                    xkey: 'y',
	                    ykeys: ['a'],
	                    //ymax:50,
	                    labels: ['Compartidos'],
	                    fillOpacity: 0.8,
	                    //hideHover: 'auto',
	      				behaveLikeLine: true,
	      				pointFillColors:['#ffffff'],
					    pointStrokeColors: ['black'],
					    lineColors:['black','red'],
	                    xLabelAngle:45,                    
	                    hideHover: 'auto'
	                });	
	                
	                var encabezado="<?php echo "		  	                                                        											              "; ?>";	
					encabezado= encabezado+"<?php echo "SOCIAL MEDIA ACADEMIC NETWORK"; ?>";
					encabezado= encabezado+"<?php echo "							        					        "; ?>";
					encabezado= encabezado+"<?php echo "							        					        "; ?>";
					encabezado= encabezado+"<?php echo "Recursos Más Compartidos de Todos los Tiempos"; ?>";
					encabezado= encabezado+"<?php echo "					                                                          		        "; ?>";
					encabezado= encabezado+"<?php echo "							        			 "; ?>";		
					encabezado= encabezado+"Fecha: <?php print(date('m/d/Y h:i:s a', time())); ?> ";
	                
	                var table = $('#tblTotalCompartidos').DataTable( {
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
													                    "sPdfOrientation": "landscape",            
													                    "sTitle": "                               											                             	   UNIVERSIDAD TÉCNICA DE AMBATO",
													                    "sFileName":"mascompartidostodoslostiempos.pdf"
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
					var html2='<div class="chart" id="estadistica" style="width:100%; height: 300px;"></div><div class="chart" id="tblEstadistica" ></div>';
					$("#panel1").html('');		
					$("#panel1").html(html2);
					$.ajax({
		        		type: "post",
		        		url: "/gamma/article/JSONMascompartidostotal/",	        		
				        dataType: "json",
				        success: function(response, status) {   
				        	var html="<table id='tblTotalCompartidos' border='1' class='table table-bordered table-striped results'><thead><th>Título</th><th>Creador</th><th>Compartidos</th></thead><tbody>";     	
				        	var b = new Array();
		                               var fila=0;
					                     for (var i = 0; i < response.length; i++) {
					                         html=html+"<tr><td><a href='"+response[i]['url']+"' target='_blank'>"+response[i]['title']+"</a></td><td>"+response[i]['name']+"</a></td><td>"+response[i]['share']+"</td></tr>";
					                         b[fila] = new Array();
					                         b[fila]["y"]=response[i]['title'];
					                         b[fila]["a"] = response[i]['share'];				                                            		                         
					                        					                        	
					                         fila++;
					                         
					                         if(i==$("#ddlLimit").val()-1)
					                         {
					                         	i=response.length;
					                         }
				                        			                        
					                     }	
					    html=html+"</tbody> </table>";	
				        $("#tblEstadistica").html(html);	        
				        	
				        	//BAR CHART
		                var bar = new Morris.Bar({
		                    element: 'estadistica',
		                    resize: true,
		                    data: b,
		                    //barColors: 'auto',
		                    xkey: 'y',
		                    ykeys: ['a'],
		                    //ymax:50,
		                    labels: ['Compartidos'],
		                    fillOpacity: 0.8,
		                    //hideHover: 'auto',
		      				behaveLikeLine: true,
		      				pointFillColors:['#ffffff'],
						    pointStrokeColors: ['black'],
						    lineColors:['black','red'],
		                    xLabelAngle:45,                    
		                    hideHover: 'auto'
		                });	
		                
		                var encabezado="<?php echo "		  	                                                        											              "; ?>";	
						encabezado= encabezado+"<?php echo "SOCIAL MEDIA ACADEMIC NETWORK"; ?>";
						encabezado= encabezado+"<?php echo "							        					        "; ?>";
						encabezado= encabezado+"<?php echo "							        					        "; ?>";
						encabezado= encabezado+"<?php echo "Recursos Más Compartidos de Todos los Tiempos"; ?>";
						encabezado= encabezado+"<?php echo "					                                                          		        "; ?>";
						encabezado= encabezado+"<?php echo "							        			 "; ?>";		
						encabezado= encabezado+"Fecha: <?php print(date('m/d/Y h:i:s a', time())); ?> ";
						
		                var table = $('#tblTotalCompartidos').DataTable( {
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
													                    "sPdfOrientation": "landscape",            
													                    "sTitle": "                               											                             	   UNIVERSIDAD TÉCNICA DE AMBATO",
													                    "sFileName":"mascompartidostodoslostiempos.pdf"
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
				
				$("#btnBuscar").on("click",function () 
				{
					$.ajax({
		        		type: "post",
		        		url: "/gamma/article/JSONMascompartidosrango/",	        		
				        dataType: "json",
				        data: {'fecha1':$("#fecha1").val(), 'fecha2':$("#fecha2").val()},
				        success: function(response, status) {
				        var html2='<div class="chart" id="evolucion" style="width:100%; height: 300px;"></div><div class="chart" id="tblMes" ></div>';
						$("#panel2").html('');		
						$("#panel2").html(html2);  
				        var html=null; 
			        	html="<table id='tblMesesCompartidos' border='1' class='table table-bordered table-striped results'><thead><th>Título</th><th>Creador</th><th>Compartidos</th></thead><tbody>";      	
				        	var b = new Array();
		                               var fila=0;
					                     for (var i = 0; i < response.length; i++) {
					                         html=html+"<tr><td><a href='"+response[i]['url']+"' target='_blank'>"+response[i]['title']+"</a></td><td>"+response[i]['name']+"</a></td><td>"+response[i]['share']+"</td></tr>";
					                         b[fila] = new Array();
					                         b[fila]["y"]=response[i]['title'];
					                         b[fila]["a"] = response[i]['share'];				                         			                         		                         
					                         				                        	
					                         fila++;	
					                         
					                         if(i==$("#ddlLimitmes").val()-1)
					                         {
					                         	i=response.length;
					                         }		                        			                        
					                     }	
					          html=html+"</tbody> </table>";					          	
				        	  $("#tblMes").html(html); 	
				        	          
				        	
				        	//LINE CHART
			                var bar = new Morris.Bar({
			                    element: 'evolucion',
			                    resize: true,
			                    data: b,
			                    //barColors: 'auto',
			                    xkey: 'y',
			                    ykeys: ['a'],
			                    //ymax:50,
			                    //xLabels:'month',
			                    /*xLabelFormat: function (y) {
								                  var IndexToMonth = ["Enero", "Febreo", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
								                  var month = IndexToMonth[ y.getMonth() ];
								                  //var year = y.getFullYear();
								                  return month;
								              },
								              
								dateFormat: function (y) {
								                  var IndexToMonth = ["Enero", "Febreo", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
								                  var month = IndexToMonth[ new Date(y).getMonth() ];
								                  //var year = new Date(y).getFullYear();
								                  return month;
								              },*/
			                    labels: ['Compartido'],
			                    colors: [ "#00a65a","#0b62a4", "#7a92a3"],
			                    xLabelAngle:45,                    
			                    hideHover: 'auto'
			                    
			                });	
			                
			                var encabezado="<?php echo "		  	                                                        											              "; ?>";	
							encabezado= encabezado+"<?php echo "SOCIAL MEDIA ACADEMIC NETWORK"; ?>";
							encabezado= encabezado+"<?php echo "							        					        "; ?>";
							encabezado= encabezado+"<?php echo "							        			        "; ?>";
							encabezado= encabezado+"<?php echo "Recursos Más Compartidos por Fechas               "; ?>";
							encabezado= encabezado+"<?php echo "		  	                                                                    		        "; ?>";
							encabezado= encabezado+"<?php echo "					        			 "; ?>";		
							encabezado= encabezado+"Fecha: <?php print(date('m/d/Y h:i:s a', time())); ?>         ";												        			                         "; ?>";
							encabezado=encabezado+" Desde: "+$("#fecha1").val() + "      Hasta: "+ $("#fecha2").val();	
			                
			                var table = $('#tblMesesCompartidos').DataTable( {
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
														                    "sPdfOrientation": "landscape",            
														                    "sTitle": "                               											                             	   UNIVERSIDAD TÉCNICA DE AMBATO",
														                    "sFileName":"mascompartidosporfechas.pdf"
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