# angular-symfony Admin Panel

Purpose of this project is to learn and practice angular and symfony development. It utilizes PHP with symfony framework for backend part, and Angular for frontend part of project.

# Running project

For running this project [docker](https://docs.docker.com/get-docker/) is needed

First get into symfony-backend folder ```cd symfony-backend```

Next fire ```docker-compose up -d```

After docker done it's job run ```composer install```

Set passphrase for JWT key in .env ```JWT_PASSPHRASE```

Generate public key files

```docker exec -it symfony-backend_php_1 mkdir -p config/jwt```

```docker exec -it symfony-backend_php_1 openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096```

```docker exec -it symfony-backend_php_1 openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout```
