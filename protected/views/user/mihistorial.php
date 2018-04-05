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
<section class="content">
	<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'estadistica-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
<?php $this->setPageTitle("MI HISTORIAL"); ?>
<div id="btnDescargar" ><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/pdf.ico" width="25" height="25" /></div>	

<div id="HTMLtoPDF" class="row">
    <div class="col-md-11 alpha omega ">
    <div id="Autor" class="panel  panel-default">
    <div class="panel-heading">
        <i class="fa fa-fw fa-user"></i> Autor    
        <div class="pull-right">
            <div class="btn-group">
                
            </div>
        </div>    
    </div>
    <!-- /.panel-heading -->
    <div class="panel-body"> 
    	<div class="col-md-7 panel">
		<?php $this->widget('zii.widgets.CDetailView', array(
			'htmlOptions'=> array('class' =>'table table-mailbox results'),
			'data'=>$model,
			'attributes'=>array(
				//'id',
				//'uid',
				'firstname',
				'lastname',
				//array('name'=>'Url','type'=>'raw',  'value'=>CHtml::link($model->url, $model->url, array('target'=>'_blank'))),
				//'image',
				//'reading',
				//'state',
				//'kind',
				//'creator',
				array('name'=>'Creado', 'header'=>'Date', 'value'=>Yii::app()->dateFormatter->format("d MMM y HH:mm", strtotime($model->createdAt))),
				//array('name'=>'Actualizado', 'header'=>'Date', 'value'=>Yii::app()->dateFormatter->format("d MMM y HH:mm", strtotime($model->updatedAt))),
				//'createdAt',
				//'updatedAt',
			),
		)); ?>
	<input id ="artid" value="<?php echo $model->id?>" hidden="hidden"/>	
	<table >
	<thead>		
	</thead>
		
	<tbody>
		<?php foreach ($dataProvider as $key => $value) { ?>
			<tr>		
				<td width="195px">&nbsp&nbsp<label><?php echo $value['accion']; ?></label></td>		
				<td><?php echo $value['cantidad']; ?></td>
			</tr>
		<?php } ?>
		
		
	</tbody>
</table>

<table >
	<thead>
		
	</thead>
		
	<tbody>
		<?php foreach ($dataProvider1 as $key => $value) { ?>
			<tr height="5px">		
				<td width="195px">&nbsp&nbsp<label><?php echo $value['estado']; ?></label></td>		
				<td><?php echo $value['cantidad']; ?></td>
			</tr>
		<?php } ?>		
	</tbody>
</table>
	<br>
	<?php echo CHtml::link('Recomendados', array('/user/recomendadosautor/'.$model->id), array('target'=>'_blank', 'class'=>'btn btn-info btnVistaArticle'));  ?>
	<?php echo CHtml::link('Compartidos', array('/user/compartidosautor/'.$model->id), array('target'=>'_blank', 'class'=>'btn btn-info btnVistaArticle'));  ?>
	<?php echo CHtml::link('Visitados', array('/user/visitadosautor/'.$model->id), array('target'=>'_blank', 'class'=>'btn btn-info btnVistaArticle'));  ?>
	<?php echo CHtml::link('Gustados', array('/user/gustadosautor/'.$model->id), array('target'=>'_blank', 'class'=>'btn btn-info btnVistaArticle'));  ?>
	<?php echo CHtml::link('Por Categoría', array('/user/autorporcategoria/'.$model->id), array('target'=>'_blank', 'class'=>'btn btn-info btnVistaArticle'));  ?>	
	</div>	
      <div class="col-md-5">
                
                <div class="chart" id="activosdesactivos" style="height: 250px;"></div>

        </div>
        
    </div>
    <!-- /.panel-body -->    
    <!-- /.panel-footer -->
</div>
<!-- /.panel -->


</div>
</div>
<div class="row">
<div class="col-md-11 alpha omega ">	
	<div id="Anio" class="panel  panel-default">
    <div class="panel-heading">
        <i class="fa fa-bar-chart-o fa-fw"></i> Total Recursos Educativos vs Mis Recursos Educativos 
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
        <i class="fa fa-bar-chart-o fa-fw"></i> Total Recursos Educativos vs Mis Recursos Educativos por Meses 
        <div style="float: right;"> 
	        <label>Tipo de Gráfica: </label>
	    	<select id="ddlTipo" style="width: 150px;">
	        <option value="Line">Líneas</option>
	        <option value="Area">Áreas</option>
	        <option value="Bar">Barras</option>	        	        
	    	</select>           
    </div>      
    <!-- /.panel-heading -->
    <div id='panel2' class="panel-body"> </div>

</div>
</div>        
    </div>
</div>

<div class="row">
<div class="col-md-11 alpha omega ">	
	<div id="Dia" class="panel  panel-default">	
    <div class="panel-heading">
        <i class="fa fa-bar-chart-o fa-fw"></i> Total Recursos Educativos vs Mis Recursos Educativos por Días 
        <div style="float: right;"> 
	        <label>Tipo de Gráfica: </label>
	    	<select id="ddlTipodia" style="width: 150px;">
	        <option value="Line">Líneas</option>
	        <option value="Area">Áreas</option>
	        <option value="Bar">Barras</option>	        	        
	    	</select>           
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
				
			html2canvas(document.getElementById("Autor"), {
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
			
			doc.addImage(img1, 'JPEG', 15 , 60, 180, 70);				
			
			
			doc.addImage(img2, 'JPEG', 15 , 150, 180, 100);
			doc.addPage()
			doc.addImage(img3, 'JPEG', 15 , 20, 180, 150);
			doc.addPage()
			doc.addImage(img4, 'JPEG', 15 , 20, 180, 150);
			doc.save("mihistorial.pdf");
		  			
		}
		
		$.noConflict();
		
		jQuery(document).ready(function($){		
		
			"use strict";				
			$.ajax({
	        		type: "post",
	        		url: "/gamma/user/JSONoaactivosdesactivos/"+$("#artid").val(),	        		
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
			        		element: "activosdesactivos", 
			        		resize: true, 
			        		colors: [ "#0b62a4", "#7a92a3"], 
			        		data: b, 
			        		hideHover: "auto" });			        	
	                	
			        },
			        error: function (response, status) {
			                alert("Error");
			        },
				});
				
				$.ajax({
	        		type: "post",
	        		url: "/gamma/user/JSONtotalvsautoroa/"+$("#artid").val(),	        		
			        dataType: "json",
			        success: function(response, status) { 
			        	var html2='<div class="chart" id="estadistica" style="width:100%; height: 300px;"></div><div class="chart" id="tblEstadistica" ></div>';
			        	$("#panel1").html('');		
						$("#panel1").html(html2);	  
			        	var html="<table id='tblTotalAnio' border='1' class='table table-bordered table-striped results'><thead><th>Año</th><th>Recursos Autor</th><th>Recursos Totales</th><th>Porcentaje(%)</th></thead><tbody>";     	
			        	var b = new Array();
	                               var fila=0;
				                     for (var i = 0; i < response.length; i++) {
				                         html=html+"<tr><td><div class='anio' style='color:blue;'>"+response[i]['anio']+"</div></td><td>"+response[i]['cantidad']+"</td><td>"+response[i]['total']+"</td><td>"+response[i]['porcentaje']+"</td></tr>";
				                         b[fila] = new Array();
				                         b[fila]["y"]=response[i]['anio'];
				                         b[fila]["a"]=response[i]['total'];
				                         b[fila]["b"] = response[i]['cantidad'];                  
				                        	
				                         fila++;
			                        			                        
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
	                    ykeys: ['a','b'],
	                    //ymax:50,
	                    labels: ['Total', 'Autor'],
	                    fillOpacity: 0.8,
	                    //hideHover: 'auto',
	      				behaveLikeLine: true,
	      				pointFillColors:['#ffffff'],
					    pointStrokeColors: ['black'],
					    //lineColors:['black','red'],
	                    xLabelAngle:45,                    
	                    hideHover: 'auto'
	                });	
	                
	                var encabezado="<?php echo "		  					                											              "; ?>";	
					encabezado= encabezado+"<?php echo "SOCIAL MEDIA ACADEMIC NETWORK"; ?>";
					encabezado= encabezado+"<?php echo "							        					        "; ?>";
					encabezado= encabezado+"<?php echo "Total recursos vs Mis recursos"; ?>";
					encabezado= encabezado+"<?php echo "							        					        "; ?>";
					encabezado= encabezado+"<?php echo "							        			 "; ?>";		
					encabezado= encabezado+"Fecha: <?php print(date('m/d/Y h:i:s a', time())); ?>";
					encabezado=encabezado+" Usuario: "+"<?php echo $model->name; ?>";					
	                
	                var table = $('#tblTotalAnio').DataTable( {
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
					                    "aButtons":    [ "csv","xls", 
					                    						{"sExtends": "pdf",	                    
	                    										 "sPdfMessage": encabezado, 
	                    										 "sTitle": "                                  UNIVERSIDAD TÉCNICA DE AMBATO",
	                    										 "sFileName":"totalvsmisreursos.pdf"
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
						url1="/gamma/user/JSONtotalvsautoroa/"+$("#artid").val();
					}
					else
					{
						url1="/gamma/user/JSONaototalporaniovsautoroa/"+$("#artid").val();
					}
					
					$.ajax({
	        		type: "post",
	        		url: url1,	        		
			        dataType: "json",
			        success: function(response, status) { 
			        	var html2='<div class="chart" id="estadistica" style="width:100%; height: 300px;"></div><div class="chart" id="tblEstadistica" ></div>';
			        	$("#panel1").html('');		
						$("#panel1").html(html2);	  
			        	var html="<table id='tblTotalAnioLimit' class='table table-bordered table-striped results' border='1' class='table table-mailbox results'><thead><th>Año</th><th>Recursos Autor</th><th>Recursos Totales</th><th>Porcentaje(%)</th></thead><tbody>";     	
			        	var b = new Array();
	                               var fila=0;
				                     for (var i = 0; i < response.length; i++) {
				                         html=html+"<tr><td><div class='anios' style='color:blue;'>"+response[i]['anio']+"</div></td><td>"+response[i]['cantidad']+"</td><td>"+response[i]['total']+"</td><td>"+response[i]['porcentaje']+"</td></tr>";
				                         b[fila] = new Array();
				                         b[fila]["y"]=response[i]['anio'];
				                         b[fila]["a"]=response[i]['total'];
				                         b[fila]["b"] = response[i]['cantidad'];                  
				                        	
				                         fila++;
			                        			                        
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
	                    ykeys: ['a','b'],
	                    //ymax:50,
	                    labels: ['Total', 'Autor'],
	                    fillOpacity: 0.8,
	                    //hideHover: 'auto',
	      				behaveLikeLine: true,
	      				pointFillColors:['#ffffff'],
					    pointStrokeColors: ['black'],
					    //lineColors:['black','red'],
	                    xLabelAngle:45,                    
	                    hideHover: 'auto'
	                });	
	                
	                var encabezado="<?php echo "		  					                											              "; ?>";	
					encabezado= encabezado+"<?php echo "SOCIAL MEDIA ACADEMIC NETWORK"; ?>";
					encabezado= encabezado+"<?php echo "							        				        "; ?>";
					encabezado= encabezado+"<?php echo "Total recursos vs Mis recursos por Año"; ?>";
					encabezado= encabezado+"<?php echo "							        			  "; ?>";
					encabezado= encabezado+"<?php echo "							        			 "; ?>";		
					encabezado= encabezado+"Fecha: <?php print(date('m/d/Y h:i:s a', time())); ?>";
					encabezado=encabezado+" Usuario: <?php echo $model->name?>";
	                
	                var table = $('#tblTotalAnioLimit').DataTable( {
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
													                    	"sFileName":"totalvsmisreursosporanio.pdf"
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
				
				$("#btnBuscar").on("click",function () {
				var html2='<div class="chart" id="todosvsmismes" style="width:100%; height: 300px;"></div><div class="chart" id="tblMes" ></div>';
					$("#panel2").html('');		
					$("#panel2").html(html2);
					$.ajax({
		        		type: "post",
		        		url: "/gamma/user/JSONaototalpormesvsautoroarango/"+$("#artid").val(),	        		
				        dataType: "json",
				        data: {'fecha1':$("#fecha1").val(), 'fecha2':$("#fecha2").val()},
				        success: function(response, status) {				        	 
				        	var html="<table id='tblTotalMeses' border='1' class='table table-bordered table-striped results'><thead><th>Mes</th><th>Recursos Autor</th><th>Recursos Totales</th><th>Porcentaje (%)</th></thead><tbody>";       	
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
			                    //ymax:50,
			                    labels: ['Total', 'Autor'],
			                    //fillOpacity: 0.8,
			                    //hideHover: 'auto',
			      				behaveLikeLine: true,
			      				pointFillColors:['#ffffff'],
							    pointStrokeColors: ['black'],
							    lineColors: [ '#3c8dbc','#a0d0e0'],
			                    xLabelAngle:90,                    
			                    hideHover: 'auto'
			                });	
			                
			                var encabezado="<?php echo "		  					                											              "; ?>";	
							encabezado= encabezado+"<?php echo "SOCIAL MEDIA ACADEMIC NETWORK"; ?>";
							encabezado= encabezado+"<?php echo "						        					        "; ?>";
							encabezado= encabezado+"<?php echo "Total recursos vs Mis recursos por Meses"; ?>";
							encabezado= encabezado+"<?php echo "									        "; ?>";
							encabezado= encabezado+"<?php echo "						        			 "; ?>";		
							encabezado= encabezado+"Fecha: <?php print(date('m/d/Y h:i:s a', time())); ?>";
							encabezado=encabezado+" Usuario: <?php echo $model->name?>";
							encabezado= encabezado+"<?php echo "						        			 "; ?>";
							encabezado= encabezado+"<?php echo "						        			 "; ?>";
							encabezado= encabezado+"<?php echo "						        			 "; ?>";
							encabezado= encabezado+"<?php echo "						        			 "; ?>";
							encabezado= encabezado+"<?php echo "						        			 "; ?>";
							encabezado=encabezado+" Desde: "+$("#fecha1").val() + "      Hasta: "+ $("#fecha2").val();
			                
			                var table = $('#tblTotalMeses').DataTable( {
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
													                    	"sFileName":"totalvsmisreursospormeses.pdf"
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
				
			//Articulos creados por día de un determinado mes
			$(document).on('click','.mes', function () {				
				var html2='<div class="chart" id="todosvsmisdia" style="width:100%; height: 300px;"></div><div class="chart" id="tblDia" ></div>';
					$("#panel3").html('');		
					$("#panel3").html(html2);
					$.ajax({
		        		type: "post",
		        		url: "/gamma/user/JSONaototalpormesvsautoroadias/"+$("#artid").val(),	        		
				        dataType: "json",
				        data: {'mes':$(this).text()},
				        success: function(response, status) {				        	 
				        	var html="<table id='tblTotalDias' border='1' class='table table-bordered table-striped results'><thead><th>Día</th><th>Recursos Autor</th><th>Recursos Totales</th><th>Porcentaje (%)</th></thead><tbody>";       	
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
			                //var bar = new Morris.Area({
			                    element: 'todosvsmisdia',
			                    resize: true,
			                    data: b,
			                    //barColors: 'auto',
			                    xkey: 'y',
			                    ykeys: ['a', 'b'],
			                    //ymax:50,
			                    labels: ['Total', 'Autor'],
			                    //fillOpacity: 0.8,
			                    //hideHover: 'auto',
			      				behaveLikeLine: true,
			      				pointFillColors:['#ffffff'],
							    pointStrokeColors: ['black'],
							    lineColors: [ '#3c8dbc','#a0d0e0'],
			                    xLabelAngle:90,                    
			                    hideHover: 'auto'
			                });
			                
			                var encabezado="<?php echo "		  					                											              "; ?>";	
							encabezado= encabezado+"<?php echo "SOCIAL MEDIA ACADEMIC NETWORK"; ?>";
							encabezado= encabezado+"<?php echo "							        					        "; ?>";
							encabezado= encabezado+"<?php echo "Total recursos vs Mis recursos por Días"; ?>";
							encabezado= encabezado+"<?php echo "									        "; ?>";
							encabezado= encabezado+"<?php echo "						        			 "; ?>";		
							encabezado= encabezado+"Fecha: <?php print(date('m/d/Y h:i:s a', time())); ?>";
							encabezado=encabezado+" Usuario: <?php echo $model->name?>";
			                
			                var table = $('#tblTotalDias').DataTable( {
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
													                    	"sFileName":"totalvsmisreursospordias.pdf"
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
