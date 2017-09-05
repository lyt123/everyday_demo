const jade=require('jade');

var str=jade.renderFile('./views/8.jade', {pretty: true});

console.log(str);
