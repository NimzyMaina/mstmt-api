<!DOCTYPE html>
<html lang="en-US">
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
<script src="https://cdn.jsdelivr.net/satellizer/0.15.5/satellizer.min.js"></script>
<script src="{{asset('js/index.js')}}"></script>
<head>
    <title>{{config("app.name")}} - App</title>
</head>
<body>

<div ng-app="app" ng-controller="authController">

    First Name: <input type="text" ng-model="firstName"><br>
    Last Name: <input type="text" ng-model="lastName"><br>
    <br>
    Full Name: @{{firstName + " " + lastName}}
    <br/>
    <ul>
        <li ng-repeat="x in names">
            @{{ x }}
        </li>
    </ul>
    <br/>
    <input name="login" type="text" ng-model="login" placeholder="Enter password"/>
    <input name="password" type="password" ng-model="password" placeholder="Enter password"/>
    <button ng-click="loginUser()">Login</button>

    <pre>
            @{{response}}
        </pre>

    <br/>

    <button ng-click="authenticate('facebook')">Sign in with Facebook</button>

</div>

</body>
</html>