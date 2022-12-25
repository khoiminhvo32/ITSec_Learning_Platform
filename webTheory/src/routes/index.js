var express = require('express');
var router = express.Router();
const indexController = require("../controllers/index");

router.get("/", indexController.getIndex);
router.get("/welcome", indexController.getWelcome);
router.get("/academy", indexController.getAcademy);
router.get("/academy/sql-injection", indexController.getSQLi);

module.exports = router;