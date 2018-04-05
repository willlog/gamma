<?php
/**
 * class LoginForm
 * @author Igor Ivanović
 * Main login system 
 */
class LoginForm extends CFormModel
{

    public $username;
    public $password;
    public $_identity;

    /**
     * Model rules
     * @return type 
     */
    public function rules() 
    {
        return array(
            array("username", "required", "message" => "Korisničko ime je obavezno."),
            array("password", "required", "message" => "Lozinka je obavezna."),
            array("password", "authenticate"),            
        );
    }
  
    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate() 
    {
        $this->_identity = new UserIdentity($this->username,$this->password);
        
        if( $this->_identity->authenticate() !== UserIdentity::ERROR_NONE ) 
        {
            $this->addError( 'username', Yii::t('Web', 'Kriva kombinacija lozinke i korisničkog imena.') );
        }
    }
    
    /**
     * Model attribute labels
     * @return type 
     */
    public function attributeLabels() 
    {
        return array(
            "username"              => Yii::t("lang", "Korisničko ime"),
            "password"              => Yii::t("lang", "Lozinka"),
        );
    }    
    

    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function login() 
    {
        
        if($this->_identity === NULL) 
        {
            $this->_identity = new UserIdentity($this->username, $this->password);
            $this->_identity->authenticate();
        }
           
        if($this->_identity->errorCode === UserIdentity::ERROR_NONE) 
        {
            Yii::app()->user->login($this->_identity, NULL);
            return TRUE; 
        } 
        else 
        {
            return FALSE;
        }
        
    }
    
    
}