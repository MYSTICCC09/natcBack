<?php

/**
 * Base class for API resources. It is handled in similar way to Active Record.
 * 
 * @copyright 2014 FreshRealm
 * @author Ondrej Nebesky <ondrej@freshrealm.co>
 * @author John Grogg <grogg@freshrealm.co>
 * @version 0.91
 * @package FreshRest
 */
class FrApiResource extends CFormModel {

    // GET variables
    /**
     * Database record limit for list view
     * @var integer 
     */
    public $limit = 10;

    /**
     * Database limit / offset
     * @var integer 
     */
    public $offset = 0;

    /**
     * Timestamp for database filtering purposes
     * @var integer|string 
     */
    public $timestamp = 0;

    /**
     * Additional filters applied to the query
     * @var type 
     */
    public $filter;

    /**
     * Attribute used for a filtering by timestamp
     * @var type 
     */
    public $lastUpdateAttribute = 'update_time';

    /**
     * Associated active record
     * @var CActiveRecord 
     */
    protected $model;

    /**
     * Data sent via POST or PUT. Set using setPostData()
     * @var type 
     */
    //protected $postData;

    /**
     * Link to the module instance
     * @var type 
     */
    protected $module;

    /**
     * New instance flag - true for create action
     * @var type 
     */
    public $isNewRecord = false;

    /**
     * Any resource should have access to its module to access data from user and
     * configuration settings necessary to load active records from database
     * @param FrApiBaseModule $module
     */
    public function __construct($module, $scenario = 'setApiParams') {
        parent::__construct($scenario);
        $this->module = $module;
    }

    /**
     * Override this function to set a class name of optional associated active record.
     * @return string
     */
    public function activeRecordClassName() {
        return null;
    }

    /**
     * Basic rules used to set GET attributes from URL.
     * @return type
     */
    public function rules() {
        return array(
            array('limit,offset,timestamp', 'numerical', 'on' => 'setApiParams'),
            array('filter', 'safe', 'on' => 'setApiParams')
        );
    }

    /**
     * Returns criteria model that is always being applied to both findAll() and findOne()
     * function.
     * @return \CDbCriteria
     */
    public function defaultScope() {
        return new CDbCriteria();
    }

    /**
     * DB Criteria that is being applied for different scenarios. Default scenarios
     * are "view", "list", "create", "update". Key can be comma separated list of scenarios
     * or single scenario
     * @return type
     */
    public function scopes() {
        return array();
    }

    /**
     * Load one instance of model or use cached one.
     * @return FrApiResource;
     */
    public function getModel() {
        if ($this->model != null) {
            return $this->model;
        }
        $this->model = $this->findOne();
        return $this->model;
    }

    /**
     * Set POST/PUT data into the resource. Do not update active record yet
     * @param type $data
     */
    /* public function setPostData($data) {
      $this->postData = $data;
      } */

    /**
     * Create new instance of active record model.
     */
    public function createModel() {
        $className = $this->activeRecordClassName();
        $this->model = new $className;
        $this->model->scenario = $this->scenario;
    }

    /**
     * Find one active record and load model and attributes to Api Resource
     * @param type $id
     * @return boolean
     */
    public function findOne($id) {
        if ($this->activeRecordClassName() == null) {
            return false;
        }
        $className = $this->activeRecordClassName();
        $lookupCriteria = $this->getLookupCriteria();
        $lookupCriteria->mergeWith($this->getPkCriteria($id));

        // TODO: use id attribute in custom criteria rather than PK
        $model = $className::model()->find($lookupCriteria);

        if ($model == null) {
            return false;
        }
        $this->model = $model;
        $this->model->scenario = $this->scenario;
        $this->isNewRecord = false;
        $this->loadFromModel($model);
        return true;
    }

    /**
     * Loads array of models using provided cdbcriteria and creates new API resource
     * based on it. New resource will have the same settings (scenario, limit...) as
     * the original one.
     * @return FrApiResource[]
     */
    public function findAll() {
        $output = array();
        if ($this->activeRecordClassName() == null) {
            return $output;
        }

        $className = $this->activeRecordClassName();
        $lookupCriteria = $this->getLookupCriteria();
        $models = $className::model()->findAll($lookupCriteria);

        foreach ($models as $model) {
            // create new instance of API resource that inherits from this class
            $apiModel = new static($this->module);
            $apiModel->scenario = "setApiParams";
            $apiModel->attributes = $this->attributes;
            $apiModel->scenario = $this->scenario;
            $apiModel->model = $model;
            $apiModel->isNewRecord = false;
            $apiModel->loadFromModel($model);
            $output[] = $apiModel;
        }
        return $output;
    }

    /**
     * Override this function if api lookup key is different from active record
     * primary key or multiple fields are used for lookup.
     */
    public function getPkCriteria($id) {
        if ($this->activeRecordClassName() == null) {
            return array();
        }
        $className = $this->activeRecordClassName();
        $alias = $className::model()->getTableAlias();
        $pkAttribute = $alias . '.' . $className::model()->tableSchema->primaryKey;
        $criteria = new CDbCriteria();
        $criteria->addColumnCondition(array(
            $pkAttribute => $id
        ));
        return $criteria;
    }

    /**
     * All criteria merged together:
     * - default
     * - per scenario
     * - limit, offset, timestamp
     * - filters
     * @return type
     */
    private function getLookupCriteria() {
        // start with criteria that has to be always there
        $default = $this->defaultScope();
        $scopes = $this->scopes();

        // apply limit/offest/timestamp
        if ($this->limit > 0) {
            $default->limit = $this->limit;
        }
        if ($this->offset > 0) {
            $default->offset = $this->offset;
        }
        if ($this->timestamp > 0 && $this->lastUpdateAttribute != null) {
            $default->addCondition('t.' . $this->lastUpdateAttribute . ' > FROM_UNIXTIME(' . $this->timestamp . ')');
        }

        if ($this->filter != null) {
            $filterCriteria = $this->filter($this->filter);
            $default->mergeWith($filterCriteria);
        }

        // merge with per-scenario criteria
        foreach ($scopes as $scenarios => $criteria) {
            if ($this->inScenario($scenarios)) {
                $default->mergeWith($criteria);
            }
        }
        return $default;
    }

    /**
     * Is current scenario in a list of provided scenarios? The scenario list is comma separated string.
     * @param type $scenarioList
     * @return boolean
     */
    private function inScenario($scenarioList) {
        if (strstr($scenarioList, ',')) {
            $array = explode(',', $scenarioList);
            foreach ($array as $value) {
                if (trim($value) == $this->scenario) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Load values from Active Record model to API resource model using mapping
     * defined in attributeMap
     * @param CActiveRecord $model
     */
    public function loadFromModel($model) {
        $map = $this->attributeMap();
        $this->model = $model;

        $newAttributes = array();
        foreach ($map as $apiAttribute => $activeAttribute) {
            if ($this->canSetProperty($apiAttribute) || property_exists($this, $apiAttribute)) {
                $newAttributes[$apiAttribute] = $model->$activeAttribute;
            }
        }
        $this->setAttributes($newAttributes, false);

        // let component to set extra attributes
        $this->afterFind($model);
    }

    /**
     * Refresh values of api resource with loaded model.
     */
    public function reloadFromModel() {
        if ($this->model != null) {
            $this->loadFromModel($this->model);
        }
    }

    /**
     * Executy any additional getters after the model is being loaded from database.
     * @param type $model
     */
    public function afterFind($model) {
        
    }

    /**
     * Set attributes from this model back to active record using attribute mapping.
     */
    public function updateModelAttributes() {
        if ($this->model == null) {
            return false;
        }
        $map = $this->attributeMap();
        $newAttributes = array();
        $model = $this->model;
        $modelAttributes = $model->attributes;

        foreach ($map as $apiAttribute => $activeAttribute) {
            if ($this->isAttributeSafe($apiAttribute) &&
                    (array_key_exists($activeAttribute, $modelAttributes) ||
                    $model->canSetProperty($activeAttribute) ||
                    property_exists($model, $activeAttribute))) {
                $newAttributes[$activeAttribute] = $this->$apiAttribute;
            }
        }
        $this->model->attributes = $newAttributes;
        return true;
    }

    /**
     * Load all requested fields and format them into associative array
     * @return type
     */
    public function getApiOutput() {
        $safe = $this->getSafeAttributeNames();
        $output = array();
        foreach ($safe as $attribute) {

            $output[$attribute] = $this->$attribute;
        }
        return $output;
    }

    /**
     * Attribute mapping between API and Active Record
     * @return array of mapping between api attributes (key) and CActiveRecord model attributes (value).
     * Don't forget to override this function if api model and active record does not match exactly.
     */
    public function attributeMap() {
        // Resource not connected to ActiveRecord has to override this function
        if ($this->activeRecordClassName() == null) {
            return array();
        }
        $className = $this->activeRecordClassName();
        $attributes = $className::model()->attributes;

        $output = array();
        foreach ($attributes as $attribute => $value) {
            $output[$attribute] = $attribute;
        }
        return $output;
    }

    /**
     * Besides standard mass setter translate values back to model attributes for
     * active record.
     * @param array $values
     * @param boolean $updateActiveModel we don't want to update model attributes after find
     */
    public function setAttributes($values, $updateActiveModel = true) {
        parent::setAttributes($values, true);
        if ($updateActiveModel) {
            $this->updateModelAttributes();
        }
    }

    /**
     * Extended after validate function from CFormModel that validates associated
     * active record as well
     * @param array $attributes
     * @param boolean $clearErrors
     * @return boolean
     */
    public function afterValidate($attributes = null, $clearErrors = true) {
        if ($this->model != null) {
            if ($this->model->validate()) {
                return true;
            } else {
                $errors = $this->model->getErrors();
                $this->addErrors($errors);
                return false;
            }
        }
        return true;
    }

    /**
     * Function executed before the model is being saved
     */
    public function beforeSave() {
        return true;
    }

    /**
     * Save associated active record. Use beforeSave and afterValidate functions to
     * set extra attributues such as update time and id of authenticated model.
     * Validation runs both on API resource and active record.
     * @param boolean $validate
     * @return boolean
     */
    public function save($validate = true) {

        if ($validate && !$this->validate()) {
            return false;
        }

        if (!$this->beforeSave()) {
            return false;
        }

        $saved = $this->model->save(false);
        // some fields might be updated during save, we want to refresh the current
        // model before returning output
        $this->scenario = 'view'; // TODO: is there a cleaner way?
        $this->loadFromModel($this->model);

        if ($saved) {
            $this->afterSave();
        }

        return true;
    }

    /**
     * Function executed after the model is saved.
     */
    public function afterSave() {
        
    }

    /**
     * Creates cdbcriteria to filter database attributes
     * @param array $filter key value array for column filtering or array of field/operator/value records
     * @return CDbCriteria
     */
    public function filter($filter) {
        $criteria = new CDbCriteria();
        if (empty($filter)) {
            return $criteria;
        }

        $attributes = $this->attributeMap();

        if (!is_array($filter)) {
            $filterItems = CJSON::decode(urldecode($filter));
            if ($filterItems == null) {
                // error parsing JSON string
                return $criteria;
            }
        } else {
            $filterItems = $filter;
        }

        $params = array();
        foreach ($filterItems as $key => $filterItem) {

            $operator = '=';
            if (is_array($filterItem)) {
                if (!isset($filterItem['field']) || !isset($filterItem['value'])) {
                    continue;
                }
                $fieldName = $filterItem['field'];
                $value = $filterItem['value'];
                if (isset($filterItem['operator'])) {
                    $operator = strtolower($filterItem['operator']);
                }
            } else {
                $fieldName = $key;
                $value = $filterItem;
            }

            if (!isset($attributes[$fieldName]) || empty($value)) {
                continue;
            }

            $paramName = ':' . $attributes[$fieldName];
            $dbField = $attributes[$fieldName];

            if (!strstr($dbField, '.')) {
                $dbField = "t." . $dbField;
            }

            if ($operator == '=') {
                $criteria->addColumnCondition(array($dbField => $value));
            } else {
                switch ($operator) {
                    case 'not in':
                        $criteria->addNotInCondition($dbField, $value);
                        break;
                    case 'in':
                        $criteria->addInCondition($dbField, $value);
                        break;
                    case 'like':
                        //$compare = " LIKE :" . $prop;
                        $params[$paramName] = '%' . $value . '%';
                        $criteria->addCondition("$dbField LIKE %$paramName%");
                        break;
                    case '=' :
                    case '<' :
                    case '<=':
                    case '>' :
                    case '!=':
                    case '<>':
                    case '>=':
                        $params[$paramName] = $value;
                        $criteria->addCondition("$dbField $operator $paramName");
                        break;
                    default :
                        $params[$paramName] = $value;
                        $criteria->addCondition("$dbField=$paramName");
                        break;
                }
            }
        }
        $criteria->params = CMap::mergeArray($criteria->params, $params);

        return $criteria;
    }

    /**
     * Create a link to API resource
     * @param type $resource
     * @param type $id
     * @param type $params
     * @return string
     */
    public function getApiUrl($resource = null, $id = null, $params = '') {
        $url = $this->module->baseUrl . '/' . $resource . ($id == null ? '' : '/' . $id);
        $key = $this->module->getAuthKey();
        if (strlen($key)) {
            $url .= "?key=" . $key;
        }
        if (strlen($params)) {
            $url .= '&' . $params;
        }
        return $url;
    }

}
