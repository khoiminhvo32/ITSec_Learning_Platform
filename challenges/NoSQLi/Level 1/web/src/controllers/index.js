const users = require("../models/user");

exports.getIndex = (req, res, next) => {
    return res.render("index");
};

exports.postLogin = (req, res, next) => {
    users.findOne({
        username: req.body.username,
        password: req.body.password
    }).then(user => {
        if (user) {
            if (req.body.username == "admin") {
                return res.send("You are now Admin, but then what, you still don't know my password 🙃");
            }
            return res.send("Login Successfully");
        }
        return res.send("Wrong username or password");
    })
};
