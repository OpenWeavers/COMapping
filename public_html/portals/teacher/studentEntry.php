<html xmlns="http://www.w3.org/1999/html">
<head>
    <title>SJCE DB</title>
    <script src="../../js/angular.js">
    </script>
    <script src="js/app/myApp.js"></script>
</head>
<body ng-app="myApp" ng-controller="myController">
<form ng-submit="submitStudent()">
    Name : <input type="text" size="32" ng-model="student.name" /><br>
    Number of CO's : <input type="number" ng-model="noOfCOs" ng-change="changeCO()"><br>
    Enter CO :<br>
    <table>
        <tr>
            <th></th>
            <th ng-repeat="row in student.CIE[0] track by $index">CO{{$index + 1}}</th>
        </tr>
        <tr ng-repeat="row in student.CIE">
            <td>CIE{{$index + 1}}</td>
            <td ng-repeat="cell in row track by $index">
                <input type="number" value="{{cell}}" ng-model="row[$index]">
            </td>
        </tr>
    </table>
    <input type="submit" value="Submit">
</form>

<div onload="getStudents()">
    <table>
        <tr ng-repeat="row in allStudents">
            <td ng-repeat="i in row track by $index">
                {{i}}
            </td>
        </tr>
    </table>
</div>
<div>Response : <span ng-bind="resp"></span></div>
</body>
</html>
