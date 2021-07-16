## docker-compose configuration

This configuration basically resembles a mix of [cmaessen's docker-php-sendmail](https://github.com/cmaessen/docker-php-sendmail) project and [mikechernev's NGINX configuration](https://github.com/mikechernev/dockerised-php). 

It includes the following:

- NGINX
  - port [8080](http://localhost:8080)
- PHP
  - FPM configured for NGINX
  - XDebug connecting to the docker host
  - place `.php` files into a directory named *"code"* for them to be executable
- sendmail
- MailDev
  - you might want to adjust the root mail address in `Dockerfile:17`
  - port [8081](http://localhost:8081)
- MySQL
  - you also might want to adjust the default password (which is *"password"*) in `docker-compose.yml`
  - port 3306
- phpmyadmin
  - defaults see `docker-compose.yml`, also consider changing the password here too
  - port [8082](http://localhost:8082)
  