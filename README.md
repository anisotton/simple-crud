#  Simple CRUD Client

Esse repositorio contem o projeto de gerenciamento de clientes.

Ambiente:

- [PHP 7.2.19](https://www.php.net/)
- [Apache 2.4.35](https://httpd.apache.org/)
- [MySQL 5.7.24](https://www.mysql.com)

#### Instalação:

1) Clonar repositório:
```
$ git clone https://github.com/anisotton/essentia.git essentia
```

2) Criar base de dados para aplicação
```
$ mysql>> CREATE DATABASE essentia;
```

3) Importar extrutura da base de dados
```
$ mysql>> essentia < installer/base.sql;
```

4) Configurar o arquivo: config.php
```
define( 'APP_URI', 'http://localhost/essentia/' );
define( 'HOSTNAME', 'localhost' );
define( 'DB_NAME', 'essentia' );
define( 'DB_USER', 'root' );
define( 'DB_PASSWORD', '' );
```

Exemplo:
[DEMO](http://essentia.isotton.com.br/)

Open source:
- [PHP](http://php.net/)
- [MySQL](https://www.mysql.com/)
- [Apache](https://www.apache.org/)
