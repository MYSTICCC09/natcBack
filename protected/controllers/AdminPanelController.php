<?php

class AdminPanelController extends RestController {

    public function restEvents() {
        $this->onRest('req.get.listUsers.render', function () {
            $userArr = array();
            $users = NatcUsers::model()->findAll();
            foreach ($users as $key => $user) {
                $userArr[$key] = $user->attributes;
            }
            echo $this->restJsonEncode($userArr);
        });

        $this->onRest('req.post.addUser.render', function ($data) {
            $user = new NatcUsers();
            $user->attributes = $data;
            $user->status = 1;
            $user->password = md5($data['password']);
            if($user->save()){
                echo $this->restJsonEncode("success");
            }

        });
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

}
