<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/sello.png" type="image/x-icon" />
        <title><?php echo $this->pageTitle;?>
        </title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="<?php echo Yii::app()->theme->baseUrl;?>/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="<?php echo Yii::app()->theme->baseUrl;?>/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="<?php echo Yii::app()->theme->baseUrl;?>/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Morris chart -->
        <link href="<?php echo Yii::app()->theme->baseUrl;?>/css/morris/morris.css" rel="stylesheet" type="text/css" />
        <!-- jvectormap -->
        <link href="<?php echo Yii::app()->theme->baseUrl;?>/css/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
        <!-- fullCalendar -->
        <link href="<?php echo Yii::app()->theme->baseUrl;?>/css/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css" />
        <!-- Daterange picker -->
        <link href="<?php echo Yii::app()->theme->baseUrl;?>/css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
        <!-- bootstrap wysihtml5 - text editor -->
        <link href="<?php echo Yii::app()->theme->baseUrl;?>/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?php echo Yii::app()->theme->baseUrl;?>/css/AdminLTE.css" rel="stylesheet" type="text/css" />
        
        <!-- blueprint CSS framework -->
	<!--<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print">-->	
	
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection">
	<![endif]-->

	<!--<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css">-->

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                GAMMA
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <!-- Messages: style can be found in dropdown.less-->
                        <li class="dropdown messages-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-envelope"></i>
                                <span class="label label-success"><?php echo Yii::app()->user->getState('mensajes'); ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">Tienes <?php echo Yii::app()->user->getState('mensajes'); ?> mensajes</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                    	<?php
                                    	/*$dataMensaje = array(Yii::app()->user->getState('datamensajes'));
										//print_r($dataMensaje);
										foreach ($dataMensaje as $key => $value)
											{
												//print_r($value);
												foreach ($value as $key1 => $value1)
												{*/ ?> 
										  
                                        <li><!-- start message -->
                                            <a id ="<?php /*echo $value1['id'];*/?>" href="https://soman.uta.edu.ec/gamma/user/vermensaje/<?php /*echo $value1['id'];*/?>">
                                                <div class="pull-left">
                                                    <!--<img src="img/avatar3.png" class="img-circle" alt="User Image"/>-->
                                                    <?php /*echo CHtml::image($value1['image'],'alt',array('width'=>50,'height'=>50, 'class'=> "img-circle" , 'alt'=>"User Image"));*/?>
                                                </div>
                                                <h4>
                                                    <?php /*echo $value1['name'];*/ ?>
                                                    <small><i class="fa fa-clock-o"></i> <?php /*echo $value1['datesend'];*/ ?></small>
                                                </h4>
                                                <p><?php /*echo $value1['subject'];*/ ?></p>
                                            </a>
                                        </li><!-- end message -->                 
                                         <?php /*}}*/ ?>                       
                                    </ul>
                                </li>
                                <li class="footer"><a href="https://soman.uta.edu.ec/gamma/user/Indexmensajes">Ver todos los mensajes</a></li>
                            </ul>
                        </li>
                        
                        <!-- Notifications: style can be found in dropdown.less -->
                        <li class="dropdown messages-menu" >
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-warning"></i>
                                <span class="label label-warning"><?php print_r( Yii::app()->user->getState('numero')); ?></span>
                            </a>
                            <ul class="dropdown-menu" width="50%">
                                <li class="header">Tienes  <?php print_r( Yii::app()->user->getState('numero')); ?> notificaciones</li> 
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">                         	                                     	                                     	 
                                    	 <?php
                                    	 //echo Yii::app()->user->getNotifications();
                                    	 //print_r(Yii::app()->user->getState('data'));	
										 $dataProvider = array(Yii::app()->user->getState('data'));									 
                                    	 //$equipo = array('creado'=>'30', 'deshabilitado'=>'10', 'medio'=>'Lampard', 'delantero'=>'Torres');
										 //print_r("     ");
										 //print_r($equipo);
 
										//foreach($equipo as $posicion=>$jugador)
										if(Yii::app()->user->getState('numero')>0){					
										
										
										foreach ($dataProvider as $key => $value)
										{
											//print_r($value);
											foreach ($value as $key1 => $value1)
										{?>                                       
	                                   <li><!-- start message -->
	                                        <a id ="<?php echo $value1['idNotificacion'];?>" href="http://soman.uta.edu.ec/gamma/user/vernotificacion/<?php echo $value1['idNotificacion'];?>">
	                                            <div class="pull-left">
	                                                <!--<img src="img/avatar3.png" class="img-circle" alt="User Image"/>-->
	                                                <i class="fa fa-warning" bgcolor="black"></i> 
	                                            </div>
	                                            <h4>
	                                                <?php echo $value1['action']; ?>
	                                                <small><i class="fa fa-clock-o"></i> <?php echo $value1['fechaHora']; ?></small>
	                                            </h4>
	                                            <p><?php echo $value1['texto']; ?></p>
	                                        </a>
                                        </li><!-- end message -->                           
                                                                                 
                                        <?php }}} ?>                                                                             
                                    </ul>
                                </li>
                                <li class="footer"><a href="https://soman.uta.edu.ec/gamma/user/Indexnotificaciones" >Ver todas</a></li>
                            </ul>
                        </li>
                        <!-- Tasks: style can be found in dropdown.less -->
                       
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo Yii::app()->user->getName(); ?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                    <?php echo CHtml::image(Yii::app()->user->getState('foto'),'alt',array('width'=>50,'height'=>50, 'class'=> "img-circle" , 'alt'=>"User Image"));?>
                                    <p>
                                        <?php echo Yii::app()->user->getName(); ?> - Usuario
                                        <small>Member since Nov. 2012</small>
                                    </p>
                                </li>
                                <!-- Menu Body -->
                                <li class="user-body">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Followers</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Sales</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Friends</a>
                                    </div>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <?php echo CHtml::link('Mi Cuenta',array('/user/indexconfig'),array('class'=>'btn btn-default btn-flat')); ?>
                                    </div>
                                    <div class="pull-right">
                                        <?php echo CHtml::link('Cerrar',array('/site/logout'),array('class'=>'btn btn-default btn-flat')); ?>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <?php echo CHtml::image(Yii::app()->user->getState('foto'),'alt',array('width'=>50,'height'=>50, 'class'=> "img-circle" , 'alt'=>"User Image"));?>
                        </div>
                        <div class="pull-left info">
                            <p>Bienvenido, <?php echo Yii::app()->user->getName(); ?></p>

                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                    <!-- search form -->
                    <form action="#" method="get" class="sidebar-form">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Search..."/>
                            <span class="input-group-btn">
                                <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                    <!-- /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <?php if (Yii::app()->user->checkAccess('admin'))
					{
						$this->widget('zii.widgets.CMenu',array(
                        'htmlOptions'=> array('class' =>'sidebar-menu','id'=>'mnuPrueba'),
                        'submenuHtmlOptions' => array('class' => 'treeview-menu'),
                        'encodeLabel' => false,
                        'items'=>array(
                           /* array(  'label'=>'<i class="fa fa-hand-o-up"></i>Home', 
                                    'url'=>array('/site/index'),
                                    'itemOptions'=>array('class' => 'active')
                                ),*/
                            array('label'=>'<i class="fa fa-envelope-o"></i> Mensaje', 'url'=>array('/user/nuevomensaje')),	
                            array(  'label'=>'<i class="fa fa-gears"></i> <span>Administración</span><i class="fa pull-right fa-angle-down"></i>', 
                                    'url'=>array(''),
                                    'itemOptions'=>array('class' => 'treeview'),
                                    'items'=>array(
                                            //array('label'=>'<i class="fa fa-angle-double-right"></i> Grupos', 'url'=>array('/authitem/index')),
                                            array('label'=>'<i class="fa fa-angle-double-right"></i> Usuarios', 'url'=>array('/user/index')),
											array('label'=>'<i class="fa fa-angle-double-right"></i> Notificaciones', 'url'=>array('/user/confignotificaciones'))
                                        )
                                ),

                            array(  'label'=>'<i class="fa fa-fw fa-pencil-square-o"></i> <span>Aplicación</span><i class="fa pull-right fa-angle-down"></i>', 
                                    'url'=>array(''),
                                    'itemOptions'=>array('class' => 'treeview'),
                                    'items'=>array(
                                            array('label'=>'<i class="fa fa-angle-double-right"></i> Categorías', 'url'=>array('/category/index')),                                            
                                            array('label'=>'<i class="fa fa-angle-double-right"></i> Mis Recursos', 'url'=>array('/article/index')),
                                            array('label'=>'<i class="fa fa-angle-double-right"></i> Todos Recursos', 'url'=>array('/article/indexgeneral')),                                                                                        
                                        )
                                ),          
								                                
								array(  'label'=>'<i class="fa fa-fw fa-bar-chart-o"></i> <span>Mis Estadísticas</span><i class="fa pull-right fa-angle-down"></i>', 
                                    'url'=>array(''),
                                    'itemOptions'=>array('class' => 'treeview'),
                                    'items'=>array(
                                    		array('label'=>'<i class="fa fa-angle-double-right"></i> Historial', 'url'=>array('/user/mihistorial')),
                                    		array('label'=>'<i class="fa fa-angle-double-right"></i> Recursos Educativos', 'url'=>array('/article/indexmisoa')),
                                            array('label'=>'<i class="fa fa-angle-double-right"></i> Compartidos', 'url'=>array('/share/index')),
                                            array('label'=>'<i class="fa fa-angle-double-right"></i> Visitas', 'url'=>array('/visit/index')),
                                            array('label'=>'<i class="fa fa-angle-double-right"></i> Gustados', 'url'=>array('/like/index')),                                            
                                        )
                                ),
                                
								array(  'label'=>'<i class="fa fa-fw fa-signal"></i> <span>Estadísticas Generales</span><i class="fa pull-right fa-angle-down"></i>', 
                                    'url'=>array(''),
                                    'itemOptions'=>array('class' => 'treeview'),
                                    'items'=>array(
                                    		array('label'=>'<i class="fa fa-angle-double-right"></i> Autores', 'url'=>array('/user/indextodosautores')),
                                    		array('label'=>'<i class="fa fa-angle-double-right"></i> Recursos Educativos', 'url'=>array('/article/indextodosoa')),
                                    		array('label'=>'<i class="fa fa-angle-double-right"></i> Categorías', 'url'=>array('/category/todascategoria')),
                                    		//array('label'=>'<i class="fa fa-angle-double-right"></i> Recomendados', 'url'=>array('/share/indexgeneral')),
                                            array('label'=>'<i class="fa fa-angle-double-right"></i> Compartidos', 'url'=>array('/share/indexgeneral')),
                                            array('label'=>'<i class="fa fa-angle-double-right"></i> Visitas', 'url'=>array('/visit/indexgeneral')),
                                            array('label'=>'<i class="fa fa-angle-double-right"></i> Gustados', 'url'=>array('/like/indexgeneral')),                                            
                                        )
                                ),
                            
                            array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
                            array('label'=>'<i class="fa fa-fw fa-reply"></i> Salir ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)),                                                        
                    )); 					  
	                    
					}?>
					<?php if (Yii::app()->user->checkAccess('user'))
					{
						$this->widget('zii.widgets.CMenu',array(
                        'htmlOptions'=> array('class' =>'sidebar-menu','id'=>'mnuPrueba'),
                        'submenuHtmlOptions' => array('class' => 'treeview-menu'),
                        'encodeLabel' => false,
                        'items'=>array(                        	
                        	array('label'=>'<i class="fa fa-fw fa-user"></i> Mi Cuenta', 'url'=>array('/user/indexconfig')),
                        	array('label'=>'<i class="fa fa-envelope-o"></i> Mensaje', 'url'=>array('/user/nuevomensaje')),
                        	//array('label'=>'<i class="fa fa-warning"></i> Personalizar Notificaciones', 'url'=>array('/user/confignotificacionesusuario')),          
                            

                            array(  'label'=>'<i class="fa fa-fw fa-pencil-square-o"></i> <span>Aplicación</span><i class="fa pull-right fa-angle-down"></i>', 
                                    'url'=>array(''),
                                    'itemOptions'=>array('class' => 'treeview'),
                                    'items'=>array(                                            
                                            array('label'=>'<i class="fa fa-angle-double-right"></i> Mis Recursos', 'url'=>array('/article/index')),
                                            //array('label'=>'<i class="fa fa-angle-double-right"></i> Todos Recursos', 'url'=>array('/article/indexgeneral')),
                                            array('label'=>'<i class="fa fa-angle-double-right"></i> Notificaciones', 'url'=>array('/user/confignotificacionesusuario')),                                            
                                        )
                                ), 
                                                       
								array(  'label'=>'<i class="fa fa-fw fa-bar-chart-o"></i> <span>Mis Estadísticas</span><i class="fa pull-right fa-angle-down"></i>', 
                                    'url'=>array(''),
                                    'itemOptions'=>array('class' => 'treeview'),
                                    'items'=>array(      
                                    		array('label'=>'<i class="fa fa-angle-double-right"></i> Historial', 'url'=>array('/user/mihistorial')),
                                    		array('label'=>'<i class="fa fa-angle-double-right"></i> Recursos Educativos', 'url'=>array('/article/indexmisoa')),                              		
                                            array('label'=>'<i class="fa fa-angle-double-right"></i> Compartidos', 'url'=>array('/share/index')),
                                            array('label'=>'<i class="fa fa-angle-double-right"></i> Visitas', 'url'=>array('/visit/index')),
                                            array('label'=>'<i class="fa fa-angle-double-right"></i> Gustados', 'url'=>array('/like/index')),                                            
                                        )
                                ),
                                
								array(  'label'=>'<i class="fa fa-fw fa-signal"></i> <span>Estadísticas Generales</span><i class="fa pull-right fa-angle-down"></i>', 
                                    'url'=>array(''),
                                    'itemOptions'=>array('class' => 'treeview'),
                                    'items'=>array(
                                    		array('label'=>'<i class="fa fa-angle-double-right"></i> Autores', 'url'=>array('/user/indextodosautores')),
                                    		array('label'=>'<i class="fa fa-angle-double-right"></i> Recursos Educativos', 'url'=>array('/article/indextodosoa')),
                                    		array('label'=>'<i class="fa fa-angle-double-right"></i> Categorías', 'url'=>array('/category/todascategoria')),
                                    		//array('label'=>'<i class="fa fa-angle-double-right"></i> Recomendados', 'url'=>array('/share/indexgeneral')),
                                            array('label'=>'<i class="fa fa-angle-double-right"></i> Compartidos', 'url'=>array('/share/indexgeneral')),
                                            array('label'=>'<i class="fa fa-angle-double-right"></i> Visitas', 'url'=>array('/visit/indexgeneral')),
                                            array('label'=>'<i class="fa fa-angle-double-right"></i> Gustados', 'url'=>array('/like/indexgeneral')),                                            
                                        )
                                ),       
                            
                            array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
                            array('label'=>'<i class="fa fa-fw fa-reply"></i> Salir ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)),                            
                    )); 												
					}?> 
                   <!-- <ul class="sidebar-menu">
                        <li class="active">
                            <a href="index.html">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="pages/widgets.html">
                                <i class="fa fa-th"></i> <span>Widgets</span> <small class="badge pull-right bg-green">new</small>
                            </a>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-bar-chart-o"></i>
                                <span>Charts</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="pages/charts/morris.html"><i class="fa fa-angle-double-right"></i> Morris</a></li>
                                <li><a href="pages/charts/flot.html"><i class="fa fa-angle-double-right"></i> Flot</a></li>
                                <li><a href="pages/charts/inline.html"><i class="fa fa-angle-double-right"></i> Inline charts</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-laptop"></i>
                                <span>UI Elements</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="pages/UI/general.html"><i class="fa fa-angle-double-right"></i> General</a></li>
                                <li><a href="pages/UI/icons.html"><i class="fa fa-angle-double-right"></i> Icons</a></li>
                                <li><a href="pages/UI/buttons.html"><i class="fa fa-angle-double-right"></i> Buttons</a></li>
                                <li><a href="pages/UI/sliders.html"><i class="fa fa-angle-double-right"></i> Sliders</a></li>
                                <li><a href="pages/UI/timeline.html"><i class="fa fa-angle-double-right"></i> Timeline</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-edit"></i> <span>Forms</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="pages/forms/general.html"><i class="fa fa-angle-double-right"></i> General Elements</a></li>
                                <li><a href="pages/forms/advanced.html"><i class="fa fa-angle-double-right"></i> Advanced Elements</a></li>
                                <li><a href="pages/forms/editors.html"><i class="fa fa-angle-double-right"></i> Editors</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-table"></i> <span>Tables</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="pages/tables/simple.html"><i class="fa fa-angle-double-right"></i> Simple tables</a></li>
                                <li><a href="pages/tables/data.html"><i class="fa fa-angle-double-right"></i> Data tables</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="pages/calendar.html">
                                <i class="fa fa-calendar"></i> <span>Calendar</span>
                                <small class="badge pull-right bg-red">3</small>
                            </a>
                        </li>
                        <li>
                            <a href="pages/mailbox.html">
                                <i class="fa fa-envelope"></i> <span>Mailbox</span>
                                <small class="badge pull-right bg-yellow">12</small>
                            </a>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-folder"></i> <span>Examples</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="pages/examples/invoice.html"><i class="fa fa-angle-double-right"></i> Invoice</a></li>
                                <li><a href="pages/examples/login.html"><i class="fa fa-angle-double-right"></i> Login</a></li>
                                <li><a href="pages/examples/register.html"><i class="fa fa-angle-double-right"></i> Register</a></li>
                                <li><a href="pages/examples/lockscreen.html"><i class="fa fa-angle-double-right"></i> Lockscreen</a></li>
                                <li><a href="pages/examples/404.html"><i class="fa fa-angle-double-right"></i> 404 Error</a></li>
                                <li><a href="pages/examples/500.html"><i class="fa fa-angle-double-right"></i> 500 Error</a></li>
                                <li><a href="pages/examples/blank.html"><i class="fa fa-angle-double-right"></i> Blank Page</a></li>
                            </ul>
                        </li>
                   </ul>-->
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                       
                        <small></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Dashboard</li>
                    </ol>
                </section>

               <?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

                    <?php echo $content;  ?>
                
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!-- add new calendar event modal -->


        <!-- jQuery 2.0.2 -->
        <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>-->
        <script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.min.js"></script>
        <!-- jQuery UI 1.10.3 -->
        <script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
        <!-- Bootstrap -->
        <script src="<?php echo Yii::app()->theme->baseUrl;?>/js/bootstrap.min.js" type="text/javascript"></script>
        <!-- Morris.js charts -->
        <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl;?>/js/raphael-min.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/morris/morris.min.js" type="text/javascript"></script>
        <!-- Sparkline -->
        <script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
        <!-- jvectormap -->
        <script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
        <!-- fullCalendar -->
        <script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
        <!-- jQuery Knob Chart -->
        <script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/jqueryKnob/jquery.knob.js" type="text/javascript"></script>
        <!-- daterangepicker -->
        <script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
        <!-- iCheck -->
        <script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>

        <!-- AdminLTE App -->
        <script src="<?php echo Yii::app()->theme->baseUrl;?>/js/AdminLTE/app.js" type="text/javascript"></script>
        
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="<?php echo Yii::app()->theme->baseUrl;?>/js/AdminLTE/dashboard.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl;?>/js/main.js"></script>        

    </body>
</html>
