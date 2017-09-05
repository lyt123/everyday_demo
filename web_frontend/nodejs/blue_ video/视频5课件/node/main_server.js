const http=require('http');
const fs=require('fs');
const querystring=require('querystring');
const urlLib=require('url');


//这里的代码只会执行一次
console.log('进来了');

var server=http.createServer(function (req, res){
  //GET
  var obj=urlLib.parse(req.url, true);

  var url=obj.pathname;
  const GET=obj.query;
    //说明server里的代码会多次执行
    console.log('进来了');
  //POST
  var str='';
  req.on('data', function (data){
    str+=data;
  });

    req.on('end', function (){
    const POST=querystring.parse(str);
        console.log(POST);
        console.log(GET);

    /*
    url——要什么
    GET——get数据
    POST——post数据
    */

    //文件请求
    var file_name='./www'+url;
    fs.readFile(file_name, function (err, data){
      if(err){
        res.write('404');
      }else{
        res.write(data);
      }
      res.end();
    });
  });
});

server.listen(8081);
