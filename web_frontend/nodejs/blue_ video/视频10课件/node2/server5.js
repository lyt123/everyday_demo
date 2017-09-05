const express=require('express');
const bodyParser2=require('./libs/my-body-parser');

var server=express();
server.listen(8080);

server.use(bodyParser2.aaa());

server.use('/', function (req, res){
  console.log(req.body);
});
