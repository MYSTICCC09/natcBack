<?php

/**
 * Base class for any API module. This class should be extended in the module itself.
 * 
 * @copyright 2014 FreshRealm
 * @author Ondrej Nebesky <ondrej@freshrealm.co>
 * @author John Grogg <grogg@freshrealm.co>
 * @version 0.9
 * @package FreshRest
 */
class FrApiBaseModule extends CWebModule {

    public $version = 1;
    public $format = 'json';

    /**
     * Attribute used to find the last update time of active record in database.
     * This attribue is compared to "timestamp" parameter in api for syncing only
     * changed records with client.
     * @var string 
     */
    public $lastUpdateAttribute = 'update_time';

    /**
     * @var string string the id of the default controller for this module.
     */
    public $defaultController = 'default';

    /**
     * Url used to construct links for api that include authentication token
     * @var type 
     */
    public $baseUrl = null;
    public $schema = 'http';

    /**
     * Name of the authentication table that will be created the first time
     * this module is being used. Set to empty string or null to disable builtin
     * authentication
     * @var string 
     */
    public $authTableName = "fr_api_device";
    public $authModelClass = "FrAuthModel";
    public $myAuthenticatedModelClass = '';
    public $myAuthenticatedModelPasswordField = '';
    public $authCacheDuration = 3600; // one hour
    protected $authData;
    protected $authModel;
    protected $authenticatedModel;
    public $errorCodes = array(
        200 => 'OK',
        400 => 'Bad Request',
        401 => 'Access Denied',
        403 => 'Token key is not valid',
        404 => 'Resource Not Found',
        500 => 'Internal Server Error',
        501 => 'Not Implemented'
    );

    /**
     * How is access token being passed to api module
     * http_bearer: the token is stored in request header Authorization: Bearer __token__
     * url_token: token is passed in url via key=__token__ or token=__token__
     * @var type 
     */
    public $supportedAuth = array(
        'http_bearer',
        'url_token'
    );

    protected function getAuthData() {
        if ($this->authData != null) {
            return $this->authData;
        }
        $modelClass = $this->authModelClass;

        $this->authData = array(
            'ipAddress' => $_SERVER['REMOTE_ADDR'],
            'method' => $_SERVER['REQUEST_METHOD'],
            'token' => null
        );

        if (in_array('url_token', $this->supportedAuth)) {
            if (isset($_GET['key'])) {
                $this->authData['token'] = $_GET['key'];
            } else if (isset($_GET['token'])) {
                $this->authData['token'] = $_GET['token'];
            }

            // auth token passed via PUT
            if (!$this->authData['token']) {
                $data = Yii::app()->controller->getData();
                if (isset($data['token'])) {
                    $this->authData['token'] = $data['token'];
                }
            }
        }

        if ($this->authData['token'] == null && in_array('http_bearer', $this->supportedAuth)) {
            $headers = getallheaders();
            if (isset($headers['Authorization']) && preg_match("/^Bearer\\s+(.*?)$/", $headers['Authorization'], $matches)) {
                $this->authData['token'] = $matches[1];
            }
        }

        $this->authModel = new $modelClass($this, $this->authData);
        return $this->authData;
    }

    public function getAuthModel() {
        if ($this->authModel != null) {
            return $this->authModel;
        }
        $this->getAuthData();
        return $this->authModel;
    }

    /**
     * Return authenticated active record
     * @return CActiveRecord
     */
    public function getAuthenticatedModel() {
        $auth = $this->getAuthModel();
        return $auth->getModel();
    }

    public function getAuthKey() {
        $data = $this->getAuthData();
        return $data['token'];
    }

    public function getIpAddress() {
        $data = $this->getAuthData();
        return $data['ipAddress'];
    }

    public function init() {
        $id = $this->id;
        $this->setImport(
                array(
                    "application.modules.$id.components.*",
                    "application.modules.$id.controllers.*",
                    "application.modules.$id.models.*",
                )
        );
        $this->installAuthSchema();

        // construct default url
        if ($this->baseUrl == null) {
            $this->baseUrl = Yii::app()->createAbsoluteUrl('/' . $this->getId(), array(), $this->schema);
        }
        if (substr($this->baseUrl, 0, 4) != 'http') {
            $this->baseUrl = $this->schema . '://' . $this->baseUrl;
        }
    }

    public function getVersion() {
        return $this->version;
    }

    /**
     * Check for existence of databse table that stores temporary auth tokens
     * and create it if it doesn't exist.
     * @return null
     */
    public function installAuthSchema() {
        if (strlen($this->authTableName) == 0) {
            return;
        }
        $tableSchema = Yii::app()->db->schema->getTable($this->authTableName);
        if ($tableSchema == null) {
            $createSql = Yii::app()->db->schema->createTable($this->authTableName, array(
                'id' => 'int(11) unsigned not null auto_increment primary key',
                'token' => 'varchar(63)',
                'ip_address' => 'varchar(45)',
                'update_time' => 'datetime',
                'connected_type' => 'varchar(45)',
                'connected_id' => 'string'
            ));
            Yii::app()->db->createCommand($createSql)->execute();
        }
    }

    /**
     * Create resource absolute url
     * @param string $resource relative path to end point
     * @return string
     */
    public function getUrl($resource = '') {
        return$this->baseUrl . '/' . $resource;
    }

}

/**
 * getallheaders is not implemented for fastcgi for php 5.3 and nginx
 */
if (!function_exists('getallheaders')) {

    function getallheaders() {
        $headers = '';
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
        return $headers;
    }

} 