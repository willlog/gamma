<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/datatables/dataTables.tableTools.css" rel="stylesheet" type="text/css" />
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/bootstrap-datepicker.js"></script>
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap-datepicker3.css" rel="stylesheet" type="text/css" />
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/dataTables.bootstrap.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/dataTables.tableTools.js"></script>

<?php $this->setPageTitle("PRINCIPAL"); ?>
<!-- Main content -->
<section class="content">
<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title">SOMAN: Social Media Academic Network.</h3>    
  </div>
  <div class="box-body">
    SOMAN le da la bienvenida a todos los que ven en Facebook una herramienta no solo de ocio y distracción sino también una herramienta de estudio y trabajo. Este proyecto de investigación se propone desarrollar un sistema de gestión de la “vida social” en el entorno académico haciendo uso de Facebook. Creemos que el registro de las acciones sociales con fin académico permitirá fortalecer la comunicación estudiante-docente y estudiante-estudiante.

Además de aportarle un componente lúdico al modelo educativo universitario, este proyecto permitirá 1) analizar el proceso académico desde “dentro” de la propia red social, 2) apoyar la toma de decisión en la gestión académica desde una perspectiva social y 3) generar influencia en el uso de los medios sociales con fin académico.
  </div>
  <!-- /.box-body -->
</div>
<!-- Small boxes (Stat box) -->             

<br>

<!-- Main row -->
<div class="row">
<!-- Left col -->
<section class="col-lg-6 connectedSortable"> 
<!-- Box (with bar chart) -->
<div class="box box-danger" id="loading-example">
    <div class="box-header">
        <!-- tools box -->
        <div class="pull-right box-tools">
            <button class="btn btn-danger btn-sm refresh-btn" data-toggle="tooltip" title="Reload"><i class="fa fa-refresh"></i></button>
            <button class="btn btn-danger btn-sm" data-widget='collapse' data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-danger btn-sm" data-widget='remove' data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
        </div><!-- /. tools -->
        <i class="fa fa-user"></i>
        

        <h3 class="box-title">Top 5 Usarios Relevantes</h3>
    </div><!-- /.box-header -->
    <div class="box-body no-padding">
        <div id="panel1" class="table-responsive">
            <!-- .table - Uses sparkline charts-->
           <table id="tblUser" class="table table-striped">
	                <thead>
	                <tr>
	                	<th style="width: 10px">#</th>
	                    <th style="width: 10px"></th>
	                    <th>Nombre</th>	                    
	                    <th>Usuario desde</th>
	                    <th>Recursos</th>	                    
	                    <th>Relevancia</th>                        
	                    
	                </tr>
	                </thead>
	                <tbody>
	                <?php foreach ($dataProvider as $key => $value) { ?>
					<tr>
						<td><?php echo $key+1;?></td>
	                    <td><?php echo CHtml::image($value['image'],'alt',array('width'=>30,'height'=>30));?></td>
	                    <td><?php echo $value['name']; ?></td>	                    
	                    <td><?php echo $value['createdAt']; ?></td>
	                    <td><?php echo $value['cantidad']; ?></td>
	                    <td><?php echo $value['relevancia']; ?></td>  
	                    	                    
	                    
	                </tr>   
	                 <?php if ($key==4) {
	                 	break;						 
					 }; ?>     						
					<?php } ?>
	                
	                </tbody>
	            </table>
        </div>
        
    </div><!-- /.box-body -->
    <div class="box-footer">
        <div class="row">
            
        </div><!-- /.row -->
    </div><!-- /.box-footer -->
</div><!-- /.box -->                             

</section><!-- /.Left col -->
    <!-- right col (We are only adding the ID to make the widgets sortable)-->
 <section class="col-lg-6 connectedSortable">
 	<div class="box box-danger" id="loading-example">
    <div class="box-header">
        <!-- tools box -->
        <div class="pull-right box-tools">
            <button class="btn btn-danger btn-sm refresh-btn" data-toggle="tooltip" title="Reload"><i class="fa fa-refresh"></i></button>
            <button class="btn btn-danger btn-sm" data-widget='collapse' data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-danger btn-sm" data-widget='remove' data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
        </div><!-- /. tools -->
        <i class="fa fa-video-camera"></i>
        

        <h3 class="box-title">Redes Sociales en la Educación</h3>
    </div><!-- /.box-header -->
    <div class="box-body no-padding">   	
    	
        <iframe width="540" height="315" src="https://www.youtube.com/embed/yQmaln8Ywt0" frameborder="0" allowfullscreen></iframe>
        
    </div><!-- /.box-body -->
    <div class="box-footer">
        <div class="row">
            
        </div><!-- /.row -->
    </div><!-- /.box-footer -->
</div><!-- /.box -->                             

 	
 </section><!-- right col -->
    
</div><!-- /.row (main row) -->
   <div class="row">
        <section class="col-lg-12 connectedSortable">
        <!-- Map box -->
        <div class="box box-primary">
            <div class="box-header">
                <!-- tools box -->
                <div class="pull-right box-tools">                                  
                    <button class="btn btn-primary btn-sm pull-right" data-widget='remove' data-toggle="tooltip" title="Remove" style="margin-right: 5px;"><i class="fa fa-times"></i></button>
                    <button class="btn btn-primary btn-sm pull-right" data-widget='collapse' data-toggle="tooltip" title="Collapse" style="margin-right: 5px;"><i class="fa fa-minus"></i></button>                    
                </div><!-- /. tools -->

                <i class="fa fa-fw fa-book"></i>
                <h3 class="box-title">
                    Top 5 Recursos Educativos
                </h3>
            </div>
            <div class="box-body no-padding">
            <div id="panel2" class="table-responsive">
            <!-- .table - Uses sparkline charts-->
            
        </div>                
                
            </div><!-- /.box-body-->
            <div class="box-footer">
                
            </div>
        </div>
        <!-- /.box -->                        

    </section><!-- right col -->
   </div><!-- /.row -->	

</section><!-- /.content -->
<script type="text/javascript">
		 $.noConflict();			
		jQuery(document).ready(function($){
			"use strict";				
				$.ajax({					
	        		type: "post",
	        		url: "/gamma/article/JSONMasrecomendadostotal/",	        		
			        dataType: "json",
			        success: function(response, status) {   
			        	var html2='<div class="chart" id="estadistica" style="width:100%; "></div><div class="chart" id="tblEstadistica" ></div>';
						$("#panel2").html('');		
						$("#panel2").html(html2);
			        	var html="<table id='tblTotalRecomendados' class='table table-striped'><thead><th>Título</th><th>Creador</th><th>Compartidos</th><th>Visitado</th><th>Gustado</th><th>Relevancia</th></thead><tbody>";     	
			        	var b = new Array();
	                               var fila=0;
				                     for (var i = 0; i < response.length; i++) {
				                         html=html+"<tr><td><a href='"+response[i]['url']+"' target='_blank'>"+response[i]['title']+"</a></td><td>"+response[i]['name']+"</a></td><td>"+response[i]['share']+"</td><td>"+response[i]['visit']+"</td><td>"+response[i]['likes']+"</td><td>"+response[i]['recomendado']+"</td></tr>";
				                         b[fila] = new Array();
				                         b[fila]["y"]=response[i]['title'];
				                         b[fila]["a"] = response[i]['recomendado'];       			                         		                         
				                         				                        	
				                         fila++;
				                         
				                         if(i==4)
				                         {
				                         	i=response.length;
				                         }
				                         			                        			                        
				                     }	
				    html=html+"</tbody> </table>";	
			        $("#tblEstadistica").html(html);  
			        
			        $('#tblTotalRecomendados').DataTable( {
							"paging":   false,
					        "ordering": true,
					        "info":     false,
					        'searching':false,
					        
					      
					        
				} );	        
	               		        	
	                	
			        },
			        error: function (response, status) {
			                alert("Error");
			        },
				});	
				
				 $('#tblUser').DataTable( {
							"paging":   false,
					        "ordering": true,
					        "info":     false,
					        'searching':false,
					        
					      
					        
				} );	
				
					

		});
</script>  