<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/datatables/dataTables.tableTools.css" rel="stylesheet" type="text/css" />
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/dataTables.bootstrap.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/dataTables.tableTools.js"></script>
<div class="table-responsive" id="tblOpcionesDeUsuarios" >
 <!-- THE MESSAGES -->
 <table id='tblCategory' class="table table-bordered table-striped results" >
    <thead>
    <tr>
        <th style="width: 10px">#</th>
        <th>Nombre</th>        
        <th>Fecha Creación</th>
        <th>Descripción</th>
        <th style="width: 150px">Opciones</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($dataProvider as $key => $value) { ?>
	<tr>
        <td><?php echo $key+1; ?></td>
        <td><?php echo $value->name; ?></td>
        <td><?php echo $value->createdAt; ?></td>
        <td>
            <?php echo $value->description; ?>
        </td>
        <td>
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
	

<script type="text/javascript">
    $.noConflict();			
	jQuery(document).ready(function($){   
		"use strict";

		$('.btnEliminarCategoria').on('click', function() {
			$("#txtDetalleDelete").html($(this).closest('tr').find('td:eq(1)').text());
			$("#btnDeleteCategorias").val($(this).attr("value"));
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
		
		var table = $('#tblCategory').DataTable( {
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
	                    								} ]
	                }
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

