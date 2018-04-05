<!-- jQuery 2.0.2 -->
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/datatables/dataTables.tableTools.css" rel="stylesheet" type="text/css" />
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/dataTables.bootstrap.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/dataTables.tableTools.js"></script>

<?php $this->setPageTitle("ESTADÍSTICAS CATEGORÍAS"); ?>
<section class="content">
	<?php echo CHtml::link('<i class="fa fa-bar-chart-o fa-fw"> Estadísticas</i>', array('/category/estadisticageneral/'), array('target'=>'_blank', 'class'=>'btn btnVistaArticle'));  ?>
	<br/>
	<br/>
	<div style="float: right;">	 	 
	 	<button  id="btnRefresCategoria"  onclick="window.location.reload()"><i class="fa fa-refresh"></i> </button>
	</div> 
	<div class="table-responsive" id="tableArticles">
	            <table id="tblCategory" class="table table-bordered table-striped results">
	            	<thead>
	                <tr>
	                    <th style="width: 20px">#</th>	                    
	                    <th>Nombre</th>
	                    <th>Descripción</th>
	                    <th>Fecha Creación</th>	 
	                    <th>Número de Artículos</th>	                                      
	                    <th>Ver</th>
	                </tr>
	                </thead>
	                <tbody>
	                <?php foreach ($dataProvider as $key => $value) { ?>
					<tr>
	                    <td><?php echo $key+1; ?></td>	                    
	                    <td><?php echo $value['name']; ?></td>
	                    <td><?php echo $value['description']; ?></td>	                    
	                    <td><?php echo $value['createdAt']; ?></td>
	                    <td><?php echo $value['cantidad']; ?></td>
	                    	                    
	                    <td>
	                    	<div class="btn-group">       
	                            <?php echo CHtml::link('<i class="fa fa-eye"></i>', array('/category/estadisticacategoria/'.$value['id']), array('target'=>'_blank', 'class'=>'btn btn-info btnVistaArticle'));  ?>
	                                                     
	                        </div>
	                    </td>
	                </tr>
							
					<?php } ?>
	                
	              </tbody> 
	            </table>
	        </div><!-- /.box-body -->
	
</section><!-- /.content -->
<script type="text/javascript">
    
    $.noConflict();			
	jQuery(document).ready(function($){
		"use strict";
		//$('#tblCategory').dataTable();
		
		var encabezado="<?php echo "		  					                											              "; ?>";	
		encabezado= encabezado+"<?php echo "SOCIAL MEDIA ACADEMIC NETWORK"; ?>";
		encabezado= encabezado+"<?php echo "							        					        "; ?>";
		encabezado= encabezado+"<?php echo "Estadísticas de las Categorías"; ?>";
		encabezado= encabezado+"<?php echo "							        					        "; ?>";
		encabezado= encabezado+"<?php echo "							        			 "; ?>";		
		encabezado= encabezado+"Fecha: <?php print(date('m/d/Y h:i:s a', time())); ?>";
		
		 
		//$("#tblCategory").beautyHover();
	
		var table = $('#tblCategory').DataTable( {
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
	                    "sFileName":"estadistica_categoria.pdf"
	                    
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