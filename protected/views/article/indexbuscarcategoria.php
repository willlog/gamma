<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.min.js"></script>
<style type="text/css">

	.results tr[visible='false'],
	.no-result{
	  display:none;
	}

	.results tr[visible='true']{
	  display:table-row;
	}	
</style>
<div class="row">
    <div class="col-md-8">
        <div class="box">			
	        
	        <div class="table-responsive" id="tableCategoryBusqueda">
	            <table class="table table-mailbox results">
	                
	                <?php foreach ($dataProvider as $key => $value) {  ?>
					<tr>
	                    <td><?php echo $key+1; ?></td>
	                    <td><?php echo $value->name; ?></td>	                    
	                    
	                    <td>
	                    	<div class="btn-group">
	                            
	                            <button type="button" id="<?php echo $value->name; ?>" class="btnVerCategoriArticle" value="<?php echo $value->id; ?>" ><i class="fa fa-search"></i></button>
	                            
	                        </div>
	                    </td>
	                </tr>
							
					<?php } ?>
	                
	                
	            </table>
	        </div><!-- /.box-body -->
	       

        </div>	
    </div>
</div>

<script type="text/javascript">
    $(function() {
		"use strict";		
		$('.btnVerCategoriArticle').on('click', function() {			
			$("#namepertenese").html("Categoría: "+$(this).attr("id"));
			$("#namepertenese").val("Categoría: "+$(this).attr("id"));
			$.ajax({
        		type: "GET",
        		url: "indexconsultageneralcategoria/"+$(this).attr("value"),
        		success: function(response, status) {
        			
		        	$("#tableArticles").html(response);
		        },
		        error: function (response, status) {
		                //alert("Error");
		        },
			});
		       
		});

		
        
    });
</script>	

