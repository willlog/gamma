<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.min.js"></script>
<?php $this->setPageTitle("MI CUENTA"); ?>
<div class="continer">
    <div class="col-md-4">
        <!-- Default box -->
        <div class="box box-solid">
            <div class="box-header">
                <h3 class="box-title"><i class="fa fa-fw fa-pencil"></i> Información</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-default btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
            		<CENTER>
                		<small class="badge bg-green"><h4>User <code id="name"><?php echo $dataProvider->name; ?></code></h4></small>
                		<a class="btn btn-primary" id="btnFoto">
                            <i class="fa fa-picture-o"></i> Foto
                        </a>		                                    
                        <hr>		                                  
                        <div id="contImage"></div>	
                        <br>	                                    
                        <?php echo CHtml::image(Yii::app()->user->getState('foto'),'alt',array('width'=>100,'height'=>100));?>

                        <script type="text/javascript">
							 $(function() {
								"use strict";  
						        $('#btnFoto').on('click', function() {	
						        											        	
								  $.ajax({
						        		type: "GET",
						        		url: "imagen ",
						        		success: function(response, status) {
								        	$("#contImage").html(response);
								        },
								        error: function (response, status) {
								                alert("Error");
								        },
									});
								});
						    });
						</script> 	
            		</CENTER>
            		</br>			                    		 
            		<table class="table table-bordered">
                    <tr>
                        <th>Detalle</th>
                        <th>Datos</th>
                    </tr>
                    <tr>
                        <td>
                                <code>Nombre:<code>
                        </td>
                        <td><span class="badge bg-light-blue"><h5 id="nom"><?php echo $dataProvider->firstname; ?></h5></span></td>
                    </tr>
                    <tr>
                        <td>
                            <code>Apellido:<code>
                        </td>
                        <td><span class="badge bg-light-blue"><h5 id="ape"><?php echo $dataProvider->lastname; ?></h5></span></td>
                    </tr>
                    <tr>
                        <td>
                            <code>Fecha:<code>
                        </td>
                        <td><span class="badge bg-light-blue"><h5 id="fec"><?php echo $dataProvider->birthday; ?></h5></span></td>
                    </tr>
                    <tr>
                        <td>
                           <code>E-mail:<code>
                        </td>
                        <td><span class="badge bg-light-blue"><h5 id="mai"><?php echo $dataProvider->email; ?></h5></span></td>
                    </tr>
                </table>
                
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- /.col -->

    <div class="col-md-4">
        <!-- Primary box -->
        <div class="box box-solid box-primary">
            <div class="box-header">
                <h3 class="box-title"><i class="fa  fa-pencil-square-o"></i>Datos</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-primary btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
               	<center><a class="btn btn-app" id="btnEditarconfiUser">
                    <i class="fa fa-edit"></i> Editar
                </a></center>
                    <script type="text/javascript">
						 $(function() {
							"use strict";  
					        $('#btnEditarconfiUser').on('click', function() {
							  $.ajax({
					        		type: "GET",
					        		url: "updateconf/",
					        		success: function(response, status) {
							        	$("#contEditarUserConf").html(response);
							        },
							        error: function (response, status) {
							                alert("Error");
							        },
								});
							});
					    });
					</script>
                <p id="contEditarUserConf">
                  
                </p>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- /.col -->

    <div class="col-md-4">
        <!-- Info box -->
        <div class="box box-solid box-info">
            <div class="box-header">
                <h3 class="box-title"><i class="fa fa-fw fa-key"></i>Contraseña</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-info btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
               	<center><a class="btn btn-app" id="btnEditarconfiUserPass">
                    <i class="fa fa-key"></i> Cambiar Contrasena 
                </a></center>
                    <script type="text/javascript">
						 $(function() {
							"use strict";  
					        $('#btnEditarconfiUserPass').on('click', function() {
							  $.ajax({
					        		type: "GET",
					        		url: "updateconfpass/",
					        		success: function(response, status) {
							        	$("#contEditarUserConfpass").html(response);
							        },
							        error: function (response, status) {
							                alert("Error");
							        },
								});
							});
					    });
					</script>
                <p id="contEditarUserConfpass">
                  
                </p>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- /.col -->
</div><!-- /.row -->