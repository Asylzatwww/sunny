<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "catalog4".
 *
 * @property integer $id
 * @property string $title
 * @property integer $category3_id
 *
 * @property Catalog3 $category3
 * @property Product[] $products
 */
class Catalog4 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog4';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'category3_id', 'alias'], 'required'],
            [['category3_id'], 'integer'],
            [['title', 'alias'], 'string', 'max' => 300],
            [['alias'], 'trim'],
            [['category3_id'], 'exist', 'skipOnError' => true, 'targetClass' => Catalog3::className(), 'targetAttribute' => ['category3_id' => 'id']],
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
            'category3_id' => 'Category3 ID',
            'alias' => 'Alias',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory3()
    {
        return $this->hasOne(Catalog3::className(), ['id' => 'category3_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['catalog4_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttributeShow()
    {
        return $this->hasOne(AttributeShow::className(), ['catalog4_id' => 'id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
                // Да это новая запись (insert)
                $attributeShow = new AttributeShow();                
                $attributeShow->catalog4_id = $this->id;$attributeShow->save();
        } else {          
                
                // Нет, старая (update)
        }
        parent::afterSave($insert, $changedAttributes);
    }

    public function uniqAlias(){

        if ($this->id != null) { 
            if (Catalog::find()->select(['alias'])->where(['alias' => $this->alias])->count() > 0 && 
                Catalog::find()->select(['alias'])->where(['alias' => $this->alias, 'id' => $this->id])->count() == 0) {
                $this->addError('alias', 'alias must be uniq.');
                return false; 
            }
        }
        else
        if (Catalog::find()->select(['alias'])->where(['alias' => $this->alias])->count() > 0) {
            $this->addError('alias', 'alias must be uniq.');
            return false; 
        }
        return true;
    }
}
