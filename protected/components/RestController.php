<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class RestController extends Controller {

    public function filters() {
        return array(
            array(
                'ext.starship.RestfullYii.filters.ERestFilter + 
                REST.GET, REST.PUT, REST.POST, REST.DELETE, REST.OPTIONS'
            ),
        );
    }

    public function actions() {
        return array(
            'REST.' => 'ext.starship.RestfullYii.actions.ERestActionProvider',
        );
    }

    public function accessRules() {
        return array(
            array('allow', 'actions' => array('REST.GET', 'REST.PUT', 'REST.POST', 'REST.DELETE', 'REST.OPTIONS'),
                'users' => array('*'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Rest Result renderer format Json
     * @param $obj array
     * @return string
     */
    public function restJsonEncode($obj) {
        $jsonResult = array();
        if ($obj) {
            $jsonResult['success'] = "true";
            $jsonResult['message'] = "Record(s) found";
            $jsonResult['data'] = $obj;
        }else{
            $jsonResult['success'] = "false";
            $jsonResult['message'] = "Record(s) not found";
            $jsonResult['data'] = "";
        }
        return json_encode($jsonResult);
    }

}
