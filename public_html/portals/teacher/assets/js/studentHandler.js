var app = new angular.module('studentHandler', []);
app.controller('myController', function ($scope, $window, $http) {
    $scope.ress = "Default";
    $scope.subjectList = [];
    $scope.studentList = [];
    $scope.selectedSubject = {};
    $scope.selectedStudent = {};

    var index = 0;
    var length = $scope.studentList.length;

    $scope.nextStudent = function () {
        if (index < length - 1) {
            $scope.selectedStudent = $scope.studentList[++index];
        }
    };
    $scope.prevStudent = function () {
        if (index > 0) {
            $scope.selectedStudent = $scope.studentList[--index];
        }
    };
    $scope.getSubjectList = function () {
        $http({
            method: 'POST',
            url: 'getSubjectList.php'
        }).then(function (response) {
            $scope.subjectList = JSON.parse(angular.fromJson(response.data).data);
            $scope.subjectList.forEach(x => {
                x.max_co = JSON.parse(x.max_co);
                x.no_of_co = parseInt(x.no_of_co);
            });
            $scope.selectedSubject = $scope.subjectList[0];
            $scope.getStudentList();
        }, function (response) {
            var recieved = angular.fromJson(response.data);
            $window.alert(recieved.data);
        });
    };

    $scope.submitStudent = function () {
        //$scope.selectedSubject.id='CS110';
        if ($scope.selectedSubject.subject_code && $scope.selectedSubject.no_of_co > 0) {
            $http({
                method: 'POST',
                url: 'addStudentCIE.php',
                data: {usn:$scope.selectedStudent.usn,subject_code: $scope.selectedSubject.subject_code, cie: JSON.stringify($scope.selectedStudent.cie)}
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

    zeros = function (dimensions) {
        var array = [];

        for (var i = 0; i < dimensions[0]; ++i) {
            array.push(dimensions.length == 1 ? 0 : zeros(dimensions.slice(1)));
        }

        return array;
    };

    $scope.not_valid_cie = zeros([5,$scope.selectedSubject.no_of_co]);

    $scope.validate_cie = function(r,c) {
        $scope.not_valid_cie[r][c] = $scope.selectedStudent.cie[r][c] > $scope.selectedSubject.max_co[r][c]
            || $scope.selectedStudent.cie[r][c] < 0
            || $scope.selectedStudent.cie[r][c] !== parseInt($scope.selectedStudent.cie[r][c], 10);
    };

    $scope.getStudentList = function () {
        if( !$scope.selectedSubject.max_co || !$scope.selectedSubject.no_of_co) {
            alert("Subject Max CIE Is not fIlled" + $scope.selectedSubject.max_co +  $scope.selectedSubject.no_of_co);
            $window.location.href = "subject.php";
            return;
        }
        $http({
            method: 'POST',
            url: 'getStudentList.php',
            data: {
                subject_code: $scope.selectedSubject.subject_code,
                semester: $scope.selectedSubject.semester,
                section_id: $scope.selectedSubject.section_id
            }
        }).then(function (response) {
            //alert($scope.selectedSubject.max_co);
            $scope.studentList = JSON.parse(angular.fromJson(response.data).data);
            //alert($scope.studentList[0].cie);
            $scope.studentList.forEach(
                x => x.cie = JSON.parse(x.cie) || zeros([5,$scope.selectedSubject.no_of_co])
            );
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
    $scope.getSubjectList();
});