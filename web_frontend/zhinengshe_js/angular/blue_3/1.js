// JavaScript Document

var app=angular.module('test', []);

app.controller('main', function ($scope){
	$scope.show=false;
});
app.directive('znsshowmore', function (){
	return {
		restrict: 'E',
		template:
		'<div class="{{show?\'more2\':\'more\'}}">\
			<a href="javascript:;" ng-click="show=!show">显示更多</a>\
			<span ng-transclude></span>\
		</div>',
		transclude: true
	};
});