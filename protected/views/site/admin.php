<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin.css" />
<div class="row">
    <div class="col-lg-4">
        <div id="admin-panel">
            <a class="btn btn-primary btn-block text-align-left" href="#/games">Games</a>
            <a class="btn btn-primary btn-block text-align-left">Teams</a>
            <a class="btn btn-primary btn-block text-align-left">Players</a>
            <a class="btn btn-primary btn-block text-align-left">Settings</a>
        </div>
    </div>
    <div class="col-lg-8">
        <div ng-view id="admin-page">
        </div>
    </div>
</div>