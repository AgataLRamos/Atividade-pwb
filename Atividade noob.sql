create database Cadastro;
use Cadastro;
drop table user;
create table user(
id int not null primary key auto_increment,
nome varchar(40) not null ,
email varchar(40)  not null ,
senha varchar (80)  not null,
telefone varchar(40)

)engine=innodb;

insert into user values (1, 'Agata', 'agata.ligi@hotmail.com', '98723456712','123');
select * from user;