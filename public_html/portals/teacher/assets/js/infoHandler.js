var app = new angular.module('infoHandler', []);
app.controller('myController', function ($scope, $window, $http) {
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
    $scope.getInfo();

});