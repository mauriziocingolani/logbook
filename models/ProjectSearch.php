<?php

namespace app\models;

use yii\data\ActiveDataProvider;

class ProjectSearch extends Project {

    public function rules() {
        return [
            ['Name', 'safe'],
        ];
    }

    public function search($params) {
        $query = Project::find();
        $query->orderBy(['Created' => SORT_DESC]);
        $dataProvider = new ActiveDataProvider(['query' => $query, 'pagination' => ['pageSize' => 10]]);
        if (!$this->load($params))
            return $dataProvider;
        $query->andFilterWhere(['like', 'Name', $this->Name]);
        return $dataProvider;
    }

}
