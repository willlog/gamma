     <!-- jQuery 2.0.2 -->
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.min.js"></script>
<h1>Prueba Redes Sociales Like</h1>
    <section class="content">

                    <div class="row">
                       
                        <div class="col-md-6">
                            
                            <!-- BAR CHART -->
                            <div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title">Likes por Persona</h3>
                                </div>
                                <div class="box-body chart-responsive">
                                    <div class="chart" id="bar-chart" style="height: 300px;"></div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

                        </div><!-- /.col (RIGHT) -->
                    </div><!-- /.row -->

                </section><!-- /.content -->
                
  <!-- page script -->
        <script type="text/javascript">
            $(function() {
            	
                "use strict";  
                var datos=[
                        {y: '2006', a: 100, b: 90},
                        {y: '2007', a: 75, b: 65},
                        {y: '2008', a: 50, b: 40},
                        {y: '2009', a: 75, b: 65},
                        {y: '2010', a: 50, b: 40},
                        {y: '2011', a: 75, b: 65},
                        {y: '2012', a: 100, b: 90}
                    ];              
               $.ajax({
        		type: "post",
        		url: "/redsocial/like/JSONgrafico",
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
				                         b[fila]["y"]=response[i]['name'];
				                         b[fila]["a"] = response[i]['cantidad'];
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
                    labels: ['LIKE'],
                    xLabelAngle:45,                    
                    hideHover: 'auto'
                });	
		        	
		        	
                	//alert(response[0]["name"]);
	                //$.each(response, function(i, item) {
				    //alert(response[i].name);
			//});
		        },
		        error: function (response, status) {
		                alert("Fucking Bull Shit!");
		        },
			});
               
            });
        </script>

                  
 
            