<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "catalog2".
 *
 * @property integer $id
 * @property string $title
 * @property integer $catalog_id
 *
 * @property Catalog $catalog
 * @property Catalog3[] $catalog3s
 */
class Catalog2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog2';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'catalog_id', 'alias'], 'required'],
            [['catalog_id'], 'integer'],
            [['title', 'alias'], 'string', 'max' => 300],
            [['alias'], 'trim'],
            [['catalog_id'], 'exist', 'skipOnError' => true, 'targetClass' => Catalog::className(), 'targetAttribute' => ['catalog_id' => 'id']],
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
            'catalog_id' => 'Catalog ID',
            'alias' => 'Alias',
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
    public function getCatalog3s()
    {
        return $this->hasMany(Catalog3::className(), ['catalog2_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['catalog2_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttributeShow()
    {
        return $this->hasOne(AttributeShow::className(), ['catalog2_id' => 'id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
                // Да это новая запись (insert)
                $attributeShow = new AttributeShow();                
                $attributeShow->catalog2_id = $this->id;$attributeShow->save();
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
