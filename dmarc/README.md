# DMARC

---

## What is

DMARC is a standard email authentication, policy, and reporting protocol, is configured as a txt record in DNS. It is developed to work with SPF and DKIM protocols. Helps prevent hackers and other attackers from spoofing your organization and domain.

![DMARC author to recipient flow](DMARC_author-to-recipient_flow.jpg)

You can configure DMARC to receive reports from external servers, and send them to a specified account, to help identify possible authentication problems and malicious activity for messages sent from our mail server.

## Format

The DMARC record is a plain text line. The text is a list of DMARC tags and values, separated by semicolons. Some tags are required and some are optional.

Examples:

* Google

```text
v=DMARC1; p=reject; rua=mailto:postmaster@solarmora.com, mailto:dmarc@solarmora.com; pct=100; adkim=s; aspf=s
```

* dmarc.org

```ext
v=DMARC1;p=reject;pct=100;rua=mailto:postmaster@dmarcdomain.com
```

* Microsoft

```text
v=DMARC1; p=none; pct=100; rua=mailto:d@rua.contoso.com; ruf=mailto:d@ruf.contoso.com; fo=1
```

* Amvara

```text
v=DMARC1; p=reject; rua=mailto:postmaster@amvara.eu; ruf=mailto:postmaster@amvara.eu;
```

### Tags

|Tag|Required?|Description and values|
|--|--|--|
|`v`|Required|DMARC version. Must be DMARC1.  Note: A wrong, or absent DMARC version tag would cause the entire record to be ignored.|
|`p`|Required|Instructs the receiving mail server what to do with messages that don’t pass authentication. <ul><li> `none` - Take no action on the message and deliver it to the intended recipient. Log messages in a daily report. The report is sent to the email address specified with the rua option in the record. </li><li>`quarantine` - Mark the messages as spam and send it to the recipient's spam folder. Recipients can review spam messages to identify legitimate messages.</li><li>`reject` - Reject the message. With this option, the receiving server usually sends a bounce message  to the sending server.</li></ul><br/>**BIMI note**: If your domain uses BIMI, the DMARC `p` option must be set to `quarantine` or `reject`. BIMI doesn't support DMARC policies with the `p` option set to `none`.|
|`pct`|Optional|Specifies the percent of unauthenticated messages are subject to the DMARC policy. When you gradually deploy DMARC, you might start with a small percentage of your messages. As more messages from your domain pass authentication with receiving servers, update your record with a higher percentage, until you reach 100 percent.<br/>Must be a whole number from 1 to 100. If you don’t use this option in the record, your DMARC policy applies to 100% of messages sent from your domain.<br/><br/>**BIMI note**: If your domain uses BIMI, your DMARC policy must have a `pct` value of 100. BIMI doesn't support  DMARC policies with the `pct` value set to less than 100.|
|`rua`|Optional|Email address to receive reports about DMARC activity for your domain.<br/>The email address must include `mailto:`. For example: `mailto:dmarc-reports@solarmora.com`.<br/>To send the report to more than one email address, separate emails with a comma.<br/>This option can potentially result in a high volume of report emails. We don’t recommend using your own email address. Instead, consider using a dedicated mailbox, a group, or a third-party service that specializes in DMARC reports.|
|`ruf`|Optional (Not supported in Gmail)|Used to send failure reports. Failure reports are also called forensic reports.<br/>The email address must include `mailto:`. For example: `mailto:dmarc-reports@solarmora.com`.<br/>To send the report to more than one email address, separate emails with a comma.<br/>Gmail doesn’t support the ruf tag.|
|`sp`|Optional|Sets the policy for messages from subdomains of your primary domain. Use this option if you want to use a different DMARC policy for your subdomains.<br/><ul><li>*none* - Take no action on the message and deliver it to the intended recipient. Log messages in a daily report. The report is sent to the email address specified with the rua option in the policy.</li><li>*quarantine* - Mark the messages as spam and send it to the recipient's spam folder. Recipients can review spam messages to identify legitimate messages.</li><li>*reject* - Reject the message. With this option, the receiving server should send a bounce message  to the sending server</li></ul><br/>If you don’t use this option in the record, subdomains inherit the DMARC policy set for the parent domain.|

<!-- FIXME
| @adkim@|Optional|Sets the alignment policy for DKIM, which defines how strictly message information must match DKIM signatures.<ul>*s* - Strict alignment. The sender domain name must exactly match the corresponding @d=domainname@ in the DKIM mail headers.
* *r* - Relaxed alignment (default). Allows partial matches. Any valid subdomain of @d=domain@ in the DKIM mail headers is accepted.|
| @aspf@| Optional|	Sets the alignment policy for SPF, which specifies how strictly message information must match SPF signatures.
&nbsp;
* *s* - Strict alignment. The message @From@ header must exactly match the domain name in the @SMTP MAIL FROM@ command
* *r* - Relaxed alignment (default). Allows partial matches. Any valid subdomain of domain name is accepted.|
|@fo@|Optional|Forensic reporting options
&nbsp;
* *0* - Generate a DMARC failure report if all underlying authentication mechanisms (SPF and DKIM) fail to produce an aligned “pass” result. (Default)
* *1* - Generate a DMARC failure report if any underlying authentication mechanism (SPF or DKIM) produced something other than an aligned “pass” result. (Recommended)
* *d* - Generate a DKIM failure report if the message had a signature that failed evaluation, regardless of its alignment.
* *s* - Generate an SPF failure report if the message failed SPF evaluation, regardless of its alignment.
&nbsp;
If you would like to receive multiple types of reports you can specify them by using a colon between each type|
|@rf@|Optional|Forensic reporting format(s)
&nbsp;
* *afrf*
* *iodef* </ul>|
|@ri@|Optional|The reporting interval (seconds) for how often you’d like to receive aggregate XML reports.| -->

## DMARC testing

* Test Domains dmarc entry: "amvara.eu":https://www.agari.com/insights/tools/dmarc/?domain_name=amvara.eu, "cometa.rocks":https://www.agari.com/insights/tools/dmarc/?domain_name=cometa.rocks

## Webgrafia

### Web

* "Setup DMARC with mailcow":https://rspamd.com/doc/modules/dmarc.html
* "RFC7489":https://datatracker.ietf.org/doc/html/rfc7489
* "Google DMARC info":https://support.google.com/a/topic/2759254
* "mimecast | dmarcanalyzer":https://www.dmarcanalyzer.com/dmarc/
* "Microsoft DMARC info":https://docs.microsoft.com/en-us/microsoft-365/security/office-365-security/use-dmarc-to-validate-email?view=o365-worldwide#what-is-a-dmarc-txt-record
* "DMARC org":https://dmarc.org/overview/
* "dmarcian What is DMARC?":https://dmarcian.com/why-dmarc/

### Videos

* "What is DMARC? - Google":https://youtu.be/swz8sxA1NF8
* "DMARC - How it works and what it does":https://youtu.be/sNuVaVtfick
* "Why DMARC?":https://youtu.be/OsdXGiPLnLw
* "What is DMARC? - Cisco":https://youtu.be/qP9ODdimHvM
* "DMARC - Technical Overview":https://youtu.be/JSwnh9aww0E
* "DMARC cómo evitar el fraude en el correo electrónico":https://youtu.be/3U6kLQwmaXw
