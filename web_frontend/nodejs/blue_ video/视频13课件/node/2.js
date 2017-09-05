const jade=require('jade');

console.log(jade.renderFile('./views/7.jade', {pretty: true, a: 12, b: 5}));
