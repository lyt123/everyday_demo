var str='\
aaa\n\
\n\
asdfasdfasdfafsdasdf\n\
aaa\n\
\n\
asdfasdfasdfafsdasdf\n\
';

var str2=str.replace(/^/gm, '<p>').replace(/$/gm, '</p>');

console.log(str2);
