Repository has two applications on Symfony 5 and Docker configuration fot its setup.

HerdWatchTest is application with API routes for user and group entity.
HerdWatchTestCli has CLI commands for user and group CRUD options.

Steps for test deploy:
1. Add next settings to .env file of HerdWatchTest application
   - DATABASE_URL="mysql://root:4as6iKILL47<>and2002alex@databaseHerdWatch:3306/databaseHerdWatch?serverVersion=8&charset=utf8mb4"
   - DATABASE_HOST=mysql
   - DATABASE_PASSWORD=4as6iKILL47<>and2002alex
   - DATABASE_PORT=3306
   - DATABASE_USER=root
   - DATABASE_NAME=databaseHerdWatch
2. Open terminal in folder with docker-compose.yml and run command " docker exec -it <container_id> bash " (container id of fpm service)
3. Run command inside of Docker container - " cd /var/www/app "
4. Run command inside of Docker container - " composer install "
5. Run command inside of Docker container - " php bin/console doctrine:migrations:migrate " and press YES 
6. Run command inside of Docker container - " cd /var/www/cli "
7. Run command inside of Docker container - " composer install "

After deploy you will have an access to CRUD APIs, for example create user - POST http://127.0.0.1:8080/api/user/

For using CLI commands from HerdWatchTestCli
you just need open terminal in folder with HerdWatchTestCli application on your PC (not Docker machine) and write commands.
For example - "php bin/console app:creat-user"

P.S. chnage path mappings (left side of volume) to your folder tree destination in docker-compose.yml
