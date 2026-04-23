<?php

class SiteController extends RestController
{
    /**
     * Declares class-based actions.
     */
//    public function actions()
//    {
//        return array(
//            // captcha action renders the CAPTCHA image displayed on the contact page
//            'captcha' => array(
//                'class' => 'CCaptchaAction',
//                'backColor' => 0xFFFFFF,
//            ),
//            // page action renders "static" pages stored under 'protected/views/site/pages'
//            // They can be accessed via: index.php?r=site/page&view=FileName
//            'page' => array(
//                'class' => 'CViewAction',
//            ),
//        );
//    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        $this->render('search');
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionAdmin()
    {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        if (!Yii::app()->user->isGuest) {
            $this->render('admin');
        } else {
            throw new CHttpException(503, "Forbidden Resource");
        }
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    public function actionSearch()
    {
        $this->render('search');
    }

    public function actionItemlist()
    {
        $this->render("itemlist");
    }

    public function actionParseXML()
    {
        $file = '';
//        $feed = file_get_contents();
        $xml = simplexml_load_file("C:/xampp/htdocs" . Yii::app()->request->baseUrl . '/uploads/3774.xml');
//        $this->printa($xml);exit;
        $productlisting = $xml->listing;
        $productArr = array();
        $dealerArr = array();
        $dealerArr['name'] = "$xml->name";
        $dealerArr['phone'] = "$xml->phone";
        $index = 0;

        foreach ($productlisting as $key => $prod) {
            $sku = $prod->stock_number;
            $productArr[$index]['stockNumber'] = "$sku[0]";
            $productArr[$index]['industry'] = "$prod->industry";
            $productArr[$index]['type'] = "$prod->type";
            $productArr[$index]['subtype'] = "$prod->subtype";
            $productArr[$index]['configuration'] = "$prod->configuration";
            $productArr[$index]['model'] = "$prod->model";
            $productArr[$index]['make'] = "$prod->make";
//            $productArr[$index]['model'] = "$conf->model";
            $attrs = $prod->attributes;

            foreach ($attrs->attribute as $a => $attr) {
//                $this->printa($attr);
                if ($attr->attributes()->name == 'Retail Price') {
                    $productArr[$index]['srp'] = "$attr";
                }
                if ($attr->attributes()->name == 'Model Specific') {
                    $productArr[$index]['ms'] = "$attr";
                }
                if ($attr->attributes()->name == 'Year') {
                    $productArr[$index]['year'] = "$attr";
                }
            }

            $index++;
        }
//        exit;
//        echo $productArr['stockNumber'];
//        $this->printa($dealerArr);
//        $this->printa($productArr);exit;
        $this->render("xmltest", array(
            'dealer' => $dealerArr,
            'products' => $productArr
        ));
    }

    /**
     * Displays the contact page
     */
    public function actionContact()
    {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $headers = "From: {$model->email}\r\nReply-To: {$model->email}";
                mail(Yii::app()->params['adminEmail'], $model->subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

    public function actionStatistics()
    {
        $churchcnt = Church::model()->count();
        $rschcnt = ChurchSupplies::model()->count();
        $usercnt = AppUsers::model()->count();
        $this->render('statistics', array(
            'churchcnt' => $churchcnt,
            'rsccnt' => $rschcnt,
//                'eventcnt' => $eventcnt,
            'usercnt' => $usercnt,
        ));
    }

    /**
     * Displays the login page
     */
    public function actionLogin()
    {
        $model = new LoginForm;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
//                        $this->printa($model->attributes);exit;
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login())
                $this->redirect('admin');
        }
        // display the login form
        $this->render('login', array('model' => $model));
    }

    public function login($user)
    {
        $login = new LoginForm;
        $login->username = $user['username'];
        $login->password = $user['password'];
        $login->rememberMe = false;
        $loginArr = array();
        if ($login->validate() && $login->login()) {
            //return is logged in
            $loginArr['isLoggedIn'] = true;
            $loginArr['isGuest'] = Yii::app()->user->isGuest;
            $loginArr['userId'] = Yii::app()->user->getUser('userId');
            $loginArr['name'] = Yii::app()->user->getUser('fullname');
            //$authManager = Yii::app()->authManager;
            return $loginArr;
        }
    }

    /**
     * Retrieves all Jobs inside the Database
     */
    public function productList()
    {
        $jobs = new Products();
        return $jobs->productList();
    }

    public function productListFront()
    {
        $jobs = new Products();
        return $jobs->productListFront();
    }

    /**
     * Retrieves all Jobs inside the Database
     */
    public function applicantList()
    {
        if (isset($_GET['query'])) {
            $query = $_GET['query'];
        } else {
            $query = "";
        }
        $applicants = new Applicants();
        return $applicants->applicantList($query);
    }

    public function checkLogin()
    {
        $loginArr = array();
        if (Yii::app()->user->isGuest === false) {
            $loginArr['isLoggedIn'] = true;
            $loginArr['isGuest'] = Yii::app()->user->isGuest;
            $loginArr['userId'] = Yii::app()->user->getUser('userId');
            $loginArr['name'] = Yii::app()->user->getUser('fullname');
            $loginArr['userName'] = Yii::app()->user->getUser('userName');
            $loginArr['userType'] = Yii::app()->user->getUser('userType');
            return $loginArr;
        } else {
            $loginArr['isLoggedIn'] = false;
            $loginArr['isGuest'] = Yii::app()->user->isGuest;
            $loginArr['userId'] = null;
            $loginArr['name'] = null;
            return $loginArr;
        }
    }

    public function logout()
    {
        $loginArr = array();
        Yii::app()->user->logout();
        $loginArr['isLoggedIn'] = false;
        $loginArr['isGuest'] = Yii::app()->user->isGuest;
        $loginArr['userId'] = null;
        $loginArr['name'] = null;
        return $loginArr;
    }

    public function restEvents()
    {
        $this->onRest('req.post.login.render', function ($data) {

            echo $this->restJsonEncode($this->login($data));
        });
        $this->onRest('req.get.checkLogin.render', function () {
            echo $this->restJsonEncode($this->checkLogin());
        });
        $this->onRest('req.get.logout.render', function () {
            echo $this->restJsonEncode($this->logout());
        });
        $this->onRest('req.post.contactUs.render', function ($data) {

            $email = Yii::app()->email;
            $email->from = $data['email'];
            $email->to = 'gramonotechnology@gmail.com';
            $email->subject = 'Someone sent us a message';
            $email->view = 'contactUs';
            $email->viewVars = array('body'=>$data['message']);
            $email->send();

            $email = Yii::app()->email;
            $email->from = $data['email'];
            $email->to = 'jovelle.ka@gmail.com';
            $email->subject = 'Someone sent us a message';
            $email->view = 'contactUs';
            $email->viewVars = array('body'=>$data['message']);
            $email->send();

            $email = Yii::app()->email;
            $email->from = $data['email'];
            $email->to = 'Gembacrera@gmail.com';
            $email->subject = 'Someone sent us a message';
            $email->view = 'contactUs';
            $email->viewVars = array('body'=>$data['message']);
            $email->send();

            $result = "You have successfully sent a message to us!";

            echo $this->restJsonEncode($result);
        });
        $this->onRest('req.post.uploadPic.render', function () {
//            $this->printa($_POST);exit;
            if ($_FILES['file']['error'] == 1) {
                throw new CHttpException(500, "You picture might be too big!");
            }
            $allow = array("jpg", "jpeg");
            $productId = $_POST['productId'];
            $todir = dirname(__FILE__) . '/../../uploads/' . $productId;

            if (!file_exists($todir)) {
                mkdir($todir, 0777);
            } else {
                chmod($todir, 0777);
            }
            if (!!$_FILES['file']['tmp_name']) { // is the file uploaded yet?
                $info = explode('.', strtolower($_FILES['file']['name'])); // whats the extension of the file
                if (in_array(end($info), $allow)) { // is this file allowed
                    $uploadedFile = $_FILES['file']['tmp_name'];
//                echo end($info); exit;
                    if (end($info) == 'jpg' || end($info) == 'jpeg') {
                        $src = imagecreatefromjpeg($uploadedFile);
                    }
//                if (end($info) == 'png') {
//                    $src = imagecreatefrompng($uploadedFile);
//                }
                    list($width, $height) = getimagesize($uploadedFile);

                    $newwidth = 500;
                    $newheight = ($height / $width) * $newwidth;

                    $category = $product = Products::model()->findByPk($productId)->category;
                    if($category === 'Software Solutions'){
                        $newwidth = 500;
                        $newheight = ($height / $width) * $newwidth;
                    }

                    $tmp = imagecreatetruecolor($newwidth, $newheight);

                    imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

                    if (!file_exists($todir . "/" . $productId . "." . end($info))) {
                        imagejpeg($tmp, $todir . "/" . $productId . "." . end($info), 100);
                    } else {
                        if (unlink($todir . "/" . $productId . "." . end($info))) {
                            imagejpeg($tmp, $todir . "/" . $productId . "." . end($info), 100);
                        }
                    }
                } else {
                    throw new CHttpException(500, "You must only upload jpeg, jpg file extension images");
                }
            }
            exit;
        });
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

}
