const http = require('http');
const fs = require('fs');

var server = http.createServer(function (req, res) {
    //req.url=>'/index.html'
    //读取=>'./www/index.html'
    //  './www'+req.url
    var file_name = './www' + req.url;

    fs.readFile(file_name, function (err, data) {
        if (err) {
            res.write('404');
        } else {
            res.write(data);
        }
        res.end();
    });

    //res.end()放在外面会出问题。异步执行的问题
    //res.end();

});

server.listen(8080);
