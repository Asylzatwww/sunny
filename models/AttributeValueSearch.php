<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AttributeValue;

use app\models\AttributeType;

use yii\helpers\ArrayHelper;

/**
 * AttributeValueSearch represents the model behind the search form about `app\models\AttributeValue`.
 */
class AttributeValueSearch extends AttributeValue
{
    public $attributeTypeList;
    public $attributeTypes;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['title', 'attribute_type_id', 'attributeTypes'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = AttributeValue::find();

        $this->attributeTypeList = ArrayHelper::map(AttributeType::find()->all(), 'id', 'title');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->joinWith('attributeType');

        // grid filtering conditions
        $query->andFilterWhere([
            'attribute_value.id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'attribute_value.title', $this->title])
            ->andFilterWhere(['like', 'attribute_type.title', $this->attribute_type_id]);
        if ($this->attributeTypes != null) $query->where([ 'attribute_type_id' => $this->attributeTypes ]);

        return $dataProvider;
    }
}
