# MYSQL
Conector mysql.

## Instalar
```bash
$ composer require josalba/mysql-connect
```

## Iniciar
```php
require_once 'vendor/autoload.php';

use mysqlconnect\mysql;

$m = new mysql(
    "localhsot",
    "root",
    "passwd",
    "3306",
    "midb"
);

```

## Comando SQL

### Select
```php
require_once 'vendor/autoload.php';

use mysqlconnect\mysql;

$m = new mysql(
    "localhsot",
    "root",
    "passwd",
    "3306",
    "midb"
);

$r = $m->_db_consulta(
    "SELECT col1 FROM ejemple"
);

echo "\n-------------";

//Comando.
foreach($r->rows as $fila){

    echo "\n".$fila['col1'];

}

echo "\n-------------";

//Numero de filas.
echo "\n Nuemro de filas".$r->num_rows;
//Recuperar solo la primera fila.
echo "\n Primera fila".$r->row['col1'];

```

### Insert
```php
require_once 'vendor/autoload.php';

use mysqlconnect\mysql;

$m = new mysql(
    "localhsot",
    "root",
    "passwd",
    "3306",
    "midb"
);

//Comando.
$r = $m->_db_consulta(
    "INSERT INTO...."
);

//Recuperar el id de la nueva fila insertada.
echo $m->_ultimo_id();

```

### Comandos
```php
require_once 'vendor/autoload.php';

use mysqlconnect\mysql;

$m = new mysql(
    "localhsot",
    "root",
    "passwd",
    "3306",
    "midb"
);

//Comando.
$r = $m->_db_consulta(
    "COMANDO...."
);


```