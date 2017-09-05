exports.sum=function (){
  var res=0;

  for(var i=0;i<arguments.length;i++){
    res+=arguments[i];
  }

  return res;
};

exports.div=function (a, b){
  return a/b;
};
