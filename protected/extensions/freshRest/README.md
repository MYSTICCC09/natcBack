![FreshRealm](http://freshrealm.co/img/FRLogo80.png)

# FreshRest
FreshRest is an elegant Yii extension and module which enables easy RESTful interface development following best practices.

The extension contains three basic building blocks: **module** based API interfaces, API action **controllers**, and API **resource** models. 

* Multiple API interfaces can be created as separate **modules**, allowing for easy versioning maintenance and siloing of access. 
* **controllers** automatically handle CRUD operations on **resource** models, and easily allow the addition of custom actions. 
* API **resources** is an enhancement to Active Record and contains mapping between active record and the RESTful API.

Project Page: <https://bitbucket.org/onebesky/freshrest>

# Installation

* copy extension files to /extensions/freshRest
* create a module to act as the defenition of your api (i.e. /modules/api1). The included example module can help you get started.
* add the module to your yii configuration file

## Example yii configurations

routes for subdomain version accessed as _api1.myproject.com_:

```php
<?php
'components' => array(
    'urlManager' => array(
        'rules' => array(
            // custom actions in resource controller
            array('api1/<controller>/<action>', 'pattern' => 'http://api1.*/<controller:\w+>/<action:\w+>/<id:\d+>'),
            // crud for resource controller
            array('api1/<controller>/<action>', 'pattern' => 'http://api1.*/<controller:\w+>/<action:\w+>'),
            // everything else goes to the default controller
            array('api1/default/<action>', 'pattern' => 'http://api1.*/<action:\w+>'),
        ),
    ),
),
```

routes for simple path version accessed as _myproject.com/api1_:

```php
<?php
'components' => array(
    'urlManager' => array(
        'rules' => array(
            // custom actions in resource controller
            array('api1/<controller>/<action>', 'pattern' => 'api1/<controller:\w+>/<action:\w+>/<id:\d+>'),
            // crud for resource controller
            array('api1/<controller>/<action>', 'pattern' => 'api1/<controller:\w+>/<action:\w+>'),
            // everything else goes to the default controller
            array('api1/default/<action>', 'pattern' => 'api1/<action:\w+>'),
        ),
    ),
),
```

enable module:

```php
<?php
'modules' => array(
    // name and version of the module
    'api1' => array(
        'class' => 'application.modules.api1.ApiModule',
        // optional configuration:        
        'baseUrl' => 'api.myproject.com', // skip to use path format myproject.com/api1
        'lastUpdateAttribute' => 'update_time', // DATETIME field that contains last update time of active record
        'format' => 'json', // only json is supported so far 
        'authModelClass' => 'FrAuthModel', // override this class to change authentication behavior
        'myAuthenticatedModelClass' => 'Organization', // active record that used for login
        'myAuthenticatedModelPasswordField' => 'api_password',
    ),
),
```

# How to Use

## Recommended RESTful reading
Ebook from Apigee: <http://apigee.com/about/api-best-practices>. 

## Actions and Verbs

Resources should be named in plural. If database table name is `project` and active record class name is `Project`, then name your API resource `projects`.
This way we will result in the following urls:

|HTTP Method  |URL            |Description           |
|-------------|---------------|----------------------|
|GET          |/projects      |list of all projects  |
|GET          |/projects/5547 |view one project only |
|POST         |/projects      |create new project    |
|PUT          |/projects/5547 |update one project    |
|DELETE       |/projects/5547 |delete one project    |


## Offset and Limit
The extension supports offset and limit data selection options passed in via the URL: `limit=100&offset=50` will display 100 records starting with record 51.

## Timestamp Filter
Timestamp filter is useful for data synchronization. Every response contains a `timestamp` field that can be passed into the next request to load only
data changed since the previous request. To enable this behavior all related active records need to have a timestamp column (for example `update_time`) that is
updated with each active record change - typically in the `beforeSave()` function.

Usage: `/api1/items?timestamp=1394048408`

## User Defined Filters
The filter GET attribute enables search functionality and is applied on top of the default class lookup criteria.
This attribute can be a simple array("column"=>"value") column filter or more complex expression.
For example, a json representation of the filter GET attribute that one would use to filter for zipcode 93xxx is:

```json
[
    {
        field: 'zipcode',
        operator: '>',
        value: 93000
    },
    {
        field: 'zipcode',
        operator: '<',
        value: 94000  
    }
]
```

## Versions

The base url can be either subdomain (api1.myproject.com) or path (myproject.com/api1). With any significant changes to the interface.

## Authentication
The built-in authentication uses a combination of an authentication token loaded from the url and the ip address to authenticate each request.
It is attached to active record through a polymorphic connection. Using the authentication component also gives you access to the authenticated model in any API resource.

### Setup
1. Create a password field in a table that represents a client (i.e. user or organization). In the module configuration add the following attributes:

```php
<?php
// module setup
'api1' => array(
    'myAuthenticatedModelClass' => 'Organization', // active record class that will be available in all models after authentication
    'myAuthenticatedModelPasswordField' => 'api_secret' // table field that contains “secret” password
),
```

2. Enable the Auth Filter by adding it to each controller:

3. Create "api_secret" column in your authenticated model table (i.e. Organization or User). There should be also an user interface on random string generator in beforeSave function to populate this field.

```php
<?php
public function filters() {
    return array(
        array(
            'ext.freshRest.FrAuthFilter'
        )
    );
}
```

### Authentication Process
1. Get the authentication token
    * call authenticate action in the default controller passing password through POST (and preferably ssl too)
    * `FrAuthModel` compares the password to the one stored in the database based on your module configuration
    * `FrAuthModel` creates a new record with the authentication token and IP address

2. Use the token
  There are three supported methods:

  a) add `&key=randomauthneticationtoken` to the request url or POST/PUT data

  b) add `&token=randomauthneticationtoken` to the request url or POST/PUT data

  c) add Authorization HTTP header into request
     curl example: $options[CURLOPT_HTTPHEADER] = array('Authorization: Bearer ' . $randomauthneticationtoken);

# Module Development

## Controllers
Controllers inherit from the `FrApiBaseController` class.
Each action translates directly into a controller action. The default controller `DefaultController.php` handles
authentication and the root index action. It should also have all actions that are not resource related. For example, `calculateDistance($latituedA, $longitudeA, $latituedB, $longitudeB)`.
These actions should use verbs.

Any other controller manages one API Resource. For instance, ProjectsController.php would handle all CRUD actions for the Projects api resource. 
Index, view, update, create, and delete actions work out of the box, but can be customized by redefining the action within the resource controller. 
The controller looks for a model that has the same name, but it can be modified by overriding the `resourceClassName` class variable.
This type of controller will also manage any non-CRUD actions that are resource related. For example, `/api1/projects/deploy/5562` will trigger `actionDeploy($id){...}`.

You can use yii filters in any controller to enforce authentication, disable an action, or accept only post requests.

```php
<?php
public function filters() {
    return array(
        // disable builtin actions
        'disabled +delete, update, create',
        // action receiveGoods can be submitted only through POST
        'postOnly +receiveGoods',
        // enable authentication
        array(
            'ext.freshRest.FrAuthFilter'
        )
    );
}
```

## Models
Models (API Resources) inherit from the `FrApiResource` class. They can be connected to active record or act as standalone form models.
Basic setup requires all the attributes to be defined as a public property and list them all in the `rules()` function.

To integrate with active record two functions must be implemented: `activeRecordClassName()`, which returns a string name for the active record model, and `attributeMap()`, 
which returns a mapping array between the active record attributes (key) and the api resource attributes (value). This function maps attributes 1:1 by default.

### Scenarios
Scenarios are used to display or accept different attributes in different actions. Also, they can create different lookup criteria for different actions.

**Built-in scenarios:**

* create - called from create action
* update - called from update action
* list   - called from list (index) action
* view   - called from view action and as a result of successful create or update action
* setApiParams - used before the model is loaded to pass additional GET attributes to the class

**Use Cases**

Display extra attributes during the view action

```php
<?php
public function rules() {
    $rules = parent::rules();
    return CMap::mergeArray($rules, array(
                array('id, name', 'safe', 'on' => 'view,list'),
                array('valueThatIsExpensiveToLoad', 'safe', 'on' => 'view'),
    ));
}
```

Disable email attribute update by default, but allow it on create

```php
<?php
public function rules() {
    $rules = parent::rules();
    return CMap::mergeArray($rules, array(
                array('id, name, email', 'safe', 'on' => 'view,list'),
                array('name, email', 'safe', 'on' => 'create'),
                array('name', 'safe', 'on' => 'update'),
    ));
}
```

Don't include records with status="new" in the default list view, but include them in
newRecords action:

```php
<?php
public function scopes(){
    return array(
        'list' => array(
            'condition' => 'status!="new"'
        ),
        'newRecords' => array(
            'condition' => 'status="new"'
        )
    );
}
```

### Scopes
Extra search criteria are useful when the API is supposed to work only with records that
belong to the authenticated user. Default criteria are used for both single and list views.
Additional per-scenario criteria can be specified in `scopes()` function.

```php
<?php
public function defaultScope() {
    // get the user that is currently authenticated
    $user = $this->module->getAuthenticatedModel();
    return new CDbCriteria(array(
        // use "with" to enforce eager loading and speed up the api 
        'with' => array(
            'comments',
        ),
        // newest first
        'order' => 't.update_time DESC',
        // limit to results for this user only
        'condition' => 't.user_id=:userId',
        'params' => array(':userId' => $user->id)
    ));
}
```

### Virtual Getters and Setters
Some fields should be presented in a different way than they are stored within the database. See the following timestamp example:

#### Translated Active Record Example

```php
<?php
class Posts extends FrApiResource {
    /**
    * Private variable that stores time in unix timestamp format
    */
    protected $_updateTime;

    public function rules() {
        $rules = parent::rules();
        return CMap::mergeArray($rules, array(
                    array('updateTime', 'numerical', 'integerOnly' => true, 'on' => 'view,list,update'),
        ));
    }

    /**
     * Connects our _updateTime to the active record's update_time field
     */
    public function attributeMap() {
        return array(
            'updateTime' => 'update_time'
        );
    }

    /**
    * Getter for updateTime
    */
    public function getUpdateTime(){
        if ($this->scenario=="update"){
            // the input is coming from user and is returned back to active record
            return date('Y-m-d H:i', $this->_updateTime);
        } else {
            // api time is represented as unix timestamp
            return $this->_updateTime;
        }
    }

    /**
    * Setter for updateTime
    */
    public function setUpdateTime($value){
        if (is_int($value)){
            // Field is already stored as a timestamp
            $this->_updateTime = $value;
        } else {
            // Field is a datetime string, so convert it to a timestamp
            $this->_updateTime = strtotime($value);
        }
    }
}
```

Notice that there is no `updateTime` attribute defined in the class. The user input value is stored into the private `_updateTime` variable.
For more details see Yii documentation: <http://www.yiiframework.com/wiki/167/understanding-virtual-attributes-and-get-set-methods/>.

#### Nested Data Example using FrApiResouce sub model

If we want to display a list of all comments in a post resource. We will need two models within our api module: `Posts` and `Comments`.
Both inherit FrApiResource class.

```php
<?php
class Posts extends FrApiResource {

    /**
    * @var Comments Api resource for comment model, temporary storage
    */
    protected $_comments;
    /**
    * Get list of all comments in api format.
    */
    public function getComments(){
        if ($this->_comments == null){
            $this->_comments = array();
            // use relation from post model to load comments
            foreach ($this->model->comments as $model) {
                // each api resource needs to be created with the module instance
                $_comment = new Comments($this->module, $this->scenario);
                // load the comment's data into the object
                $_comment->loadFromModel($model);
                // add it to post model
                $this->_comments[] = $_comment;
            }
        }
        // prepare output as simple array
        $output = array();
        foreach ($this->_comments as $comment){
            $output[] = $comment->getApiOutput();
        }
        return $output;
    }
    
    /**
    * Set comments
    */
    public function setComments(){
        if (!is_array($value)){
            return;
        }
        $this->_comments = array();
        foreach ($value as $comment) {
            // each api resource needs to be created with the module instance
            $_comment = new Comments($this->module, $this->scenario);
            // the comment is passed in as an array in API format. If it is active record we could use $_comment->loadFromModel($comment) instead
            $_comment->attributes = $comment;
            $this->_comments[] = $_comment;
        }
    }
}
```

#### Nested Data Example using virtual getters

```php
<?php
getComments(){
    // load all comments using relation
    $comments = $this->model->comments;
    $output = array();
    foreach ($comments as $comment) {
        // return whole attributes array 
        // $output[] = $comment->attributes;
        // or just selected attributes
        $output[] = array('id' => $comment->id, 'text' => $comment->text);
    }
    return $output;
}
```

### Processing User Input
Use the built-in `beforeValidate()`, `afterValidate()`, `beforeSave()`, and `afterSave()` functions to modify the model before it is being saved.
Create and update process is execute in the following order:

1. find or create the model
2. execute afterFind()
3. set attributes on the API Resource - only safe attributes will be applied
    * set attributes from API Resource to Active Record
4. validate the API Resource (and execute before validate)
5. validate the Active Record
6. save the Active Record
7. change scenario to "view" and render the API Resource

There are a couple of places where additional data processing can happen:
 
**afterFind()** to prepare data after the model is loaded from the database

**beforeValidate()** to process data directly passed to the API Resource and set attributes to Active Record for fields that require additional validation

**afterValidate()** to update attributes of the Active Record that are not directly mapped using attributeMap() and do not require validation

