<?php

/**
 * Filter class used to authenticate users or entities from api.
 * 
 * Usage:
 * <pre>
 * public function filters() {
 *       return array(
 *           array(
 *               'ext.freshApi.FrAuthFilter'
 *           )
 *       );
 *   }
 * </pre>
 * 
 * @copyright 2014 FreshRealm
 * @author Ondrej Nebesky <ondrej@freshrealm.co>
 * @author John Grogg <grogg@freshrealm.co>
 * @version 0.91
 * @package FreshRest
 */
class FrAuthFilter extends CFilter {

    /**
     * Performs the pre-action filtering.
     * @param CFilterChain $filterChain the filter chain that the filter is on.
     * @return boolean whether the filtering process should continue and the action should be executed.
     * @throws CHttpException if the user is denied access.
     */
    protected function preFilter($filterChain) {
        $controller = $filterChain->controller;
        $module = $controller->module;
        $key = $module->getAuthKey();
        $authModel = $module->getAuthModel();

        if ($authModel->isAuthenticated($key)) {
            return true;
        }
        
        throw new CHttpException(403, Yii::t('yii', 'You are not authorized to perform this action.'));
    }

}
