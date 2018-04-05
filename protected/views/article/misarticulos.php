<h1>Mis Articulos</h1>
<?php echo CHtml::link("Crear artículo", array("create")) ?>
<?php foreach($article as $data):?>
	<h3><?php echo $data->title?> </h3> 
	<?php echo $data->id ?> 
	<?php echo CHtml::link("Actualizar", array("update", "id"=>$data->id)); ?> |
	<?php echo CHtml::link("Eliminar", array("delete", "id"=>$data->id, "uid"=>$data->uid), array("confirm"=>"Esta seguro que desea borrar?")); ?>|
	<?php echo CHtml::link("Ver", array("view", "id"=>$data->id, "uid"=>$data->uid)); ?>
<?php endforeach  ?>