<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/datatables/dataTables.tableTools.css" rel="stylesheet" type="text/css" />
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/dataTables.bootstrap.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/dataTables.tableTools.js"></script>

<?php $this->setPageTitle("ADMINISTRACIÓN DE USUARIOS"); ?>

<div class="mailbox row">
    <div class="col-xs-12">
        <div class="box box-solid">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-3 col-sm-4">
                        <!-- BOXES are complex enough to move the .box-header around.
                             This is an example of having the box header within the box body -->
                        <div class="box-header">
                            <i class="fa fa-inbox"></i>
                            <h3 class="box-title">Usuarios</h3>
                        </div>
                        <!-- compose message btn -->
                        <a class="btn btn-block btn-primary" id="btnAddFullUser" data-toggle="modal" data-target="#compose-modal">
                        	<i class="fa fa-pencil"></i> Agregar usuario</a>
                        <!-- Navigation - folders-->
                        <div style="margin-top: 15px;">
                            <ul class="nav nav-pills nav-stacked">
                                <li class="header">Detalle</li>
                                <li class="active"><a id="btnUserSolicitudes" href="#"><i class="fa fa-inbox"></i> Solicitudes  <small  class="badge pull-right bg-yellow"> <div id="valSol"><?php echo $solicitada; ?></div></small></a></li>
                                <li><a id="btnUserActivadas" href="#"><i class="fa fa-pencil-square-o"></i> Activados <small  class="badge pull-right bg-green"><div id="valAct"><?php echo $activada; ?></div></small></a></li>
                                <li><a id="btnUserCanceladas" href="#"><i class="fa fa-mail-forward"></i>  Cancelados <small  class="badge pull-right bg-red"><div id="valCan"><?php echo $cancelada; ?></div></small></a></li>
                                
                            </ul>
                        </div>
                    </div><!-- /.col (LEFT) -->
                    <div class="col-md-9 col-sm-8">
                        <div class="row pad">
                            <div class="col-sm-6">
                                
                                <!-- Action button -->
                                <!--<div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm btn-flat dropdown-toggle" data-toggle="dropdown">
                                        Opciones <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#">Acpertar a todos</a></li>
                                        <li><a href="#">Bloquear a todos</a></li>
                                        
                                    </ul>
                                </div>-->

                            </div>
                            
                        </div><!-- /.row -->
						<div style="float: right;">	 	 
						 	<button  id="btnRefresCategoria"  onclick="window.location.reload()"><i class="fa fa-refresh"></i> </button>
						 </div> 
                        <div id="tblOpcionesDeUsuarios">
                            <!-- THE MESSAGES -->
                            <table id="tblUsuarios" class="table table-bordered table-striped results">
                            	<thead>
				               		<tr>
					                    <th>#</th>
					                    <th></th>
					                    <th>Usuario</th>	                   
					                    <th>Nombre</th>
					                    <th>Apellido</th>
					                    <th>Email</th>
					                    <th>Fecha Creación</th>
					                </tr>
				                </thead>
                            	<tbody>
	                            	<?php foreach ($dataProvider as $key => $value) { ?>
	                            		<tr >
		                                    <td >
		                                    	<div class="btn-group">
									                <button type="button" class="btn btn-info"><i class="fa fa-check-circle"></i></button>
									                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
									                    <span class="caret"></span>
									                    <span class="sr-only">Toggle Dropdown</span>
									                </button>
									                <ul class="dropdown-menu ddmActivarSolicitud" role="menu">
									                    <li value="editor" id="<?php echo $value->id; ?>"><a href="#"><i class="fa fa-check"></i> Activar</a></li>
									                    <li value="cancel" id="<?php echo $value->id; ?>"><a href="#"><i class="fa fa-circle-o"></i> Cancelar</a></li>
									                    <li value="editar" id="<?php echo $value->id; ?>" data-toggle="modal" data-target="#compose-modal"><a href="#"><i class="fa fa-pencil-square-o"></i> Editar</a></li>
									    				<li value="eliminar" id="<?php echo $value->id; ?>"><a href="#"><i class="fa fa-trash-o"></i> Eliminar</a></li>
									                </ul>
									            </div>
		                                    </td>
		                                    <td class="small-col"><i class="fa fa-user"></i></td>
		                                    <td class="name"><a href="#"><?php echo $value->name; ?></a></td>
		                                    <td class="subject"><a href="#"><?php echo $value->firstname; ?></a></td>
		                                    <td class="subject"><a href="#"><?php echo $value->lastname; ?></a></td>
		                                    <td class="subject"><a href="#"><?php echo $value->email; ?></a></td>
		                                    <td class="time"><?php echo $value->createdAt; ?></td>
		                                </tr>
	                            	<?php } ?>
                            	<tbody>
                            </table>  
                            
                            <script type="text/javascript">
							    $.noConflict();			
								jQuery(document).ready(function($){
									"use strict"; 				        
							
							        $('.ddmActivarSolicitud li').on('click', function() {
							           // $("#rolcontenido").html($(this).attr("value"));
							           if ($(this).attr("value")=="eliminar") {
							                
							                $.ajax({
							                    type: "POST",
							                    url: "delete/"+$(this).attr("id"),
							                    success: function(response, status) {
							                        var obj = jQuery.parseJSON(response);
							                        $('#valSol').html(obj.sol);
							                        $('#valAct').html(obj.act);
							                        $('#valCan').html(obj.can);
							                        $("#btnUserSolicitudes").trigger( "click" );
							                    },
							                    error: function (response, status) {
							                            alert("Error");
							                    },
							                });
							
							           }else if($(this).attr("value")=="editar") {
							
							           		 $.ajax({
								        		type: "GET",
								        		url: "update/"+$(this).attr("id"),
								        		success: function(response, status) {
										        	$("#cntContenidoDeAddUserFull").html(response);
										        },
										        error: function (response, status) {
										                alert("Error");
										        },
											});
							
							           } else{
							                
							                $.ajax({
							                    type: "POST",
							                    data:{'stado':$(this).attr("value")},
							                    url: "updates/"+$(this).attr("id"),
							                    success: function(response, status) {
							                        
							                        var obj = jQuery.parseJSON(response);
							
							                        
							                        $('#valSol').html(obj.sol);
							                        $('#valAct').html(obj.act);
							                        $('#valCan').html(obj.can);
							                        $("#btnUserSolicitudes").trigger( "click" );
							                    },
							                    error: function (response, status) {
							                            alert("Error");
							                    },
							                });
							
							           }
							            
							        });	
							        
							        var encabezado="<?php echo "		  	                                                        											              "; ?>";	
									encabezado= encabezado+"<?php echo "SOCIAL MEDIA ACADEMIC NETWORK"; ?>";
									encabezado= encabezado+"<?php echo "							        					        "; ?>";
									encabezado= encabezado+"<?php echo "							        					        "; ?>";
									encabezado= encabezado+"<?php echo "Solicitudes de Activación de Cuenta"; ?>";
									encabezado= encabezado+"<?php echo "							        	                                                                    		        "; ?>";
									encabezado= encabezado+"<?php echo "							        			 "; ?>";		
									encabezado= encabezado+"Fecha: <?php print(date('m/d/Y h:i:s a', time())); ?>";				
									
									
									var table = $('#tblUsuarios').DataTable( {
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
								                    "mColumns": [ 2,3,4,5,6 ],
								                    "sTitle": "                               											                             	   UNIVERSIDAD TÉCNICA DE AMBATO",
	                    							"sFileName":"solicitud_usuarios.pdf"
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
							
								//$('#tblUsuarios').dataTable();
							    });
							</script>          

                        </div><!-- /.table-responsive -->
                    </div><!-- /.col (RIGHT) -->
                </div><!-- /.row -->
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
                
            </div><!-- box-footer -->
        </div><!-- /.box -->
    </div><!-- /.col (MAIN) -->
</div>
<!-- MAILBOX END -->
<div class="modal fade" id="compose-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-user"></i> Usuario</h4>
            </div>
            <div class="modal-body" id="cntContenidoDeAddUserFull">
            	
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script type="text/javascript">
	//$.noConflict();			
	jQuery(document).ready(function($){
		"use strict";  
        $('#btnAddFullUser').on('click', function() {
		  $.ajax({
        		type: "GET",
        		url: "create/",
        		success: function(response, status) {
		        	$("#cntContenidoDeAddUserFull").html(response);
		        },
		        error: function (response, status) {
		                alert("Error");
		        },
			});
		});
		
		$('#btnUserSolicitudes').on('click', function() {
		   // $("#rolcontenido").html($(this).attr("value"));
		    $.ajax({
        		type: "GET",
        		url: "indexs",
        		success: function(response, status) {
		        	$("#tblOpcionesDeUsuarios").html(response);
		        },
		        error: function (response, status) {
		                alert("Error");
		        },
			});
		});
		
		$('#btnUserActivadas').on('click', function() {
									 	
		   // $("#rolcontenido").html($(this).attr("value"));
		    $.ajax({
        		type: "GET",
        		url: "indexa",
        		success: function(response, status) {
        			
		        	$("#tblOpcionesDeUsuarios").html(response);
		        	
		        },
		        error: function (response, status) {
		                alert("Error");
		        },
			});		
		       
		});
		
		$('#btnUserCanceladas').on('click', function() {
									 	
		   // $("#rolcontenido").html($(this).attr("value"));
		    $.ajax({
        		type: "GET",
        		url: "indexc",
        		success: function(response, status) {
        			
		        	$("#tblOpcionesDeUsuarios").html(response);
		        },
		        error: function (response, status) {
		                alert("Error");
		        },
			});
		       
		});	
		
    });
</script>