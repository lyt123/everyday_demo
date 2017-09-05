const urlLib=require('url');

var obj=urlLib.parse("http://www.zhinengshe.com/index?a=12&b=5", true);

console.log(obj.pathname, obj.query);
