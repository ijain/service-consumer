# consumer-service

## Backend recruitment task for Chiliz (Mid)

### Tech Stack
- PHP 7
- Symfony 4 (https://symfony.com/)
- MariaDb
- Docker

### Dependencies
Please use the already required dependencies in order to complete the task
- Doctrine for the database
- Guzzle Client for the consuming

All of them are already required by composer and upon `composer install` they should be installed.

#### Database schema
Database schema should be installed upon running the migrations. 

### Purpose of this task

Candidate should write the code of the provided consumer service (symfony is already bootstrapped) to consume the list-rest-api endpoint
```
http://localhost:8005/api/v1/partners?status=active
```
and should store in the database provided, all the partners that have active surveys.

The expected correct partners that should be stored in the database are having the below names:
```
partner_name_3
partner_name_4
partner_name_5
``` 

### Build
In order to build the symfony project run the below commands

```
# build docker
docker-compose up --build -d

# install dependencies
./bin/composer install

# run the migrations
./bin/sf d:m:m
```

##### Be sure that all docker containers are running
```
# All containers and the status of the containers
docker ps -a
```

In case one or more containers are not running run again the command
```
# build and start docker containers
docker-compose up --build -d
```

### Commit your code
- Extract your code to your local machine.
- Append your code/changes.
- Send back a zipped file with your changes.

## Questions
In case you have any questions about the task do not hesitate to contact or ask for more information at `christos@mediarex.com`

#### Command to show partner list (params: status and limit)
./bin/console partners-show active 1

#### Command to store active partners
./bin/console partners-store --quiet


