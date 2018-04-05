<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/datatables/dataTables.tableTools.css" rel="stylesheet" type="text/css" />
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/dataTables.bootstrap.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/dataTables.tableTools.js"></script>
<?php $this->setPageTitle("ADMINISTRACIÓN DE CATEGORÍAS"); ?>
<div class="mailbox row">
    <div class="col-xs-12">
        <div class="box box-solid">         
			<div class="box-header">
                <i class="fa fa-fw fa-folder"></i>
                <h3 class="box-title">Categorías</h3>
            </div>
             <hr>
            <div class="box-body">
           
           	<div class="btn-group">  
	                <!--<button style="width: 50px" id="btnRefresCategoria" class="btn btn-block btn-primary"><i class="fa fa-refresh"></i> </button>-->                
		            <a class="btn btn-block btn-primary" id="btnAddCategoria" data-toggle="modal" data-target="#modalCategorias" style="width: 250px">
					<i class="fa fa-pencil"></i> Agregar Categoría </a>
			</div>          
	       
			<br>
			<br>
			<div style="float: right;">	 	 
			 	<button  id="btnRefresCategoria"  onclick="window.location.reload()"><i class="fa fa-refresh"></i> </button>
			 </div> 
            <div class="table-responsive" id="tblOpcionesDeUsuarios" >
                            <!-- THE MESSAGES -->
               <table id="tblCategory" class="table table-bordered table-striped results" >
               		<thead>
	                <tr>
	                    <th style="width: 20px">#</th>
	                    <th>Nombre</th>
	                    <th>Descripcion</th>
	                    <th >Fecha Creación</th>
	                    <th style="width: 150px">Opciones</th>
	                </tr>
	                </thead>
	                <tbody>
	                <?php foreach ($dataProvider as $key => $value) { ?>
					<tr>
	                    <td><?php echo $key+1; ?></td>
	                    <td><?php echo $value->name; ?></td>
	                    <td>
	                        <?php echo $value->description; ?>
	                    </td>
	                    <td><?php echo $value->createdAt; ?></td>
	                    <td >
	                    	<div class="btn-group">
	                            
	                            <button type="button" class="btn btn-info btnEditarCategoria" value="<?php echo $value->id; ?>" data-toggle="modal" data-target="#modalCategorias"><i class="fa fa-pencil-square-o"></i></button>
	                            <button type="button" class="btn btn-warning btnVistaCategoria" value="<?php echo $value->id; ?>" data-toggle="modal" data-target="#modalCategorias"><i class="fa fa-eye"></i></button>
	                            <button type="button" class="btn btn-danger btnEliminarCategoria" value="<?php echo $value->id; ?>" data-toggle="modal" data-target="#modalDeleteCategorias"><i class="fa fa-trash-o"></i></button>
	                        </div>
	                    </td>
	                </tr>							
					<?php } ?>
	                
	               </tbody> 
	            </table>	                            
                          

            </div><!-- /.table-responsive -->
	        
	        </div>
		</div>
        </div>	
    </div>
</div>	

<div class="modal fade" id="modalCategorias" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-fw fa-folder"></i> Categoría</h4>
            </div>
            <div class="modal-body" id="cntAddCategoriasTotal">
            	
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="modalDeleteCategorias" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-fw fa-folder"></i> Categoria</h4>
            </div>
            <div class="modal-body">
            	<h4> Esta seguro que desea eliminar la categoría <span class="label label-success" id="txtDetalleDelete"></span> </h4><hr> 
            </div>
            <div class="modal-footer clearfix">

                <button id="btnDeleteCategorias" type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Eliminar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script type="text/javascript">
    $.noConflict();			
	jQuery(document).ready(function($){    	
		"use strict"; 
		$('.modal').on('hidden.bs.modal', function () {
			  $("#btnRefresCategoria").trigger( "click" );
		});
		 
		$('.btnEliminarCategoria').on('click', function() {
			$("#txtDetalleDelete").html($(this).closest('tr').find('td:eq(1)').text());
			$("#btnDeleteCategorias").val($(this).attr("value"));
		});
		
		$('#btnDeleteCategorias').on('click', function() {
			$.ajax({
        		type: "POST",
        		url: "delete/"+$("#btnDeleteCategorias").val(),
        		success: function(response, status) {
        			
		        	//$("#cntDeleteCategoriasTotal").html(response);
		        },
		        error: function (response, status) {
		                alert("Error");
		        },
			});
			
			$.ajax({
        		type: "GET",
        		url: "indexs/",
        		success: function(response, status) {
        			$("#tblOpcionesDeUsuarios").html(response);
		        },
		        error: function (response, status) {
		                alert("Error");
		        },
			});
		       
		});	
		
		$('.btnEditarCategoria').on('click', function() {
			//alert($(this).attr("value"));
			$.ajax({
                    type: "GET",
                    url: "update/"+$(this).attr("value"),
                    success: function(html, status) {
                       $('#cntAddCategoriasTotal').html(html);
                    },
                    error: function (response, status) {
                            alert("Error");
                    },
            });
		});
		
		$('.btnVistaCategoria').on('click', function() {
			//alert($(this).attr("value"));
			$.ajax({
                    type: "GET",
                    url: "view/"+$(this).attr("value"),
                    success: function(html, status) {
                       $('#cntAddCategoriasTotal').html(html);
                    },
                    error: function (response, status) {
                            alert("Error");
                    },
            });
		});

		$('#btnAddCategoria').on('click', function() {
			//alert($(this).attr("value"));
			$.ajax({
                    type: "GET",
                    url: "create/",
                    success: function(html, status) {
                       $('#cntAddCategoriasTotal').html(html);
                    },
                    error: function (response, status) {
                            alert("Error");
                    },
            });
		});	
														  
										
				$('#btnRefresCategoria').on('click', function() {
					$.ajax({
		        		type: "GET",
		        		url: "indexs/",
		        		success: function(response, status) {
		        			$("#tblOpcionesDeUsuarios").html(response);
				        },
				        error: function (response, status) {
				                alert("Error");
				        },
					});
				       
				});
				
			//$('#tblCategory').dataTable();
			
			//$("#tblCategory").beautyHover();
			var encabezado="<?php echo "		  					                											              "; ?>";	
			encabezado= encabezado+"<?php echo "SOCIAL MEDIA ACADEMIC NETWORK"; ?>";
			encabezado= encabezado+"<?php echo "							        					        "; ?>";
			encabezado= encabezado+"<?php echo "Categorías Educativas         "; ?>";
			encabezado= encabezado+"<?php echo "							        					        "; ?>";
			encabezado= encabezado+"<?php echo "							        			 "; ?>";		
			encabezado= encabezado+"Fecha: <?php print(date('m/d/Y h:i:s a', time())); ?>";
						
			var table = $('#tblCategory').DataTable( {
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
		                    "mColumns": [ 0,1,2,3 ],
		                    "sTitle": "                                  UNIVERSIDAD TÉCNICA DE AMBATO",
	                    	"sFileName":"categoriaseducativas.pdf"
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

