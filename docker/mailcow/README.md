# Mailcow Documentation

This documentation is made for **debian** and **ubuntu**

----

## [Prerequisites](https://mailcow.github.io/mailcow-dockerized-docs/prerequisite-system/)

## Requisites

### System

| Resource    | mailcow: dockerized                             |
| ----------- | ----------------------------------------------- |
| CPU         | 1 GHz                                           |
| RAM         | **Minimum** 6 GiB + 1 GiB swap (default config) |
| Disk        | 20 GiB (without emails)                         |
| System Type | x86_64                                          |

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
    curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /usr/share/keyrings/docker-archive-keyring.gpg
    apt-get remove -y docker docker-engine docker.io containerd runc
    echo "deb [arch=amd64 signed-by=/usr/share/keyrings/docker-archive-keyring.gpg] https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null
    ```

  * Install docker

    ```shell
    apt-get update
    apt-get install docker-ce docker-ce-cli containerd.io
    ```

* Docker-Compose

    ```shell
    curl -L "https://github.com/docker/compose/releases/download/1.29.2/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
    chmod +x /usr/local/bin/docker-compose
    ln -s /usr/local/bin/docker-compose /usr/bin/docker-compose
    ```

## Installation

<!--TODO copiar comandos -->

## Configuration

<!-- TODO añadir los archivos modificados -->

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

h3. Change admin password

It is very important to change the default password of the administrator to avoid security flaws

Acces -> Administrators -> Edit
!Captura%20de%20pantalla%202021-07-23%20111404.png!


h2. Changelog

2021-07-21 RRO add alias "localhost" to domain "amvara.eu" to avoid watchdog mails, changed <code>[::1]/128 [fe80::]/10 172.22.1.0/24 [fd4d:6169:6c63:6f77::]/64 192.168.2.0/24
</code> in "/opt/mailcow-dockerized/data/conf/postfix/extra.cf"