<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;
	private $_usern;
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$user=User::model()->find("LOWER(email)=?",array(strtolower($this->username)));
		
		if($user===null)
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		elseif(sha1($this->password)!==$user->password)
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		//Controlar que la cuenta este activa
		//elseif($user->estadoCuenta!='activa')
			//$this->errorCode=self::ERROR_PASSWORD_INVALID;
		elseif($user->status!='editor')
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
		{
			$this->_id=$user->id;
			$this->_usern=$user->name;
			
			$this->setState('foto', $user->image);
			$this->getNotifications($user->id);	
			$this->errorCode=self::ERROR_NONE;
		}
		return !$this->errorCode;
	}
	
	public function authenticatefacebook($id)
	{
		$user=User::model()->find("LOWER(email)=?",array(strtolower($id)));
		
		if($user===null)
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		else 
		{
			$this->_id=$user->id;
			$this->_usern=$user->name;
			$this->setState('foto', $user->image);
			$this->getNotifications($user->id);	
			$this->errorCode=self::ERROR_NONE;
		}
		
		return !$this->errorCode;
	}
		
	public function getId(){
		return $this->_id;
	}
	
	public function getName(){
		return $this->_usern;
	}


	public function getNotifications($userid)
	{
		//CODIGO PARA INSERTAR LAS NOTIFICACIONES
			
		//Cuando sobre un recurso no se realizan acciones sociales en un determinado tiempo
		$sqlRecursos = "Select id From article Where article.creator=".$userid.""; 			
		$dbCommand = Yii::app()->db->createCommand($sqlRecursos);			
		$recusosid = $dbCommand->queryAll();
		
		//Consultar si sobre los recursos no se han realizado acciones sociales
		//1. Consultar todos los recursos del usuario.
		$sqlArticulos = "Select article.id, article.title, 3650 as sharedias, 3650 as visitdias, 3650 as likedias
						From article
						Where article.creator=".$userid."";
						
		$dbCommand = Yii::app()->db->createCommand($sqlArticulos);
		$dataRecursos = $dbCommand->queryAll();
		
		//2. Consultar dias del últimos share
		$sqlShare = "Select article.id, article.title, DATEDIFF(NOW(), max(share.createdAt)) as sharedias
						From article, share
						where article.id = share.article and  article.creator=".$userid."
						GROUP BY article.id";
		$dbCommand = Yii::app()->db->createCommand($sqlShare);
		$dataShare = $dbCommand->queryAll();
						
		//3. Consultar días del último visit
		$sqlVisit = "Select article.id, article.title, DATEDIFF(NOW(), max(visit.createdAt)) as visitdias
						From article, visit
						where article.id = visit.article and  article.creator=".$userid."
						GROUP BY article.id";
		$dbCommand = Yii::app()->db->createCommand($sqlVisit);
		$dataVisit = $dbCommand->queryAll();
						
		//4. Consultar días del último like
		$sqlLike = "Select article.id, article.title, DATEDIFF(NOW(), max(`like`.createdAt)) as likedias
						From article, `like`
						where article.id = `like`.article and  article.creator=".$userid."
						GROUP BY article.id";
		$dbCommand = Yii::app()->db->createCommand($sqlLike);
		$dataLike = $dbCommand->queryAll();
						
		
		foreach ($dataRecursos as $key => $value)
		{
			foreach ($dataShare as $key1 => $value1) 
			{				
				if ($value['id']===$value1['id']) 
				{
					$dataRecursos[$key]['sharedias']=$value1['sharedias'];
				}							
			}										
		}
		
		foreach ($dataRecursos as $key => $value)
		{
			foreach ($dataVisit as $key1 => $value1) 
			{				
				if ($value['id']===$value1['id']) 
				{
					$dataRecursos[$key]['visitdias']=$value1['visitdias'];
				}							
			}										
		}
		
		foreach ($dataRecursos as $key => $value)
		{
			foreach ($dataLike as $key1 => $value1) 
			{				
				if ($value['id']===$value1['id']) 
				{
					$dataRecursos[$key]['likedias']=$value1['likedias'];
				}							
			}										
		}
		
		//Ver si existe el parámetro de comparación (Caso contrario insertarlo)
		$sql = "Select count(*) from tipo_notificacion_usuario where action='noacciones' and userid=".$userid."";	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$existe = $dbCommand->queryScalar();		
		
		if($existe==='0')
		{
			$sql = "Select texto from tipo_notificacion where action='noacciones'";
			$dbCommand = Yii::app()->db->createCommand($sql);
			$Texto =$dbCommand->queryScalar();
			
			$sql = "Select valor from tipo_notificacion where action='noacciones'";
			$dbCommand = Yii::app()->db->createCommand($sql);
			$Valor =$dbCommand->queryScalar();
			
			$conexion1 = Yii::app()->db;
			
			$consulta = "INSERT INTO tipo_notificacion_usuario(`userid`,`texto`, `valor`, `action`)";
			$consulta.=" VALUES($userid, '$Texto', $Valor, 'noacciones')";					
						
			$resultado = $conexion1->createCommand($consulta)->execute();				
		}		
		
		//Consultar el valor de comparación
		$sql = "Select valor from tipo_notificacion_usuario where action='noacciones' and userid=".$userid."";	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$noacciones = $dbCommand->queryScalar();	
		
		$fecha = new CDbExpression('NOW()');
		$conexion = Yii::app()->db;		
		
		foreach ($dataRecursos as $key => $value)
		{
			if($value['sharedias']>$noacciones and $value['visitdias']>$noacciones and $value['likedias']>$noacciones)
			{
				$articleid = $value['id'];
				$mensaje = utf8_encode(substr(utf8_decode($value['title']), 0, 20)." ... sin utilizar hace mas de ".$noacciones." días");
				
				$sql = "Select count(*) from notificaciones where action='noacciones' and articleid=".$articleid."";
				$dbCommand = Yii::app()->db->createCommand($sql);
				$existe = $dbCommand->queryScalar();
				
				if($existe==='0')
				{				
					//Insertar las notificaciones (No se ha realizado acciones sociales sobre los recursos)
					$consulta = "INSERT INTO `notificaciones`(`texto`, `userid`, `articleid`, `action`, `estado`, `fechaHora`)";
					$consulta.=" VALUES('$mensaje', $userid, $articleid, 'noacciones', 'enviado', $fecha)";
				
					$resultado = $conexion->createCommand($consulta)->execute();
				}									 
			}
		}
					
		//Código para ver(insertar) la notificación con el número de dias que el usuario no publica.		
		//Códido para ver el número de días que no publican el usuario
		$sqlCount = "Select count(*) 
					from article
					Where article.creator='".$userid."'";
		$dbCommand = Yii::app()->db->createCommand($sqlCount);
		$numarticulo = $dbCommand->queryScalar();
		
		if($numarticulo>0)
		{		
			$sqlNopublicas = "select DATEDIFF(NOW(), max(article.createdAt)) 
								from article
								Where article.creator='".$userid."'";					
			$dbCommand = Yii::app()->db->createCommand($sqlNopublicas);
			$diasnopublicas = $dbCommand->queryScalar();
		}
		else 
		{
			$diasnopublicas=3650;
		}
		
		//Ver si existe el parámetro de comparación (Caso contrario insertarlo)
		$sql = "Select count(*) from tipo_notificacion_usuario where action='nopublicas' and userid=".$userid."";	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$existe = $dbCommand->queryScalar();		
		
		if($existe==='0')
		{
			$sql = "Select texto from tipo_notificacion where action='nopublicas'";
			$dbCommand = Yii::app()->db->createCommand($sql);
			$Texto =$dbCommand->queryScalar();
			
			$sql = "Select valor from tipo_notificacion where action='nopublicas'";
			$dbCommand = Yii::app()->db->createCommand($sql);
			$Valor =$dbCommand->queryScalar();
			
			$conexion1 = Yii::app()->db;
			
			$consulta = "INSERT INTO tipo_notificacion_usuario(`userid`,`texto`, `valor`, `action`)";
			$consulta.=" VALUES($userid, '$Texto', $Valor, 'nopublicas')";					
						
			$resultado = $conexion1->createCommand($consulta)->execute();				
		}
		
		//Consultar el valor de comparación	
		$sql = "Select valor from tipo_notificacion_usuario where action='nopublicas' and userid=".$userid."";	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$nopublicas = $dbCommand->queryScalar();
		
		if($diasnopublicas>$nopublicas)
		{
			$sqlExiste = "Select count(*) from `notificaciones` where userid=".$userid."
						  and action='nopublicas'";
			$dbCommand = Yii::app()->db->createCommand($sqlExiste);
			$existe = $dbCommand->queryScalar();
			
			$fecha = new CDbExpression('NOW()');
			$conexion = Yii::app()->db;	
			
			if($diasnopublicas==3650)
			{
				$mensaje = utf8_encode('Usted no ha publicado ningún artículo hasta el momento');
			}
			else 
			{
				$mensaje = utf8_encode('Usted no ha publicado hace mas de '.$nopublicas.' días');	
			}		
			
			if($existe<1)
			{
				//Insertar el registro
				$consulta = "INSERT INTO `notificaciones`(`texto`, `userid`, `action`, `estado`, `fechaHora`)";
				$consulta.=" VALUES('$mensaje', $userid, 'nopublicas', 'enviado', $fecha)";
				
				$resultado = $conexion->createCommand($consulta)->execute();
			}				
		}
		//$this->setState('tunopublicas', $dataNopublicas);
		
		//Código para ver(insertar) la notificación con el número de dias que nadie publica
		//Códido para ver el número de días que no publican
		$sqlNopublican = "select DATEDIFF(NOW(), max(article.createdAt)) 
						  from article";
		$dbCommand = Yii::app()->db->createCommand($sqlNopublican);
		$diasnopublican = $dbCommand->queryScalar();
		
		$sql = "Select valor from tipo_notificacion where action='nopublican'";	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$nopublican = $dbCommand->queryScalar();
		
		if($diasnopublican>$nopublican)
		{
			$sqladminids = "SELECT userid FROM `AuthAssignment` Where itemname='admin'";
			$dbCommand = Yii::app()->db->createCommand($sqladminids);
			$dataAdmin = $dbCommand->queryAll(); 
			
			$fecha = new CDbExpression('NOW()');
			$conexion = Yii::app()->db;						
			
			foreach ($dataAdmin as $key => $value)
			{
				$id = $value['userid'];
				$mensaje = utf8_encode("Ningun usuario ha publicado en ".$nopublican." días");
				
				$sqlExiste = "Select count(*) from `notificaciones` where userid=".$id."
							and action='nopublican'"; 
				$dbCommand = Yii::app()->db->createCommand($sqlExiste);
				$existe = $dbCommand->queryScalar();
				
				if($existe<1)
				{
					//Insertar el registro
					$consulta = "INSERT INTO `notificaciones`(`texto`, `userid`, `action`, `estado`, `fechaHora`)";
					$consulta.=" VALUES('$mensaje', $id, 'nopublican', 'enviado', $fecha)";
					
					$resultado = $conexion->createCommand($consulta)->execute();				
				}					
			}								
		}
		//$this->setState('nopublican', $dataNopublican);
		
		
		//Código para ver(insertar) los recursos del usuario que sobrepasaron una catidad de compartidos				
		$slqSobrepasashare = "select article.id, article.title, count(share.id) as shares 
							from share, article 
							where share.article = article.id and article.creator = ".$userid."								 
							Group By article.id";
		$dbCommand = Yii::app()->db->createCommand($slqSobrepasashare);
		$dataSobrepasashare = $dbCommand->queryAll();
		
		//Ver si existe el parámetro de comparación (Caso contrario insertarlo)
		$sql = "Select count(*) from tipo_notificacion_usuario where action='shares' and userid=".$userid."";	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$existe = $dbCommand->queryScalar();		
		
		if($existe==='0')
		{
			$sql = "Select texto from tipo_notificacion where action='shares'";
			$dbCommand = Yii::app()->db->createCommand($sql);
			$Texto =$dbCommand->queryScalar();
			
			$sql = "Select valor from tipo_notificacion where action='shares'";
			$dbCommand = Yii::app()->db->createCommand($sql);
			$Valor =$dbCommand->queryScalar();
			
			$conexion1 = Yii::app()->db;
			
			$consulta = "INSERT INTO tipo_notificacion_usuario(`userid`,`texto`, `valor`, `action`)";
			$consulta.=" VALUES($userid, '$Texto', $Valor, 'shares')";					
						
			$resultado = $conexion1->createCommand($consulta)->execute();				
		}		
		
		
		//Consultar el valor de sharedias
		$sql = "Select valor from tipo_notificacion_usuario where action='shares' and userid=".$userid."";
		$dbCommand = Yii::app()->db->createCommand($sql);
		$shares = $dbCommand->queryScalar();
		
		$fecha = new CDbExpression('NOW()');
		$conexion = Yii::app()->db;
		foreach ($dataSobrepasashare as $key => $value)
		{						
			if($value['shares']>$shares)
			{
				$id = $value['id'];
				$mensaje = utf8_encode(substr($value['title'], 0, 20)." ... más de ".$shares." compartidos");
				
				$sqlExiste="Select count(*) from `notificaciones` where articleid=".$id."
							and userid=".$userid."
							and action='shares'";
				$dbCommand = Yii::app()->db->createCommand($sqlExiste);
				$existe = $dbCommand->queryScalar();	
				
				if($existe<1)
				{										
					$consulta = "INSERT INTO `notificaciones`(`texto`, `userid`, `articleid`, `action`, `estado`, `fechaHora`)";
					$consulta.=" VALUES('$mensaje',$userid, $id, 'shares', 'enviado', $fecha)";
					
					$resultado = $conexion->createCommand($consulta)->execute();
				}
			}				
		}
		$this->setState('sobrepasashare', $dataSobrepasashare);
		
		//Código para ver(insertar) los recursos del usuario que sobrepasaron una catidad de visitas
		$sqlSobrepasavisit = "select article.id, article.title, count(visit.id) as visits 
							from visit, article 
							where visit.article = article.id and article.creator = ".$userid."								 
							Group By article.id";
		$dbCommand = Yii::app()->db->createCommand($sqlSobrepasavisit);
		$dataSobrepasavisit = $dbCommand->queryAll();
		
		//Ver si existe el parámetro de comparación (Caso contrario insertarlo)
		$sql = "Select count(*) from tipo_notificacion_usuario where action='visits' and userid=".$userid."";	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$existe = $dbCommand->queryScalar();		
		
		if($existe==='0')
		{
			$sql = "Select texto from tipo_notificacion where action='visits'";
			$dbCommand = Yii::app()->db->createCommand($sql);
			$Texto =$dbCommand->queryScalar();
			
			$sql = "Select valor from tipo_notificacion where action='visits'";
			$dbCommand = Yii::app()->db->createCommand($sql);
			$Valor =$dbCommand->queryScalar();
			
			$conexion1 = Yii::app()->db;
			
			$consulta = "INSERT INTO tipo_notificacion_usuario(`userid`,`texto`, `valor`, `action`)";
			$consulta.=" VALUES($userid, '$Texto', $Valor, 'visits')";					
						
			$resultado = $conexion1->createCommand($consulta)->execute();				
		}		
		
		//Consultar el valor de visits dias
		$sql = "Select valor from tipo_notificacion_usuario where action='visits' and userid=".$userid."";
		$dbCommand = Yii::app()->db->createCommand($sql);
		$visits = $dbCommand->queryScalar();
		
		foreach ($dataSobrepasavisit as $key => $value)
		{							
			if($value['visits']>$visits)
			{
				$id = $value['id'];
				$mensaje = utf8_encode(substr($value['title'], 0, 20)." ... más de ".$visits." visitas");
				
				$sqlExiste="Select count(*) from `notificaciones` where articleid=".$id."
							and userid=".$userid."
							and action='visits'";
				$dbCommand = Yii::app()->db->createCommand($sqlExiste);
				$existe = $dbCommand->queryScalar();
								
				if($existe<1)
				{																
					$consulta = "INSERT INTO `notificaciones` (`texto`, `userid`, `articleid`, `action`, `estado`, `fechaHora`)";
					$consulta.=" VALUES('$mensaje',$userid, $id, 'visits','enviado', $fecha)";
					
					$resultado = $conexion->createCommand($consulta)->execute();					
				}
			}				
		}
		
		//Código para ver(insertar) los recursos del usuario que sobrepasaron una catidad de "me gusta"
		$sqlSobrepasalikes = "select article.id, article.title, count(`like`.id) as likes 
							from `like`, article 
							where `like`.article = article.id and article.creator = ".$userid."								 
							Group By article.id";
		$dbCommand = Yii::app()->db->createCommand($sqlSobrepasalikes);
		$dataSobrepasalikes = $dbCommand->queryAll();
		
		//Ver si existe el parámetro de comparación (Caso contrario insertarlo)
		$sql = "Select count(*) from tipo_notificacion_usuario where action='likes' and userid=".$userid."";	
		$dbCommand = Yii::app()->db->createCommand($sql);
		$existe = $dbCommand->queryScalar();		
		
		if($existe==='0')
		{
			$sql = "Select texto from tipo_notificacion where action='likes'";
			$dbCommand = Yii::app()->db->createCommand($sql);
			$Texto =$dbCommand->queryScalar();
			
			$sql = "Select valor from tipo_notificacion where action='likes'";
			$dbCommand = Yii::app()->db->createCommand($sql);
			$Valor =$dbCommand->queryScalar();
			
			$conexion1 = Yii::app()->db;
			
			$consulta = "INSERT INTO tipo_notificacion_usuario(`userid`,`texto`, `valor`, `action`)";
			$consulta.=" VALUES($userid, '$Texto', $Valor, 'likes')";					
						
			$resultado = $conexion1->createCommand($consulta)->execute();				
		}		
		
		//Consultar el valor de likedias
		$sql = "Select valor from tipo_notificacion_usuario where action='likes' and userid=".$userid."";
		$dbCommand = Yii::app()->db->createCommand($sql);
		$likes = $dbCommand->queryScalar();
		
		foreach ($dataSobrepasalikes as $key => $value)
		{
			$mensaje= utf8_encode('Un artículo ha sobrepasado los '.$value['likes'].' gustados');
							
			if($value['likes']>$likes)
			{
				$id = $value['id'];
				$mensaje = utf8_encode(substr($value['title'], 0, 20)." ... más de ".$likes." likes");
				
				$sqlExiste="Select count(*) from `notificaciones` where articleid=".$id."
							and userid=".$userid."
							and action='likes'";
				$dbCommand = Yii::app()->db->createCommand($sqlExiste);
				$existe = $dbCommand->queryScalar();
				
				if($existe<1)
				{					
					$consulta = "INSERT INTO `notificaciones` (`texto`, `userid`, `articleid`, `action`, `estado`, `fechaHora`)";
					$consulta.=" VALUES('$mensaje',$userid, $id, 'likes', 'enviado', $fecha)";
					
					$resultado = $conexion->createCommand($consulta)->execute();
				}
			}				
		}			
		
		//CODIGO PARA LOS MENSAJES
		//Para consltar el número de mensajes
		$sqlNumeroMen = "SELECT count(*) FROM message where idreceive='".$userid."'";
		
		$dbCommand = Yii::app()->db->createCommand($sqlNumeroMen);
		$dataNumeroMen =$dbCommand->queryScalar();
		
		$this->setState('mensajes', $dataNumeroMen);
		
		//Para sacar los mensajes del usuario
		$sqlMensajes = "SELECT message.id, message.datesend, message.subject, user.name, user.image FROM message, user where message.idsend=user.id and idreceive='".$userid."'"; 
		
		$dbCommand = Yii::app()->db->createCommand($sqlMensajes);
		$dataMensajes = $dbCommand->queryAll();
		
		$ordenar=array();
		
		foreach ($dataMensajes as $key => $value) {
			$ordenar[$key]= $value['datesend'];				
		}		
		
		array_multisort($ordenar, SORT_DESC, $dataMensajes);
		
		$this->setState('datamensajes', $dataMensajes);			
		
		//CODIGO PARA LAS NOTIFICACIONES
		//Para consultar el número de notificaciones
		$sqlNumero = "SELECT count(*) FROM notificaciones where estado='enviado' and userid = '".$userid."'";
			
		$dbCommand = Yii::app()->db->createCommand($sqlNumero);
		$dataNumero =$dbCommand->queryScalar();
		//$this->setState('data', json_encode($dataNotificaciones));
		$this->setState('numero', $dataNumero);
		//Para mostrar las notificaciones del usuario
		$sqlNotificaciones = "SELECT * FROM notificaciones where estado='enviado' and userid = '".$userid."'";
			
		$dbCommand = Yii::app()->db->createCommand($sqlNotificaciones);
		
		$dataNotificaciones =$dbCommand->queryAll();
		
		$ordenar1=array();	
		
		foreach ($dataNotificaciones as $key => $value) {
			$ordenar1[$key]= $value['fechaHora'];				
		}
		
		array_multisort($ordenar1, SORT_DESC, $dataNotificaciones);
		//$dataNotificaciones = array_orderby($dataNotificaciones1, 'fechaHora', SORT_DESC);		
		//$this->setState('data', json_encode($dataNotificaciones));
		$this->setState('data', $dataNotificaciones);															
	
	}	
}