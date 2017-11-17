var app = new angular.module('infoHandler', []);
app.controller('myController', function ($scope, $window, $http) {

    $scope.subjectList = [];
    $scope.studentList = [];
    $scope.selectedSubject = {};
    $scope.selectedStudent = {};

    $scope.humanize = function (str) {
        var frags = str.split('_');
        for (i=0; i<frags.length; i++) {
            frags[i] = frags[i].charAt(0).toUpperCase() + frags[i].slice(1);
        }
        return frags.join(' ');
    };
    $scope.getInfo = function () {
        $http({
            method:'POST',
            url: 'getStats.php'
        }).then(
            function (response) {
                $scope.subInfo = JSON.parse(angular.fromJson(response.data).data);
                $scope.subInfo.forEach(x => {
                    x.cie_entered = x.cie_entered == "0" ? false:true;
                    x.total_students = parseInt(x.total_students);
                    x.total_entered = parseInt(x.total_entered);
                });
                $scope.total_students = $scope.subInfo.reduce((x,y)=>x.total_students+y.total_students);
                $scope.total_entered = $scope.subInfo.reduce((x,y)=>x.total_entered+y.total_entered);
                $scope.properties = [];
                var object = $scope.subInfo[0];
                for (var property in object) {
                    if (object.hasOwnProperty(property)) {
                        $scope.properties.push(property.toString())
                    }
                }
                //$scope.properties = $scope.properties.map(x=>{id:x,display:humanize(x)});
                $scope.subInfo.forEach(x => {
                    x.percentage = (x.total_entered/x.total_students * 100 ).toFixed(2)
                });
            },
            function (response) {
                $window.alert(JSON.parse(response).data)
            }
        )
    };

    zeros = function (dimensions) {
        var array = [];

        for (var i = 0; i < dimensions[0]; ++i) {
            array.push(dimensions.length == 1 ? 0 : zeros(dimensions.slice(1)));
        }

        return array;
    };

    $scope.getSubjectList = function (subject) {
        $http({
            method: 'POST',
            url: 'getSubjectList.php'
        }).then(function (response) {
            $scope.subjectList = JSON.parse(angular.fromJson(response.data).data);
            $scope.subjectList.forEach(x => {
                x.max_co = JSON.parse(x.max_co);
                x.no_of_co = parseInt(x.no_of_co);
            });
            $scope.selectedSubject = $scope.subjectList.find(x=>x.subject_code==subject.subject_code);
            $scope.getStudentList();
        }, function (response) {
            var recieved = angular.fromJson(response.data);
            $window.alert(recieved.data);
        });
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
            //alert($scope.selectedSubject.max_co);
            $scope.studentList = JSON.parse(angular.fromJson(response.data).data);
            //alert($scope.studentList[0].cie);
            $scope.studentList.forEach(
                x => x.cie = JSON.parse(x.cie) || zeros([5,$scope.selectedSubject.no_of_co])
            );
            console.log($scope.selectedSubject.max_co)
            $scope.max_cie_marks = $scope.selectedSubject.max_co.map(x=>x.reduce((y,z)=>y+z))
            $scope.max_co_marks = ($scope.selectedSubject.max_co[0].map((col, i) => $scope.selectedSubject.max_co.map(row => row[i]))).map(x=>x.reduce((y,z)=>y+z));
            console.log($scope.max_cie_marks)
            console.log($scope.max_co_marks)
            $scope.avg_cie_attained = zeros([$scope.max_cie_marks.length])
            $scope.avg_co_attained = zeros([$scope.max_co_marks.length])
            var n = $scope.studentList.length;
            $scope.studentList.forEach(x => {
               var obtained_cie = x.cie.map(x=>x.reduce((y,z)=>y+z));
               var obtained_co = (x.cie[0].map((col, i) => x.cie.map(row => row[i]))).map(x=>x.reduce((y,z)=>y+z));
               for(var i=0; i< $scope.avg_cie_attained.length ; i++)
                   $scope.avg_cie_attained[i] += obtained_cie[i]/($scope.max_cie_marks[i] * n);
                for(var i=0; i< $scope.avg_co_attained.length ; i++)
                    $scope.avg_co_attained[i] += obtained_co[i]/($scope.max_co_marks[i] * n);
            });
            $scope.avg_cie_attained = $scope.avg_cie_attained.map((x,i)=>['CIE'+(i+1).toString(),(x*100)]);
            $scope.avg_co_attained = $scope.avg_co_attained.map((x,i)=>['CO'+(i+1).toString(),(x*100)]);
            console.log($scope.avg_cie_attained)
            console.log($scope.avg_co_attained)
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawCIEChart);
            google.charts.setOnLoadCallback(drawCOChart);
            function drawCIEChart() {

                // Create the data table.
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'CIE');
                data.addColumn('number', '% CIE');
                data.addRows($scope.avg_cie_attained);

                // Set chart options
                var options = {'title':'Percentage CIE Attainment',
                    'width':500,
                    'height':300};

                // Instantiate and draw our chart, passing in some options.
                var chart = new google.visualization.ColumnChart(document.getElementById('cie_chart_div'));
                chart.draw(data, options);
            }
            function drawCOChart() {

                // Create the data table.
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'CO');
                data.addColumn('number', '% CO');
                data.addRows($scope.avg_co_attained);

                // Set chart options
                var options = {'title':'Percentage CO Attainment',
                    'width':500,
                    'height':300};

                // Instantiate and draw our chart, passing in some options.
                var chart = new google.visualization.ColumnChart(document.getElementById('co_chart_div'));
                chart.draw(data, options);
            }
        }, function (response) {
            var recieved = angular.fromJson(response.data);
            $window.alert(recieved.data);
        });
    };


    $scope.calculate = function (subject) {
        /*if (!subject.cie_entered) {
            alert("CIE For Subject " + subject.subject_name + " Not entered");
            return;
        }
        else if (subject.total_students !== subject.total_entered) {
            alert("Data  Entry Not finished yet. Please Complete and then Calculate.")
        }*/
        $scope.getSubjectList(subject);

    };

    $scope.getInfo();

});