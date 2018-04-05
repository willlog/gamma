     <!-- jQuery 2.0.2 -->
<!--<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.min.js"></script>-->	
<script src="<?php echo Yii::app()->request->baseUrl;?>/js/jquery.min.js"></script>
<h1>Prueba Redes Sociales Share</h1>


<!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-md-10">
                            <!-- BAR CHART -->
                            <div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title">Total de Articulos Compartidos por Año</h3>
                                </div>
                                <div class="box-body chart-responsive">
                                    <div class="chart" id="bar-chart" style="height: 300px;"></div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->                         
                  
      

                </section><!-- /.content -->       
   
  <!-- page script -->
        <script type="text/javascript">
            $(function() {              
               
               "use strict";  
                         
               $.ajax({
        		type: "post",
        		url: "/gamma/share/JSONrecomendados",
        		//url: "/like/JSONgrafico",
		        //data: data,
		        dataType: "json",
		        success: function(response, status) {
		        	
		        	
		        	var b = new Array();
                               var fila=0;
			                     for (var i = 0; i < response.length; i++) {
			                         //if(i%2==0)
			                         //{
				                         b[fila] = new Array();
				                         b[fila]["y"]=response[i]['title'];
				                         b[fila]["a"] = response[i]['recomendado'];
				                         //b[fila]["b"] = response[i]['cantidad']+5;
				                         //b[fila]["b"] = response[i+1]['cantidad'];
				                         //b[fila]["count"] = response[i]['cantidad'];
				                        	
				                         fila++;
			                        //}
			                     }

		        //BAR CHART
                var bar = new Morris.Bar({
                    element: 'bar-chart',
                    resize: true,
                    data: b,
                    //barColors: 'auto',
                    xkey: 'y',                    
                    ykeys: ['a'],
                    labels: ['Recomendado'],
                    //stacked:true,
                    xLabelAngle:45,                    
                    hideHover: 'auto'
                });			        	
		
		        },
		        error: function (response, status) {
		                alert("Error!");
		        },
			});
               
            });
        </script>

                  
 
            