<!-- jQuery 2.0.2 -->
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/datatables/dataTables.tableTools.css" rel="stylesheet" type="text/css" />
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/bootstrap-datepicker.js"></script>
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap-datepicker3.css" rel="stylesheet" type="text/css" />
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/dataTables.bootstrap.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/dataTables.tableTools.js"></script>
<?php $this->setPageTitle("ESTADÍSTICA AUTORES"); ?>
<section class="content">	
	 <div class="col-sm-7 search-form">           
     <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab">Búsqueda por fecha</a></li>            
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
        
        </div><!-- /.tab-content -->
    </div><!-- nav-tabs-custom -->		    
</div>	
<div class="col-sm-12"> 
	 <div style="float: right;">	 	 
	 	<button  id="btnRefresCategoria"  onclick="window.location.reload()"><i class="fa fa-refresh"></i> </button>
	 </div>   
	
	<div class="table-responsive" id="tblUsuarios"  >
	            <table id="tblUser" class="table table-bordered table-striped results">
	                <thead>
	                <tr>
	                    <th style="width: 20px">#</th>
	                    <th>Nombre</th>	                    
	                    <th>Usuario desde</th>
	                    <th>Cantidad de Recursos</th>	                    
	                    <th>Relevancia</th>	                                      
	                    <th>Ver</th>
	                </tr>
	                </thead>
	                <tbody>
	                <?php foreach ($dataProvider as $key => $value) { ?>
					<tr>
	                    <td><?php echo $key+1; ?></td>
	                    <td><?php echo $value['name']; ?></td>	                    
	                    <td><?php echo $value['createdAt']; ?></td>
	                    <td><?php echo $value['cantidad']; ?></td>
	                    <td><?php echo $value['relevancia']; ?></td>  
	                    	                    
	                    <td>
	                    	<div class="btn-group">
	                    		<?php echo CHtml::link('<i class="fa fa-eye"></i>', array('/user/Estadisticaautor/'.$value['id']), array('target'=>'_blank', 'class'=>'btn btn-info btnVistaArticle'));  ?>       
	                        </div>
	                    </td>
	                </tr>   
	                      						
					<?php } ?>
	                
	                </tbody>
	            </table>
	        </div><!-- /.box-body -->
</div>	
</section><!-- /.content -->

<script type="text/javascript">
    
    $.noConflict();			
	jQuery(document).ready(function($){
		"use strict";
		$("#btnBuscar").on("click",function () 
		{
			$.ajax({
        		type: "GET",        		
        		url: "indexautorbuscarfecha/",        		
				data: {'fecha1':$("#fecha1").val(), 'fecha2':$("#fecha2").val()},
        		success: function(response, status) {
        			
		        	$("#tblUsuarios").html(response);
		        	
		        },
		        error: function (response, status) {
		                //alert("Error");
		        },
			});
		});
		//$('#tblUser').dataTable();
		
		$('.fecha').datepicker
		({
			language: "es",
		});
		
		var encabezado="<?php echo "		  					                											              "; ?>";	
		encabezado= encabezado+"<?php echo "SOCIAL MEDIA ACADEMIC NETWORK"; ?>";
		encabezado= encabezado+"<?php echo "							        					        "; ?>";
		encabezado= encabezado+"<?php echo "Estadísticas de los Usuarios"; ?>";
		encabezado= encabezado+"<?php echo "							        					        "; ?>";
		encabezado= encabezado+"<?php echo "							        			 "; ?>";		
		encabezado= encabezado+"Fecha: <?php print(date('m/d/Y h:i:s a', time())); ?>";
		
		 
		//$("#tblCategory").beautyHover();
	
		var table = $('#tblUser').DataTable( {
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
	                    "mColumns": [ 0,1,2,3,4],
	                    "sTitle": "                                  UNIVERSIDAD TÉCNICA DE AMBATO",
	                    "sFileName":"estadistica_autores.pdf"
	                    
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


            
  

            