const ejs=require('ejs');

ejs.renderFile('./views/6.ejs', {type: 'admin'}, function (err, data){
  console.log(data);
});
