
PHP

AMA Session 08.05.2021

# De donde viene

Fue creado por Rasmus Leerdorf.
PHP=Pretty Homepage Parser

# How does it work

* realtime parser
* Funciona a dentro de un servidor web
* Interpreta los commandos y los compila on demand


```
  WEB-Server
   |- carpeta HTML
   |   |-> foo.php
   |- cgi 
       |-> executar 
       |-> index.pl
       |-> incde.cgi


  Request  "foo.php" => Webserver
                           |-> Modulo PHP     <- foo.php
```

# Protocol http

Donde van headers?
Hay algo invisble?
Para que sirve?
Puedo hacer GZIP encima de HTML? Cuando? Como?
Porque ocultar el server-footprint?

# Prepared Statements

Que son?
Para que sirven?
Porque son importante?

# create functions

Porque capsular?
Reuse?
Clases?

# includes

__DIR__

# CLI

Porque utilizar php en commandline?
Para que?
Data cleansing
