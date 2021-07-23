# Mailcow Documentation

This documentation is made for **debian** and **ubuntu**

----

## [Prerequisites](https://mailcow.github.io/mailcow-dockerized-docs/prerequisite-system/)

### System

| Resource    | mailcow: dockerized                             |
| ----------- | ----------------------------------------------- |
| CPU         | 1 GHz                                           |
| RAM         | **Minimum** 6 GiB + 1 GiB swap (default config) |
| Disk        | 20 GiB (without emails)                         |
| System Type | x86_64                                          |

## Requisites

### Packages

* Git

    ```shell
    apt install git
    ```

* Python 3

    ```shell
    apt install python3-pip
    ```

* Docker `(version >= 20.10.2)`
  * Docker requisites

    ```shell
    apt-get update
    apt-get install -y apt-transport-https ca-certificates curl gnupg lsb-release
    LINUX_DISTRO=$(lsb_release -is)
    curl -fsSL https://download.docker.com/linux/${LINUX_DISTRO,,}/gpg | sudo gpg --dearmor -o /usr/share/keyrings/docker-archive-keyring.gpg
    apt-get remove -y docker docker-engine docker.io containerd runc
    echo "deb [arch=amd64 signed-by=/usr/share/keyrings/docker-archive-keyring.gpg] https://download.docker.com/linux/${LINUX_DISTRO,,} $(lsb_release -cs) stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null
    ```

  * Install docker

    ```shell
    apt-get update
    apt-get install docker-ce docker-ce-cli containerd.io
    ```

* Docker-Compose [(Use the latest release)](https://github.com/docker/compose/releases/latest)

    ```shell
    COMPOSE_VERSION="1.29.2"
    curl -L "https://github.com/docker/compose/releases/download/${COMPOSE_VERSION}/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
    chmod +x /usr/local/bin/docker-compose
    ln -s /usr/local/bin/docker-compose /usr/bin/docker-compose
    ```

## Installation

<!-- TODO mejorar esto con ejemplos -->

```shell
cd /opt
git clone https://github.com/mailcow/mailcow-dockerized
cd mailcow-dockerized
./generate_config.sh
mail.axample.com
Europe/Madrid
docker-compose pull
docker-compose up -d
```

## Configuration

<!-- TODO añadir los archivos modificados -->

* Edited `mailcow.conf`
  * Added watchdog mail sender
* Edited `extra.cf`
  * Added

    ```shell
    mynetworks = 127.0.0.0/8 [::ffff:127.0.0.0]/104 [::1]/128 [fe80::]/10 172.22.1.0/24 [fd4d:6169:6c63:6f77::]/64 192.168.2.0/24
    ```

## Web configuration

### First login

* Default user: `admin`
* Default password: `moohoo`

https://user-images.githubusercontent.com/57411642/126798996-b262765f-a3f2-49d4-88e6-4b952d4f4666.mp4

### Change password policy

It is advisable to change the password policy to increase security

Configuration -> Password policy

https://user-images.githubusercontent.com/57411642/126799042-f6afef00-cab7-4b62-b0e4-51f5db5e51c6.mp4

### Change admin password

It is very important to change the default password of the administrator to avoid security flaws

Acces -> Administrators -> Edit

https://user-images.githubusercontent.com/57411642/126799085-c528c2d9-ba61-44aa-8012-886fc3421ddc.mp4

### Implement 2FA to admin

<!-- Regrabar video-->

https://user-images.githubusercontent.com/57411642/126799404-7366b478-67a4-4764-af16-2e9bf4dd7f16.mp4

### Enable rspamd

https://user-images.githubusercontent.com/57411642/126799516-c040f32d-aa7f-4c22-ba2e-07051978a348.mp4

### Configure fail2ban

https://user-images.githubusercontent.com/57411642/126800058-783c1bde-3720-4d10-86c1-29997409cda1.mp4

### Personalize webadmin

https://user-images.githubusercontent.com/57411642/126800169-eb53c23d-7c15-4ae9-bb82-adad0b9d6cb5.mp4

### Create mail domain

https://user-images.githubusercontent.com/57411642/126800872-e2da8fc8-bbc5-479a-b9fc-8d15f8a7c88e.mp4

### Create dkim key for dns record

https://user-images.githubusercontent.com/57411642/126800932-e9f5cd94-0c5b-41c6-a51a-fa321c539dc3.mp4

### Create mail user 

https://user-images.githubusercontent.com/57411642/126801021-08144bd5-0046-414d-8ba2-893538d297c4.mp4

## Configure DNS

### Check DNS configuration

https://user-images.githubusercontent.com/57411642/126801090-49d51d1b-d94c-40a0-a5cf-f8b72478c92a.mp4

## Changelog

2021-07-21 RRO add alias "localhost" to domain "amvara.eu" to avoid watchdog mails, changed `[::1]/128 [fe80::]/10 172.22.1.0/24 [fd4d:6169:6c63:6f77::]/64 192.168.2.0/24` in "/opt/mailcow-dockerized/data/conf/postfix/extra.cf"
