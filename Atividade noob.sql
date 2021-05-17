create database Cadastro;
use Cadastro;
drop table user;
create table user(
id int not null primary key auto_increment,
nome varchar(40) not null ,
email varchar(40)  not null ,
senha varchar (80)  not null,
mensagem varchar(256) not null

)engine=innodb;


select * from user;