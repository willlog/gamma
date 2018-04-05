<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.min.js"></script>
<?php $this->widget('zii.widgets.CDetailView', array(
	'htmlOptions'=> array('class' =>'table table-bordered'),
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'description',
		'createdAt',
		'updatedAt',
	),
)); ?>

<?php echo "Cantidad de Artículos Creados por Año"; ?>
<br>
<table class="table table-bordered">
	                <tr>
	                    
	                    <th>Año</th>
	                    <th>Cantidad</th>
	                </tr>
	                <?php foreach ($datos as $key => $value) { ?>
					<tr>
	                    <td><?php echo $value['anio']; ?></td>
	                    <td><?php echo $value['cantidad']; ?></td>	                    
	                    
	                </tr>
							
					<?php } ?>	                
	                
	            </table>




