const http=require('http');
const urlLib=require('url');

http.createServer(function (req, res){
  var obj=urlLib.parse(req.url, true);

  var url=obj.pathname;
  var GET=obj.query;

  console.log(url, GET);

  //req获取前台请求数据
  res.write('xaa');
  res.end();
}).listen(8081);
