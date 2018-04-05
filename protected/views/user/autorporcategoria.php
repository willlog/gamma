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
<?php $this->setPageTitle("CATEGORÍAS POR AUTOR"); ?>
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
    	<div class="col-md-6 panel">
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
        <i class="fa fa-bar-chart-o fa-fw"></i> Recursos Categoría Total vs Recursos Autor Categoría         
    </div>
    <!-- /.panel-heading -->
    <div class="panel-body">  
    	<div class="chart" id="estadistica" style="height: 250px;"></div>  
    	<div class="chart" id="tblEstadistica" ></div>  
	</div>

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
        <i class="fa fa-bar-chart-o fa-fw"></i> Recursos Categoría vs Recursos Autor Categoría por Fechas        
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
			
			doc.addImage(img1, 'JPEG', 15 , 60, 180, 50);				
			
			
			doc.addImage(img2, 'JPEG', 15 , 120, 180, 150);
			doc.addPage()
			doc.addImage(img3, 'JPEG', 15 , 20, 180, 150);
			
			doc.save("categoriasporautor.pdf");
		  			
		}

		$.noConflict();		
		jQuery(document).ready(function($){	
			"use strict";	
				
				$.ajax({
	        		type: "post",
	        		url: "/gamma/user/JSONpublicacionesporautorcategoria/"+$("#artid").val(),	        		
			        dataType: "json",
			        success: function(response, status) {   
			        	var html="<table id='tblTotalCategorias' border='1' class='table table-bordered table-striped results'><thead><th>Categoría</th><th>Recursos Autor</th><th>Recursos Totales</th><th>Porcentaje(%)</th></thead><tbody>";     	
			        	var b = new Array();
	                               var fila=0;
				                     for (var i = 0; i < response.length; i++) {
				                         html=html+"<tr><td>"+response[i]['name']+"</td><td>"+response[i]['cantidad']+"</td><td>"+response[i]['total']+"</td><td>"+response[i]['porcentaje']+"</td></tr>";
				                         b[fila] = new Array();
				                         b[fila]["y"]=response[i]['name'];
				                         b[fila]["a"] = response[i]['total'];
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
					    lineColors:['black','red'],
	                    xLabelAngle:45,                    
	                    hideHover: 'auto'
	                });
	                
	                var encabezado="<?php echo "		  	                                                        											              "; ?>";	
					encabezado= encabezado+"<?php echo "SOCIAL MEDIA ACADEMIC NETWORK"; ?>";
					encabezado= encabezado+"<?php echo "							        					        "; ?>";
					encabezado= encabezado+"<?php echo "							        					        "; ?>";
					encabezado= encabezado+"<?php echo "Recursos del Usuario por Categorías"; ?>";
					encabezado= encabezado+"<?php echo "							        	                                                                    		        "; ?>";
					encabezado= encabezado+"<?php echo "							        			 "; ?>";		
					encabezado= encabezado+"Fecha: <?php print(date('m/d/Y h:i:s a', time())); ?> ";
					encabezado= encabezado+"Usuario: <?php echo $model->name; ?>";	       
	                	                
	                var table = $('#tblTotalCategorias').DataTable( {
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
					                    								"sExtends":"pdf",
					                    								"sPdfOrientation": "landscape",
					                    								"sPdfMessage": encabezado,
					                    								"sTitle": "                               											                             	   UNIVERSIDAD TÉCNICA DE AMBATO",
					                    								"sFileName":"categoriasporautor.pdf"
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
				
				$("#btnBuscar").on("click",function () {
					var html2='<div class="chart" id="categoriarango" style="width:100%; height: 300px;"></div><div class="chart" id="tblCategoriarango" ></div>';
					$("#panel2").html('');		
					$("#panel2").html(html2);
					$.ajax({
	        		type: "post",
	        		url: "/gamma/user/JSONpublicacionesporautorcategoriarango/"+$("#artid").val(),	        		
			        dataType: "json",
			        data: {'fecha1':$("#fecha1").val(), 'fecha2':$("#fecha2").val()},
			        success: function(response, status) {   
			        	var html=null;
			        	var html="<table id='tblMesesCategorias' border='1' class='table table-bordered table-striped results'><thead><th>Categoría</th><th>Recursos Autor</th><th>Recursos Totales</th><th>Porcentaje(%)</th></thead><tbody>";     	
			        	var b = new Array();
	                               var fila=0;
				                     for (var i = 0; i < response.length; i++) {
				                         html=html+"<tr><td>"+response[i]['name']+"</td><td>"+response[i]['cantidad']+"</td><td>"+response[i]['total']+"</td><td>"+response[i]['porcentaje']+"</td></tr>";
				                         b[fila] = new Array();
				                         b[fila]["y"]=response[i]['name'];
				                         b[fila]["a"] = response[i]['total'];
				                         b[fila]["b"] = response[i]['cantidad'];                        			                         		                         
				                         
				                        	
				                         fila++;
			                        			                        
				                     }	
				    html=html+"</tbody> </table>";	
			        $("#tblCategoriarango").html(html);	        
			        	
			        	//BAR CHART
	                var bar = new Morris.Bar({
	                    element: 'categoriarango',
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
					    lineColors:['black','red'],
	                    xLabelAngle:45,                    
	                    hideHover: 'auto'
	                });	
	                
	                var encabezado="<?php echo "		  	                                                        											              "; ?>";	
					encabezado= encabezado+"<?php echo "SOCIAL MEDIA ACADEMIC NETWORK"; ?>";
					encabezado= encabezado+"<?php echo "							        					        "; ?>";
					encabezado= encabezado+"<?php echo "							        			        "; ?>";
					encabezado= encabezado+"<?php echo "Recursos del Usuario por Categorías                         "; ?>";
					encabezado= encabezado+"<?php echo "		  	                                                                    		        "; ?>";
					encabezado= encabezado+"<?php echo "					        			 "; ?>";		
					encabezado= encabezado+"Fecha: <?php print(date('m/d/Y h:i:s a', time())); ?> ";
					encabezado= encabezado+"Usuario: <?php echo $model->name; ?>                                             ";
					encabezado= encabezado+"<?php echo "					        			                             "; ?>";
					encabezado= encabezado+"<?php echo "					        			                         "; ?>";
					encabezado=encabezado+" Desde: "+$("#fecha1").val() + "      Hasta: "+ $("#fecha2").val();
					
	                var table = $('#tblMesesCategorias').DataTable( {
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
					                    								"sExtends":"pdf",
					                    								"sPdfOrientation": "landscape",
					                    								"sPdfMessage": encabezado,
					                    								"sTitle": "                               											                             	   UNIVERSIDAD TÉCNICA DE AMBATO",
					                    								"sFileName":"categoriasporautorfechas.pdf"
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
				
				$('.fecha').datepicker({
					language: "es",

				});	
				
				$("#btnDescargar").on("click",function () {
					getPDF();
				});				
				
		});
</script>  