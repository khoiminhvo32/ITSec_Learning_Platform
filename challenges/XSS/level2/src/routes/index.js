var express = require('express');
var router = express.Router();

router.get('/', function (req, res, next) {
    res.render('index');
});

// Note search feature
router.get('/search', function (req, res, next) {
    // Sử dụng regex để replace <script> tag
    // Flag g: dùng để match tất cả ký tự trong mẫu tìm kiếm
    // Flag i: case insensitve không phân biệt chữ hoa chữ thường
    sanitized_q = req.query.q.replace(/<script>|<\/script>/gi, "");
    html = '<script> (function() {var _old_alert = window.alert;window.alert = function() {document.body.innerHTML += "<br>";_old_alert.apply(window,arguments);document.body.innerHTML += "<b>Here is your flag: ' + process.env.FLAG + '</b><br>";};})();</script>';
    html += 'Your search - <b>' + sanitized_q + '</b> - did not match any notes.<br><br>'
    res.send(html);
});

module.exports = router;
