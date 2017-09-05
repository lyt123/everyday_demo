const express=require('express');
const cookieParser=require('cookie-parser');

var server=express();



//cookie
server.use(cookieParser('wesdfw4r34tf'));

server.use('/', function (req, res){
  res.clearCookie('user');

  res.send('ok');
});

server.listen(8080);
