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
<?php $this->setPageTitle("MÁS COMPARTIDOS POR CATEGORÍA"); ?>
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
    <div class="col-md-12 alpha omega ">
    <div id="Categoria" class="panel  panel-default">
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
	<div id="Anio" class="panel  panel-default">
    <div class="panel-heading">
        <i class="fa fa-bar-chart-o fa-fw"></i> Recursos Educativos Más Compartidos de Todos los Tiempos
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
	<div id="Mes" class="panel  panel-default">
	<div class="panel-heading">
	<label>Fecha Inicio: </label>
	<input data-date-format="yyyy/mm/dd" class="fecha"  id="fecha1" type="text" readonly>
	<label>&nbsp&nbsp&nbsp&nbsp Fecha Fin: </label> 
    <input data-date-format="yyyy/mm/dd" class="fecha" id="fecha2" type="text" readonly>&nbsp&nbsp&nbsp&nbsp	
    <div id="btnBuscar" class="btn btn-info">Buscar</div> 
	</div>
    <div class="panel-heading">
        <i class="fa fa-bar-chart-o fa-fw"></i>  Recursos Educativos Más Compartidos por Fechas 
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

		function getPDF () {
				
			html2canvas(document.getElementById("Categoria"), {
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
			
			doc.addImage(img1, 'PNG', 15 , 60, 180, 60);		
						
			doc.addImage(img2, 'PNG', 15 , 130, 180, 100);
			doc.addPage()
			doc.addImage(img3, 'PNG', 15 , 20, 180, 150);
			
			doc.save("mascompartidos.pdf");
		  			
		}

		$.noConflict();
			
		jQuery(document).ready(function($){
			"use strict";
			$.ajax({
	        		type: "post",
	        		url: "/gamma/category/JSONmascompartidoscategoria/"+$("#catid").val(),	        		
			        dataType: "json",
			        success: function(response, status) {
			        	var html2='<div class="chart" id="recomendados" style="width:100%; height: 300px;"></div><div class="chart" id="tblRecomendados" ></div>';
						$("#panel1").html('');		
						$("#panel1").html(html2);    
			        	var html="<table id='tblTotalCompartidos' border='1' class='table table-bordered table-striped results'><thead><th>Recurso Educativo</th><th>Autor</th><th>Compartidos</th></thead><tbody>";     	
			        	var b = new Array();
	                               var fila=0;
				                     for (var i = 0; i < response.length; i++) {
				                         html=html+"<tr><td><a href='"+response[i]['url']+"' target='_blank'>"+response[i]['title']+"</a></td><td>"+response[i]['autor']+"</td><td>"+response[i]['share']+"</td></tr>";
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
			        $("#tblRecomendados").html(html);	        
			        	
			        	//BAR CHART
	                var bar = new Morris.Bar({
	                    element: 'recomendados',
	                    resize: true,
	                    data: b,
	                    //barColors: 'auto',
	                    xkey: 'y',
	                    ykeys: ['a'],
	                    ymax:50,
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
					encabezado= encabezado+"<?php echo "Recursos Más Compartidos por Categoría"; ?>";
					encabezado= encabezado+"<?php echo "						      	                                                                    		        "; ?>";
					encabezado= encabezado+"<?php echo "						        			 "; ?>";		
					encabezado= encabezado+"Fecha: <?php print(date('m/d/Y h:i:s a', time())); ?> ";
					encabezado= encabezado+"Categoría: <?php echo $model->name; ?>";	
	                
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
													                    "sFileName":"mascompartidoscategoria.pdf"
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
	        		url: "/gamma/category/JSONmascompartidoscategoria/"+$("#catid").val(),	        		
			        dataType: "json",
			        success: function(response, status) {
			        	var html2='<div class="chart" id="recomendados" style="width:100%; height: 300px;"></div><div class="chart" id="tblRecomendados" ></div>';
						$("#panel1").html('');		
						$("#panel1").html(html2);    
			        	var html="<table id='tblTotalCompartidos' border='1' class='table table-bordered table-striped results'><thead><th>Recurso Educativo</th><th>Autor</th><th>Compartidos</th></thead><tbody>";     	
			        	var b = new Array();
	                               var fila=0;
				                     for (var i = 0; i < response.length; i++) {
				                         html=html+"<tr><td><a href='"+response[i]['url']+"' target='_blank'>"+response[i]['title']+"</a></td><td>"+response[i]['autor']+"</td><td>"+response[i]['share']+"</td></tr>";
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
			        $("#tblRecomendados").html(html);	        
			        	
			        	//BAR CHART
	                var bar = new Morris.Bar({
	                    element: 'recomendados',
	                    resize: true,
	                    data: b,
	                    //barColors: 'auto',
	                    xkey: 'y',
	                    ykeys: ['a'],
	                    ymax:50,
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
					encabezado= encabezado+"<?php echo "Recursos Más Compartidos por Categoría"; ?>";
					encabezado= encabezado+"<?php echo "						      	                                                                    		        "; ?>";
					encabezado= encabezado+"<?php echo "						        			 "; ?>";		
					encabezado= encabezado+"Fecha: <?php print(date('m/d/Y h:i:s a', time())); ?> ";
					encabezado= encabezado+"Categoría: <?php echo $model->name; ?>";	
	                
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
													                    "sFileName":"mascompartidoscategoria.pdf"
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
					var html2='<div class="chart" id="compartidosmeses" style="width:100%; height: 300px;"></div><div class="chart" id="tblCompartidosmeses" ></div>';
					$("#panel2").html('');		
					$("#panel2").html(html2);					
					$.ajax({
	        		type: "post",
	        		url: "/gamma/category/JSONmascompartidoscategoriarango/"+$("#catid").val(),	        		
			        dataType: "json",
			        data: {'fecha1':$("#fecha1").val(), 'fecha2':$("#fecha2").val()},
			        success: function(response, status) {			        	    
			        	var html="<table id='tblMesesCompartidos' border='1' class='table table-bordered table-striped results'><thead><th>Recurso Educativo</th><th>Autor</th><th>Compartidos</th></thead><tbody>";     	
			        	var b = new Array();
	                               var fila=0;
				                     for (var i = 0; i < response.length; i++) {
				                         html=html+"<tr><td><a href='"+response[i]['url']+"' target='_blank'>"+response[i]['title']+"</a></td><td>"+response[i]['autor']+"</td><td>"+response[i]['share']+"</td></tr>";
				                         b[fila] = new Array();
				                         b[fila]["y"]=response[i]['title'];
				                         b[fila]["a"] = response[i]['share'];        			                         		                         
				                         				                        	
				                         fila++;
				                         
				                         if(i==$("#ddlLimitfecha").val()-1)
				                         {
				                         	i=response.length;
				                         }				                        			                        
				                     }	
				    html=html+"</tbody> </table>";	
			        $("#tblCompartidosmeses").html(html);	        
			        	
			        	//BAR CHART
	                var bar = new Morris.Bar({
	                    element: 'compartidosmeses',
	                    resize: true,
	                    data: b,
	                    //barColors: 'auto',
	                    xkey: 'y',
	                    ykeys: ['a'],
	                    ymax:50,
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
					encabezado= encabezado+"<?php echo "							        			        "; ?>";
					encabezado= encabezado+"<?php echo "Recursos Más Compartidos por Categoria                     "; ?>";
					encabezado= encabezado+"<?php echo "		  	                                                                  		        "; ?>";
					encabezado= encabezado+"<?php echo "					        			 "; ?>";		
					encabezado= encabezado+"Fecha: <?php print(date('m/d/Y h:i:s a', time())); ?> ";
					encabezado= encabezado+"Categoría: <?php echo $model->name; ?>                                             ";
					encabezado= encabezado+"<?php echo "					        			                             "; ?>";
					encabezado= encabezado+"<?php echo "					        			                         "; ?>";
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
													                    "sFileName":"mascompartidoscategoriafechas.pdf"
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