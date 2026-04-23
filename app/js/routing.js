app.config(['$routeProvider',
  function($routeProvider) {
    $routeProvider.
      when('/games', {
        templateUrl: '../../app/js/games/template/games.html',
        controller: 'GamesController'
      }).
      otherwise({
        redirectTo: '/phones'
      });
  }]);


