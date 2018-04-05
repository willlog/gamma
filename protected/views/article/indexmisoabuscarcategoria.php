<!-- jQuery 2.0.2 -->
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/datatables/dataTables.tableTools.css" rel="stylesheet" type="text/css" />
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/bootstrap-datepicker.js"></script>
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap-datepicker3.css" rel="stylesheet" type="text/css" />
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/dataTables.bootstrap.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/dataTables.tableTools.js"></script>
	
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
        <th>Ver</th>
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
<input id ="catname" value="<?php echo $model->name?>" hidden="hidden"/>
 <script type="text/javascript">
	$.noConflict();			
	jQuery(document).ready(function($){
		"use strict";
		$("#tblArticle").dataTable().fnDestroy();	  				
		
		var encabezado="<?php echo "		  	                                                        											              "; ?>";	
		encabezado= encabezado+"<?php echo "SOCIAL MEDIA ACADEMIC NETWORK"; ?>";
		encabezado= encabezado+"<?php echo "							        					        "; ?>";
		encabezado= encabezado+"<?php echo "							        					        "; ?>";
		encabezado= encabezado+"<?php echo "Estadísticas de los Recursos Educativos"; ?>";
		encabezado= encabezado+"<?php echo "							        	                                                                    		        "; ?>";
		encabezado= encabezado+"<?php echo "							        			 "; ?>";		
		encabezado= encabezado+"Fecha: <?php print(date('m/d/Y h:i:s a', time())); ?>";
		encabezado=encabezado+" Usuario: "+$("#username").val();
		encabezado= encabezado+"<?php echo "							        		                     	     "; ?>";
		encabezado= encabezado+"<?php echo "							        		                             "; ?>";
		encabezado= encabezado+"<?php echo "							        		                             "; ?>";		
		encabezado=encabezado+" Categorìa: "+$("#catname").val();
	
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
	    
	});
		
</script> 
<script type="text/javascript">
	$.noConflict();			
	jQuery(document).ready(function($){
		"use strict";	  				
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
		
		//$('#tblArticle').dataTable();
		/*var table = $('#tblArticle').DataTable( {
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

    