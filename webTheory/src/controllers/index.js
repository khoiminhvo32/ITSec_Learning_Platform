// const users = require("../models/user");

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

exports.getFileUpload = (req, res, next) => {
    return res.render("file-upload-vulnerabilities");
}

exports.getBrokenAuth = (req, res, next) => {
    return res.render("broken-authentication");
}

exports.getXSS = (req, res, next) => {
    return res.render("xss");
}

exports.getIDOR = (req, res, next) => {
    return res.render("idor");
}

exports.getPathTraversal = (req, res, next) => {
    return res.render("path-traversal");
}

exports.getInfoDisclosure = (req, res, next) => {
    return res.render("information-disclosure");
}

exports.getSSRF = (req, res, next) => {
    return res.render("ssrf");
}

exports.getAdvanced = (req, res, next) => {
    return res.render("advanced-challenges");
}