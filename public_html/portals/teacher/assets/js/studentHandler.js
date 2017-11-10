var app = new angular.module('studentHandler', []);
app.controller('myController', function ($scope, $window, $http) {
    $scope.noOfCOs = 5;
    $scope.ress = "Default";
    $scope.subject = {
        id: "",
        CIE: [[], [], [], [], []]
    };
    $scope.subjectList = [];
    $scope.studentList = [];
    $scope.selectedSubject = [];
    $scope.selectedStudent = [];

    var index = 0;
    var length = $scope.studentList.length;

    $scope.nextStudent = function () {
        if (index < length - 1) {
            $scope.selectedStudent = $scope.studentList[++index];
            $scope.updateStudent();
        }
    };
    $scope.prevStudent = function () {
        if (index > 0) {
            $scope.selectedStudent = $scope.studentList[--index];
            $scope.updateStudent();
        }
    };
    $scope.getSubjectList = function () {
        $http({
            method: 'POST',
            url: 'getSubjectList.php'
        }).then(function (response) {
            $scope.subjectList = JSON.parse(angular.fromJson(response.data).data);
            $scope.selectedSubject = null;
        }, function (response) {
            var recieved = angular.fromJson(response.data);
            $window.alert(recieved.data);
        });
    };
    $scope.updateStudent = function () {
        // Send request to getStudentInfo.php
        // Param usn,subcode
        // if cie matrix already filled, display, else zeros
    };
    $scope.updateSubject = function () {
        // To get max CO info
        // Send request to getSubjectInfo.php
        // if max CO matrix exsists, get it
        // else redirect to subject.php
    };
    $scope.submitStudent = function () {
        //$scope.selectedSubject.id='CS110';
        if ($scope.selectedSubject.subject_code && $scope.noOfCOs > 0) {
            $http({
                method: 'POST',
                url: 'addStudentCIE.php',
                data: {usn:$scope.selectedStudent.usn,subject_code: $scope.selectedSubject.subject_code, cie: JSON.stringify($scope.subject.CIE)}
            }).then(function (response) {
                $scope.resp = response.data;
                alert(response.data.data)
            }, function (response) {
                console.log(response.data, response.status);
            });
        }
        else {
            $window.alert("Insert valid name and number of COs");
            $window.alert($scope.selectedSubject.subject_code);
        }
    };
    $scope.updateIndex = function () {
        index = $scope.studentList.indexOf($scope.selectedStudent);
    };
    $scope.changeCO = function () {
        $scope.subject.CIE = [[], [], [], [], []];
        for (var i = 0; i < 5; i++) {
            for (var j = 0; j < $scope.noOfCOs; j++) {
                $scope.subject.CIE[i][j] = 0;
            }
        }
    };
    $scope.getStudentList = function () {
        $http({
            method: 'POST',
            url: 'getStudentList.php',
            data: {
                subject_code: $scope.selectedSubject.subject_code,
                semester: $scope.selectedSubject.semester,
                section_id: $scope.selectedSubject.section_id
            }
        }).then(function (response) {
            $scope.studentList = JSON.parse(angular.fromJson(response.data).data);
            $scope.selectedStudent = $scope.studentList[0];
            length = $scope.studentList.length;
        }, function (response) {
            var recieved = angular.fromJson(response.data);
            $window.alert(recieved.data);
        });
    };
    $scope.getTotal = function (x) {
        txt = 0;
        for (i = 0; i < x.length; i++) {
            c = x[i];
            txt += c;
        }
        return txt;
    };
    $scope.changeCO();
    $scope.getSubjectList();
    $scope.getStudentList();
});