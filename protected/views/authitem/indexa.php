<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.min.js"></script>

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
		        		type: "POST",
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