<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" ng-app="oSystems">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="language" content="en"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>

    <!-- blueprint CSS framework -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css"
          media="screen, projection"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css"
          media="print"/>
    <link rel="stylesheet"
          href="<?php echo Yii::app()->request->baseUrl; ?>/bower_components/bootstrap/dist/css/bootstrap.css">

    <!--[if lt IE 8]>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css"
          media="screen, projection"/>
    <![endif]-->

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css"/>

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css"/>

    <!--   Link Effects   -->
    <link rel="stylesheet" type="text/css"
          href="<?php echo Yii::app()->request->baseUrl; ?>/includes/linkeffects/css/normalize.css"/>
    <link rel="stylesheet" type="text/css"
          href="<?php echo Yii::app()->request->baseUrl; ?>/includes/linkeffects/css/demo.css"/>
    <link rel="stylesheet" type="text/css"
          href="<?php echo Yii::app()->request->baseUrl; ?>/includes/linkeffects/css/component.css"/>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/includes/linkeffects/js/modernizr.custom.js"></script>

    <!-- Angular CSS Injectors -->
    <link rel="stylesheet" type="text/css"
          href="<?php echo Yii::app()->request->baseUrl; ?>/bower_components/ng-notify/dist/ng-notify.min.css"/>
    <link rel="stylesheet" type="text/css"
          href="<?php echo Yii::app()->request->baseUrl; ?>/bower_components/ngDialog/css/ngDialog.min.css"/>
    <link rel="stylesheet" type="text/css"
          href="<?php echo Yii::app()->request->baseUrl; ?>/bower_components/ngDialog/css/ngDialog-theme-plain.css"/>

    <!-- Angular Controllers -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/bower_components/angular/angular.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/app/js/app.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/app/js/routing.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/app/js/site/controllers/siteController.js"></script>

    <!-- Angular Injectors -->
    <script
        src="<?php echo Yii::app()->request->baseUrl; ?>/bower_components/angular-animate/angular-animate.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/bower_components/ng-notify/dist/ng-notify.min.js"></script>
    <script
        src="<?php echo Yii::app()->request->baseUrl; ?>/bower_components/angular-route/angular-route.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/bower_components/ngDialog/js/ngDialog.min.js"></script>


    <!-- Angular Services -->

    <!-- Angular Factories -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/app/js/factories/globals.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/bower_components/underscore/underscore-min.js"></script>

    <!-- Angular Directives -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/app/js/directives/slider/slider.js"></script>
    <style type="text/css">

        #menu-link-effect a {
            font-family: 'Raleway', sans-serif;
            position: relative;
            display: inline-block;
            margin: 10px 10px;
            outline: none;
            color: #fff;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 400;
            text-shadow: 0 0 1px rgba(255, 255, 255, 0.3);
            font-size: 1.10em;
            background: #5E5E5E;
        }

        #menu-link-effect .cl-effect-1 {
            background: #5E5E5E !important;
        }

        nav a:hover,
        nav a:focus {
            outline: none;
        }
    </style>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container-fluid" id="page" style="padding-right: 0px; padding-left: 0px">
    <div  style="width: 100%; z-index: 1000">
        <div id="header" class="row">
            <div id="logo" class="col-sm-2"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/logo.png"></div>
            <div class="col-sm-10">
                <div id="menu-link-effect" style="padding-top: 5px; text-align: right">
                    <section class="color-1">
                        <nav class="cl-effect-1">
                            <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/site/search">Home</a>
                            <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/site/itemlist">Trade Now</a>
                            <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/site/search">Search</a>
                            <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/site/login">Sign Up</a>
                        </nav>
                    </section>
                </div>
            </div>
        </div>
        <!-- mainmenu -->
    </div>
    <?php if (isset($this->breadcrumbs)): ?>
        <?php
        $this->widget('zii.widgets.CBreadcrumbs', array(
            'links' => $this->breadcrumbs,
        ));
        ?><!-- breadcrumbs -->
    <?php endif ?>

    <?php echo $content; ?>

    <div class="clear"></div>

    <div id="footer">
        Copyright &copy; <?php echo date('Y'); ?> by Parasolutions Digital Inc.<br/>
        All Rights Reserved.<br/>
    </div>
    <!-- footer -->

</div>
<!-- page -->

</body>
</html>
