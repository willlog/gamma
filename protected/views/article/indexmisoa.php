<!-- jQuery 2.0.2 -->
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/datatables/dataTables.tableTools.css" rel="stylesheet" type="text/css" />
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/bootstrap-datepicker.js"></script>
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap-datepicker3.css" rel="stylesheet" type="text/css" />
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/dataTables.bootstrap.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/dataTables.tableTools.js"></script>
<?php $this->setPageTitle("ESTADÍSTICAS MÍS RECURSOS EDUCATIVOS"); ?>
<section class="content">
<div class="col-sm-7 search-form">           
     <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab">Búsqueda por fecha</a></li>
            
            <li><a href="#tab_3" data-toggle="tab">Búsqueda por Categorias</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
                <form action="#" class="text-right">
                    <div class="input-group">
                    	<label>Fecha Inicio: </label>
						<input data-date-format="yyyy/mm/dd" class="fecha"  id="fecha1" type="text" readonly>
						<label>&nbsp&nbsp&nbsp&nbsp Fecha Fin: </label> 
					    <input data-date-format="yyyy/mm/dd" class="fecha" id="fecha2" type="text" readonly>&nbsp&nbsp&nbsp&nbsp	
					    <div id="btnBuscar" class="btn btn-info">Buscar</div> 
                    	<!--<input type="text" class="form-control input-sm search" placeholder="Buscar año">
                        <div class="input-group-btn">
                            <button type="submit" name="q" class="btn btn-sm btn-primary"><span class="counter"></span> <i class="fa fa-search"></i></button>
                        </div>-->
                    </div>                                                     
                </form>
            </div><!-- /.tab-pane -->    
                
            <div class="tab-pane" id="tab_3">
                <div class="input-group"> 
                    	<input id="txtBuscarCategoria" type="text" class="form-control input-sm " placeholder="Buscar categoria">
                        <div class="input-group-btn">
                            <button type="submit" name="q" class="btn btn-sm btn-primary"><span class="counters"></span> <i class="fa fa-search"></i></button>
                        </div>
                </div>                                                     
              	
          		<div id="contenidoDeCategorias">
					
				  </div>
            </div><!-- /.tab-pane -->
        </div><!-- /.tab-content -->
    </div><!-- nav-tabs-custom -->		    
</div>    
<div class="col-sm-12">
	<div style="float: right;">	 	 
	 	<button  id="btnRefresCategoria"  onclick="window.location.reload()"><i class="fa fa-refresh"></i> </button>
	 </div> 
	<div class="table-responsive" id="tableArticles">
	            <table id="tblArticle" class="table table-bordered table-striped results">
	                <thead>
	                <tr>
	                    <th style="width: 20px">#</th>
	                    <th>Recurso Educativo</th>
	                    <th>Fecha Creación</th>	 
	                    <th>Share</th>
	                    <th>Visit</th>
	                    <th>Like</th>
	                    <th>Relevancia</th>	                                      
	                    <th>Opciones</th>
	                </tr>
	                </thead>
	                <tbody>
	                <?php foreach ($dataProvider as $key => $value) { ?>
					<tr>
	                    <td><?php echo $key+1; ?></td>	                    
	                    <td><?php echo CHtml::link($value['title'], $value['url'], array('target'=>'_blank'));  ?></td>
	                    <td><?php echo $value['createdAt']; ?></td>
	                    <td><?php echo $value['share']; ?></td>
	                    <td><?php echo $value['visit']; ?></td>
	                    <td><?php echo $value['likes']; ?></td>
	                    <td><?php echo $value['recomendado']; ?></td>	                    
	                    <td>
	                    	<div class="btn-group">       
	                            <?php echo CHtml::link('<i class="fa fa-eye"></i>', array('/article/Estadisticaoa/'.$value['id']), array('target'=>'_blank', 'class'=>'btn btn-info btnVistaArticle'));  ?>	                            
	                            
	                        </div>
	                    </td>
	                </tr>
							
					<?php } ?>
	                
	            </tbody>    
	            </table>
	        </div><!-- /.box-body -->
 </div>	
 <input id ="username" value="<?php echo $model->name?>" hidden="hidden"/>
</section><!-- /.content -->

<script type="text/javascript">

		$.noConflict();			
		jQuery(document).ready(function($){
			"use strict";	
			$("#btnBuscar").on("click",function () {
					
			$("#namepertenese").html($("#fecha1").val()+" - "+$("#fecha2").val());
			$.ajax({				
        		type: "GET",
        		//url: "indexgeneralbuscarfecha/"+$(this).val(),
        		url: "Indexmisoabuscarfecha/",
        		//dataType: "json",
				data: {'fecha1':$("#fecha1").val(), 'fecha2':$("#fecha2").val()},
        		success: function(response, status) {        			
		        	$("#tableArticles").html(response);
		        	
		        },
		        error: function (response, status) {
		                //alert("Error");
		        },
			});
										   
	  	});		
	  		  	
	  	$("#txtBuscarCategoria").keyup(function () {
			
			$.ajax
			({
        		type: "GET",
        		url: "indexbuscarcategoriamis/"+$("#txtBuscarCategoria").val(),
        		success: function(response, status) {
        			
		        	$("#contenidoDeCategorias").html(response);		        	
		        },
		        error: function (response, status) {
		                //alert("Error");
		        },
			});
			if($("#txtBuscarCategoria").val().length==0)
        	{
        		$("#contenidoDeCategorias").html("");
        	}
		});
			
			$('.btnVistaArticle').on('click', function(response) {
			$.ajax({				
                    type: "POST",
                    data:{'uid':$(this).attr("id")},
                    url: "Pasarid/"+$(this).attr("value"),
                    success: function(response, status) {
                    	                	
                       
                    },
                    error: function (response, status) {
                        
                    },
            });
		});
		
		$('.fecha').datepicker
		({
			language: "es",
		});
		
		/*$('#tblArticle').dataTable({
			
		});*/
		
		// Make all JS-activity for dashboard
		//DashboardTabChecker();
		// Make beauty hover in table
		//$("#tblArticle").beautyHover();
		
		var encabezado="<?php echo "		  	                                                        											              "; ?>";	
		encabezado= encabezado+"<?php echo "SOCIAL MEDIA ACADEMIC NETWORK"; ?>";
		encabezado= encabezado+"<?php echo "							        					        "; ?>";
		encabezado= encabezado+"<?php echo "							        					        "; ?>";
		encabezado= encabezado+"<?php echo "Estadísticas de los Recursos Educativos"; ?>";
		encabezado= encabezado+"<?php echo "							        	                                                                    		        "; ?>";
		encabezado= encabezado+"<?php echo "							        			 "; ?>";		
		encabezado= encabezado+"Fecha: <?php print(date('m/d/Y h:i:s a', time())); ?>";
		encabezado=encabezado+" Usuario: "+"<?php echo $model->name; ?>";
	
		var table = $('#tblArticle').DataTable( {
			"paging":   true,
	        "ordering": true,
	        "info":     true,
	        'searching':true,
	        "dom": 'T<"clear">lfrtip',
	        tableTools: {
	            "aButtons": [
	                "copy",
	                "csv",
	                "xls",
	                {
	                    "sExtends": "pdf",
	                    "sPdfMessage": encabezado,
	                    "sPdfOrientation": "landscape",
	                    "mColumns": [ 0,1,2,3,4,5,6],
	                    "sTitle": "                               											                             	   UNIVERSIDAD TÉCNICA DE AMBATO",
	                    "sFileName":"estadistica_misrecursos.pdf"
	                },
	                "print"
	            ]
	        }
	        
	    } );
	    /*
		var tt = new $.fn.dataTable.TableTools(table);
	    $('#grupoBononesTabla').append( tt.fnContainer() );
	    
	    $('#ToolTables_tableGroups_6 > div > embed').mousedown(function() {
		  alert('mouse down');
		});*/
			
	});
</script>


            
  

                  