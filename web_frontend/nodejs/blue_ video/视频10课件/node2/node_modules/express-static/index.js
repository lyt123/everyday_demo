var fs		= require('fs');
var url		=	require('url');
var path	= require('path');
var mime 	= require('mime');

var Static = function(options){
	this.options = options;
};

Static.prototype.send = function(req, res, next){
	var uri = url.parse(req.url);
	var pathname = uri.pathname;
	if(/\/$/.test(pathname)) pathname += 'index.html';
	var filename = path.join(this.options.root, pathname);
	fs.stat(filename, function(err, stat){
		if(err){
			return next((~[ 'ENOENT' ].indexOf(err.code)) ? null : err);
		}
		if(stat.isDirectory()) return res.redirect(pathname + '/'); 
		var type = mime.lookup(filename);
		var charset = mime.charsets.lookup(type);
		res.setHeader('Content-Type'	, type + (charset ? '; charset=' + charset : '' ));
		res.setHeader('Content-Length', stat.size);
		res.setHeader('Last-Modified'	, stat.mtime.toUTCString());
		
		fs.createReadStream(filename).pipe(res);
	});
};

module.exports = function(root, options){
	options = options || {};
	options.root = root;
	var static = new Static(options);	
	return function(req, res, next){
		static.send.apply(static, arguments)
	};
};
