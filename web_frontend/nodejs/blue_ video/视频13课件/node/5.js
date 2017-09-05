const jade=require('jade');

console.log(jade.renderFile('./views/11.jade', {pretty: true,
  arr: ['aaa', 'sfasdf', '3423', 'asdfasdf']
}));
