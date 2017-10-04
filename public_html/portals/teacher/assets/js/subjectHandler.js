var app = new angular.module('subjectHandler', []);


app.controller('myController', function ($scope, $window, $http) {
    $scope.noOfCOs = 5;
    $scope.re = "Default";
    $scope.subject = {
        id: "",
        CIE: [[], [], [], [], []]
    };
    $scope.subjectList = [];
    $scope.getSubjectList = function () {
        $http({
            method: 'POST',
            url: 'getSubjectList.php'
        }).then(function (response) {
            $scope.subjectList = JSON.parse(angular.fromJson(response.data).data);
            $scope.selectedSubject = $scope.subjectList[0];
        }, function (response) {
            var recieved = angular.fromJson(response.data);
            alert(recieved.data);
        });
    };
    $scope.submitSubject = function () {
        if ($scope.selectedSubject.id && $scope.noOfCOs > 0) {
            $http({
                method: 'POST',
                url: '../addStudent.php',
                data: {name: $scope.selectedSubject.name, cie: JSON.stringify($scope.subject.CIE)}
            }).then(function (response) {
                $scope.resp = response.data;
            }, function (response) {
                console.log(response.data, response.status);
            })
        }
        else {
            $window.alert("Insert valid name and number of COs");
        }
    };
    $scope.getTotal = function (x) {
        txt = 0;
        for (i = 0; i < x.length; i++) {
            c = x[i];
            txt += c;
        }
        return txt;
    };
    $scope.changeCO = function () {
        $scope.subject.CIE = [[], [], [], [], []];
        for (var i = 0; i < 5; i++) {
            for (var j = 0; j < $scope.noOfCOs; j++) {
                $scope.subject.CIE[i][j] = 0;
            }
        }
    };
    $scope.changeCO();
    $scope.getSubjectList();
});

