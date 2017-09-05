const ejs=require('ejs');

ejs.renderFile('./views/4.ejs', {}, function (err, data){
  console.log(data);
});
