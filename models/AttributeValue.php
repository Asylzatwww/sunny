<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "attribute_value".
 *
 * @property integer $id
 * @property string $title
 * @property integer $attribute_type_id
 *
 * @property AttributeType $attributeType
 */
class AttributeValue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'attribute_value';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'attribute_type_id'], 'required'],
            [['attribute_type_id'], 'integer'],
            [['title'], 'string', 'max' => 300],
            [['attribute_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => AttributeType::className(), 'targetAttribute' => ['attribute_type_id' => 'id']],
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
            'attribute_type_id' => 'Attribute Type ID',
            'attributeTypes' => 'Attr Types'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttributeType()
    {
        return $this->hasOne(AttributeType::className(), ['id' => 'attribute_type_id']);
    }
}
