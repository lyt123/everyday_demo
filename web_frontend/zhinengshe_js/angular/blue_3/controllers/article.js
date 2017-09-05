angular.module('articleMod', [])
.controller('articleController', function ($scope, $routeParams){
	switch($routeParams.type){
		case 'sport':
			$scope.arr=['新闻1', '新闻222', '新闻33', '新闻44', '新闻55', '66223'];
			break;
		case 'game':
			$scope.arr=['aaa1', 'bbb222', '新闻eee', '新闻44', '新闻55', '66223'];
			break;
		case 'news':
			$scope.arr=['新dsfasdf', 'adsfasd222', '45yhfh33', '新闻hfghfgh', '新闻55', '66223'];
			break;
	}
});