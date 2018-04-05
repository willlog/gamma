<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property string $id
 * @property string $provider
 * @property string $uid
 * @property string $name
 * @property string $birthday
 * @property string $gender
 * @property string $email
 * @property string $status
 * @property string $firstname
 * @property string $lastname
 * @property string $profileUrl
 * @property string $password
 * @property string $createdAt
 * @property string $updatedAt 
 *
 * The followings are the available model relations:
 * @property Article[] $articles
 * @property Like[] $likes
 * @property Share[] $shares
 * @property Visit[] $visits
 */
class User extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	 
	//Variables personalizadas
	public static $estadosCuenta=array('solicitada'=>'solicitada','activada'=>'activada', 'cancelada'=>'cancelada' );
	public static $generos = array('male'=>'masculino', 'female'=>'femenino');  
	
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('uid, estadoCuenta', 'required'),
			array('provider, image, uid, name, gender, email, firstname, lastname, password', 'length', 'max'=>255),
			array('profileUrl', 'length', 'max'=>250),
			//array('estadoCuenta', 'length', 'max'=>20),
			array('status', 'length', 'max'=>15),
			array('birthday, createdAt, updatedAt', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, provider, uid, name, birthday, gender, email, status, image, firstname, lastname, profileUrl, password, createdAt, updatedAt', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'articles' => array(self::HAS_MANY, 'Article', 'creator'),
			'likes' => array(self::HAS_MANY, 'Like', 'user'),
			'shares' => array(self::HAS_MANY, 'Share', 'user'),
			'visits' => array(self::HAS_MANY, 'Visit', 'user'),
		);
	}

	//Funcion personalizada para obtener estado de la cuenta del usuario
	public function getEstados()
	{
		return self::$estadosCuenta;	
	}	
	
	//Funcion personalizada para obtener genero de la persona	
	public function getGeneros()
	{
		return self::$generos;				
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'provider' => 'Red Social',
			'uid' => 'Uid',
			'name' => 'Usuario',
			'birthday' => 'Fecha Nacimiento',
			'gender' => 'Género',
			'email' => 'Email',
			'status' => 'Estado',
			'firstname' => 'Nombre',
			'lastname' => 'Apellido',
			'profileUrl' => 'Url Perfil',
			'password' => 'Contraseña',
			'createdAt' => 'Fecha Creación',
			'updatedAt' => 'Fecha Actualización',
			//'estadoCuenta' => 'Estado Cuenta',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('provider',$this->provider,true);
		$criteria->compare('uid',$this->uid,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('birthday',$this->birthday,true);
		$criteria->compare('gender',$this->gender,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('firstname',$this->firstname,true);
		$criteria->compare('lastname',$this->lastname,true);
		$criteria->compare('profileUrl',$this->profileUrl,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('createdAt',$this->createdAt,true);
		$criteria->compare('updatedAt',$this->updatedAt,true);
		//$criteria->compare('estadoCuenta',$this->estadoCuenta,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	//Para autentificacion via facebook
	
	/**
     * Selects user in database and return data
     * @param type $username
     * @return \user|null 
     */
    public static function prepareUserForAuthorisation( $username )
    {

        if( strpos($username, "@") ) 
        {
            $user = self::model()->notDeleted()->find( 'LOWER(e_mail)=?', array($username) );
        } 
        else 
        {
            $user = self::model()->notDeleted()->find( 'LOWER(username)=?', array($username) );
        }
        
        if($user instanceof user)
        {
            return $user;
        }
        
        return NULL;
        
    }    
	
	/**
     * Create random username
     * @param type $lenght
     * @return type 
     */
    public static function createRandomUsername($lenght = 10)
    {
        $chars   = "QWERTZUIOPASDFGHJKLYXCVBNMasdfghjklqwertzuiopyxcvbnm1234567890";
        $shuffle = str_split($chars);
        shuffle($shuffle);
        $string  = implode("", $shuffle);
        return substr($string, 0, $lenght).time();
    }
	
	/**
     * Validate pasword
     * If is facebook user dont validate password
     * @param type $password
     * @return boolean 
     */
    public function validatePassword($password) 
    {
        if( $this->facebook_account ==  1)
        {
            return true;
        }
        
        return $this->password == self::hash($password);
    }
    
    /**
     * Hash password
     * @param type $password
     * @return type 
     */
    public static function hash($password) 
    {
        return md5($password);
    }   
}
