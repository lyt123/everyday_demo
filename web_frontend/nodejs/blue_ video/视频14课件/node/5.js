const ejs=require('ejs');

ejs.renderFile('./views/5.ejs', {}, function (err, data){
  console.log(data);
});
