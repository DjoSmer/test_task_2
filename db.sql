create table statuses
(
  id int auto_increment
    primary key,
  type varchar(10) not null,
  name varchar(30) not null
)
;

create table tasks
(
  id int auto_increment
    primary key,
  user_id int not null,
  status_id int not null,
  text text not null,
  create_at datetime default CURRENT_TIMESTAMP null,
  update_at datetime default CURRENT_TIMESTAMP null
)
;

create table users
(
  id int auto_increment
    primary key,
  name varchar(30) not null,
  email varchar(30) not null,
  password varchar(30) null,
  is_admin tinyint(1) default '0' null,
  create_at datetime default CURRENT_TIMESTAMP null
)
;

INSERT INTO db_tasks.users (name, email, password, is_admin) VALUES ('admin', 'admin@taks.com', '123', 1);

INSERT INTO db_tasks.statuses (type, name) VALUES ('task', 'Новая');
INSERT INTO db_tasks.statuses (type, name) VALUES ('task', 'Выполнена');