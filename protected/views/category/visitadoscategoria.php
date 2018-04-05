<!-- jQuery 2.0.2 -->
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/datatables/dataTables.tableTools.css" rel="stylesheet" type="text/css" />
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap-datepicker3.css" rel="stylesheet" type="text/css" />
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/bootstrap-datepicker.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/dataTables.bootstrap.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/dataTables.tableTools.js"></script>
<?php $this->setPageTitle("MÁS VISITADOS POR CATEGORÍA"); ?>
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
        <i class="fa fa-fw fa-folder-o"></i> Categoría  
        <div class="pull-right">
            <div class="btn-group">
                
            </div>
        </div>    
    </div>
    <!-- /.panel-heading -->
    <div class="panel-body"> 
    	<div class="col-md-6 panel">
		<?php $this->widget('zii.widgets.CDetailView', array(
			'htmlOptions'=> array('class' =>'table table-mailbox results'),
			'data'=>$model,
			'attributes'=>array(
				//'id',
				//'uid',
				'name',
				'description',
				//array('name'=>'Url','type'=>'raw',  'value'=>CHtml::link($model->url, $model->url, array('target'=>'_blank'))),
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
	<input id ="catid" value="<?php echo $model->id?>" hidden="hidden"/>	
	<table>
	<thead>
		
	</thead>
		
	<tbody>
		<?php foreach ($dataProvider as $key => $value) { ?>
			<tr>		
				<td width="215px">&nbsp&nbsp<label><?php echo $value['articulos']; ?></label></td>		
				<td><?php echo $value['cantidad']; ?></td>
			</tr>
		<?php } ?>
		
		
	</tbody>
</table>
	
    
	</div>	
     
        
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
        <i class="fa fa-bar-chart-o fa-fw"></i> Recursos Educativos Más Visitados de Todos los Tiempos
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
<div class="col-md-12 alpha omega ">	
	<div class="panel  panel-default">
	<div class="panel-heading">
	<label>Fecha Inicio: </label>
	<input data-date-format="yyyy/mm/dd" class="fecha"  id="fecha1" type="text" readonly>
	<label>&nbsp&nbsp&nbsp&nbsp Fecha Fin: </label> 
    <input data-date-format="yyyy/mm/dd" class="fecha" id="fecha2" type="text" readonly>&nbsp&nbsp&nbsp&nbsp	
    <div id="btnBuscar" class="btn btn-info">Buscar</div> 
	</div>
    <div class="panel-heading">
        <i class="fa fa-bar-chart-o fa-fw"></i> Recursos Educativos Más Visitados por Fechas 
        <div style="float: right;"> 
	        <label>Top: </label>
	    	<select id="ddlLimitfecha">
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

    <!-- /.panel-body -->
    
    <!-- /.panel-footer -->
</div>
</div>
</section><!-- /.content -->
<?php $this->endWidget(); ?>

<script type="text/javascript">

		$.noConflict();
			
		jQuery(document).ready(function($){
			"use strict";
			$.ajax({
	        		type: "post",
	        		url: "/gamma/category/JSONmasvisitadoscategoria/"+$("#catid").val(),	        		
			        dataType: "json",
			        success: function(response, status) { 
			        	var html2='<div class="chart" id="recomendados" style="width:100%; height: 300px;"></div><div class="chart" id="tblRecomendados" ></div>';
						$("#panel1").html('');		
						$("#panel1").html(html2);   
			        	var html="<table id='tblTotalVisitas' border='1' class='table table-bordered table-striped results'><thead><th>Recurso Educativo</th><th>Autor</th><th>Visitas</th></thead><tbody>";     	
			        	var b = new Array();
	                               var fila=0;
				                     for (var i = 0; i < response.length; i++) {
				                         html=html+"<tr><td><a href='"+response[i]['url']+"' target='_blank'>"+response[i]['title']+"</a></td><td>"+response[i]['autor']+"</td><td>"+response[i]['visit']+"</td></tr>";
				                         b[fila] = new Array();
				                         b[fila]["y"]=response[i]['title'];
				                         b[fila]["a"] = response[i]['visit'];       			                         		                         
				                         				                        	
				                         fila++;
				                         
				                         if(i==$("#ddlLimit").val()-1)
				                         {
				                         	i=response.length;
				                         }				                        			                        
				                     }	
				    html=html+"</tbody> </table>";	
			        $("#tblRecomendados").html(html);	        
			        	
			        	//BAR CHART
	                var bar = new Morris.Bar({
	                    element: 'recomendados',
	                    resize: true,
	                    data: b,
	                    //barColors: 'auto',
	                    xkey: 'y',
	                    ykeys: ['a'],
	                    //ymax:50,
	                    labels: ['Visitas'],
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
					encabezado= encabezado+"<?php echo "Recursos Más Visitados por Categoría"; ?>";
					encabezado= encabezado+"<?php echo "						      	                                                                    		        "; ?>";
					encabezado= encabezado+"<?php echo "						        			 "; ?>";		
					encabezado= encabezado+"Fecha: <?php print(date('m/d/Y h:i:s a', time())); ?> ";
					encabezado= encabezado+"Categoría: <?php echo $model->name; ?>";
	                
	                var table = $('#tblTotalVisitas').DataTable( {
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
													                    "sFileName":"masvisitadoscategoria.pdf"
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
					$.ajax({
	        		type: "post",
	        		url: "/gamma/category/JSONmasvisitadoscategoria/"+$("#catid").val(),	        		
			        dataType: "json",
			        success: function(response, status) { 
			        	var html2='<div class="chart" id="recomendados" style="width:100%; height: 300px;"></div><div class="chart" id="tblRecomendados" ></div>';
						$("#panel1").html('');		
						$("#panel1").html(html2);   
			        	var html="<table id='tblTotalVisitas' border='1' class='table table-bordered table-striped results'><thead><th>Recurso Educativo</th><th>Autor</th><th>Visitas</th></thead><tbody>";     	
			        	var b = new Array();
	                               var fila=0;
				                     for (var i = 0; i < response.length; i++) {
				                         html=html+"<tr><td><a href='"+response[i]['url']+"' target='_blank'>"+response[i]['title']+"</a></td><td>"+response[i]['autor']+"</td><td>"+response[i]['visit']+"</td></tr>";
				                         b[fila] = new Array();
				                         b[fila]["y"]=response[i]['title'];
				                         b[fila]["a"] = response[i]['visit'];       			                         		                         
				                         				                        	
				                         fila++;
				                         
				                         if(i==$("#ddlLimit").val()-1)
				                         {
				                         	i=response.length;
				                         }				                        			                        
				                     }	
				    html=html+"</tbody> </table>";	
			        $("#tblRecomendados").html(html);	        
			        	
			        	//BAR CHART
	                var bar = new Morris.Bar({
	                    element: 'recomendados',
	                    resize: true,
	                    data: b,
	                    //barColors: 'auto',
	                    xkey: 'y',
	                    ykeys: ['a'],
	                    //ymax:50,
	                    labels: ['Visitas'],
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
					encabezado= encabezado+"<?php echo "Recursos Más Visitados por Categoría"; ?>";
					encabezado= encabezado+"<?php echo "						      	                                                                    		        "; ?>";
					encabezado= encabezado+"<?php echo "						        			 "; ?>";		
					encabezado= encabezado+"Fecha: <?php print(date('m/d/Y h:i:s a', time())); ?> ";
					encabezado= encabezado+"Categoría: <?php echo $model->name; ?>";	
	                
	                var table = $('#tblTotalVisitas').DataTable( {
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
													                    "sFileName":"masvisitadoscategoria.pdf"
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
				
				$("#btnBuscar").on("click",function () {
					var html2='<div class="chart" id="visitasmeses" style="width:100%; height: 300px;"></div><div class="chart" id="tblVisitasmeses" ></div>';
					$("#panel2").html('');		
					$("#panel2").html(html2);
						$.ajax({
		        		type: "post",
		        		url: "/gamma/category/JSONmasvisitadoscategoriarango/"+$("#catid").val(),	        		
				        dataType: "json",
				        data: {'fecha1':$("#fecha1").val(), 'fecha2':$("#fecha2").val()},
				        success: function(response, status) {			        	 
				        	var html="<table id='tblMesesVisitas' border='1' class='table table-bordered table-striped results'><thead><th>Recurso Educativo</th><th>Autor</th><th>Visitas</th></thead><tbody>";     	
				        	var b = new Array();
		                               var fila=0;
					                     for (var i = 0; i < response.length; i++) {
					                         html=html+"<tr><td><a href='"+response[i]['url']+"' target='_blank'>"+response[i]['title']+"</a></td><td>"+response[i]['autor']+"</td><td>"+response[i]['visit']+"</td></tr>";
					                         b[fila] = new Array();
					                         b[fila]["y"]=response[i]['title'];
					                         b[fila]["a"] = response[i]['visit'];       			                         		                         
					                         				                        	
					                         fila++;
					                         
					                         if(i==$("#ddlLimitfecha").val()-1)
					                         {
					                         	i=response.length;
					                         }				                        			                        
					                     }	
					    html=html+"</tbody> </table>";	
				        $("#tblVisitasmeses").html(html);	        
				        	
				        	//BAR CHART
		                var bar = new Morris.Bar({
		                    element: 'visitasmeses',
		                    resize: true,
		                    data: b,
		                    //barColors: 'auto',
		                    xkey: 'y',
		                    ykeys: ['a'],
		                    //ymax:50,
		                    labels: ['Visitas'],
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
						encabezado= encabezado+"<?php echo "							        			        "; ?>";
						encabezado= encabezado+"<?php echo "Recursos Más Visitados por Categoria                     "; ?>";
						encabezado= encabezado+"<?php echo "		  	                                                                  		        "; ?>";
						encabezado= encabezado+"<?php echo "					        			 "; ?>";		
						encabezado= encabezado+"Fecha: <?php print(date('m/d/Y h:i:s a', time())); ?> ";
						encabezado= encabezado+"Categoría: <?php echo $model->name; ?>                                             ";
						encabezado= encabezado+"<?php echo "					        			                             "; ?>";
						encabezado= encabezado+"<?php echo "					        			                         "; ?>";
						encabezado=encabezado+" Desde: "+$("#fecha1").val() + "      Hasta: "+ $("#fecha2").val();
		                	
		                
		                var table = $('#tblMesesVisitas').DataTable( {
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
														                    "sFileName":"masvisitadoscategoriafechas.pdf"
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

		});
</script>  