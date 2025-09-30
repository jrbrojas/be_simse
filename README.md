# Como levantar el proyecto
Para levantar el proyecto se puede hacer de varias formas, se sugiere usar docker
compose, para ello ir al apartado "Forma de iniciar el proyecto con Docker"
si desea usar la linea de comandos de php puede ver el apartado "Forma de iniciar
el proyecto con php"

```bash
$ rm storage/app/private/* -Rf
```

## Forma de iniciar el proyecto con Docker

### 1. Docker
```bash
$ docker compose build
```

```bash
$ docker compose up -d
```

### 2. Instalar dependencias

```bash
$ docker compse exec app composer install
```

### 3. Correr migraciones
Es necesario tener tu archivo .env, se puede copiar el archivo .env.example y
colocarle estos valores
```
DB_CONNECTION=pgsql
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=bd_simse
DB_USERNAME=usuariosimse
DB_PASSWORD=th1s@p4ssw0rd
```

```bash
$ docker compose exec php artisan migrate:fresh --seed
```

### 4. Generar key de aplicacion

```bash
$ php artisan key:generate
```

## Forma de iniciar el proyecto con php

### 1. Instalar dependencias

```bash
$ composer install
```

### 2. Correr migraciones
Es necesario tener tu archivo .env, se puede copiar el archivo .env.example y
colocarle estos valores
```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=bd_simse
DB_USERNAME=usuariosimse
DB_PASSWORD=th1s@p4ssw0rd
```

```bash
$ php artisan migrate:fresh --seed
```

### 3. Generar key de aplicacion

```bash
$ php artisan key:generate
```

### 4. Correr Servidor

```bash
$ php artisan serve
```

