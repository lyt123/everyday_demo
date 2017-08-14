var app=angular.module('index_m', ['news_module', 'category_module']);

app.filter('showAsHtml', function ($sce){
  return function (input){
    return $sce.trustAsHtml(input);
  };
});

app.controller('index_m', function ($scope, $http){
  //index_m特有的写在这儿
});

app.controller('article_m', function ($scope, $http){
  //id——文章用
  var id=location.search.substring(1).split('=')[1];

  $http.get('/ports/jianshu/articleInfor/'+id+'.do').success(function (res){
    if(res.code==100){
      $scope.articleInfo=res.data;
    }else {
      alert('错了：'+res.code);
    }
  }).error(function (){
    alert('失败');
  });















});

app.controller('index_pc', function ($scope, $http){

});
