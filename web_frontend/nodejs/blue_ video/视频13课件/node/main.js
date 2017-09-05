const jade=require('jade');
const fs=require('fs');

var str=jade.renderFile('./views/index.jade', {pretty: true});

fs.writeFile('./build/index.html', str, function (err){
  if(err)
    console.log('编译失败');
  else
    console.log('成功');
});
