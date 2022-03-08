use herblay
;

create table if not exists users(
	id_user smallint auto_increment primary key,
    fname varchar(30) not null,
    email varchar(100) not null unique,
    password varchar(255) not null,
    picture mediumblob
);