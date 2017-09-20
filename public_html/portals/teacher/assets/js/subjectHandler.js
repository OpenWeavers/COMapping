var app = new angular.module('subjectHandler', []);
app.controller('myController', function ($scope, $window, $http) {
    $scope.noOfCOs = 5;
    $scope.subject = {
        id: "",
        CIE: [[], [], [], [], []]
    };
    $scope.subjectList = [
        {
            name:"DBMS",
            id:"CS510"
        },
        {
            name:"DS",
            id:"CS310"
        }
    ];
    $scope.selectedSubject = $scope.subjectList[0];
    $scope.submitSubject = function () {
        if ($scope.selectedSubject.id && $scope.noOfCOs > 0) {
            $http({
                method: 'POST',
                url: 'addStudent.php',
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

    $scope.changeCO = function () {
        $scope.subject.CIE = [[], [], [], [], []];
        for (var i = 0; i < 5; i++) {
            for (var j = 0; j < $scope.noOfCOs; j++) {
                $scope.subject.CIE[i][j] = 0;
            }
        }
    };
    $scope.changeCO();
});