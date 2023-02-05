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
  post_id char(32) primary key,
  content text,
  author_id int not null,
  public tinyint(1) not null
);

INSERT INTO posts (post_id, content, author_id, public) VALUES ('5a7041cfa5505e1f56a360b0ecbc32e3', 'Welcome to Fakebook! Fakebook helps you connect and stalk your crush', 1, 1);
INSERT INTO posts (post_id, content, author_id, public) VALUES ('843aee05febb92380748648dc6db311a', 'Nice catch! You are rewarded XXXX$ by Fakebook', 1, 0);
INSERT INTO posts (post_id, content, author_id, public) VALUES ('38405b03f1c29368beaaa94f24a1c893', 'I love hackers <3 VIS{Still_N0t_So_Gut_L0gic!!} <3', 2, 0);