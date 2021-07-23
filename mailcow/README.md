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

### Change password policy

It is advisable to change the password policy to increase security

Configuration -> Password policy

* Before
[PNG]
* After
[PNG]

### Change admin password

It is very important to change the default password of the administrator to avoid security flaws

Acces -> Administrators -> Edit

## Changelog

2021-07-21 RRO add alias "localhost" to domain "amvara.eu" to avoid watchdog mails, changed `[::1]/128 [fe80::]/10 172.22.1.0/24 [fd4d:6169:6c63:6f77::]/64 192.168.2.0/24` in "/opt/mailcow-dockerized/data/conf/postfix/extra.cf"
