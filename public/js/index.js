var app = angular.module('app', ['satellizer'])
    .config(function($authProvider){

        $authProvider.facebook({
            clientId: '404020580057017',
            redirectUri: window.location.origin + '/v1/social/redirect/facebook'
        });

    });

app.controller('authController', function($scope,$http,$auth) {
    $scope.firstName= "John";
    $scope.lastName= "Doe";
    $scope.names = ["Emil", "Tobias", "Linus"];
    $scope.response = "";
    $scope.loginUser = function(){
        $scope.response = ""
        $http.post('http://os.test/api/v1/login',{
            'login': $scope.login,
            'password': $scope.password
        }).then(function(response){
            $scope.response = response.data
        }).catch(function(error){
            $scope.response = error.data.message
        })

    }

    $scope.authenticate = function(provider) {
        $auth.authenticate(provider);
    };

});

