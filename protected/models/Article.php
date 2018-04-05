<?php

/**
 * This is the model class for table "article".
 *
 * The followings are the available columns in table 'article':
 * @property string $id 
 * @property string $title
 * @property string $description
 * @property string $url
 * @property string $image
 * @property string $reading
 * @property string $state
 * @property string $kind
 * @property string $creator
 * @property string $createdAt
 * @property string $updatedAt
 *
 * The followings are the available model relations:
 * @property User $creator0
 * @property ArticleCategoriesCategoryArticles[] $articleCategoriesCategoryArticles
 * @property ArticleRelated[] $articleRelateds
 * @property ArticleRelated[] $articleRelateds1
 * @property Like[] $likes
 * @property Share[] $shares
 * @property Visit[] $visits
 */
class Article extends CActiveRecord
{
	public $valores;
	public $picture;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'article';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, description, url', 'required','message'=>'Hay campos requeridos'),
			array('valores', 'required','message'=>'Debe asignar una categoria'),
			array('valores, title, url, image, kind', 'length', 'max'=>255),
			array('state', 'length', 'max'=>15),
			array('creator', 'length', 'max'=>10),
			array('reading, createdAt, updatedAt', 'safe'),
			//array('picture', 'safe'),
			//array('picture', 'file', 'types'=>'jpg, gif, png', 'safe'=>false),
			//array('picture', 'setOnEmpty'=>'null'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, description, url, image, reading, state, kind, creator, createdAt, updatedAt', 'safe', 'on'=>'search'),
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
			'creator0' => array(self::BELONGS_TO, 'User', 'creator'),
			'articleCategoriesCategoryArticles' => array(self::HAS_MANY, 'ArticleCategoriesCategoryArticles', 'article_categories'),
			'articleRelateds' => array(self::HAS_MANY, 'ArticleRelated', 'main_article'),
			'articleRelateds1' => array(self::HAS_MANY, 'ArticleRelated', 'related_article'),
			'likes' => array(self::HAS_MANY, 'Like', 'article'),
			'shares' => array(self::HAS_MANY, 'Share', 'article'),
			'visits' => array(self::HAS_MANY, 'Visit', 'article'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',			
			'title' => 'Título',
			'description' => 'Descripción',
			//'picture'=>'Imagen',
			'url' => 'Enlace',
			'image' => 'Imagen',
			'picture'=>'Imagen',
			'reading' => 'Reading',
			'state' => 'Estado',
			'kind' => 'Tipo',
			'creator' => 'Creador',
			'createdAt' => 'Creado',
			'updatedAt' => 'Actualizado',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('reading',$this->reading,true);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('kind',$this->kind,true);
		$criteria->compare('creator',$this->creator,true);
		$criteria->compare('createdAt',$this->createdAt,true);
		$criteria->compare('updatedAt',$this->updatedAt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function primaryKey() 
	{
	    return 'id';
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Article the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
