<?php

/**
 * This is the model class for table "article_related".
 *
 * The followings are the available columns in table 'article_related':
 * @property string $id
 * @property string $main_article
 * @property string $related_article
 * @property string $createdAt
 * @property string $updatedAt
 *
 * The followings are the available model relations:
 * @property Article $mainArticle
 * @property Article $relatedArticle
 */
class ArticleRelated extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'article_related';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('main_article, related_article', 'required'),
			array('main_article, related_article', 'length', 'max'=>10),
			array('createdAt, updatedAt', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, main_article, related_article, createdAt, updatedAt', 'safe', 'on'=>'search'),
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
			'mainArticle' => array(self::BELONGS_TO, 'Article', 'main_article'),
			'relatedArticle' => array(self::BELONGS_TO, 'Article', 'related_article'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'main_article' => 'Main Article',
			'related_article' => 'Related Article',
			'createdAt' => 'Created At',
			'updatedAt' => 'Updated At',
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
		$criteria->compare('main_article',$this->main_article,true);
		$criteria->compare('related_article',$this->related_article,true);
		$criteria->compare('createdAt',$this->createdAt,true);
		$criteria->compare('updatedAt',$this->updatedAt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ArticleRelated the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
