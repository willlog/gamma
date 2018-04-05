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
<?php $this->setPageTitle("ESTADÍSTICA RECURSO EDUCATIVO"); ?>
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
    <div id="recursoeducativo" class="panel  panel-default">
    <div class="panel-heading">
        <i class="fa fa-fw fa-book"></i> Recurso Educativo    
        <div class="pull-right">
            <div class="btn-group">
                
            </div>
        </div>    
    </div>
    <!-- /.panel-heading -->
    <div class="panel-body"> 
    	<div class="col-md-9 panel">
		&nbsp&nbsp&nbsp<label> Autor:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
		<?php foreach ($dataAutor as $key => $value) { ?>				
				<?php echo CHtml::link($value['name'], array('/user/estadisticaautor/'.$value['id']), array('target'=>'_blank'));  ?>	
		<?php } ?>
		<?php $this->widget('zii.widgets.CDetailView', array(
			'htmlOptions'=> array('class' =>'table table-mailbox results'),
			'data'=>$model,
			'attributes'=>array(
				//'id',
				//'uid',
				//array('name'=>'Autor','type'=>'raw', 'value'=>'Diego F. Leon' ),
				'title',
				'description',
				array('name'=>'Url','type'=>'raw',  'value'=>CHtml::link($model->url, $model->url, array('target'=>'_blank'))),
				//'image',
				//'reading',
				//'state',
				//'kind',
				//'creator',
				array('name'=>'Creado', 'header'=>'Date', 'value'=>Yii::app()->dateFormatter->format("d MMM y HH:mm", strtotime($model->createdAt))),
				array('name'=>'Actualizado', 'header'=>'Date', 'value'=>Yii::app()->dateFormatter->format("d MMM y HH:mm", strtotime($model->updatedAt))),				
				//'createdAt',
				//'updatedAt',
				
			),
		)); ?>
		
		
		&nbsp&nbsp&nbsp<label>Categorías:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
		
		<?php foreach ($dataProvider as $key => $value) { ?>
				
				<?php echo(' | ') ?>	
				<?php echo CHtml::link($value['name'], array('/category/estadisticacategoria/'.$value['id']), array('target'=>'_blank'));  ?>	
		<?php } ?>
		<input id ="artid" value="<?php echo $model->id?>" hidden="hidden"/>
		
		
	</div>	
      <div class="col-md-3">
          <div class="chart" id="estadistica" style="height: 250px;"></div>
        </div>
        
    </div>
    <!-- /.panel-body -->    
    <!-- /.panel-footer -->
</div>
<!-- /.panel -->


</div>
</div>

<div class="row">
<div  class="col-md-11 alpha omega ">	
	<div id="Anio" class="panel  panel-default">
    <div class="panel-heading">
        <i class="fa fa-bar-chart-o fa-fw"></i> Aciones Sociales por Año            
    </div>
    <!-- /.panel-heading -->
    <div class="panel-body">  
    	<div class="chart" id="accionesporanio" style="height: 250px;"></div>    
    	<div class="chart" id="tblTotal" ></div>
	</div>

</div>
</div>        
</div>

<div class="row">
<div  class="col-md-11 alpha omega ">	
	<div id="Mes" class="panel  panel-default">
	<div class="panel-heading">
	<label>Fecha Inicio: </label>
	<input data-date-format="yyyy/mm/dd" class="fecha"  id="fecha1" type="text" readonly>
	<label>&nbsp&nbsp&nbsp&nbsp Fecha Fin: </label> 
    <input data-date-format="yyyy/mm/dd" class="fecha" id="fecha2" type="text" readonly>&nbsp&nbsp&nbsp&nbsp	
    <div id="btnBuscar" class="btn btn-info">Buscar</div> 
	</div>
    <div class="panel-heading">
        <i class="fa fa-bar-chart-o fa-fw"></i> Aciones Sociales por Meses 
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
    <div id='panel1' class="panel-body"> </div>
</div>
</div>        
</div>

<div class="row">
<div class="col-md-11 alpha omega ">	
	<div id="Dia" class="panel  panel-default">	
    <div class="panel-heading">
        <i class="fa fa-bar-chart-o fa-fw"></i> Aciones Sociales por Días
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

</section><!-- /.content -->
<?php $this->endWidget(); ?>

<script type="text/javascript">

			function getPDF () {
				
				html2canvas(document.getElementById("recursoeducativo"), {
					onrendered: function (canvas) {
						img1 = canvas.toDataURL("image/png");
					}
				});
				
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
				
				doc.addImage(img1, 'JPEG', 15 , 60, 180, 80);				
				
				
				doc.addImage(img2, 'JPEG', 15 , 150, 180, 100);
				doc.addPage()
				doc.addImage(img3, 'JPEG', 15 , 20, 180, 150);
				doc.addPage()
				doc.addImage(img4, 'JPEG', 15 , 20, 180, 150);
				doc.save("recursoeducativo.pdf");
			  			
			}

			$.noConflict();
			
			jQuery(document).ready(function($){
			"use strict";	
			$("#btnBuscar").on("click",function () {
				var html2='<div class="chart" id="evolucion" style="width:100%; height: 300px;"></div><div class="chart" id="tblMes" ></div>';
					$("#panel1").html('');		
					$("#panel1").html(html2);
					$.ajax({
		        		type: "post",
		        		url: "/gamma/article/JSONevolucionrango/"+$("#artid").val(),	        		
				        dataType: "json",
				        data: {'fecha1':$("#fecha1").val(), 'fecha2':$("#fecha2").val()},
				        success: function(response, status) {  
				        var html=null; 
			        	html="<table id='tblMesesAcciones' border='1' class='table table-bordered table-striped results'><thead><th>Mes</th><th>Compartidos</th><th>Visitas</th><th>Gustados</th></thead><tbody>";      	
				        	var b = new Array();
		                               var fila=0;
					                     for (var i = 0; i < response.length; i++) {
					                         html=html+"<tr><td><div class='mes' style='color:blue;' >"+response[i]['mes']+"</div></td><td>"+response[i]['share']+"</td><td>"+response[i]['visit']+"</td><td>"+response[i]['likes']+"</td></tr>";
					                         b[fila] = new Array();
					                         b[fila]["y"]=response[i]['mes'];
					                         b[fila]["a"] = response[i]['share'];
					                         b[fila]["b"] = response[i]['visit'];
					                         b[fila]["c"] = response[i]['likes'];			                         		                         
					                         				                        	
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
			                    element: 'evolucion',
			                    resize: true,
			                    data: b,
			                    //barColors: 'auto',
			                    xkey: 'y',
			                    ykeys: ['a', 'b', 'c'],
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
			                    labels: ['Compartidos', 'Visitas', 'Gustados'],
			                    colors: [ "#00a65a","#0b62a4", "#7a92a3"],
			                    xLabelAngle:90,                    
			                    hideHover: 'auto',
			                    behaveLikeLine: true,
			      				pointFillColors:['#ffffff'],
							    pointStrokeColors: ['black'],
			                    
			                });	
			                
			                var encabezado="<?php echo "		  					                											              "; ?>";	
							encabezado= encabezado+"<?php echo "SOCIAL MEDIA ACADEMIC NETWORK"; ?>";
							encabezado= encabezado+"<?php echo "							       					        "; ?>";
							encabezado= encabezado+"<?php echo "Aciones Sociales por Meses"; ?>";
							encabezado= encabezado+"<?php echo "							        					        "; ?>";
							encabezado= encabezado+"<?php echo "							        			 "; ?>";		
							encabezado= encabezado+"Fecha: <?php print(date('m/d/Y h:i:s a', time())); ?>";
							encabezado=encabezado+" Desde: "+$("#fecha1").val() + "      Hasta: "+ $("#fecha2").val();
							encabezado= encabezado+"<?php echo "						        			 "; ?>";
							encabezado= encabezado+"<?php echo "						        			 "; ?>";
							encabezado= encabezado+"<?php echo "						        		 "; ?>";
							encabezado= encabezado+"<?php echo "						        		 "; ?>";
							encabezado=encabezado+" Recurso Educativo: <?php echo $model->title?>";
			                
			                var table = $('#tblMesesAcciones').DataTable( {
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
												                    	"sFileName":"recursoeducativopormeses.pdf"
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
				
			//Aciones soliciales del oa separado por años
			$.ajax({
        		type: "post",
        		url: "/gamma/article/JSONsharevisitlikeoaporanio/"+$("#artid").val(),	        		
		        dataType: "json",
		        success: function(response, status) {  
		        	var html="<table id='tblAniosAcciones' border='1' class='table table-bordered table-striped results'><thead><th>Año</th><th>Compartidos</th><th>Visitas</th><th>Gustados</th></thead><tbody>";      	
		        	var b = new Array();
                               var fila=0;
			                     for (var i = 0; i < response.length; i++) {
			                        html=html+"<tr><td><div class='anios' style='color:blue;' >"+response[i]['anio']+"</div></td><td>"+response[i]['compartido']+"</td><td>"+response[i]['visitado']+"</td><td>"+response[i]['gustado']+"</td></tr>"; 
			                         b[fila] = new Array();
			                         b[fila]["y"]=response[i]['anio'];
			                         b[fila]["a"] = response[i]['compartido'];
			                         b[fila]["b"] = response[i]['visitado'];
			                         b[fila]["c"] = response[i]['gustado'];          			                         		                         
			                         			                        	
			                         fila++;		                        			                        
			                     }
			         html=html+"</tbody> </table>";	
			         $("#tblTotal").html(html);	        
		        	
		        	//BAR CHART
	                var bar = new Morris.Bar({
	                    element: 'accionesporanio',
	                    resize: true,
	                    data: b,
	                    //barColors: 'auto',
	                    xkey: 'y',
	                    ykeys: ['a', 'b', 'c'],
	                    //ymax:100,
	                    labels: ['Compartidos', 'Visitas', 'Gustados'],
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
					encabezado= encabezado+"<?php echo "							        					        "; ?>";
					encabezado= encabezado+"<?php echo "Aciones Sociales por Años"; ?>";
					encabezado= encabezado+"<?php echo "							        					        "; ?>";
					encabezado= encabezado+"<?php echo "							        			 "; ?>";		
					encabezado= encabezado+"Fecha: <?php print(date('m/d/Y h:i:s a', time())); ?>";
					encabezado=encabezado+" Recurso Educativo: <?php echo $model->title?>";
            
	                var table = $('#tblAniosAcciones').DataTable( {
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
												                    	"sFileName":"recursoeducativoporanios.pdf"
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
			
				
			$.ajax({
	        		type: "post",
	        		url: "/gamma/article/JSONoasharevisitlike/"+$("#artid").val(),	        		
			        dataType: "json",
			        success: function(response, status) {        	
			        	var b = new Array();
	                               var fila=0;
				                     for (var i = 0; i < response.length; i++) {
				                         
					                         b[fila] = new Array();
					                         
					                         b[fila]["label"]=response[i]['label'];
					                         b[fila]["value"] = response[i]['value'];				                         
					                        	
					                         fila++;				                        
				                     }		        
			        	
			        	var donut = new Morris.Donut({ 
			        		element: "estadistica", 
			        		resize: true, 
			        		colors: [ "#00a65a","#0b62a4", "#7a92a3"], 
			        		data: b, 
			        		hideHover: "auto" });			        	
	                	
			        },
			        error: function (response, status) {
			                alert("Error");
			        },
				});
				
				//Aciones sociales por meses de un determinado año
				$(document).on('click','.mes', function () {
					var html2='<div class="chart" id="evoluciondias" style="width:100%; height: 300px;"></div><div class="chart" id="tblDia" ></div>';
					$("#panel3").html('');		
					$("#panel3").html(html2);
					$.ajax({
		        		type: "post",
		        		url: "/gamma/article/JSONevoluciondias/"+$("#artid").val(),	        		
				        dataType: "json",
				        data: {'mes':$(this).text()},
				        success: function(response, status) {  
				        var html=null; 
			        	html="<table id='tblDiasAcciones' border='1' class='table table-bordered table-striped results'><thead><th>Día</th><th>Compartidos</th><th>Visitas</th><th>Gustados</th></thead><tbody>";      	
				        	var b = new Array();
		                               var fila=0;
					                     for (var i = 0; i < response.length; i++) {
					                         html=html+"<tr><td><div class='dia' style='color:blue;' >"+response[i]['dia']+"</a></td><td>"+response[i]['share']+"</td><td>"+response[i]['visit']+"</td><td>"+response[i]['likes']+"</td></tr>";
					                         b[fila] = new Array();
					                         b[fila]["y"]=response[i]['dia'];
					                         b[fila]["a"] = response[i]['share'];
					                         b[fila]["b"] = response[i]['visit'];
					                         b[fila]["c"] = response[i]['likes'];			                         		                         
					                         				                        	
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
			                //var bar = new Morris.Line({
			                    element: 'evoluciondias',
			                    resize: true,
			                    data: b,
			                    //barColors: 'auto',
			                    xkey: 'y',
			                    ykeys: ['a', 'b', 'c'],
			                    //ymax:50,
			                    /*xLabels:'month',
			                    xLabelFormat: function (y) {
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
			                    labels: ['Compartidos', 'Visitas', 'Gustados'],
			                    colors: [ "#00a65a","#0b62a4", "#7a92a3"],
			                    xLabelAngle:90,                    
			                    hideHover: 'auto',
			                    behaveLikeLine: true,
			      				pointFillColors:['#ffffff'],
							    pointStrokeColors: ['black'],
			                    
			                });		
			                
			                var encabezado="<?php echo "		  					                											              "; ?>";	
							encabezado= encabezado+"<?php echo "SOCIAL MEDIA ACADEMIC NETWORK"; ?>";
							encabezado= encabezado+"<?php echo "							        					        "; ?>";
							encabezado= encabezado+"<?php echo "Aciones Sociales por Días"; ?>";
							encabezado= encabezado+"<?php echo "							        					        "; ?>";
							encabezado= encabezado+"<?php echo "							        			 "; ?>";		
							encabezado= encabezado+"Fecha: <?php print(date('m/d/Y h:i:s a', time())); ?>";
							encabezado=encabezado+" Recurso Educativo: <?php echo $model->title?>";	
					                
			                var table = $('#tblDiasAcciones').DataTable( {
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
												                    	"sFileName":"recursoeducativopordias.pdf"
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