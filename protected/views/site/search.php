<style>

    .list-items:hover{
        opacity: .5;
    }
    #browse-category a{
        color: white;
    }
</style>
<br><br>
<div id="search-div"class="text-center row">
    <div style="text-align: left;" class=" col-sm-12 col-md-12 col-lg-12">
        <form action="">
            <div class="">
                <div class="input-group input-group-lg">
                    <input type="text" class="form-control" placeholder="Swap Now!" style="border-radius: 0px">
                <span class="input-group-btn">
                    <input class="btn btn-default" type="submit" style="border-radius: 0px" value="Go!">
                </span>
                </div>
            </div>
            <br/>
            <input type="checkbox"> Check me out
            <input type="checkbox"> Check me out
            <input type="checkbox"> Check me out
            <input type="checkbox"> Check me out
            <input type="checkbox"> Check me out
            <input type="checkbox"> Check me out
            <input type="checkbox"> Check me out
            <input type="checkbox"> Check me out

        </form>
    </div>
</div>
<div id="browse-div" class="row">
    <div class="col-sm-8 col-md-8 col-lg-8 inside-shadow" style="border-radius: 5px;">
        <div class="text-align-left" style="position: absolute">
            <h1 style="margin-bottom: 0px">Can't Decide what to search?</h1>
            Just click search and browse from over 20,000 items in our shelf!
        </div>
        <img class="img-responsive center-block abs" src="<?php echo Yii::app()->request->baseUrl; ?>/images/signup/adbanner.png">
    </div>
    <div class="col-sm-4 col-md-4 col-lg-4 text-align-left" style="padding-left: 3px">
        <div style="border-radius: 5px; color: white;">
            <ul class="list-group" id="browse-category" style=" width: 100%">
                <li class="list-group-item" style="background: #606060"><strong>Browse Categories</strong></li>
                <li class="list-group-item list-items"><a href="#"><div>Music</div></a></li>
                <li class="list-group-item list-items"><a href="#"><div>Cars</div></a></li>
                <li class="list-group-item list-items"><a href="#"><div>Clothing</div></a></li>
                <li class="list-group-item list-items"><a href="#"><div>Shoes</div></a></li>
                <li class="list-group-item list-items"><a href="#"><div>Phones</div></a></li>
                <li class="list-group-item list-items"><a href="#"><div>Gadgets</div></a></li>
                <li class="list-group-item list-items"><a href="#"><div>Appliances</div></a></li>
                <li class="list-group-item list-items"><a href="#"><div>Computers</div></a></li>
                <li class="list-group-item list-items"><a href="#"><div>Spare Parts</div></a></li>
                <li class="list-group-item list-items"><a href="#"><div>Books</div></a></li>
                <li class="list-group-item list-items"><a href="#"><div>Accessories</div></a></li>
            </ul>
        </div>
    </div>
</div>
<div id="search-suggestions" class="row text-align-left">
    <h3>Top Searches</h3><br>
    <div class="row">
        <div class="col-xs-6 col-md-3">
            <a href="#" class="thumbnail">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/thumbs.jpg" alt="...">
            </a>
            dsf
        </div>
        <div class="col-xs-6 col-md-3">
            <a href="#" class="thumbnail">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/thumbs.jpg" alt="...">
            </a>
            asdf
        </div>
        <div class="col-xs-6 col-md-3">
            <a href="#" class="thumbnail">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/thumbs.jpg" alt="...">
            </a>
            sadf
        </div>
        <div class="col-xs-6 col-md-3">
            <a href="#" class="thumbnail">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/thumbs.jpg" alt="...">
            </a>
            sf
        </div>
    </div>

    <h3>Suggested</h3><br>
    <div class="row">
        <div class="col-xs-6 col-md-3">
            <a href="#" class="thumbnail">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/thumbs.jpg" alt="...">
            </a>
            dsf
        </div>
        <div class="col-xs-6 col-md-3">
            <a href="#" class="thumbnail">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/thumbs.jpg" alt="...">
            </a>
            asdf
        </div>
        <div class="col-xs-6 col-md-3">
            <a href="#" class="thumbnail">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/thumbs.jpg" alt="...">
            </a>
            sadf
        </div>
        <div class="col-xs-6 col-md-3">
            <a href="#" class="thumbnail">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/thumbs.jpg" alt="...">
            </a>
            sf
        </div>
    </div>

</div>