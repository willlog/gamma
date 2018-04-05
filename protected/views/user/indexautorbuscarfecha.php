<!-- jQuery 2.0.2 -->
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/datatables/dataTables.tableTools.css" rel="stylesheet" type="text/css" />
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/dataTables.bootstrap.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/dataTables.tableTools.js"></script>
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

<script type="text/javascript">
    
    $.noConflict();			
	jQuery(document).ready(function($){
		"use strict";
		//$('#tblUser').dataTable();
		
		var encabezado="<?php echo "		  					                											              "; ?>";	
		encabezado= encabezado+"<?php echo "SOCIAL MEDIA ACADEMIC NETWORK"; ?>";
		encabezado= encabezado+"<?php echo "							        					        "; ?>";
		encabezado= encabezado+"<?php echo "Estadísticas de los Usuarios por Fechas"; ?>";
		encabezado= encabezado+"<?php echo "							        	    "; ?>";
		encabezado= encabezado+"<?php echo "							        		"; ?>";		
		encabezado= encabezado+"Fecha: <?php print(date('m/d/Y h:i:s a', time())); ?>";
		encabezado=encabezado+" Desde: "+$("#fecha1").val() + "      Hasta: "+ $("#fecha2").val();		
		 
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