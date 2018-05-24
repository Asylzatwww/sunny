<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "attribute_show".
 *
 * @property integer $id
 * @property integer $catalog_id
 * @property integer $catalog2_id
 * @property integer $catalog3_id
 * @property integer $catalog4_id
 * @property string $prize
 */
class AttributeShow extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'attribute_show';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['catalog_id', 'catalog2_id', 'catalog3_id', 'catalog4_id'], 'safe'],
            [['catalog_id', 'catalog2_id', 'catalog3_id', 'catalog4_id'], 'integer'],
            [['prize', 'weight', 'country', 'pol', 'proizvoditel', 'sezonnost', 'materialout', 'materialin', 'category', 'color'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'catalog_id' => 'Catalog ID',
            'catalog2_id' => 'Catalog2 ID',
            'catalog3_id' => 'Catalog3 ID',
            'catalog4_id' => 'Catalog4 ID',
            'prize' => 'Prize',
            'weight' => 'weight',
            'country' => 'country',
            'pol' => 'pol',
        ];
    }
}
