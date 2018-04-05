<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.min.js"></script>

<div class="row">

<div class="col-lg-8 col-xs-6" id="contenidoRolesIndex">

	<?php foreach ($data as $key => $value) { ?>
	
	        <!-- small box -->
	    <div class="col-lg-4 col-xs-6">
	        <div class="small-box bg-aqua">
	            <div class="inner">
	                <h3>
	                   <?php echo $value->name; ?>
	                </h3>
	                <p>
	                    Tipo <?php echo $value->type; ?>
	                </p>
	            </div>
	            <div class="icon">
	                <i class="ion ion-bag"></i>
	            </div>
	            <div class="small-box-footer">
	                <button class="btn bg-navy btn-circle btnEditRoles" value="<?php echo $value->name; ?>"><i class="fa fa-eye fa-lg"></i></button>
	            </div>
	        </div>
	    </div><!-- ./col -->
	<?php } ?>
	<script type="text/javascript">
		    $(function() {
				"use strict";  
		        $('.btnEditRoles').on('click', function() {
				 	
				   // $("#rolcontenido").html($(this).attr("value"));
				  
				    $.ajax({
		        		type: "GET",
		        		url: "view/"+$(this).attr("value"),
		        		success: function(response, status) {
				        	$("#rolcontenido").html(response);
				        },
				        error: function (response, status) {
				                //alert("Error");
				        },
					});
				       
				});
		    });
		</script>
</div>	


<div class="col-lg-4 col-xs-2 ">
	<div class="content">
		<div class="btn-group">
			<button id="btnRefresRol" class="btn bg-navy btn-social"><i class="fa  fa-refresh"></i> </button>
			<button id="btnNewRol" class="btn bg-navy btn-social"><i class="fa fa-group"></i> <span>Agregar rol</span></button>
		</div>
		
		<div class="box box-primary">
		    <div class="box-header">
		        <h3 class="box-title">Roles</h3>
		    </div><!-- /.box-header -->
		    <!-- form start -->
		    <div id="rolcontenido">
			
			</div>
		</div>

	</div>
</div>	

	
</div>

<script type="text/javascript">
    $(function() {
		"use strict";  
        $('#btnNewRol').on('click', function() {
		  $.ajax({
        		type: "GET",
        		url: "create/",
        		success: function(response, status) {
		        	$("#rolcontenido").html(response);
		        },
		        error: function (response, status) {
		                //alert("Error");
		        },
			});
		});
		$('#btnRefresRol').on('click', function() {
		  $.ajax({
        		type: "GET",
        		url: "indexa/",
        		success: function(response, status) {
		        	$("#contenidoRolesIndex").html(response);
		        },
		        error: function (response, status) {
		                //alert("Error");
		        },
			});
		});
    });
</script>

