# Mailcow Documentation

This documentation is made for **debian** and **ubuntu**

----

## Prerequisites

### [System](https://mailcow.github.io/mailcow-dockerized-docs/prerequisite-system/#minimum-system-resources)

| Resource    | mailcow: dockerized                             |
| ----------- | ----------------------------------------------- |
| CPU         | 1 GHz                                           |
| RAM         | **Minimum** 6 GiB + 1 GiB swap (default config) |
| Disk        | 20 GiB (without emails)                         |
| System Type | x86_64                                          |

### [Firewall & Ports](https://mailcow.github.io/mailcow-dockerized-docs/prerequisite-system/#firewall-ports)

Check that the ports required for mailcow are not being used:

  ```bash
  ss -tlpn | grep -E -w '25|80|110|143|443|465|587|993|995|4190|5222|5269|5443'
  # or:
  netstat -tulpn | grep -E -w '25|80|110|143|443|465|587|993|995|4190|5222|5269|5443'
  ```

#### Default ports

If you have a firewall in front of mailcow, please make sure that these ports are open for incoming connections:

| Service             | Protocol | Port | Container       | Variable             |
| ------------------- | -------- | ---- | --------------- | -------------------- |
| Postfix SMTP        | TCP      | 25   | postfix-mailcow | `${SMTP_PORT}`       |
| Postfix SMTPS       | TCP      | 465  | postfix-mailcow | `${SMTPS_PORT}`      |
| Postfix Submission  | TCP      | 587  | postfix-mailcow | `${SUBMISSION_PORT}` |
| Dovecot IMAP        | TCP      | 143  | dovecot-mailcow | `${IMAP_PORT}`       |
| Dovecot IMAPS       | TCP      | 993  | dovecot-mailcow | `${IMAPS_PORT}`      |
| Dovecot POP3        | TCP      | 110  | dovecot-mailcow | `${POP_PORT}`        |
| Dovecot POP3S       | TCP      | 995  | dovecot-mailcow | `${POPS_PORT}`       |
| Dovecot ManageSieve | TCP      | 4190 | dovecot-mailcow | `${SIEVE_PORT}`      |
| HTTP                | TCP      | 80   | nginx-mailcow   | `${HTTP_PORT}`       |
| HTTPS               | TCP      | 443  | nginx-mailcow   | `${HTTPS_PORT}`      |

### [Configure DNS](https://mailcow.github.io/mailcow-dockerized-docs/prerequisite-dns/)

Records required for mail server and its good reputation

#### Reverse DNS

Make sure the PTR matches your FQDN, most mailservers check it.
This record is usually changed with the server provider.

> Ejemplo:  
> `4.3.2.1.in-addr.arpa`

#### DNS Records

```dns
# Name              Type       Value
mail                IN A       1.2.3.4

# Name              Type       Value
autodiscover        IN CNAME   mail.example.org. (your ${MAILCOW_HOSTNAME})
autoconfig          IN CNAME   mail.example.org. (your ${MAILCOW_HOSTNAME})

# Name              Type       Value
@                   IN MX 10   mail.example.org. (your ${MAILCOW_HOSTNAME})

# Name              Type       Value
@                   IN TXT     "v=spf1 mx a -all"
_dmarc              IN TXT     "v=DMARC1; p=reject;"
_caldavs._tcp       IN TXT     "path=/SOGo/dav/"
_carddavs._tcp      IN TXT     "path=/SOGo/dav/"

# Name              Type       Priority Weight Port    Value
_autodiscover._tcp  IN SRV     0        1      443      mail.example.org. (your ${MAILCOW_HOSTNAME})
_caldavs._tcp       IN SRV     0        1      443      mail.example.org. (your ${MAILCOW_HOSTNAME})
_carddavs._tcp      IN SRV     0        1      443      mail.example.org. (your ${MAILCOW_HOSTNAME})
_imap._tcp          IN SRV     0        1      143      mail.example.org. (your ${MAILCOW_HOSTNAME})
_imaps._tcp         IN SRV     0        1      993      mail.example.org. (your ${MAILCOW_HOSTNAME})
_pop3._tcp          IN SRV     0        1      110      mail.example.org. (your ${MAILCOW_HOSTNAME})
_pop3s._tcp         IN SRV     0        1      995      mail.example.org. (your ${MAILCOW_HOSTNAME})
_sieve._tcp         IN SRV     0        1      4190     mail.example.org. (your ${MAILCOW_HOSTNAME})
_smtp._tcp          IN SRV     0        1      25       mail.example.org. (your ${MAILCOW_HOSTNAME})
_smtps._tcp         IN SRV     0        1      465      mail.example.org. (your ${MAILCOW_HOSTNAME})
_submission._tcp    IN SRV     0        1      587      mail.example.org. (your ${MAILCOW_HOSTNAME})
```

## [Requisites](https://mailcow.github.io/mailcow-dockerized-docs/i_u_m_install/)

### Packages

* Git

    ```bash
    apt install git
    ```

* Python 3

    ```bash
    apt install python3-pip
    ```

* Docker `(version >= 20.10.2)`
  * Docker requisites

    ```bash
    apt-get update
    apt-get install -y apt-transport-https ca-certificates curl gnupg lsb-release
    LINUX_DISTRO=$(lsb_release -is)
    curl -fsSL https://download.docker.com/linux/${LINUX_DISTRO,,}/gpg | sudo gpg --dearmor -o /usr/share/keyrings/docker-archive-keyring.gpg
    apt-get remove -y docker docker-engine docker.io containerd runc
    echo "deb [arch=amd64 signed-by=/usr/share/keyrings/docker-archive-keyring.gpg] https://download.docker.com/linux/${LINUX_DISTRO,,} $(lsb_release -cs) stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null
    ```

  * Install docker

    ```bash
    apt-get update
    apt-get install docker-ce docker-ce-cli containerd.io
    ```

* Docker-Compose [(Use the latest release)](https://github.com/docker/compose/releases/latest)

    ```bash
    COMPOSE_VERSION="1.29.2"
    curl -L "https://github.com/docker/compose/releases/download/${COMPOSE_VERSION}/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
    chmod +x /usr/local/bin/docker-compose
    ln -s /usr/local/bin/docker-compose /usr/bin/docker-compose
    ```

## [Installation](https://mailcow.github.io/mailcow-dockerized-docs/i_u_m_install/)

<!-- TODO mejorar esto con ejemplos -->

```bash
cd /opt
git clone https://github.com/mailcow/mailcow-dockerized
cd mailcow-dockerized
./generate_config.sh
# Mail server hostname (FQDN) - this is not your mail domain, but your mail servers hostname: 
mail.example.com
# Timezone [Europe/Madrid]:
Europe/Madrid
docker-compose pull
```

> **Note of envoirement variable**  
> **`FQDN = ${MAILCOW_HOSTNAME}`**

## File Configuration

<!-- TODO añadir los archivos modificados -->

* Edited `mailcow.conf`
  * Added watchdog mail sender

  > Only edit `WATCHDOG_NOTIFY_EMAIL`, this environment variable already exists in the file

  ```bash
  # Send watchdog notifications by mail (sent from watchdog@MAILCOW_HOSTNAME)
  # CAUTION:
  # 1. You should use external recipients
  # 2. Mails are sent unsigned (no DKIM)
  # 3. If you use DMARC, create a separate DMARC policy ("v=DMARC1; p=none;" in _dmarc.MAILCOW_HOSTNAME)
  # Multiple rcpts allowed, NO quotation marks, NO spaces

  #WATCHDOG_NOTIFY_EMAIL=a@example.com,b@example.com,c@example.com
  WATCHDOG_NOTIFY_EMAIL=send@example.com
  ```

* Edited `extra.cf`
  * Added

    ```bash
    mynetworks = 127.0.0.0/8 [::ffff:127.0.0.0]/104 [::1]/128 [fe80::]/10 172.22.1.0/24 [fd4d:6169:6c63:6f77::]/64 192.168.2.0/24
    ```

* Start mailcow

  ```bash
  docker-compose up -d
  ```

## Web configuration

### First login

> Dashboard: `https://${MAILCOW_HOSTNAME}`

* Default user:
  * username: `admin`
  * password: `moohoo`

<https://user-images.githubusercontent.com/57411642/126798996-b262765f-a3f2-49d4-88e6-4b952d4f4666.mp4>

### Change password policy

It is advisable to change the password policy to increase security.  
Configuration -> Password policy

<https://user-images.githubusercontent.com/57411642/126799042-f6afef00-cab7-4b62-b0e4-51f5db5e51c6.mp4>

### Change admin password

It is very important to change the default password of the administrator to avoid security flaws.  
Acces -> Administrators -> Edit

<https://user-images.githubusercontent.com/57411642/126799085-c528c2d9-ba61-44aa-8012-886fc3421ddc.mp4>

### Implement 2FA to admin

Increase security in case of password theft by preventing access if you do not have a token.  
Access -> Administrator -> Two-factor authentication: Please select -> Time-based OTP

<!-- Regrabar video-->

<https://user-images.githubusercontent.com/57411642/126799404-7366b478-67a4-4764-af16-2e9bf4dd7f16.mp4>

### [Enable Rspamd UI](https://mailcow.github.io/mailcow-dockerized-docs/firststeps-rspamd_ui/)

[Rspamd documentation](https://rspamd.com/doc/index.html)

Access -> Rspamd UI

<https://user-images.githubusercontent.com/57411642/126799516-c040f32d-aa7f-4c22-ba2e-07051978a348.mp4>

> **Acces to Rspamd UI**  
> **`https://${MAILCOW_HOSTNAME}/rspamd`**

### Configure fail2ban

Configuration -> Fail2ban parameters

<!-- No se si debería explicar un poco cada parámetro -->

<https://user-images.githubusercontent.com/57411642/126800058-783c1bde-3720-4d10-86c1-29997409cda1.mp4>

### Personalize webadmin

Configuration -> Customize

<https://user-images.githubusercontent.com/57411642/126800169-eb53c23d-7c15-4ae9-bb82-adad0b9d6cb5.mp4>

### Create mail domain

Top menu bar -> Configuration -> Mail Setup

<https://user-images.githubusercontent.com/57411642/126800872-e2da8fc8-bbc5-479a-b9fc-8d15f8a7c88e.mp4>

### Create dkim key for dns record

Top menu bar -> Mail Setup -> Configuration --> Configuration -> ARC/DKIM keys

<https://user-images.githubusercontent.com/57411642/127067551-534ec12a-c9cc-495e-9425-8d9b150d0b80.mp4>

* Add dkim in dns

  ```dns
  # Name              Type       Value
  dkim._domainkey     IN TXT     (Paste dkim register)
  ```

### Create mail user

Top menu bar -> Configuration -> Mail Setup -> Mailboxes

<https://user-images.githubusercontent.com/57411642/126801021-08144bd5-0046-414d-8ba2-893538d297c4.mp4>

> Webmail: `https://[FQDN]/SOGo/`  
> Top menu bar -> Apps -> Webmail

#### Check DNS configuration --> Domains --> DNS

<https://user-images.githubusercontent.com/57411642/126801090-49d51d1b-d94c-40a0-a5cf-f8b72478c92a.mp4>

## [Update](https://mailcow.github.io/mailcow-dockerized-docs/i_u_m_update)

Mailcow is automatically updated using a script.

```bash
cd /opt/mailcow-dockerized
./update.sh
```

### [Options](https://mailcow.github.io/mailcow-dockerized-docs/i_u_m_update/#options)

```shell
# Options can be combined

# - Check for updates and show changes
./update.sh --check

# Do not try to update docker-compose, **make sure to use the latest docker-compose available**
./update.sh --no-update-compose

# - Do not start mailcow after applying an update
./update.sh --skip-start

# - Force update (unattended, but unsupported, use at own risk)
./update.sh --force

# - Run garbage collector to cleanup old image tags and exit
./update.sh --gc

# - Update with merge strategy option "ours" instead of "theirs"
#   This will **solve conflicts** when merging in favor for your local changes and should be avoided. Local changes will always be kept, unless we changed file XY, too.
./update.sh --ours

# - Don't update, but prefetch images and exit
./update.sh --prefetch
```

## Changelog

2021-07-21 RRO add alias "localhost" to domain "amvara.eu" to avoid watchdog mails, changed `[::1]/128 [fe80::]/10 172.22.1.0/24 [fd4d:6169:6c63:6f77::]/64 192.168.2.0/24` in "/opt/mailcow-dockerized/data/conf/postfix/extra.cf"
