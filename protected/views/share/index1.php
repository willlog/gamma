     <!-- jQuery 2.0.2 -->
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.min.js"></script>
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
                            
                            <?php 
$list = CHtml::listData($dataProvider, 'anio', 'anio');
echo CHtml::dropDownList('like', $dataProvider, $list, array('empty' => 'seleccione un anio')); ?>
                    <div class="row">                    	
                    	<div class="col-md-6">
                           <!-- DONUT CHART -->
                            <div class="box box-danger">
                                <div class="box-header">
                                    <h3 class="box-title">Donut Chart</h3>
                                </div>
                                <div class="box-body chart-responsive">
                                    <div class="chart" id="sales-chart" style="height: 300px; position: relative;"></div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div><!-- /.col (LEFT) -->
                        
                        
                        <div class="col-md-6">
                            
  							<!-- LINE CHART -->
                            <div class="box box-info">
                                <div class="box-header">
                                    <h3 class="box-title">Share por Año</h3>
                                </div>
                                <div class="box-body chart-responsive">
                                    <div class="chart" id="line-chart" style="height: 300px;"></div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->  
                        </div><!-- /.col (RIGHT) -->
                    </div><!-- /.row -->

                            

                        </div><!-- /.col (RIGHT) -->
                    </div><!-- /.row -->

<?php 
$list = CHtml::listData($dataProvider, 'anio', 'anio');
echo CHtml::dropDownList('like1', $dataProvider, $list, array('empty' => 'seleccione un anio')); ?>
						<div class="row">
                        <div class="col-md-10">
                            <!-- BAR CHART -->
                            <div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title">Top 50 Mas compartidos por año</h3>
                                </div>
                                <div class="box-body chart-responsive">
                                    <div class="chart" id="bar-chart1" style="height: 300px;"></div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->       


						<div class="row">
                        <div class="col-md-12">
                            <!-- BAR CHART -->
                            <div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title">Top 50 Menos compartidos por año</h3>
                                </div>
                                <div class="box-body chart-responsive">
                                    <div class="chart" id="bar-chart2" style="height: 300px;"></div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->    

                </section><!-- /.content -->       
   
  <!-- page script -->
        <script type="text/javascript">
            $(function() {           	
               
               $('#like').on('change', function() {              		
               		
               		$.ajax({
	        		type: "post",
	        		url: "/redsocial/share/JSONshareporcategoria/"+this.value,
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
					                         //b[fila]["y"]=response[i]['label'];
					                        // b[fila]["a"] = response[i]['value'];
					                         b[fila]["label"]=response[i]['label'];
					                         b[fila]["value"] = response[i]['value'];

					                         //b[fila]["b"] = response[i+1]['cantidad'];
					                         //b[fila]["count"] = response[i]['cantidad'];
					                        	
					                         fila++;
				                        //}
				                     }		        
			        	
			        	var donut = new Morris.Donut({ 
			        		element: "sales-chart", 
			        		resize: true, 
			        		//colors: [ "#f56954", "#00a65a"], 
			        		data: b, 
			        		hideHover: "auto" });
			        	
	                	//alert(response[0]["name"]);
		                //$.each(response, function(i, item) {
					    //alert(response[i].name);
				//});
			        },
			        error: function (response, status) {
			                alert("Error");
			        },
				});
				              		
               });
               
                $('#like1').on('change', function() {  
               //Cincuenta mas compartidos por año
               
               "use strict";  
                         
               $.ajax({
        		type: "post",
        		url: "/redsocial/share/JSON50mascompartidosporanio/"+this.value,
        		//url: "/like/JSONgrafico",
		        //data: data,
		        dataType: "json",
		        success: function(response, status) {
		        	
		        	
		        	var b = new Array();
                               var fila=0;
			                     for (var i = 0; i < response.length; i++) {
			                                                  
				                         b[fila] = new Array();
				                         b[fila]["y"]=response[i]['article'];
				                         b[fila]["a"] = response[i]['cantidad'];			                         		                         
				                         
				                        	
				                         fila++;
			                        
			                     }
		        	        	
		       //BAR CHART
                var bar = new Morris.Bar({
                    element: 'bar-chart1',
                    resize: true,
                    data: b,
                    //barColors: 'auto',
                    xkey: 'y',
                    ykeys: ['a'],
                    labels: ['SHARE'],
                    xLabelAngle:45,                    
                    hideHover: 'auto'
                });	
                

			
		        },
		        error: function (response, status) {
		                alert("Error!");
		        },
			});
			});

            
            $('#like1').on('change', function() {
            //Cincuenta menos compartidos por año
               
               "use strict";  
                         
               $.ajax({
        		type: "post",
        		url: "/redsocial/share/JSON50menoscompartidosporanio/"+this.value,
        		//url: "/like/JSONgrafico",
		        //data: data,
		        dataType: "json",
		        success: function(response, status) {
		        	
		        	
		        	var b = new Array();
                               var fila=0;
			                     for (var i = 0; i < response.length; i++) {
			                                                  
				                         b[fila] = new Array();
				                         b[fila]["y"]=response[i]['article'];
				                         b[fila]["a"] = response[i]['cantidad'];			                         		                         
				                         
				                        	
				                         fila++;
			                        
			                     }
		        	        	
		       //BAR CHART
                var bar = new Morris.Bar({
                    element: 'bar-chart2',
                    resize: true,
                    data: b,
                    //barColors: 'auto',
                    xkey: 'y',
                    ykeys: ['a'],
                    labels: ['SHARE'],
                    xLabelAngle:45,                    
                    hideHover: 'auto'
                });	
                

			
		        },
		        error: function (response, status) {
		                alert("Error!");
		        },
			});
			});
               
               
               
               $('#like').on('change', function() {
               "use strict";                           
               $.ajax({
        		type: "post",
        		url: "/redsocial/share/JSONshareporcategoriames/"+this.value,
        		//url: "/like/JSONgrafico",
		        //data: data,
		        dataType: "json",
		        success: function(response, status) {
		        	
		        	
		        	var b = new Array();
                               var fila=0;
			                     for (var i = 0; i < response.length; i++) {
			                                                  
				                         b[fila] = new Array();
				                         b[fila]["y"]=response[i]['mes'];
				                         b[fila]["a"] = response[i]['value'];
				                         b[fila]["a"] = response[i]['value'];			                         
				                         
				                        	
				                         fila++;
			                        
			                     }
		        	        	
		       // LINE CHART
                var line = new Morris.Line({
                    element: 'line-chart',
                    resize: true,
                    data: b,
                    xkey: 'y',
                    ykeys: ['a'],
                    labels: ['SHARE'],
                    lineColors: ['#3c8dbc'],
                    hideHover: 'auto'
                });
                

			
		        },
		        error: function (response, status) {
		                alert("Error!");
		        },
			});
			});
               
               
               
               
               
               
               
               
               
               
               
               
               
               "use strict";  
                         
               $.ajax({
        		type: "post",
        		url: "/redsocial/share/JSONshare",
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
				                         b[fila]["y"]=response[i]['anio'];
				                         b[fila]["a"] = response[i]['cantidad'];
				                         b[fila]["b"] = response[i]['cantidad+5'];
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
                    labels: ['SHARE'],
                    xLabelAngle:45,                    
                    hideHover: 'auto'
                });	
		        	
		       /*// LINE CHART
                var line = new Morris.Line({
                    element: 'line-chart',
                    resize: true,
                    parseTime:false,
                    data:  [
    { "y": "enero", "Threshold": "70", "x TV": "0", "x CA": "100", "x Retail": "0", "x Mobility": "100", "x Media": "0" }, 
    { "y": "febrero", "Threshold": "70", "x TV": "100", "x CA": "87.69", "x Retail": "100", "x Mobility": "70", "x Media": "86.67" }, 
    { "y": "marzo", "Threshold": "70", "x TV": "0", "x CA": "87.5", "x Retail": "100", "x Mobility": "93.42", "x Media": "82.14" }, 
    { "y": "abril", "Threshold": "70", "x TV": "0", "x CA": "0", "x Retail": "0", "x Mobility": "0", "x Media": "0" }, 
    { "y": "mayo", "Threshold": "70", "x TV": "0", "x CA": "0", "x Retail": "0", "x Mobility": "0", "x Media": "0" }, 
    { "y": "junio", "Threshold": "70", "x TV": "0", "x CA": "0", "x Retail": "0", "x Mobility": "0", "x Media": "0" }, 
    { "y": "julio", "Threshold": "70", "x TV": "0", "x CA": "0", "x Retail": "0", "x Mobility": "0", "x Media": "0" }]
,        
                     xkey: 'y',
    xLabels: 'day',
    ykeys: ['x TV', 'x CA', 'x Retail', 'x Mobility', 'x Media', 'Threshold'],
    ymax: 100,
    ymin:0,
    labels: ['x TV', 'x CA', 'x Retail', 'x Mobility', 'x Media', 'Threshold'],
                    lineColors: ['#3c8dbc'],
                    hideHover: 'auto'
                });*/
                
                //DONUT CHART
                var donut = new Morris.Donut({
                    element: 'sales-chart',
                    resize: true,
                    //colors: ["#3c8dbc", "#f56954", "#00a65a"],
                    data: [
                        {label: "Download Sales", value: 12},
                        {label: "In-Store Sales", value: 30},
                        {label: "Mail-Order Sales", value: 20}
                    ],
                    hideHover: 'auto'
                });

			//});
		        },
		        error: function (response, status) {
		                alert("Error!");
		        },
			});
               
            });
        </script>

                  
 
            