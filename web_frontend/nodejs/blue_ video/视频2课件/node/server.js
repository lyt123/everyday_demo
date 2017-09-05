const http=require('http');
//console.log('hehe');
var server=http.createServer(function (request, response){
  console.log('有人来了');
});

//监听——等着
//端口-数字
server.listen(8080);
