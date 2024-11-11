
create database product_crud;
use product_crud;

create table products (
id int auto_increment primary key ,
product_name varchar(120) unique not null , 
product_desc varchar(255) not null , 
product_price varchar(50) not null ,
discount int default 0 ,
quantity int default 0 , 
thumbnail varchar(255) not null 
);

