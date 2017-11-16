var app = new angular.module('infoHandler', []);
app.controller('myController', function ($scope, $window, $http) {
    var humanize = function (str) {
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
                $scope.properties = [];
                var object = $scope.subInfo[0];
                for (var property in object) {
                    if (object.hasOwnProperty(property)) {
                        $scope.properties.push(property.toString())
                    }
                }
                $scope.properties = $scope.properties.map(x=>humanize(x));
            },
            function (response) {
                $window.alert(JSON.parse(response).data)
            }
        )
    };
    $scope.getInfo();

});