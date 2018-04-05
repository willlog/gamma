<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/datatables/dataTables.tableTools.css" rel="stylesheet" type="text/css" />
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/dataTables.bootstrap.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/dataTables.tableTools.js"></script>
<?php $this->setPageTitle("ADMINISTRACIÓN DE RECURSOS EDUCATIVOS"); ?>
<div class="mailbox row">
    <div class="col-xs-12">
    	
        <div class="box box-solid">
        	
        	<div class="box-header">
                <i class="fa fa-fw fa-book"></i>                
                <h3 class="box-title">Mís Recursos Educativos</h3>  
            </div><!-- /.box-header -->
            <hr>
        	<div class="box-body">
			
			<div class="btn-group">
				<!--<button style="width: 50px" id="btnRefresCategoria" class="btn btn-block btn-primary"><i class="fa fa-refresh"></i> </button>-->
				<a class="btn btn-block btn-primary" id="btnAddArticle" data-toggle="modal" data-target="#modalArticles" style="width: 250px">
			<i class="fa fa-pencil"></i> Agregar Recurso</a> 
			</div>                           
            	         
			<br><br>	
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
	                    <th>Estado</th>                   
	                    <th style="width: 120px">Opciones</th>
	                </tr>
	                </thead>
	                <tbody>
	                <?php foreach ($dataProvider as $key => $value) { ?>
					<tr>
	                    <td><?php echo $key+1; ?></td>
	                    <td><?php echo $value->title; ?></td>	                    
	                    <td><?php echo $value->createdAt; ?></td>
	                    <td><?php if($value->state=="disable"){
	                    	echo "Deshabilitado";
	                    }else {
	                    	echo "Habilitado";
	                    } ; ?></td>
	                    <td>
	                    	<div class="btn-group">
	                            
	                            <button type="button" class="btn btn-info btnEditarArticle" value="<?php echo $value->id; ?>"  data-toggle="modal" data-target="#modalArticles"><i class="fa fa-pencil-square-o"></i></button>
	                            <button type="button" class="btn btn-warning btnVistaArticle" value="<?php echo $value->id; ?>"  data-toggle="modal" data-target="#modalArticles"><i class="fa fa-eye"></i></button>
	                            <button type="button" class="btn btn-danger btnEliminarArticle" value="<?php echo $value->id; ?>"  data-toggle="modal" data-target="#modalDeleteArticles"><i class="fa fa-trash-o"></i></button>
	                        </div>
	                    </td>
	                </tr>
							
					<?php } ?>
	                
	               </tbody>
	            </table>
	           
	          <script type="text/javascript">
			    $.noConflict();			
				jQuery(document).ready(function($){
					"use strict";
					
					//$('#tblArticle').dataTable();	
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
				                    "sPdfOrientation": "landscape",
				                    "sPdfMessage": encabezado,
				                    "mColumns": [ 0,1,2,3 ],
				                    "sTitle": "                               											                             	   UNIVERSIDAD TÉCNICA DE AMBATO",
	                    			"sFileName":"misrecursos.pdf"
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
	            
	            
	        </div>
	       
</div><!-- /.box-body -->
        </div>	
    </div>
</div>	

<div class="modal fade" id="modalArticles" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-fw fa-book"></i> Recurso Educativo</h4>
            </div>
            <div class="modal-body" id="cntAddArticlesTotal">
            	
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="modalDeleteArticles" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-fw fa-book"></i> Recurso Educativo</h4>
            </div>
            <div class="modal-body">
            	<h4> Esta seguro que desea eliminar el recurso educativo <span class="label label-success" id="txtDetalleDelete"></span> </h4><hr> 
            </div>
            <div class="modal-footer clearfix">
            <div style="display: none;" id="uidvaldel"></div>
                <button id="btnDeleteArticles" type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Eliminar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script type="text/javascript">
    //$.noConflict();			
	jQuery(document).ready(function($){
		"use strict";		
		$('#btnDeleteArticles').on('click', function() {

			$.ajax({
        		type: "POST",
        		//data:{'uid':$("#uidvaldel").html()},
        		url: "delete/"+$("#btnDeleteArticles").val(),
        		success: function(response, status) {
        			
		        	//$("#cntDeleteCategoriasTotal").html(response);
		        },
		        error: function (response, status) {
		                //alert("Error");
		        },
			});
			
			$.ajax({
	        		type: "GET",
	        		url: "/gamma/article/indexs/",
	        		success: function(response, status) {
	        			$("#tableArticles").html(response);
			        },
			        error: function (response, status) {
			                alert("Error");
			        },
				});
		       
		});

		$('.btnEliminarArticle').on('click', function() {
			$("#txtDetalleDelete").html($(this).closest('tr').find('td:eq(1)').text());
			//$("#uidvaldel").html($(this).attr("id"));;
			$("#btnDeleteArticles").val($(this).attr("value"));
		});
		
		$('.btnEditarArticle').on('click', function() {
			//alert($(this).attr("value"));
			$.ajax({
                    type: "GET",
                    //data:{'uid':$(this).attr("id")},
                    url: "/gamma/article/update/"+$(this).attr("value"),
                    success: function(html, status) {
                       $('#cntAddArticlesTotal').html(html);
                    },
                    error: function (response, status) {
                            alert("Error");
                    },
            });
		});

		$('.btnVistaArticle').on('click', function() {
			//alert($(this).attr("value"));
			$.ajax({
                    type: "GET",
                    data:{'uid':$(this).attr("id")},
                    url: "/gamma/article/view/"+$(this).attr("value"),
                    success: function(html, status) {
                       $('#cntAddArticlesTotal').html(html);
                    },
                    error: function (response, status) {
                            alert("Error");
                    },
            });
		});

		$('#btnAddArticle').on('click', function() {
			//alert($(this).attr("value"));
			$.ajax({
                    type: "GET",
                    url: "/gamma/article/create/",
                    success: function(html, status) {
                       $('#cntAddArticlesTotal').html(html);
                    },
                    error: function (response, status) {
                            alert("Error");
                    },
            });
		});

		$('#btnRefresArticle').on('click', function() {
			$.ajax({
        		type: "GET",
        		url: "/gamma/article/indexs/",
        		success: function(response, status) {
        			$("#tableArticles").html(response);
		        },
		        error: function (response, status) {
		                alert("Error");
		        },
			});
		       
		});	
        
    });
</script>	

