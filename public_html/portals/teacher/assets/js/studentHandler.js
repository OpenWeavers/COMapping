var app = new angular.module('studentHandler', ['ngMessages']);
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
    $scope.studentList = [
        {
            usn: "4JC15CS129",
            name: "Vinayaka K V"
        },
        {
            usn: "4JC15CS130",
            name: "Vinyas N S"
        },
        {
            usn: "4JC15CS131",
            name: "Vishakha M"
        }
    ];
    $scope.selectedStudent = $scope.studentList[0];
    $scope.selectedSubject = $scope.subjectList[0];
    $scope.submitStudent = function () {
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

    $scope.updateStudents = function () {
        // Read $scope.selectedSubject.id
        // Fetch the students according to their id
        // Update $scope.studentList
    };

    $scope.changeCO();
});