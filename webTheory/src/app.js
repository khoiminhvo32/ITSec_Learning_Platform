var cookieParser = require('cookie-parser');
var mongoose = require('mongoose');
var express = require('express');
var logger = require('morgan');
var dotenv = require('dotenv');
var path = require('path');
var app = express();
dotenv.config();

var indexRouter = require('./routes/index');

app.use(logger('dev'));
app.use(express.json());
app.use(cookieParser());

const publicDir = path.join(__dirname, 'views');
app.use(express.static(publicDir));

// view engine setup
app.set('view engine', 'ejs');

// route setup
app.use("/", indexRouter);

app.listen(3000);
