<?php

/**
 * Model for Items Api Resource
 */
class Items extends FrApiResource {

    // class attributes
    public $id;
    public $type;
    public $name;
    // private variables
    protected $_updateTime;

    public function activeRecordClassName() {
        return 'Item';
    }

    /**
     * Extend default rules that are used to set attributes coming for GET (usually used for filtering)
     * @return type
     */
    public function rules() {
        $rules = parent::rules();
        return CMap::mergeArray($rules, array(
                    // list all the attributes and scenarios here
                    array('id, type, name, updateTime', 'safe', 'on' => 'view,list,recent'),
        ));
    }

    /**
     * Default criteria are always applied to search conditions (list, update, view and delete)
     */
    public function defaultScope() {
        $user = $this->module->getAuthenticatedModel();
        // filter by merchant
        return new CDbCriteria(array(
            'condition' => 't.user_id=:userId',
            'params' => array(':userId' => $user->id)
        ));
    }

    /**
     * When "recent" scenario is set, only the most recent 5 items are returned.
     * @return type
     */
    public function scopes() {
        return array(
            'recent' => array(
                'order' => 'update_time DESC',
                'limit' => 5
            )
        );
    }

    /**
     * Create mapping between the Active Record ($this->model->attributes) and API Resource ($this->attributes).
     * All these attributes will be automatically loaded or saved if the mapping is found and
     * the attribute passes validation. 
     * @return type
     */
    public function attributeMap() {
        return array(
            'id' => 'id',
            'type' => 'item_type',
            'name' => 'item_name',
            'updateTime' => 'update_time'
        );
    }

    /**
     * Getter for updateTime attribute
     * @return int
     */
    public function getUpdateTime() {
        return strtotime($this->_updateTime);
    }

    /**
     * Setter for updateTime attribute
     * @param int $value
     */
    public function setUpdateTime($value) {
        $this->_updateTime = $value;
    }

}
