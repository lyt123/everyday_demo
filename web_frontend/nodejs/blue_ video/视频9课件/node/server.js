const express=require('express');

var server=express();

/*
server.get('/', function (){
  console.log('有GET');
});
server.post('/', function (){
  console.log('有POST');
});
*/
server.use('/', function (){
  console.log('use了');
});

server.listen(8080);
