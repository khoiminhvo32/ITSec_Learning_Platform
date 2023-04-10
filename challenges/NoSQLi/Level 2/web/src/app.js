var cookieParser = require('cookie-parser');
var mongoose = require('mongoose');
var express = require('express');
var logger = require('morgan');
var dotenv = require('dotenv');
var path = require('path');
var app = express();
dotenv.config();

var indexRouter = require('./routes/index');

// database setup
const urlConnect = process.env.DB;
mongoose.connect(urlConnect, { useNewUrlParser: true, useUnifiedTopology: true });
var db = mongoose.connection;
db.on('error', console.error.bind(console, 'MongoDB connection error:'));

app.use(logger('dev'));
app.use(express.json());
app.use(express.urlencoded({ extended: true }));
app.use(cookieParser());

// view engine setup
app.set('views', path.join(__dirname, 'views'));
app.set('view engine', 'ejs');

// route setup
app.use("/", indexRouter);

app.listen(3000);
