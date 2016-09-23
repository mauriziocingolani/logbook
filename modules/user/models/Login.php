<?php

namespace app\modules\user\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * @property integer $LoginID
 * @property integer $SessionID
 * @property integer $UserID
 * @property string $UserName
 * @property string $Login
 * @property string $Logout
 * @property string $IpAddress
 */
class Login extends ActiveRecord {

    public static function tableName() {
        return 'logins';
    }

    /* Relazioni */

    public function getUser() {
        return $this->hasOne(User::className(), ['UserID' => 'UserID']);
    }

    /* Eventi */
    /* Metodi */
    /* Metodi statici */

    public static function RegisterLogin() {
        Yii::$app->session->open();
        $request = Yii::$app->getRequest();
        $model = new Login;
        $model->SessionID = Yii::$app->session->id;
        if (Yii::$app->user->isGuest) :
            $model->UserName = $request->post('LoginForm')['UserName'];
        else :
            $model->UserID = Yii::$app->user->id;
        endif;
        $model->Login = new Expression('NOW()');
        $model->IpAddress = $request->userIP;
        $model->save();
    }

    public static function RegisterLogout($userid) {
        Yii::$app->session->open();
        $login = self::find()->where([
                    'SessionID' => Yii::$app->session->id,
                    'UserID' => $userid,
                ])->one();
        if ($login) :
            $login->Logout = new Expression('NOW()');
            $login->save();
        endif;
    }

}
