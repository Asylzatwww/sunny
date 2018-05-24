<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AttributeShow;

/**
 * AttributeShowSearch represents the model behind the search form about `app\models\AttributeShow`.
 */
class AttributeShowSearch extends AttributeShow
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'catalog_id', 'catalog2_id', 'catalog3_id', 'catalog4_id'], 'integer'],
            [['prize'], 'safe'],
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
        $query = AttributeShow::find();

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'catalog_id' => $this->catalog_id,
            'catalog2_id' => $this->catalog2_id,
            'catalog3_id' => $this->catalog3_id,
            'catalog4_id' => $this->catalog4_id,
        ]);

        $query->andFilterWhere(['like', 'prize', $this->prize]);

        return $dataProvider;
    }
}
