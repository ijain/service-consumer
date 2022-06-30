# list-rest-api

## Backend recruitment task for Chiliz (Mid) 

### Tech Stack
- PHP 7
- Symfony 4 (https://symfony.com/)
- MariaDb
- Docker

### Purpose of the task
This micro-service is producing a simple API endpoint at
`
http://localhost:8005/api/v1/partners
`
1. We are aware that the `list-rest-api` micro-service has bugs. We are expecting the candidate to solve them without changing the business logic 
2. We are aware that the `list-rest-api` does not follow the REST principles and we are expecting the candidate to refactor the code.
3. Some unit or functional tests should be written.

### Build
In order to build this micro-service you need to have docker installed and a command line to run the below commands. 
```
# build and start docker containers
docker-compose up --build -d

# install dependencies
./bin/composer install

# run the migrations
./bin/sf d:m:m

# load the fixtures
./bin/sf doctrine:fixtures:load -n

#To run tests:
./bin/phpunit

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
In case you have any questions about the task do not hesitate to contact us and ask for more information at
`christos@mediarex.com`

#### Command: Create Partner, Post method
URL: http://localhost:8005/api/v1/partners/store
Parameters: partner=partner_name_4&icon=icon_name_4

#### Command: List Partners, Get method
http://localhost:8005/api/v1/partners?status=active&limit=5

#### To run tests:
./bin/phpunit

