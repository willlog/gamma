<?php 
class RecuperarPassword extends CFormModel{
	
	public $name;
	public $email;
	public $captcha;
	
	public function rules()
	{
		return array(
			/*array(
				'name, email, captcha',
				'required',
				'message'=>'El campo es requerido',			
				 ),
			array(
				'name',
				'match',
				'pattern'=>'/^[a-z\d_]{4,15}$/i',
				'message'=>'Error, solo letras, números y guiones bajos',
			),	*/
			array(
				'email',
				'email',				
				'message'=>'El formato de email es incorrecto',
			),		 
			array(
				'captcha',
				'captcha',
				'message'=>'Error el código no es válido',
			),			
		);		
	}
	
	public function attributeLabels()
	{
		return array(
			'name'=>'Nombre de usuario',
			'email'=>'Email del usuario',
			'captcha'=>'Código',
			
		);
	}	
}
 ?>