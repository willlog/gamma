<?php 

class ConsultasDB
{
	public $codigo_verificacion;
	public $createdate;
	
	public function guardar_usuario($name, $gender, $firstname, $lastname, $fechaNac, $email, $password)
	{
		$conexion = Yii::app()->db;
		$id='';
		//$createdate=Yii::app()->Date->now();
		//echo $createdate;
		$uidd = rand(0, 99999);
		$codigo_verificacion=sha1(rand(10000, 99999));
		
		$password=sha1($password);
		$fecha = new CDbExpression('NOW()');
		
		$consulta = "INSERT INTO `user` (`provider`, `uid`, `name`, `birthday`, `gender`, `email`, `firstname`, `lastname`, `profileUrl`, `password`, `createdAt`, `updatedAt`, `estadoCuenta`)";
		$consulta.=" VALUES('aplicacion','$uidd','$name', '$fechaNac', '$gender', '$email', '$firstname', '$lastname', 'ninguna', '$password',$fecha,NULL,'solicitada')";
		
		$resultado = $conexion->createCommand($consulta)->execute();
		
		$consulta = "Select id FROM user WHERE name='".$name."' AND email='".$email."'";
		$resultado=$conexion->createCommand($consulta)->query();
		
		$resultado->bindColumn(1, $id);
		
		while($resultado->read()!==false)
		{
			$id=$id;
		} 
		
		Yii::app()->authManager->assign('user', $id);
		
		/*$consulta = "INSERT INTO authassignment (itemname, userid, bizrule, data)";
		$consulta.=" VALUES('user','$id',NULL, NULL)";			
		$resultado=$conexion->createCommand($consulta)->execute();*/	
	}
	
	public function aignar_rol($id, $name)
	{
		$conexion = Yii::app()->db;
		//$createdate=Yii::app()->Date->now();
		//echo $createdate;
		
		//$codigo_verificacion=sha1(rand(10000, 99999));
		
		$consulta = "INSERT INTO `authassignment` (`itemname`, `userid`, `bizrule`, `data`)";
		$consulta.=" VALUES('aplicacion','1801','$name', '$gender', '$email', '$firstname', '$lastname', 'ninguna', '$password',NULL,NULL,'solicitada')";
		
		$resultado = $conexion->createCommand($consulta)->execute();
		
	}
	
}
 ?>