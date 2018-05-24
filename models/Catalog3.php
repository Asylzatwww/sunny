<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "catalog3".
 *
 * @property integer $id
 * @property string $title
 * @property integer $catalog2_id
 *
 * @property Catalog2 $catalog2
 * @property Catalog4[] $catalog4s
 */
class Catalog3 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog3';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'catalog2_id', 'alias'], 'required'],
            [['catalog2_id'], 'integer'],
            [['title', 'alias'], 'string', 'max' => 300],
            [['alias'], 'trim'],
            [['catalog2_id'], 'exist', 'skipOnError' => true, 'targetClass' => Catalog2::className(), 'targetAttribute' => ['catalog2_id' => 'id']],
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
            'catalog2_id' => 'Catalog2 ID',
            'alias' => 'Alias',
        ];
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
    public function getCatalog4s()
    {
        return $this->hasMany(Catalog4::className(), ['category3_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['catalog3_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttributeShow()
    {
        return $this->hasOne(AttributeShow::className(), ['catalog3_id' => 'id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
                // Да это новая запись (insert)
                $attributeShow = new AttributeShow();                
                $attributeShow->catalog3_id = $this->id;$attributeShow->save();
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
