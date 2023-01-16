var express = require('express');
var router = express.Router();
const indexController = require("../controllers/index");

router.get("/", indexController.getIndex);
router.get("/welcome", indexController.getWelcome);
router.get("/academy", indexController.getAcademy);
router.get("/academy/sql-injection", indexController.getSQLi);
router.get("/academy/command-injection", indexController.getCMDi);
router.get("/academy/file-upload-vulnerabilities", indexController.getFileUpload);
router.get("/academy/broken-authentication", indexController.getBrokenAuth);
router.get("/academy/cross-site-scripting", indexController.getXSS);
router.get("/academy/broken-access-control", indexController.getIDOR);

module.exports = router;