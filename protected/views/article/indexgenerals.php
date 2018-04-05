<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/bootstrap-datepicker.js"></script>
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap-datepicker3.css" rel="stylesheet" type="text/css" />
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/datatables/dataTables.tableTools.css" rel="stylesheet" type="text/css" />
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/dataTables.bootstrap.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/dataTables.tableTools.js"></script>	
<table id="tblArticle1" class="table table-bordered table-striped results">
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
	


<script type="text/javascript">
     $.noConflict();			
	jQuery(document).ready(function($){
        "use strict";

        $('.btnEliminarArticle').on('click', function() {
            $("#txtDetalleDelete").html($(this).closest('tr').find('td:eq(1)').text());
            //$("#uidvaldel").html($(this).attr("id"));;
            $("#btnDeleteArticles").val($(this).attr("value"));
        });
        
        $('.btnEditarArticle').on('click', function() {
            //alert($(this).attr("value"));
            $.ajax({
                    type: "GET",
                    data:{'uid':$(this).attr("id")},
                    url: "update/"+$(this).attr("value"),
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
                    url: "view/"+$(this).attr("value"),
                    success: function(html, status) {
                       $('#cntAddArticlesTotal').html(html);
                    },
                    error: function (response, status) {
                            alert("Error");
                    },
            });
        });
        
        //$('#tblArticle').dataTable();		
		var table = $('#tblArticle1').DataTable( {
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
