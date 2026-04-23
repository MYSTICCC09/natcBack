<?php

/**
 * Actions in this controller should be non-resource related. 
 */
class DefaultController extends FrApiBaseController {
    
    /**
     * Default action - in most cases returns please login or redirects to documentation
     */
    public function actionIndex(){
        $this->renderOutput("Fresh REST");
    }
    
    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            array(
                'ext.freshRest.FrAuthFilter -authenticate -index'
            )
        );
    }
 
    public function actionAuthenticate() {
        $data = $this->getData();
        if (isset($data['secret'])){
            $model = $this->module->getAuthModel();
            if ($model->authenticate($data['secret'])){
                // return temporary auth token and exit
                 $this->renderOutput(array('token' => $model->token));
            }
            // wrong password provided
            $this->renderError('403', 'Wrong password provided.');
        }
        
        // wrong format
        $this->renderError('403', 'Wrong format, probably missing "secret" key.');
    }
}