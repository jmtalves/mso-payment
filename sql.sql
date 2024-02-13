create database if not exists payments;
use payments;

create table `payment` (
iduc bigint not null, 
`iduser` bigint not null, 
`created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP not null ,
`updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP  not null ON UPDATE CURRENT_TIMESTAMP,
`fail` tinyint not null
, primary key (iduc,iduser)
);