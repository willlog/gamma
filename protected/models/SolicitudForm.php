<?php
class SolicitudForm extends CFormModel
{
	//Necesarias para login facebook
	private $id;
	private $nombre;
	private $apellido;
	private $fechaNacimiento;
	private $email;
	private $estado;
	
	public function attributeLabels()
	{
		return array(
			'id'=>'ID',
			'nombre'=>'Nombre',
			'apellido'=>'Apellido',			
			'fechaNacimiento'=>'Fecha Nacimiento',
			'email'=>'Email',
			'estado'=>'Estado Cuenta'
		);
	}
}