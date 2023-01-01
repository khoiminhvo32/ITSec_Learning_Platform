var express = require('express');
var router = express.Router();
const indexController = require("../controllers/index");

router.get("/", indexController.getIndex);
router.get("/welcome", indexController.getWelcome);
router.get("/academy", indexController.getAcademy);
router.get("/academy/sql-injection", indexController.getSQLi);
router.get("/academy/command-injection", indexController.getCMDi);
router.get("/academy/file-upload-vulnerabilities", indexController.getFileUpload);

module.exports = router;