var express = require('express');
var router = express.Router();

router.get('/', function (req, res, next) {
    res.render('index');
});

// Note search feature
router.get('/search', function (req, res, next) {
    // Don't allow script keyword
    if (req.query.q.search(/script/i) > 0) {
        res.send('Hack detected');
        return;
    }
    html = '<script> (function() {var _old_alert = window.alert;window.alert = function() {document.write("<br>");_old_alert.apply(window,arguments);document.write("<b>Here is your flag: ' + process.env.FLAG + '</b><br>");};})();</script>';
    html += 'Your search - <b>' + req.query.q + '</b> - did not match any notes.<br><br>'
    res.send(html);
});

module.exports = router;
