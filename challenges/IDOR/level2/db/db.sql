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

CREATE TABLE counters (
  num_posts int default 0
);

INSERT INTO counters VALUES (0);

CREATE TRIGGER post_counter    
    AFTER INSERT ON posts
    FOR EACH ROW
    UPDATE counters SET num_posts = num_posts + 1;        

INSERT INTO posts (post_id, content, author_id, public) VALUES ('MDAwMDAx', 'Welcome to Fakebook! Fakebook helps you connect and stalk your crush', 1, 1);
INSERT INTO posts (post_id, content, author_id, public) VALUES ('MDAwMDAy', 'Nice catch! You are rewarded XXXX$ by Fakebook', 1, 0);
INSERT INTO posts (post_id, content, author_id, public) VALUES ('MDAwMDAz', 'I love hackers <3 VIS{EnCrypt_iS_Gut_BUt_Iz_Dat_En0ugh??} <3', 2, 0);