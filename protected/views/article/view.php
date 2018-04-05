<?php $this->widget('zii.widgets.CDetailView', array(
	'htmlOptions'=> array('class' =>'table table-bordered'),
	'data'=>$model,
	'attributes'=>array(
		array('name'=>'Imagen','type'=>'raw',  'value'=>CHtml::image("https://sigma.uta.edu.ec/ares/".$model->image,'alt', array('width'=>'300px', 'height'=>'100px'))),
		//'id',
		//'uid',
		'title',
		'description',
		array('name'=>'Url','type'=>'raw',  'value'=>CHtml::link($model->url, $model->url, array('target'=>'_blank'))),		
		//'reading',
		//'state',
		//'kind',
		//'creator',
		array('name'=>'Creado', 'header'=>'Date', 'value'=>Yii::app()->dateFormatter->format("d MMM y HH:mm", strtotime($model->createdAt))),
		array('name'=>'Actualizado', 'header'=>'Date', 'value'=>Yii::app()->dateFormatter->format("d MMM y HH:mm", strtotime($model->updatedAt))),
		//'createdAt',
		//'updatedAt',
	),
)); ?>

<h2>Estadísticas</h2>
<table class="table table-bordered">
	<thead>
		<th>Acción</th>
		<th>Cantidad</th>
	</thead>
		
	<tbody>
		<?php foreach ($datos as $key => $value) { ?>
			<tr>
				<td><?php echo $value['accion'] ?></td>
				<td><?php echo $value['cantidad']; ?></td>
			</tr>
		<?php } ?>
		
		
	</tbody>
</table>