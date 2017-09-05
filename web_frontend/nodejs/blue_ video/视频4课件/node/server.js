const http=require('http');

http.createServer(function (req, res){
  var GET={};

  if(req.url.indexOf('?')!=-1){
    var arr=req.url.split('?');
    //arr[0]=>地址  '/aaa'
    var url=arr[0];
    //arr[1]=>数据  'user=blue&pass=123456'

    var arr2=arr[1].split('&');
    //arr2=>['user=blue', 'pass=123456']

    for(var i=0;i<arr2.length;i++){
      var arr3=arr2[i].split('=');
      //arr3[0]=>名字   'user'
      //arr3[1]=>数据   'blue'
      GET[arr3[0]]=arr3[1];
    }
  }else{
    var url=req.url;
  }


  console.log(url, GET);

  //req获取前台请求数据
  res.write('aaa');
  res.end();
}).listen(8080);
