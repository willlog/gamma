<?php
class ImagenForm extends CFormModel{
    public $foto;
    
    public function rules()
    {
        return array(
           array('foto','file','types'=>'jpg, jpeg, png, gif'),
           array('foto', 'required'),
            );
    }
    
    public function attributeLabels()
	{
		return array(
                        'foto'=>'Foto',			
		);
	}
    
}
?>
