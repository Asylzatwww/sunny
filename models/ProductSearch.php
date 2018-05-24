<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Product;



/**
 * ProductSearch represents the model behind the search form about `app\models\Product`.
 */
class ProductSearch extends Product
{
    public $query;
    public $prizeFrom;
    public $prizeTo;
    public $title;
    public $productId;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'catalog4_id'], 'integer'],
            [['title', 'description', 'prize', 'prizeFrom', 'prizeTo', 'pol', 'country', 'proizvoditel', 'productId',
            'sezonnost', 'materialout', 'materialin', 'category', 'color'], 'safe'],
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
        if ($this->query != null) $query = $this->query; else $query = Product::find();

        // add conditions that should always apply here
        $proizvoditel = Product::find()->select([ 'proizvoditel' ])->distinct()->all();
        /*echo "<pre>";
        foreach($proizvoditel as $current){
            echo $current->proizvoditel;
        }
        echo "</pre>";*/

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
            'catalog4_id' => $this->catalog4_id,
        ]);

        if ($this->query != null) {
            if ($this->prizeFrom == null) $this->prizeFrom = 0;
            if ($this->prizeTo == null) $this->prizeTo = 20000;
        }


        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['>=', 'prize', $this->prizeFrom])
            ->andFilterWhere(['<=', 'prize', $this->prizeTo])
            ->andFilterWhere(['>=', 'date', $this->date])
            ->andFilterWhere(['like', 'description', $this->description]);


        if ($this->pol != null) $query->andFilterWhere(['pol'=>$this->pol]);
        if ($this->country != null) $query->andFilterWhere(['country'=>$this->country]);
        if ($this->proizvoditel != null) $query->andFilterWhere(['proizvoditel'=>$this->proizvoditel]);

        if ($this->sezonnost != null) $query->andFilterWhere(['sezonnost'=>$this->sezonnost]);
        if ($this->materialout != null) $query->andFilterWhere(['materialout'=>$this->materialout]);
        if ($this->materialin != null) $query->andFilterWhere(['materialin'=>$this->materialin]);
        if ($this->category != null) $query->andFilterWhere(['category'=>$this->category]);
        if ($this->color != null) $query->andFilterWhere(['color'=>$this->color]);

        if ($this->productId != null) $query->where(['id'=>$this->productId]);

        return $dataProvider;
    }
}

