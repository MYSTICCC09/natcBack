/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

app.controller('SiteController', function($scope, Globals, ngNotify, ngDialog, nbaGames) {
    $scope.imgCounter = 1;
    $scope.imgSelector = 1;
    $scope.rootUrl = Globals.rootUrl;
    $scope.images = [
        {'img': 'img1.jpg', 'order': 1, 'caption': 'Rebound! Oye!'},
        {'img': 'img2.jpg', 'order': 2, 'caption': 'Lean Back Harden!'},
        {'img': 'img3.jpg', 'order': 3, 'caption': 'Crossover move!'},
        {'img': 'img4.jpg', 'order': 4, 'caption': 'Crossover move!'}
    ];
    $scope.gameScheds = [
        {'tm1': 'bulls.gif', 'tm2': 'jazz.gif', 'gameDate': 'FEB 16', 'gameTime': '9am'},
        {'tm1': 'bulls.gif', 'tm2': 'jazz.gif', 'gameDate': 'FEB 16', 'gameTime': '9am'},
        {'tm1': 'bulls.gif', 'tm2': 'jazz.gif', 'gameDate': 'FEB 16', 'gameTime': '9am'},
        {'tm1': 'bulls.gif', 'tm2': 'jazz.gif', 'gameDate': 'FEB 16', 'gameTime': '9am'},
        {'tm1': 'bulls.gif', 'tm2': 'jazz.gif', 'gameDate': 'FEB 16', 'gameTime': '9am'},
        {'tm1': 'bulls.gif', 'tm2': 'jazz.gif', 'gameDate': 'FEB 16', 'gameTime': '9am'},
        {'tm1': 'bulls.gif', 'tm2': 'jazz.gif', 'gameDate': 'FEB 16', 'gameTime': '9am'},
        {'tm1': 'bulls.gif', 'tm2': 'jazz.gif', 'gameDate': 'FEB 16', 'gameTime': '9am'},
        {'tm1': 'bulls.gif', 'tm2': 'jazz.gif', 'gameDate': 'FEB 16', 'gameTime': '9am'},
    ];
    $scope.gameScores = [
        {'tm1': 'bulls.gif', 'tm2': 'jazz.gif', 'winScore': 119, 'loseScore': 98},
        {'tm1': 'bulls.gif', 'tm2': 'jazz.gif', 'winScore': 119, 'loseScore': 98},
        {'tm1': 'bulls.gif', 'tm2': 'jazz.gif', 'winScore': 119, 'loseScore': 98},
        {'tm1': 'bulls.gif', 'tm2': 'jazz.gif', 'winScore': 119, 'loseScore': 98},
        {'tm1': 'bulls.gif', 'tm2': 'jazz.gif', 'winScore': 119, 'loseScore': 98},
    ];
    
    nbaGames.fetchGames(
    function(success){
        
    }, function(error){
        ngNotify.set(error.message,'error');
    });
    
    setInterval(function() {
        //alert($scope.imgCounter);
        if ($scope.imgCounter === $scope.images.length) {
            $scope.imgCounter = 0;
        }
        $scope.imgCounter++;
        $scope.$apply();
    }, 5000);

    $scope.selectPhoto = function(order) {
        $scope.imgCounter = order;
    };
    $scope.clickToOpen = function() {
        ngDialog.open({
            template:'\
                <p>Are you sure you want to close the parent dialog?</p>\
                <div class="ngdialog-buttons">\
                    <button type="button" class="ngdialog-button ngdialog-button-secondary" ng-click="confirm(1)">No</button>\
                    <button type="button" class="ngdialog-button ngdialog-button-primary" ng-click="closeThisDialog(0)">Yes</button>\
                </div>',
            plain: true,
            className: 'ngdialog-theme-plain'
        });
    };


});

