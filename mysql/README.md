
# AMA - Ask me Anything Session 01.05.2021

Preguntas:
* Configurar derechos de accesso a mySQL desde cli 
* Que son indices, para que sirven


# start container

```docker-compose up -d```

See docker-compose.yml ... mirar los puertos abiertos. Tener cuidado cuando estas conectado al internet.

See open ports:
sudo netstat -tulpn | grep -i listen


# connect to container
```docker inspect ama_mariadb | grep -i ipad```
```mysql --host=172.30.0.2 --user=root amvara --password=changeme```

# Access Control and Account Management

See: 
* mySQL https://dev.mysql.com/doc/refman/8.0/en/access-control.html
* mariadb https://mariadb.com/kb/en/account-management-sql-commands/

```mysql> show databases;
+--------------------+
| Database           |
+--------------------+
| amvara             |
| information_schema |
| mysql              |
| performance_schema |
+--------------------+
4 rows in set (0.00 sec)

mysql> use mysql;
Reading table information for completion of table and column names
You can turn off this feature to get a quicker startup with -A

Database changed
mysql> show tables;
+---------------------------+
| Tables_in_mysql           |
+---------------------------+
| column_stats              |
| columns_priv              |
| db                        |
| event                     |
| func                      |
| general_log               |
| gtid_slave_pos            |
| help_category             |
| help_keyword              |
| help_relation             |
| help_topic                |
| host                      |
| index_stats               |
| innodb_index_stats        |
| innodb_table_stats        |
| plugin                    |
| proc                      |
| procs_priv                |
| proxies_priv              |
| roles_mapping             |
| servers                   |
| slow_log                  |
| table_stats               |
| tables_priv               |
| time_zone                 |
| time_zone_leap_second     |
| time_zone_name            |
| time_zone_transition      |
| time_zone_transition_type |
| user                      |
+---------------------------+
30 rows in set (0.00 sec)

mysql> select host, user  from user;
+-----------+--------+
| host      | user   |
+-----------+--------+
| %         | amvara |
| %         | root   |
| localhost | root   |
+-----------+--------+

mysql> update mysql.user set host='localhost' where host = '%';
ERROR 1062 (23000): Duplicate entry 'localhost-root' for key 'PRIMARY'
mysql> delete from mysql.user where host = '%';
Query OK, 1 row affected (0.01 sec)

mysql> select host,user from  mysql.user;
+-----------+--------+
| host      | user   |
+-----------+--------+
| localhost | amvara |
| localhost | root   |
+-----------+--------+
2 rows in set (0.00 sec)
```

# Create a user

```
select host,user from mysql.user;
select * from mysql.db;
use information_schema;
select * from USER_PRIVILEGES;
select * from information_schema.USER_PRIVILEGES;


CREATE USER foo2@test IDENTIFIED BY 'password';

SHOW CREATE USER 'foo2'@'test';
```

```
CREATE USER foo3@test IDENTIFIED BY 'password
    MAX_USER_CONNECTIONS 10
    MAX_QUERIES_PER_HOUR 200
    PASSWORD EXPIRE INTERVAL 120 DAY;
```

```
CREATE USER 'amvara_dev'@'localhost'
  IDENTIFIED WITH caching_sha2_password BY 'changeme'
  PASSWORD EXPIRE INTERVAL 180 DAY
  FAILED_LOGIN_ATTEMPTS 3 PASSWORD_LOCK_TIME 2;
```


```
SHOW GRANTS FOR 'root'@'localhost';
SHOW PRIVILEGES;

mysql> GRANT ALL PRIVILEGES ON amvara2.* TO 'foo2'@'test' WITH GRANT OPTION;
Query OK, 0 rows affected, 1 warning (0.00 sec)

mysql> select * from mysql.db;
+------+---------+--------+-------------+-------------+-------------+-------------+-------------+-----------+------------+-----------------+------------+------------+-----------------------+------------------+------------------+----------------+---------------------+--------------------+--------------+------------+--------------+
| Host | Db      | User   | Select_priv | Insert_priv | Update_priv | Delete_priv | Create_priv | Drop_priv | Grant_priv | References_priv | Index_priv | Alter_priv | Create_tmp_table_priv | Lock_tables_priv | Create_view_priv | Show_view_priv | Create_routine_priv | Alter_routine_priv | Execute_priv | Event_priv | Trigger_priv |
+------+---------+--------+-------------+-------------+-------------+-------------+-------------+-----------+------------+-----------------+------------+------------+-----------------------+------------------+------------------+----------------+---------------------+--------------------+--------------+------------+--------------+
| %    | amvara  | amvara | Y           | Y           | Y           | Y           | Y           | Y         | N          | Y               | Y          | Y          | Y                     | Y                | Y                | Y              | Y                   | Y                  | Y            | Y          | Y            |
| test | amvara  | foo2   | Y           | Y           | Y           | Y           | Y           | Y         | Y          | Y               | Y          | Y          | Y                     | Y                | Y                | Y              | Y                   | Y                  | Y            | Y          | Y            |
| test | amvara2 | foo2   | Y           | Y           | Y           | Y           | Y           | Y         | Y          | Y               | Y          | Y          | Y                     | Y                | Y                | Y              | Y                   | Y                  | Y            | Y          | Y            |
+------+---------+--------+-------------+-------------+-------------+-------------+-------------+-----------+------------+-----------------+------------+------------+-----------------------+------------------+------------------+----------------+---------------------+--------------------+--------------+------------+--------------+
3 rows in set (0.00 sec)
```

https://mariadb.com/kb/en/grant/

mysql --host=172.31.0.2 --user=root --password=changeme < test_01.sql 
# notes

