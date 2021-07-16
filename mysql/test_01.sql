show databases;
use mysql;
show tables;
use information_schema;
show tables;


GRANT ALL PRIVILEGES ON amvara2.* TO 'foo2'@'test' WITH GRANT OPTION;
GRANT ALL PRIVILEGES ON amvara.* TO 'foo2'@'test' WITH GRANT OPTION;
GRANT ALL PRIVILEGES ON amvara2.* TO 'amvara'@'%' WITH GRANT OPTION;

select host, user from mysql.db;
select host, user from mysql.user;
