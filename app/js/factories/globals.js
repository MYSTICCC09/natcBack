/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
app.factory('Globals', function($location) {
    //root folder Url
    var host = $location.host()+"/";
    if(host === 'localhost/'){
        host = $location.host()+"/lcs/"
    }
    var rootUrl = 'http://'+host;
    return {
        rootUrl : rootUrl
    };
});

