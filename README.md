
Project required PHP 7.4

Set database parameters in file `config/container.php`;

Database structure is in file `db.sql`

#### Import file 
```bash
php bin/import.php  $PWD/MOCK_DATA.csv
```


#### Start with php developer server 
```bash
php -S localhost:80 -t $PWD/public
```