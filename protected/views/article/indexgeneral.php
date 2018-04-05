<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/bootstrap-datepicker.js"></script>
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap-datepicker3.css" rel="stylesheet" type="text/css" />
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/datatables/dataTables.tableTools.css" rel="stylesheet" type="text/css" />
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/dataTables.bootstrap.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/dataTables.tableTools.js"></script>	
<?php $this->setPageTitle("RECURSOS EDUCATIVOS"); ?>
<div class="mailbox row">	
    <div class="col-xs-12">
        <div >
			<div class="box-header">
                <i class="fa fa-fw fa-book"></i>                
                <h3 class="box-title">Todos Recursos Educativos</h3>  
            </div><!-- /.box-header --> 
             <hr>
                <div class="col-sm-8 search-form">           
           
			     <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_1" data-toggle="tab">Búsqueda por fecha</a></li>
                        <li><a href="#tab_2" data-toggle="tab">Búsqueda por Usuario</a></li>
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
                        <div class="tab-pane" id="tab_2">
                            <div class="input-group"> 
                                	<input id="txtBuscar" type="text" class="form-control input-sm " placeholder="Buscar usuario">
                                    <div class="input-group-btn">
                                        <button type="submit" name="q" class="btn btn-sm btn-primary"><span class="counters"></span> <i class="fa fa-search"></i></button>
                                    </div>
                                </div>                                                     
                          	
                          		<div id="contenidoDeUser">
									
								  </div>
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
			<small class="badge bg-blue"><h4><code id="namepertenese">Pertenece a:</code></h4></small>
           <br>
           <br>
            <div class="box-body ">        	
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
	                    <th>Creador</th>
	                    <th style="width: 120px">Fecha Creación</th>	                   
	                    <th style="width: 90px">Opciones</th>
	                </tr>
	                </thead>
	                <tbody>
	                <?php foreach ($dataProvider as $key => $value) { ?>
					<tr>
	                    <td><?php echo $key+1; ?></td>
	                    <td><?php echo $value['title']; ?></td>
	                    <td><?php echo $value['name']; ?></td>
	                    <td><?php echo $value['createdAt']; ?></td>
	                    <td>
	                    	<div class="btn-group">                         
	                            
	                            <button type="button" class="btn btn-info btnVistaArticle" value="<?php echo $value['id']; ?>" data-toggle="modal" data-target="#modalArticles"><i class="fa fa-eye"></i></button>
	                            <button type="button" class="btn btn-danger btnEliminarArticle" value="<?php echo $value['id']; ?>"  data-toggle="modal" data-target="#modalDeleteArticles"><i class="fa fa-trash-o"></i></button>
	                        </div>
	                    </td>
	                </tr>
							
					<?php } ?>
					</tbody>
	                
	                
	            </table>
	        </div>
	       </div>	<!-- /.box-body -->
		</div>
        </div>	
    </div>
</div>	

<div class="modal fade" id="modalArticles" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-fw fa-book"></i> Artículo</h4>
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
    
    $.noConflict();			
	jQuery(document).ready(function($){
		"use strict";		
		$('.fecha').datepicker({
			language: "es",

		});  
		$("#txtBuscar").keyup(function () {
			
			$.ajax({
        		type: "GET",
        		url: "indexbuscar/"+$("#txtBuscar").val(),
        		success: function(response, status) {
        			
		        	$("#contenidoDeUser").html(response);
		        },
		        error: function (response, status) {
		                //alert("Error");
		        },
			});
			
			$("#contenidoDeCategorias").html("");
						
			if($("#txtBuscar").val().length==0)
        	{
        		$("#contenidoDeUser").html("");
        	}
		});
		
		
		$("#txtBuscarCategoria").keyup(function () {
			
			$.ajax({
        		type: "GET",
        		url: "indexbuscarcategoria/"+$("#txtBuscarCategoria").val(),
        		success: function(response, status) {
        			
		        	$("#contenidoDeCategorias").html(response);
		        },
		        error: function (response, status) {
		                //alert("Error");
		        },
			});
			
			$("#contenidoDeUser").html("");			
			if($("#txtBuscarCategoria").val().length==0)
        	{
        		$("#contenidoDeCategorias").html("");
        	}
		});		
		
		$("#btnBuscar").on("click",function () {
			$("#namepertenese").html("Desde: "+$("#fecha1").val()+" - "+"Hasta: "+$("#fecha2").val());
			$("#namepertenese").val("Desde: "+$("#fecha1").val()+" - "+"Hasta: "+$("#fecha2").val());
			$.ajax({
        		type: "GET",
        		//url: "indexgeneralbuscarfecha/"+$(this).val(),
        		url: "indexgeneralbuscarfecha/",
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
	        		url: "/gamma/article/indexgenerals/",
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

		$('.btnVistaArticle').on('click', function() {
			//alert($(this).attr("value"));
			$.ajax({
                    type: "GET",
                    data:{'uid':$(this).attr("id")},
                    url: "view/"+$(this).attr("value"),
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
        		url: "indexgenerals/",
        		success: function(response, status) {
        			$("#tableArticles").html(response);
		        },
		        error: function (response, status) {
		                alert("Error");
		        },
			});
		       
		});	
		
		//$('#tblArticle').dataTable();
		
		var encabezado="<?php echo "		  	                                                        											              "; ?>";	
		encabezado= encabezado+"<?php echo "SOCIAL MEDIA ACADEMIC NETWORK"; ?>";
		encabezado= encabezado+"<?php echo "							        					        "; ?>";
		encabezado= encabezado+"<?php echo "							        			        "; ?>";
		encabezado= encabezado+"<?php echo "Estadísticas de los Recursos Educativos           "; ?>";
		encabezado= encabezado+"<?php echo "		  	                                                                    		        "; ?>";
		encabezado= encabezado+"<?php echo "					        			 "; ?>";		
		encabezado= encabezado+"Fecha: <?php print(date('m/d/Y h:i:s a', time())); ?> ";		
		encabezado=encabezado+$('#namepertenese').val();
		
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
	                    "sFileName":"recursoseducativos.pdf"
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