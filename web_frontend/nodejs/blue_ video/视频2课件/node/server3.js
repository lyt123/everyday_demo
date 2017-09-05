const http=require('http');

var server=http.createServer(function (req, res){
  switch(req.url){
    case '/1.html':
      res.write("111111");
      break;
    case '/2.html':
      res.write("2222");
      break;
    default:
      res.write('404');
      break;
  }

  res.end();
});

//监听——等着
//端口-数字
server.listen(8080);

//http://localhost:8080/
