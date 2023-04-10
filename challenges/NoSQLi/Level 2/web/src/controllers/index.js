const users = require("../models/user");

exports.getIndex = (req, res, next) => {
    return res.render("index");
};

exports.postLogin = (req, res, next) => {
    users.findOne({
        username: String(req.body.username),
        password: String(req.body.password)
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

exports.postSearch = (req, res, next) => {
  if (req.body.hasOwnProperty("password"))
    return res.json({ error: "Permission Denied" });

  // NOT return _id, password fields
  users.find(req.body).select({ "_id": 0, "password": 0 })
    .then(members => { return res.json(members); })
    .catch(err => { return res.json({ error: err.message }); });
};