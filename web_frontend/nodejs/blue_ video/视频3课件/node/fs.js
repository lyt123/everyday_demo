const fs=require('fs');

//readFile(文件名, 回调函数)
fs.readFile('aaa.txt', function (err, data){
  if(err){
    console.log('读取失败');
  }else{
    console.log(data.toString());
  }
});

//fs.writeFile



