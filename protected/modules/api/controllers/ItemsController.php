<?php

class ItemsController extends FrApiBaseController {

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            // only list and view actions are allowed
            'disabled +update,create,delete',
            array(
                // authenticate except simple "hi" action
                'ext.freshRest.FrAuthFilter -sayHi'
            )
        );
    }
    
    /**
     * Public action
     */
    public function actionSayHi(){
        $this->renderOutput("Hi");
    }
    
    /**
     * Action that requires authentication
     */
    public function actionSayHiToMe(){
        $me = $this->module->getAuthenticatedModel();
        $this->renderOutput("Hi " . $me->fullName);
    }
    
    /**
     * List only 5 recently updated items
     */
    public function actionRecent(){
        $apiModel = $this->getApiResource('recent');
        $models = $apiModel->findAll();
        $output = array();
        foreach ($models as $model) {
            $output[] = $model->getApiOutput();
        }
        $this->renderOutput($output);
    }
}