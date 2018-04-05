<?php  

class ValidarRegistro extends CFormModel
{	
	//public $name;
	public $firstname;
	public $lastname;
	public $birthday;
	public $email;
	public $gender;
	public $password;
	public $repetir_password;
	
	public function rules()
	{
		return array(
			array(
				'firstname, lastname, birthday, email, gender, password, repetir_password, gender',
				 'required', 
				'message'=>'Este campo es requerido',
			),
			
			/*array(
				'name',
				'match',
				'pattern'=>'/^[a-z\d_]{4,15}$/i',
				'message'=>'Error, solo letras, números y guiones bajos',
			),*/
			
			array(
				'firstname',
				'match',
				'pattern'=>'/^[a-z\d_]{4,15}$/i',
				'message'=>'Error, solo letras, números y guiones bajos',
			),
			
			array(
				'lastname',
				'match',
				'pattern'=>'/^[a-z\d_]{4,15}$/i',
				'message'=>'Error, solo letras, números y guiones bajos',
			),
			
			array(
				'email',
				'email',				
				'message'=>'El formato de email es incorrecto',
			),
			array(
				'password',
				'match',
				'pattern'=>'/^[a-z0-9]+$/i',
				'message'=>'Solo letras y números',
				),			
			array(
				'repetir_password',
				'compare',
				'compareAttribute'=>'password',  
				'message'=>'Las contraseñas no coincide',
			),
			
			//array('name', 'comprobar_nombre'),
			//array('firstname', 'comprobar_nombre'),
			//array('lastname', 'comprobar_apellido'),
			array('email', 'comprobar_email'),
		);
		
	}
	
	public function comprobar_email($attributes, $params)
	{
		$conexion = Yii::app()->db;
		
		$consulta = "SELECT `user`.`email` FROM `user` WHERE ";
		$consulta.="`user`.`email`='".$this->email."'";
		
		$resultado = $conexion->createCommand($consulta);
		$filas = $resultado->query();
		
		foreach ($filas as $fila) 
		{
			if($this->email===$fila['email'])
			{
				$this->addError('email', 'Email ya esta registrado');
				break;
			}
			
		}
	}
	
	/*public function comprobar_estadocuenta($attributes, $params)
	{
		$conexion = Yii::app()->db;
		
		$consulta = "SELECT `user`.`email` FROM `user` WHERE ";
		$consulta.="`user`.`estadoCuenta`='activa' and `user`.`email`='".$this->email."'";
		
		$resultado = $conexion->createCommand($consulta);
		$filas = $resultado->query();
		
		foreach ($filas as $fila) 
		{
			if($this->email===$fila['email'])
			{
				$this->addError('email', 'Su cuenta aun no esta activada');
				break;
			}
			
		}
	}*/
	
	public function comprobar_nombre($attributes, $params)
	{
		$conexion = Yii::app()->db;
		
		$consulta = "SELECT `user`.`name` FROM `user` WHERE ";
		$consulta.="`user`.`name`='".$this->name."'";
		
		$resultado = $conexion->createCommand($consulta);
		$filas = $resultado->query();
		
		foreach ($filas as $fila) 
		{
			if($this->name===$fila['name'])
			{
				$this->addError('name', 'Ya existe este usuario');
				break;
			}
			
		}
	}
	
}

?>