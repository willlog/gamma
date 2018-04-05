<?php
/* @var $this CategoryController */
/* @var $model Category */

$this->breadcrumbs=array(
	'Articles'=>array('index'),
	'Create',
);
?>
<?php $this->renderPartial('_form', array('model'=>$model,'data'=>$data,'msg'=>$msg)); ?>
