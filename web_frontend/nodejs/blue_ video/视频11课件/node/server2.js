const express=require('express');
const cookieParser=require('cookie-parser');

var server=express();



//cookie
server.use(cookieParser());

server.use('/', function (req, res){
  console.log(req.cookies);

  res.send('ok');
});

server.listen(8080);
