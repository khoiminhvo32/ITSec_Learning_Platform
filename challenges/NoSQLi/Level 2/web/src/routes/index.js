var express = require('express');
var router = express.Router();
const indexController = require("../controllers/index");

router.get("/", indexController.getIndex);
router.post("/login", indexController.postLogin);
router.post("/search", indexController.postSearch);

module.exports = router;