<?php

namespace app\models;

use Yii;

use yii\web\UploadedFile;

/**
 * This is the model class for table "catalog".
 *
 * @property integer $id
 * @property string $title
 *
 * @property Catalog2[] $catalog2s
 */
class Catalog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'alias'], 'required'],
            [['title', 'alias', 'image'], 'string', 'max' => 300],
            [['alias', 'image'], 'trim'],
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
            'alias' => 'Alias',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalog2s()
    {
        return $this->hasMany(Catalog2::className(), ['catalog_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['catalog_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttributeShow()
    {
        return $this->hasOne(AttributeShow::className(), ['catalog_id' => 'id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
                // Да это новая запись (insert)
                $attributeShow = new AttributeShow();                
                $attributeShow->catalog_id = $this->id;$attributeShow->save();
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

    public function mainMenu(){
        $list1 = '';
        $list2 = '';

        $catalog2Sum = 0;
        $catalog3Sum = 0;

        $i = 0;
        foreach(Catalog::find()->all() as $catalog){
            $i++;
            $list1 .= "<li class='list" . $i . "'><a href='/catalogs/" . $catalog->alias . "'>" . $catalog->title . "</a></li>";
            $list2 .= "<div class='ilist" . $i . "''>";
            foreach($catalog->catalog2s as $catalog2){ $catalog2Sum = 0;$listHelper1 = '';
                    foreach($catalog2->catalog3s as $catalog3){ $catalog3Sum = 0;$listHelper = '';
                        foreach($catalog3->catalog4s as $catalog4){
                            $listHelper .= "<li><a href='/catalogs/" . $catalog->alias . "/" . $catalog2->alias . "/" . $catalog3->alias . "/" . $catalog4->alias . "'>" . 
                            $catalog4->title . " <span>" . count($catalog4->products) . "</span></a>";$catalog3Sum += count($catalog4->products);
                        }
                        $catalog3Sum += count($catalog3->products);
                        $listHelper1 .= "<li><ul><a href='/catalogs/" . $catalog->alias . "/" . $catalog2->alias . "/" . $catalog3->alias . "'>" . 
                        $catalog3->title . " <span>" . $catalog3Sum . "</span></a>" . $listHelper . "</ul></li>";
                        $catalog2Sum += $catalog3Sum;
                    }
                    $catalog2Sum += count($catalog2->products);
                $list2 .= "<ul><a href='/catalogs/" . $catalog->alias . "/" . $catalog2->alias . "'>" . 
                $catalog2->title . " <span>" . $catalog2Sum . "</span></a>" . $listHelper1 . "</ul>";
            }
            $list2 .= "</div>";
        }
        return ['list1' => $list1, 'list2' => $list2];
    }

}
