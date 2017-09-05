const jade=require('jade');

console.log(jade.renderFile('./views/6.jade', {pretty: true, name: 'blue'}));
