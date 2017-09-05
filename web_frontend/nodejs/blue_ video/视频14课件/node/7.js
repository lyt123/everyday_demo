const ejs=require('ejs');

ejs.renderFile('./views/7.ejs', {css_path: '../style/admin.css'}, function (err, data){
  console.log(data);
});
