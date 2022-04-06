# cms

FJ-OMS-market is a powerful and flexible Laravel app that helps developers create a custom OMS.

### Installation

- `git clone git@github.com:luispirela/zz-market-demo.git market`
- `cd market`
- `docker-compose build app`
- `docker-compose up -d`
- `docker-compose exec app composer update`
- `docker-compose exec app php artisan key:generate`
- `docker-compose exec app php artisan fulljauscms:migrate market fj`

### Ingresar a la app

En tu archivo /etc/hosts incluir las siguientes lineas

- `127.0.0.1 admin.market.fj`
- `127.0.0.1 mysql.market.fj`
- `127.0.0.1 img.market.fj`
- ` `
  Luego en tu navegador:
- `http://admin.market.fj:8000`
- `http://mysql.market.fj:8000`
- `http://img.market.fj:8000`

### Otros comandos

Para bajar los dockers

- `docker-compose down`

Para crear modulos

- `docker-compose exec app php artisan fulljauscms:modules nombre_del_modulo_a_crear`

Para crear modelos / entidades

- `docker-compose exec app php artisan fulljauscms:models nombre_del_modulo_donde_lo_alojamos nombre_del_modelo_a_crear`
