const users = require("../models/user");

exports.getIndex = (req, res, next) => {
    return res.render("index");
};

exports.getWelcome = (req, res, next) => {
    return res.render("welcome");
}