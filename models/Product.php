<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $catalog4_id
 *
 * @property Catalog4 $catalog4
 */
class Product extends \yii\db\ActiveRecord
{
    public $deleteImage;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['prize', 'weight', 'country', 'pol', 'proizvoditel', 'sezonnost', 'materialout', 'materialin', 'category', 'color'], 'integer'],
            [['title', 'description', 'alias'], 'required'],
            [['description'], 'string'],
            [['deleteImage', 'prize', 'weight', 'country', 'pol', 'catalog_id', 'catalog2_id', 'catalog3_id', 'catalog4_id',
            'sezonnost', 'materialout', 'materialin', 'category', 'color'], 'safe'],
            [['title', 'alias', 'image'], 'string', 'max' => 300],
            [['date'], 'date', 'format' => 'yyyy-m-d'],
            [['alias', 'image'], 'trim'],
            //[['catalog4_id'], 'exist', 'skipOnError' => true, 'targetClass' => Catalog4::className(), 'targetAttribute' => ['catalog4_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'catalog_id' => 'Catalog ID',
            'catalog2_id' => 'Catalog2 ID',
            'catalog3_id' => 'Catalog3 ID',
            'catalog4_id' => 'Catalog4 ID',
            'alias' => 'Alias',
            'date' => 'Date',
            'prize' => 'Prize',
            'pol' => 'Пол',
            'sezonnost' => 'Сезонность',
            'materialout' => 'Материал внешний',
            'materialin' => 'Материал внутренний',
            'category' => 'Категория',
            'color' => 'Цвет',
            'country' => 'Страна',
            'proizvoditel' => 'Производитель',
            'prizeFrom' => 'Цена,р.',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalog()
    {
        return $this->hasOne(Catalog::className(), ['id' => 'catalog_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalog2()
    {
        return $this->hasOne(Catalog2::className(), ['id' => 'catalog2_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalog3()
    {
        return $this->hasOne(Catalog3::className(), ['id' => 'catalog3_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalog4()
    {
        return $this->hasOne(Catalog4::className(), ['id' => 'catalog4_id']);
    }

    /***************  get data from AttributeValue * START *****************/

    public function getTCountry()
    {
        return $this->hasOne(AttributeValue::className(), ['id' => 'country']);
    }

    public function getTPol()
    {
        return $this->hasOne(AttributeValue::className(), ['id' => 'pol']);
    }

    public function getTProizvoditel()
    {
        return $this->hasOne(AttributeValue::className(), ['id' => 'proizvoditel']);
    }

    public function getTSezonnost()
    {
        return $this->hasOne(AttributeValue::className(), ['id' => 'sezonnost']);
    }

    public function getTMaterialout()
    {
        return $this->hasOne(AttributeValue::className(), ['id' => 'materialout']);
    }

    public function getTMaterialin()
    {
        return $this->hasOne(AttributeValue::className(), ['id' => 'materialin']);
    }

    public function getTCategory()
    {
        return $this->hasOne(AttributeValue::className(), ['id' => 'category']);
    }

    public function getTColor()
    {
        return $this->hasOne(AttributeValue::className(), ['id' => 'color']);
    }

    /***************  get data from AttributeValue * END *****************/

    public function uniqAlias(){

        if ($this->id != null) { 
            if (Product::find()->select(['alias'])->where(['alias' => $this->alias])->count() > 0 && 
                Product::find()->select(['alias'])->where(['alias' => $this->alias, 'id' => $this->id])->count() == 0) {
                $this->addError('alias', 'alias must be uniq.');
                return false; 
            }
        }
        else
        if (Product::find()->select(['alias'])->where(['alias' => $this->alias])->count() > 0) {
            $this->addError('alias', 'alias must be uniq.');
            return false; 
        }
        return true;
    }
}
