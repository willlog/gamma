<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/datatables/dataTables.tableTools.css" rel="stylesheet" type="text/css" />
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/jquery.dataTables.js"></script><br />
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/dataTables.bootstrap.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/dataTables.tableTools.js"></script>
        
<table id="tablaBuscarArticulos" class="table table-bordered table-striped results">
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
	                
	                
	                <button type="button" class="btn btn-info btnVistaArticle" value="<?php echo $value['id']; ?>"  data-toggle="modal" data-target="#modalArticles"><i class="fa fa-eye"></i></button>
	                <button type="button" class="btn btn-danger btnEliminarArticle" value="<?php echo $value['id']; ?>"  data-toggle="modal" data-target="#modalDeleteArticles"><i class="fa fa-trash-o"></i></button>
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
		
		 //$('#tablaBuscarArticulos').dataTable();
		
		 $('.btnEliminarArticle').on('click', function() {
            $("#txtDetalleDelete").html($(this).closest('tr').find('td:eq(1)').text());
            //$("#uidvaldel").html($(this).attr("id"));;
            $("#btnDeleteArticles").val($(this).attr("value"));
        });
        
		$('.btnVistaArticle').on('click', function() {
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

		

		/*$('#btnRefresArticle').on('click', function() {
			$.ajax({
        		type: "GET",
        		url: "/redsocial/article/indexgenerals/",
        		success: function(response, status) {
        			$("#tableArticles").html(response);
		        },
		        error: function (response, status) {
		                alert("Error");
		        },
			});
		       
		});*/
		
		var encabezado="<?php echo "		  	                                                        											              "; ?>";	
		encabezado= encabezado+"<?php echo "SOCIAL MEDIA ACADEMIC NETWORK"; ?>";
		encabezado= encabezado+"<?php echo "							        					        "; ?>";
		encabezado= encabezado+"<?php echo "							        			        "; ?>";
		encabezado= encabezado+"<?php echo "Estadísticas de los Recursos Educativos           "; ?>";
		encabezado= encabezado+"<?php echo "		  	                                                                    		        "; ?>";
		encabezado= encabezado+"<?php echo "					        			 "; ?>";		
		encabezado= encabezado+"Fecha: <?php print(date('m/d/Y h:i:s a', time())); ?>   ";		
		encabezado=encabezado+$('#namepertenese').val();
		
		var table = $('#tablaBuscarArticulos').DataTable( {
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
