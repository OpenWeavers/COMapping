var app = new angular.module('subjectHandler', []);


app.controller('myController', function ($scope, $window, $http) {
    $scope.noOfCOs = 5;
    $scope.re = "Default";
    $scope.subject = {
        subject_code: "",
        CIE: [[], [], [], [], []]
    };
    $scope.subjectList = [];
    $scope.selectedSubject = {};
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
        //$scope.selectedSubject.id='CS110';
        if ($scope.selectedSubject.subject_code && $scope.noOfCOs > 0) {
            $http({
                method: 'POST',
                url: 'addSubjectCIE.php',
                data: {subject_code: $scope.selectedSubject.subject_code, noOfCo:$scope.noOfCOs, section_id:$scope.selectedSubject.section_id, cie: JSON.stringify($scope.subject.CIE)}
            }).then(function (response) {
                $scope.resp = response.data;
                alert("Success")
            }, function (response) {
                console.log(response.data, response.status);
            });
        }
        else {
            $window.alert("Insert valid name and number of COs");
            $window.alert($scope.selectedSubject.subject_code);
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

