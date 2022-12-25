const users = require("../models/user");

exports.getIndex = (req, res, next) => {
    return res.render("index");
};

exports.getWelcome = (req, res, next) => {
    return res.render("welcome");
}

exports.getAcademy = (req, res, next) => {
    return res.render("academy");
}

exports.getSQLi = (req, res, next) => {
    return res.render("sql-injection");
}

exports.getCMDi = (req, res, next) => {
    return res.render("command-injection");
}