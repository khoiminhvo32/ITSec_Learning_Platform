drop database myDB;
create database IF NOT EXISTS myDB;

use myDB;

CREATE TABLE users (
  user_id int primary key auto_increment,
  username varchar(30) not null,
  password varchar(40) not null
);

INSERT INTO users (username, password) VALUES ('admin','thisisapassword');
INSERT INTO users (username, password) VALUES ('crush','1z8m81z2y1zy28z');

CREATE TABLE posts (
  post_id int primary key auto_increment,
  content text,
  author_id int not null,
  public tinyint(1) not null
);

INSERT INTO posts (content, author_id, public) VALUES ('Welcome to Fakebook! Fakebook helps you connect and stalk your crush', 1, 1);
INSERT INTO posts (content, author_id, public) VALUES ('Nice catch! You are rewarded XXXX$ by Fakebook', 1, 0);
INSERT INTO posts (content, author_id, public) VALUES ('I love hackers <3 VIS{Easy_ReaDing_@Dmin_P0sts} <3', 2, 0);