var app = new angular.module('myApp', []);
app.controller('myController', function ($scope, $window, $http) {
   $scope.noOfCOs = 5;
   $scope.student = {
       name : "",
       CIE : [[],[],[],[],[]]
   };

   $scope.getStudents = function () {
       $http({
           method : 'GET',
           url : 'getAllStudents.php'
       }).then(function (response) {
           $scope.allStudents = response.data;$scope.resp = response.data;
       }, function (response) {
           console.log(response.data, response.status);
       })
   };

   $scope.submitStudent = function () {
       if($scope.student.name && $scope.noOfCOs > 0)    {
           $http({
               method : 'POST',
               url : 'addStudent.php',
               data : {name : $scope.student.name, cie : JSON.stringify($scope.student.CIE)}
           }).then(function (response) {
               $scope.resp = response.data;
               $scope.getStudents();
           }, function (response) {
               console.log(response.data, response.status);
           })
       }
       else {
           $window.alert("Insert valid name and number of COs");
       }
   };

   $scope.changeCO = function () {
       $scope.student.CIE = [[],[],[],[],[]];
       for(var i=0; i< 5;i++)  {
           for(var j=0; j< $scope.noOfCOs; j++)  {
               $scope.student.CIE[i][j] = 0;
           }
       }
   };
   $scope.changeCO();
   $scope.getStudents();
});