#Install dependencies

```
composer install
```

#Edit database connection
```
mcedit config/db.php
```

#Apply migrations
```
php yii migrate
```

#Run tests
```
./vendor/bin/codecept run
```

#Run server

```
php yii server
```

#Open browser

```
firefox http://localhost:8080/
```
