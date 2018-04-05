<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/datatables/dataTables.tableTools.css" rel="stylesheet" type="text/css" />
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/dataTables.bootstrap.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/dataTables.tableTools.js"></script>
<table id="tblUsuarioscan" class="table table-bordered table-striped results">
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
</tbody>
</table>


<script type="text/javascript">
   		$(function(){
        "use strict"; 
        /*$('#btnUserSolicitudes').on('click', function() {
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
        });*/

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
                        $("#btnUserCanceladas").trigger( "click" );
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
                        $("#btnUserCanceladas").trigger( "click" );
                    },
                    error: function (response, status) {
                            alert("Error");
                    },
                });

           }
            
        });

        /*$('#btnUserActivadas').on('click', function() {
            
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
        });*/
        
        //$('#tblUsuarios').dataTable(); 
        
        var encabezado="<?php echo "		  	                                                        											              "; ?>";	
		encabezado= encabezado+"<?php echo "SOCIAL MEDIA ACADEMIC NETWORK"; ?>";
		encabezado= encabezado+"<?php echo "							        					        "; ?>";
		encabezado= encabezado+"<?php echo "							        					        "; ?>";
		encabezado= encabezado+"<?php echo "Solicitudes de Cuenta Canceladas"; ?>";
		encabezado= encabezado+"<?php echo "							        	                                                                    		        "; ?>";
		encabezado= encabezado+"<?php echo "							        			 "; ?>";		
		encabezado= encabezado+"Fecha: <?php print(date('m/d/Y h:i:s a', time())); ?>"; 
        
        $("#tblUsuarioscan").dataTable().fnDestroy();
        
        var table = $('#tblUsuarioscan').DataTable( {
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
						"sFileName":"usuarios_cancelados.pdf"
	                },
	                "print"
	            ]
	        }
	        
	    } );
    });
</script>