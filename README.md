# angular-symfony Admin Panel

Purpose of this project is to learn and practice angular and symfony development. It utilizes PHP with symfony framework for backend part, and Angular for frontend part of project.

# Running project

For running this project [docker](https://docs.docker.com/get-docker/) and [npm](https://www.npmjs.com/get-npm) is needed

## Backend

- Go to symfony-backend directory

- run ```docker-compose up -d```

- After docker done it's job run ```docker exec -it symfony-backend_php_1 composer install```

- Set passphrase for JWT key in .env ```JWT_PASSPHRASE```

- Generate private key files

```docker exec -it symfony-backend_php_1 mkdir -p config/jwt```

```docker exec -it symfony-backend_php_1 openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096```

```docker exec -it symfony-backend_php_1 openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout```

- Run migrations ```docker exec -it symfony-backend_php_1 bin/console doctrine:migrations:migrate```

- Create new admin user ```docker exec -it symfony-backend_php_1 bin/console app:create-admin-user <name> <email> <password>```

### Example data

- Categories - ```docker exec -it symfony-backend_php_1 php bin/console app:get-google-categories``` - Gets example categories from [google taxonomy](https://support.google.com/merchants/answer/6324436?hl=en)

- Products - ```docker exec -it symfony-backend_php_1 php bin/console app:generate-random-products``` - Generates 100000 random products

## Frontend

- Go to angular-frontend directory

- run ```npm install```

- after build run ```ng serve```

- when compilation is done, http://localhost:4200/login address will be available
