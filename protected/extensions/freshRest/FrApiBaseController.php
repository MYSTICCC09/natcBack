<?php

/**
 * Base controller for both API default controller and custom controllers. The controller
 * already handles default CRUD model.
 * 
 * @copyright 2014 FreshRealm
 * @author Ondrej Nebesky <ondrej@freshrealm.co>
 * @author John Grogg <grogg@freshrealm.co>
 * @version 0.91
 * @package FreshRest
 */
class FrApiBaseController extends CController {

    /**
     * Model used for lookup of actual data
     * @var FrApiResource 
     */
    protected $apiResource;

    /**
     * Class that is being used for underlaying model
     * @var string 
     */
    public $resourceClassName = null;

    /**
     * Temporary storage for user POST or PUT data
     * @var type 
     */
    protected $postData;

    /**
     * Cross-Domain Ajax Requests by extending request headers.
     * This option is useful mostly for javascript clients.
     * @var type 
     */
    public $allowCors = true;

    /**
     * Detect resource class name before getModel function gets called.
     * @param string $id
     * @param string $module
     */
    public function __construct($id, $module = null) {
        parent::__construct($id, $module);

        if ($this->resourceClassName == null) {
            // default controller does not have model
            if ($this->id == 'frApi') {
                $this->resourceClassName = "FrApiResource";
            } else {
                $this->resourceClassName = ucfirst($id);
            }
        }
    }

    /**
     * List all the resources
     */
    public function actionIndex() {
        $apiModel = $this->getApiResource('list');
        $models = $apiModel->findAll();
        $output = array();
        foreach ($models as $model) {
            $output[] = $model->getApiOutput();
        }
        $this->renderOutput($output);
    }

    /**
     * View one item
     */
    public function actionView($id) {
        $model = $this->loadModel($id, 'view');
        $this->renderOutput($model->getApiOutput());
    }

    /**
     * Generic update action
     * @param string|integer $id primary key of the model
     */
    public function actionUpdate($id) {
        $apiModel = $this->loadModel($id, 'update');
        $apiModel->attributes = $this->getData();

        if ($apiModel->save()) {
            // we want to display all the attributes
            $apiModel->setScenario('view');
            $this->renderOutput($apiModel->getApiOutput());
        } else {
            $this->renderError(400, errs($apiModel->getErrors()));
        }
    }

    /**
     * Delete active record from database
     * @param string|integer $id
     */
    public function actionDelete($id) {
        $apiModel = $this->loadModel($id, 'update');

        if ($apiModel->model->delete()) {
            $this->renderOutput(array('status' => 'OK'));
        }
        $this->renderError(400);
    }

    /**
     * Create new model. This happens by sending POST request to /api/resource url.
     */
    public function actionCreate() {
        $apiModel = $this->getApiResource('create');
        $apiModel->createModel();
        $apiModel->attributes = $this->getData();

        if ($apiModel->save()) {
            // we want to display all the attributes
            $apiModel->setScenario('view');
            $this->renderOutput($apiModel->getApiOutput());
        } else {
            $this->renderError(400, errs($apiModel->getErrors()));
        }
    }

    /**
     * Get instance of API resource, set scenario and get attributes, but don't load it's data yet.
     * @return FrApiResource
     */
    protected function &getApiResource($scenario = null) {
        if ($this->apiResource != null) {
            return $this->apiResource;
        }
        // model should inherit from FrApiResource
        $class = $this->resourceClassName;
        $this->apiResource = new $class($this->module);

        // set all the attributes like limit, offset, timestamp and custom fields,
        // but ignore scenario. All the GET attributes have to get validate first

        $this->apiResource->attributes = $_GET;

        //$this->apiResource->setPostData($this->getData());
        $this->apiResource->scenario = $scenario;
        return $this->apiResource;
    }

    /**
     * Load active record model from database into API Resource and return new API Resource.
     * Usse findOne or findAll functions on existing API resources.
     * Throws 404 if the resource is not found.
     * 
     * @param string|integer $id
     * @param string $scenario
     * @return FrApiResource
     */
    protected function loadModel($id, $scenario = null) {
        // Default controller does not know anything about model - override this function
        $apiModel = $this->getApiResource($scenario);

        if ($apiModel->findOne($id)) {
            return $apiModel;
        }
        $this->renderError(404);
    }

    public function init() {
        parent::init();
        Yii::app()->attachEventHandler('onException', array($this, 'handleError'));
        Yii::app()->attachEventHandler('onError', array($this, 'handleError'));

        if ($this->allowCors) {
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");

            // If OPTIONS call, end app
            $requestType = Yii::app()->request->getRequestType();
            if ($requestType == "OPTIONS") {
                Yii::app()->end();
            }
        }
    }

    /**
     * Action not found - it might be because we are trying to load a resource
     * @param type $actionID
     */
    public function missingAction($actionID) {
        $requestType = Yii::app()->request->getRequestType();

        // Actions without id handled by Base Controller will be forwareded
        if ($this->getId() == $this->module->defaultController) {

            $params = Yii::app()->request->getQueryString();
            // can be create or index
            if ($requestType == "GET") {
                $this->forward($actionID . '/index' . (strlen($params) > 0 ? '?' . $params : ''));
            } else {
                $this->forward($actionID . '/create' . (strlen($params) > 0 ? '?' . $params : ''));
            }
        } else {
            // catch default view/update/delete action when id is not a number
            if (strstr($actionID, '?')) {
                $action = substr($actionID, 0, strpos($actionID, '?'));
            } else {
                $action = $actionID;
            }

            // required for the "this->run()" function to detect the right id
            $_GET['id'] = $action;

            // index action does not have index keyword in valid restful url. It is inserted later
            if ($action == 'index') {
                $this->run('index');
            } else if ($action == 'create' && $requestType == 'POST') {
                $this->run('create');
            } else if ($requestType == 'GET') {
                $this->run('view');
            } else if ($requestType == 'PUT') {
                $this->run('update');
            } else if ($requestType == 'DELETE') {
                $this->run('delete');
            }
            $this->renderError(400);
        }
    }

    /**
     * Function that parses error messages and exceptions into json format
     * and returns them to client.
     * @param CEvent $event
     */
    public function handleError($event) {
        $code = 500;
        if (isset($event->exception)) {
            $message = $event->exception->getMessage();
            if (isset($event->exception->statusCode)) {
                $code = $event->exception->statusCode;
            }
        } else if (isset($event->message)) {
            $message = "Internal Server Error.";
            Yii::log($event->message . ', ' . $event->file . ', ' . $event->line, CLogger::LEVEL_ERROR);
        }
        $tempMessage = CJSON::decode($message);
        if ($tempMessage) {
            $message = $tempMessage;
        }

        $this->renderError($code, $message);
    }

    /**
     * Render HTTP error with custom message. Error codes are defined in API customer
     * 
     * @param integer $code
     * @param string $message
     * @throws CException
     */
    protected function renderError($code, $message = null) {
        if (isset($this->module->errorCodes[$code])) {
            if (is_null($message)) {
                $message = $this->module->errorCodes[$code];
            }
            $this->renderOutput(array('message' => $message), $code);
        } else {
            throw new CException("Using undefined error code $code");
        }
    }

    /**
     * Render data in standartized format using JSON.
     * data is usually associative array for single object
     * or array of arrays.
     * 
     * @param array $data
     * @param integer $code HTTP error code
     * @throws Exception when using a format, which is not implemented yet (jsonp, xml)
     */
    protected function renderOutput($data, $code = 200) {
        // add headers and necessary fields to the output array
        if (isset($this->module->errorCodes[$code])) {
            $message = $this->module->errorCodes[$code];
        } else {
            $message = "N/A";
        }
        $statusString = $code . ' ' . $message;
        header($_SERVER['SERVER_PROTOCOL'] . ' ' . $statusString, true, $code);

        $output = array(
            'code' => $code,
            'timestamp' => time(),
            'data' => $data);

        // send the output out
        if ($this->module->format == 'json') {
            header('content-type: application/json; charset=utf-8');
            echo CJSON::encode($output);
        } else if ($this->module->format == 'jsonp') {
            throw new Exception("not implemented yet", 500);
        } else if ($this->module->format == 'xml') {
            throw new Exception("not implemented yet", 500);
        }
        Yii::app()->end();
    }

    /**
     * Get data submited by the client
     * @return array|false POST array or false if reuest is not found.
     */
    public function getData() {
        // file_get_contents function can get PUT data only once - it has to be cached
        if ($this->postData != null) {
            return $this->postData;
        }
        $request = file_get_contents("php://input");

        if (!empty($request)) {
            $jsonPost = CJSON::decode($request);
            if ($jsonPost) {
                $this->postData = $jsonPost;
            } else {
                $variables = array();
                parse_str($request, $variables);
                $this->postData = $variables;
            }
            return $this->postData;
        } else if (!empty($_POST)) {
            $this->postData = $_POST;
            return $this->postData;
        }
        return false;
    }

    /**
     * The filter method for 'disabled' filter.
     * This filter throws an exception (CHttpException with code 403). Use it to disable udpate/create/delete actions
     * @param CFilterChain $filterChain the filter chain that the filter is on.
     * @throws CHttpException if the current request is not a POST request
     */
    public function filterDisabled($filterChain) {
        throw new CHttpException(403, 'This operation is disabled.');
    }

}
