<?php
class MyWebUser extends CWebUser
{
    public function getUser($attrib="")
    {   
        $model = NatcUsers::model()->findByPk(Yii::app()->user->getId());
        switch($attrib){
            case 'fullname':
                return $model->user_fullname;
                break;
            case 'terminal':
                return $model->terminal;
                break;
            case 'userId':
                return $model->user_id;
                break;
            case 'userName':
                return $model->username;
                break;
            case 'userStatus':
                return $model->status;
                break;
            case 'userType':
                return $model->user_type;
                break;
            default:
                return $model->attributes;
                break;
        }
    }
}
?>