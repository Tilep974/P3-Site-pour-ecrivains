create database if not exists livre character set utf8 collate utf8_unicode_ci;
use livre;

grant all privileges on livre.* to 'livre_user'@'localhost' identified by 'secret';
