var news_module=angular.module('category_module', []);

news_module.controller('newsData', function ($scope, $http){
  //=============获取所有分类列表=============
  //当前分类
  //$scope.categoryNow=0;
  $scope.categoryNow=1;

  //分类列表
  $http.get('/ports/jianshu/category.do').success(function (res){
    if(res.code==100){
      //成功
      $scope.categoryList=res.data;
      //$scope.categoryList.unshift({"categoryId":0,"name":"默认"});
      $scope.setCategoryNow=function (now){
        $scope.categoryNow=now;
        //文章列表
        getArticleList();
      };
    }else {
      alert('错了：'+res.code)
    }
  }).error(function (){
    alert('错了');
  });
});
