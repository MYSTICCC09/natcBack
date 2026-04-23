/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
app.directive('slider', function(Globals) {
  return {
    templateUrl: function(elem, attr){
      return Globals.rootUrl+'/app/js/directives/slider/template/slider.html';
    },
    rootFolder : Globals.rootUrl
  };
});


