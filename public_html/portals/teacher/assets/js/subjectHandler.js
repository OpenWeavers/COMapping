var app = new angular.module('subjectHandler', []);


app.controller('myController', function ($scope, $window, $http) {
    $scope.subjectList = [];
    $scope.selectedSubject = {};
    $scope.getSubjectList = function () {
        $http({
            method: 'POST',
            url: 'getSubjectList.php'
        }).then(function (response) {
            $scope.subjectList = JSON.parse(angular.fromJson(response.data).data);
            //alert($scope.subjectList[0].max_co);
            $scope.subjectList.forEach(x => {
                x.max_co = JSON.parse(x.max_co) || [[0,0,0,0,0],[0,0,0,0,0],[0,0,0,0,0],[0,0,0,0,0],[0,0,0,0,0]];
                x.no_of_co = parseInt(x.no_of_co) || 5;
            });
            $scope.selectedSubject = $scope.subjectList[0];
            $scope.noOfCOs = $scope.subjectList[0].no_of_co;
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
                data: {subject_code: $scope.selectedSubject.subject_code, noOfCo:$scope.selectedSubject.no_of_co, section_id:$scope.selectedSubject.section_id, cie: JSON.stringify($scope.selectedSubject.max_co)}
            }).then(function (response) {
                $scope.resp = response.data;
                //alert(JSON.stringify($scope.selectedSubject.max_co));
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
        $scope.selectedSubject.max_co = [[], [], [], [], []];
        for (var i = 0; i < 5; i++) {
            for (var j = 0; j < $scope.selectedSubject.no_of_co; j++) {
                $scope.selectedSubject.max_co[i][j] = 0;
            }
        }
    };
    $scope.changeCO();
    $scope.getSubjectList();
});

