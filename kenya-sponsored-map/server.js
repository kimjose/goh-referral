const connect = require('connect');
const serveStatic = require('serve-static');
const port = 9001;

function addMyHeaders(req, res, next) {
    res.setHeader('Access-Control-Allow-Origin', '*');
    next();
}
console.log(__dirname);
connect().use(addMyHeaders)
    .use(serveStatic(__dirname))
    .listen(port)
