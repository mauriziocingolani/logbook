<?php

namespace app\modules\user\models;

use yii\data\ActiveDataProvider;

class UserSearch extends User {

    public $role;

    public function attributeLabels() {
        return [
            'UserID' => 'ID utente',
            'UserName' => 'Nome utente',
        ];
    }

    public function rules() {
        return [
            [['UserID', 'UserName', 'Email', 'role'], 'safe'],
        ];
    }

    /* Relazioni */
    /* Eventi */
    /* Metodi */

    public function search($params) {
        $query = User::find();
        $query->joinWith(['role']);
        $dataProvider = new ActiveDataProvider(['query' => $query, 'pagination' => ['pageSize' => 10]]);
        if (!$this->load($params))
            return $dataProvider;
        $query->andFilterWhere(['UserID' => $this->UserID]);
        $query->andFilterWhere(['like', 'UserName', $this->UserName]);
        $query->andFilterWhere(['like', 'Email', $this->Email]);
        $query->orderBy(['UserName' => SORT_ASC]);
        return $dataProvider;
    }

    /* Metodi statici */
}
