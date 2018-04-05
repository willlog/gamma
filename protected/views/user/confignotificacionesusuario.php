<!-- jQuery 2.0.2 -->
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/datatables/dataTables.tableTools.css" rel="stylesheet" type="text/css" />
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/bootstrap-datepicker.js"></script>
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap-datepicker3.css" rel="stylesheet" type="text/css" />
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/dataTables.bootstrap.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/dataTables.tableTools.js"></script>
<?php $this->setPageTitle("TIPOS DE NOTIFICACIONES"); ?>
<section class="content">  
<div class="col-sm-12">
	<div style="float: right;">	 	 
	 	<button  id="btnRefresCategoria"  onclick="window.location.reload()"><i class="fa fa-refresh"></i> </button>
	 </div> 
	<div class="table-responsive" id="tableArticles">
	            <table id="tblArticle" class="table table-bordered table-striped results">
	                <thead>
	                <tr>
	                    <th style="width: 20px">#</th>
	                    <th>Tipo de Notificación</th>
	                    <th>Valor</th>	                    	                                                        
	                    <th>Opciones</th>
	                </tr>
	                </thead>
	                <tbody>
	                <?php foreach ($dataProvider as $key => $value) { ?>
					<tr>
	                    <td><?php echo $key+1; ?></td>	                    
	                    <td><?php echo CHtml::link($value['texto'], '', array('target'=>'_blank'));  ?></td>	                   
	                    <td><?php echo $value['valor']; ?></td>                                      
	                    <td>
	                    	<div class="btn-group">       
	                            <?php echo CHtml::link('<i class="fa fa-eye"></i>', array('/user/valornotificacionusuario/'.$value['id']), array('target'=>'_blank', 'class'=>'btn btn-info btnVistaArticle'));  ?>                          
	                        </div>
	                    </td>
	                </tr>
	                							
					<?php } ?>
	                
	            </tbody>    
	            </table>
	        </div><!-- /.box-body -->
 </div>	
 
</section><!-- /.content -->

<script type="text/javascript">

		$.noConflict();			
		jQuery(document).ready(function($){
			"use strict";	
			$("#btnBuscar").on("click",function () {
					
			$("#namepertenese").html($("#fecha1").val()+" - "+$("#fecha2").val());
			$.ajax({				
        		type: "GET",
        		//url: "indexgeneralbuscarfecha/"+$(this).val(),
        		url: "Indexmisoabuscarfecha/",
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
	  		  	
	  	$("#txtBuscarCategoria").keyup(function () {
			
			$.ajax
			({
        		type: "GET",
        		url: "indexbuscarcategoriamis/"+$("#txtBuscarCategoria").val(),
        		success: function(response, status) {
        			
		        	$("#contenidoDeCategorias").html(response);		        	
		        },
		        error: function (response, status) {
		                //alert("Error");
		        },
			});
			if($("#txtBuscarCategoria").val().length==0)
        	{
        		$("#contenidoDeCategorias").html("");
        	}
		});
			
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
		
		$('.fecha').datepicker
		({
			language: "es",
		});
		
		/*$('#tblArticle').dataTable({
			
		});*/
		
		// Make all JS-activity for dashboard
		//DashboardTabChecker();
		// Make beauty hover in table
		//$("#tblArticle").beautyHover();
		
			
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
	                    //"sPdfMessage": encabezado,
	                    "sPdfOrientation": "landscape",
	                    "mColumns": [0,1,2,3],
	                    "sTitle": "                               											                             	   UNIVERSIDAD TÉCNICA DE AMBATO",
	                    "sFileName":"estadistica_misrecursos.pdf"
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