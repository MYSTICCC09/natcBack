<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/includes/grid/css/normalize.css"/>
<link rel="stylesheet" type="text/css"
      href="<?php echo Yii::app()->request->baseUrl; ?>/includes/grid/fonts/font-awesome-4.3.0/css/font-awesome.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/includes/grid/css/style1.css"/>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/includes/grid/js/modernizr.custom.js"></script>

<style>
    body{
        font-family: 'Raleway', sans-serif !important;
    }
    a:hover{
        text-decoration: none;
    }
    a{
        max-height: 400px;
    }
    .main{
        margin-left: 0px !important;
    }
    .sidebar{
        width: 0px;
        padding: 0px;
    }
</style>

<button id="menu-toggle" class="menu-toggle"><span>Menu</span></button>
    <div id="theSidebar" class="sidebar">

    </div>
<div id="theGrid" class="main">
<section class="grid">
<header class="top-bar">
    <h2 class="top-bar__headline">Latest Posts</h2>
    <div class="filter">
        <span>Filter by:</span>
        <span class="dropdown">Popular</span>
    </div>
</header>
<a class="grid__item" href="#">
    <div style="height: 250px; background: url('<?php echo Yii::app()->request->baseUrl; ?>/images/banner/omega.png') no-repeat center; width: 100%">
    </div>
    <div class="meta meta--preview">
        <br><span>Rolex for Phone!</span><br>
        <span class="meta__date"><i class="fa fa-calendar-o"></i> 9 Apr</span>
        <span class="meta__reading-time"><i class="fa fa-clock-o"></i> 3 min read</span>
    </div>
</a>
<a class="grid__item" href="#">
    <div style="height: 250px; background: url('<?php echo Yii::app()->request->baseUrl; ?>/images/banner/phone.jpeg') no-repeat center; width: 100%">
    </div>
    <div class="meta meta--preview">
        <br><span>Iphone5 for sofa!</span><br>
        <span class="meta__date"><i class="fa fa-calendar-o"></i> 9 Apr</span>
        <span class="meta__reading-time"><i class="fa fa-clock-o"></i> 3 min read</span>
    </div>
</a>
<a class="grid__item" href="#">
    <div style="height: 250px; background: url('<?php echo Yii::app()->request->baseUrl; ?>/images/banner/laptop.png') no-repeat center; width: 100%">
    </div>
    <div class="meta meta--preview">
        <br><span>My laptop in for trades!</span><br>
        <span class="meta__date"><i class="fa fa-calendar-o"></i> 9 Apr</span>
        <span class="meta__reading-time"><i class="fa fa-clock-o"></i> 3 min read</span>
    </div>
</a>
<a class="grid__item" href="#">
    <div style="height: 250px; background: url('<?php echo Yii::app()->request->baseUrl; ?>/images/banner/piano.gif') no-repeat center; width: 100%">
    </div>
    <div class="meta meta--preview">
        <br><span>My old piano</span><br>
        <span class="meta__date"><i class="fa fa-calendar-o"></i> 9 Apr</span>
        <span class="meta__reading-time"><i class="fa fa-clock-o"></i> 3 min read</span>
    </div>
</a>
<a class="grid__item" href="#">
    <div style="height: 250px; background: url('<?php echo Yii::app()->request->baseUrl; ?>/images/banner/screen.jpg') no-repeat center; width: 100%">
    </div>
    <div class="meta meta--preview">
        <br><span>My Monitor</span><br>
        <span class="meta__date"><i class="fa fa-calendar-o"></i> 9 Apr</span>
        <span class="meta__reading-time"><i class="fa fa-clock-o"></i> 3 min read</span>
    </div>
</a>
<a class="grid__item" href="#">
    <div style="height: 250px; background: url('<?php echo Yii::app()->request->baseUrl; ?>/images/banner/table.jpg') no-repeat center; width: 100%">
    </div>
    <div class="meta meta--preview">
        <br><span>My Table</span><br>
        <span class="meta__date"><i class="fa fa-calendar-o"></i> 9 Apr</span>
        <span class="meta__reading-time"><i class="fa fa-clock-o"></i> 3 min read</span>
    </div>
</a>

<footer class="page-meta">
    <span>Load more...</span>
</footer>
</section>

<section class="content" style="position: absolute">
<div class="scroll-wrap" style="">
<article class="content__item">
<!--    <span class="category category--full">Stories for humans</span>-->
<!--    <h2 class="title title--full">On Humans &amp; other Beings</h2>-->
<!--    <div class="meta meta--full">-->
<!--        <img class="meta__avatar" src="img/authors/1.png" alt="author01" />-->
<!--        <span class="meta__author">Matthew Walters</span>-->
<!--        <span class="meta__date"><i class="fa fa-calendar-o"></i> 9 Apr</span>-->
<!--        <span class="meta__reading-time"><i class="fa fa-clock-o"></i> 3 min read</span>-->
<!--    </div>-->
    <div class="row">
        <div class="col-md-5 col-lg-5">
            <h2 class="">Rolex for Phone!</h2>
            <img class="img-responsive title title--full " src="<?php echo Yii::app()->request->baseUrl; ?>/images/banner/omega.png" alt="item" />
            <br>
            <div class="row">
                <div class="col-xs-6 col-md-3">
                    <a href="#" class="thumbnail">
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/banner/omega.png" alt="...">
                    </a>
                </div>
                <div class="col-xs-6 col-md-3">
                    <a href="#" class="thumbnail">
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/banner/omega.png" alt="...">
                    </a>
                </div>
                <div class="col-xs-6 col-md-3">
                    <a href="#" class="thumbnail">
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/banner/omega.png" alt="...">
                    </a>
                </div>
                <div class="col-xs-6 col-md-3">
                    <a href="#" class="thumbnail">
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/banner/omega.png" alt="...">
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-7 col-lg-7">
            <div class="row">
                <div class="col-md-2 col-lg-2">
                    <br>
                    <img style="border: 4px solid #C69C3D" src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/user.png" alt="..." class="img-circle img-responsive center-block">
                </div>
                <div class="col-md-5 col-lg-5">
                    <h3>Ohmel Paguirigan</h3>
                    <u>facebook.com/ohmel.paguirigan</u><br>
                    ps.ocpaguirigan@gmail.com<br>
                    09163013924<br>
                </div>
                <div class="col-md-5 col-lg-5">
                    <h3 class="">Preferred Meetups</h3>
                    <ul>
                        <li>Manila</li>
                        <li>Mandaluyong</li>
                        <li>Ortigas</li>
                    </ul>
                </div>
            </div>
            <h3 class="">Product Description</h3>
            <p style="font-size: 14px;">Faulty psychic actions, dreams and wit are products of the unconscious mental activity, and like neurotic or psychotic manifestations represent efforts at adjustment to one’s environment. </p>
            <h3 class="">Trade for</h3>
            <ul>
                <li>sdfhsdjhfdjks</li>
            </ul>
            <h3 class="">Tags</h3>
            <span class="label label-info tags">Watches</span>
            <span class="label label-info tags">Gadgets</span>
            <span class="label label-info tags">Accessories</span>
        </div>
    </div>
    <div>
        <h2>Comments</h2>
        <div class="row">
            <div class="col-xs-1 col-md-1 col-lg-1">
                <br>
                <img style="border: 4px solid #C69C3D; width: 100px" src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/user.png" alt="..." class="img-circle img-responsive center-block">
            </div>
            <div class="col-md-11 col-lg-11">
                <p style="font-size: 14px;">Faulty psychic actions, dreams and wit are products of the unconscious mental activity, and like neurotic or psychotic manifestations represent efforts at adjustment to one’s environment. </p>

            </div>

        </div>
        <br>
        <div>
            <textarea class="form-control" rows="3"></textarea>
        </div>
    </div>
</article>
<article class="content__item">
    <div class="row">
        <div class="col-md-5 col-lg-5">
            <h2 class="">Iphone for Sofa!</h2>
            <img class="img-responsive title title--full " src="<?php echo Yii::app()->request->baseUrl; ?>/images/banner/phone.jpeg" alt="item" />
            <br>
            <div class="row">
                <div class="col-xs-6 col-md-3">
                    <a href="#" class="thumbnail">
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/banner/phone.jpeg" alt="...">
                    </a>
                </div>
                <div class="col-xs-6 col-md-3">
                    <a href="#" class="thumbnail">
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/banner/phone.jpeg" alt="...">
                    </a>
                </div>
                <div class="col-xs-6 col-md-3">
                    <a href="#" class="thumbnail">
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/banner/phone.jpeg" alt="...">
                    </a>
                </div>
                <div class="col-xs-6 col-md-3">
                    <a href="#" class="thumbnail">
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/banner/phone.jpeg" alt="...">
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-7 col-lg-7">
            <div class="row">
                <div class="col-md-2 col-lg-2">
                    <br>
                    <img style="border: 4px solid #C69C3D" src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/user.png" alt="..." class="img-circle img-responsive center-block">
                </div>
                <div class="col-md-5 col-lg-5">
                    <h3>Ohmel Paguirigan</h3>
                    <u>facebook.com/ohmel.paguirigan</u><br>
                    ps.ocpaguirigan@gmail.com<br>
                    09163013924<br>
                </div>
                <div class="col-md-5 col-lg-5">
                    <h3 class="">Preferred Meetups</h3>
                    <ul>
                        <li>Manila</li>
                        <li>Mandaluyong</li>
                        <li>Ortigas</li>
                    </ul>
                </div>
            </div>
            <h3 class="">Product Description</h3>
            <p style="font-size: 14px;">Faulty psychic actions, dreams and wit are products of the unconscious mental activity, and like neurotic or psychotic manifestations represent efforts at adjustment to one’s environment. </p>
            <h3 class="">Trade for</h3>
            <ul>
                <li>sdfhsdjhfdjks</li>
            </ul>
            <h3 class="">Tags</h3>
            <span class="label label-info tags">Phone</span>
            <span class="label label-info tags">Iphone</span>
            <span class="label label-info tags">Mobile</span>
        </div>
    </div>
    <div>
        <h2>Comments</h2>
        <div class="row">
            <div class="col-xs-1 col-md-1 col-lg-1">
                <br>
                <img style="border: 4px solid #C69C3D; width: 100px" src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/user.png" alt="..." class="img-circle img-responsive center-block">
            </div>
            <div class="col-md-11 col-lg-11">
                <p style="font-size: 14px;">Faulty psychic actions, dreams and wit are products of the unconscious mental activity, and like neurotic or psychotic manifestations represent efforts at adjustment to one’s environment. </p>

            </div>

        </div>
        <br>
        <div>
            <textarea class="form-control" rows="3"></textarea>
        </div>
    </div>
</article>
<article class="content__item">
    <div class="row">
        <div class="col-md-5 col-lg-5">
            <h2 class="">Laptop for trades!</h2>
            <img class="img-responsive title title--full " src="<?php echo Yii::app()->request->baseUrl; ?>/images/banner/laptop.png" alt="item" />
            <br>
            <div class="row">
                <div class="col-xs-6 col-md-3">
                    <a href="#" class="thumbnail">
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/banner/laptop.png" alt="...">
                    </a>
                </div>
                <div class="col-xs-6 col-md-3">
                    <a href="#" class="thumbnail">
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/banner/laptop.png" alt="...">
                    </a>
                </div>
                <div class="col-xs-6 col-md-3">
                    <a href="#" class="thumbnail">
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/banner/laptop.png" alt="...">
                    </a>
                </div>
                <div class="col-xs-6 col-md-3">
                    <a href="#" class="thumbnail">
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/banner/laptop.png" alt="...">
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-7 col-lg-7">
            <div class="row">
                <div class="col-md-2 col-lg-2">
                    <br>
                    <img style="border: 4px solid #C69C3D" src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/user.png" alt="..." class="img-circle img-responsive center-block">
                </div>
                <div class="col-md-5 col-lg-5">
                    <h3>Ohmel Paguirigan</h3>
                    <u>facebook.com/ohmel.paguirigan</u><br>
                    ps.ocpaguirigan@gmail.com<br>
                    09163013924<br>
                </div>
                <div class="col-md-5 col-lg-5">
                    <h3 class="">Preferred Meetups</h3>
                    <ul>
                        <li>Manila</li>
                        <li>Mandaluyong</li>
                        <li>Ortigas</li>
                    </ul>
                </div>
            </div>
            <h3 class="">Product Description</h3>
            <p style="font-size: 14px;">Faulty psychic actions, dreams and wit are products of the unconscious mental activity, and like neurotic or psychotic manifestations represent efforts at adjustment to one’s environment. </p>
            <h3 class="">Trade for</h3>
            <ul>
                <li>sdfhsdjhfdjks</li>
            </ul>
            <h3 class="">Tags</h3>
            <span class="label label-info tags">Phone</span>
            <span class="label label-info tags">Iphone</span>
            <span class="label label-info tags">Mobile</span>
        </div>
    </div>
    <div>
        <h2>Comments</h2>
        <div class="row">
            <div class="col-xs-1 col-md-1 col-lg-1">
                <br>
                <img style="border: 4px solid #C69C3D; width: 100px" src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/user.png" alt="..." class="img-circle img-responsive center-block">
            </div>
            <div class="col-md-11 col-lg-11">
                <p style="font-size: 14px;">Faulty psychic actions, dreams and wit are products of the unconscious mental activity, and like neurotic or psychotic manifestations represent efforts at adjustment to one’s environment. </p>

            </div>

        </div>
        <br>
        <div>
            <textarea class="form-control" rows="3"></textarea>
        </div>
    </div>
</article>
<article class="content__item">
    <div class="row">
        <div class="col-md-5 col-lg-5">
            <h2 class="">Piano for trades</h2>
            <img class="img-responsive title title--full " src="<?php echo Yii::app()->request->baseUrl; ?>/images/banner/piano.gif" alt="item" />
            <br>
            <div class="row">
                <div class="col-xs-6 col-md-3">
                    <a href="#" class="thumbnail">
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/banner/piano.gif" alt="...">
                    </a>
                </div>
                <div class="col-xs-6 col-md-3">
                    <a href="#" class="thumbnail">
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/banner/piano.gif" alt="...">
                    </a>
                </div>
                <div class="col-xs-6 col-md-3">
                    <a href="#" class="thumbnail">
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/banner/piano.gif" alt="...">
                    </a>
                </div>
                <div class="col-xs-6 col-md-3">
                    <a href="#" class="thumbnail">
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/banner/piano.gif" alt="...">
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-7 col-lg-7">
            <div class="row">
                <div class="col-md-2 col-lg-2">
                    <br>
                    <img style="border: 4px solid #C69C3D" src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/user.png" alt="..." class="img-circle img-responsive center-block">
                </div>
                <div class="col-md-5 col-lg-5">
                    <h3>Ohmel Paguirigan</h3>
                    <u>facebook.com/ohmel.paguirigan</u><br>
                    ps.ocpaguirigan@gmail.com<br>
                    09163013924<br>
                </div>
                <div class="col-md-5 col-lg-5">
                    <h3 class="">Preferred Meetups</h3>
                    <ul>
                        <li>Manila</li>
                        <li>Mandaluyong</li>
                        <li>Ortigas</li>
                    </ul>
                </div>
            </div>
            <h3 class="">Product Description</h3>
            <p style="font-size: 14px;">Faulty psychic actions, dreams and wit are products of the unconscious mental activity, and like neurotic or psychotic manifestations represent efforts at adjustment to one’s environment. </p>
            <h3 class="">Trade for</h3>
            <ul>
                <li>sdfhsdjhfdjks</li>
            </ul>
            <h3 class="">Tags</h3>
            <span class="label label-info tags">Phone</span>
            <span class="label label-info tags">Iphone</span>
            <span class="label label-info tags">Mobile</span>
        </div>
    </div>
    <div>
        <h2>Comments</h2>
        <div class="row">
            <div class="col-xs-1 col-md-1 col-lg-1">
                <br>
                <img style="border: 4px solid #C69C3D; width: 100px" src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/user.png" alt="..." class="img-circle img-responsive center-block">
            </div>
            <div class="col-md-11 col-lg-11">
                <p style="font-size: 14px;">Faulty psychic actions, dreams and wit are products of the unconscious mental activity, and like neurotic or psychotic manifestations represent efforts at adjustment to one’s environment. </p>
            </div>
        </div>
        <br>
        <div>
            <textarea class="form-control" rows="3"></textarea>
        </div>
    </div>
</article>
<article class="content__item">
    <div class="row">
        <div class="col-md-5 col-lg-5">
            <h2 class="">Piano for trades</h2>
            <img class="img-responsive title title--full " src="<?php echo Yii::app()->request->baseUrl; ?>/images/banner/screen.jpg" alt="item" />
            <br>
            <div class="row">
                <div class="col-xs-6 col-md-3">
                    <a href="#" class="thumbnail">
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/banner/screen.jpg" alt="...">
                    </a>
                </div>
                <div class="col-xs-6 col-md-3">
                    <a href="#" class="thumbnail">
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/banner/screen.jpg" alt="...">
                    </a>
                </div>
                <div class="col-xs-6 col-md-3">
                    <a href="#" class="thumbnail">
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/banner/screen.jpg" alt="...">
                    </a>
                </div>
                <div class="col-xs-6 col-md-3">
                    <a href="#" class="thumbnail">
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/banner/screen.jpg" alt="...">
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-7 col-lg-7">
            <div class="row">
                <div class="col-md-2 col-lg-2">
                    <br>
                    <img style="border: 4px solid #C69C3D" src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/user.png" alt="..." class="img-circle img-responsive center-block">
                </div>
                <div class="col-md-5 col-lg-5">
                    <h3>Ohmel Paguirigan</h3>
                    <u>facebook.com/ohmel.paguirigan</u><br>
                    ps.ocpaguirigan@gmail.com<br>
                    09163013924<br>
                </div>
                <div class="col-md-5 col-lg-5">
                    <h3 class="">Preferred Meetups</h3>
                    <ul>
                        <li>Manila</li>
                        <li>Mandaluyong</li>
                        <li>Ortigas</li>
                    </ul>
                </div>
            </div>
            <h3 class="">Product Description</h3>
            <p style="font-size: 14px;">Faulty psychic actions, dreams and wit are products of the unconscious mental activity, and like neurotic or psychotic manifestations represent efforts at adjustment to one’s environment. </p>
            <h3 class="">Trade for</h3>
            <ul>
                <li>sdfhsdjhfdjks</li>
            </ul>
            <h3 class="">Tags</h3>
            <span class="label label-info tags">Phone</span>
            <span class="label label-info tags">Iphone</span>
            <span class="label label-info tags">Mobile</span>
        </div>
    </div>
    <div>
        <h2>Comments</h2>
        <div class="row">
            <div class="col-xs-1 col-md-1 col-lg-1">
                <br>
                <img style="border: 4px solid #C69C3D; width: 100px" src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/user.png" alt="..." class="img-circle img-responsive center-block">
            </div>
            <div class="col-md-11 col-lg-11">
                <p style="font-size: 14px;">Faulty psychic actions, dreams and wit are products of the unconscious mental activity, and like neurotic or psychotic manifestations represent efforts at adjustment to one’s environment. </p>
            </div>
        </div>
        <br>
        <div>
            <textarea class="form-control" rows="3"></textarea>
        </div>
    </div>
</article>
<article class="content__item">
    <div class="row">
        <div class="col-md-5 col-lg-5">
            <h2 class="">My Table</h2>
            <img class="img-responsive title title--full " src="<?php echo Yii::app()->request->baseUrl; ?>/images/banner/table.jpg" alt="item" />
            <br>
            <div class="row">
                <div class="col-xs-6 col-md-3">
                    <a href="#" class="thumbnail">
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/banner/table.jpg" alt="...">
                    </a>
                </div>
                <div class="col-xs-6 col-md-3">
                    <a href="#" class="thumbnail">
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/banner/table.jpg" alt="...">
                    </a>
                </div>
                <div class="col-xs-6 col-md-3">
                    <a href="#" class="thumbnail">
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/banner/table.jpg" alt="...">
                    </a>
                </div>
                <div class="col-xs-6 col-md-3">
                    <a href="#" class="thumbnail">
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/banner/table.jpg" alt="...">
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-7 col-lg-7">
            <div class="row">
                <div class="col-md-2 col-lg-2">
                    <br>
                    <img style="border: 4px solid #C69C3D" src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/user.png" alt="..." class="img-circle img-responsive center-block">
                </div>
                <div class="col-md-5 col-lg-5">
                    <h3>Ohmel Paguirigan</h3>
                    <u>facebook.com/ohmel.paguirigan</u><br>
                    ps.ocpaguirigan@gmail.com<br>
                    09163013924<br>
                </div>
                <div class="col-md-5 col-lg-5">
                    <h3 class="">Preferred Meetups</h3>
                    <ul>
                        <li>Manila</li>
                        <li>Mandaluyong</li>
                        <li>Ortigas</li>
                    </ul>
                </div>
            </div>
            <h3 class="">Product Description</h3>
            <p style="font-size: 14px;">Faulty psychic actions, dreams and wit are products of the unconscious mental activity, and like neurotic or psychotic manifestations represent efforts at adjustment to one’s environment. </p>
            <h3 class="">Trade for</h3>
            <ul>
                <li>sdfhsdjhfdjks</li>
            </ul>
            <h3 class="">Tags</h3>
            <span class="label label-info tags">Phone</span>
            <span class="label label-info tags">Iphone</span>
            <span class="label label-info tags">Mobile</span>
        </div>
    </div>
    <div>
        <h2>Comments</h2>
        <div class="row">
            <div class="col-xs-1 col-md-1 col-lg-1">
                <br>
                <img style="border: 4px solid #C69C3D; width: 100px" src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/user.png" alt="..." class="img-circle img-responsive center-block">
            </div>
            <div class="col-md-11 col-lg-11">
                <p style="font-size: 14px;">Faulty psychic actions, dreams and wit are products of the unconscious mental activity, and like neurotic or psychotic manifestations represent efforts at adjustment to one’s environment. </p>
            </div>
        </div>
        <br>
        <div>
            <textarea class="form-control" rows="3"></textarea>
        </div>
    </div>
</article>

</div>
<button class="close-button"><i class="fa fa-close"></i><span>Close</span></button>
</section>
</div>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/includes/grid/js/classie.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/includes/grid/js/main.js"></script>