# News Management
Back End Developer Technical Test

## Requirements
In supporting the running of the application, the required requirements must be met, as follows:
- PHP 8.1
- MySql
- Composer
- Supervisord
- Redis

## Roles
In this application there are 2 roles.
| Roles | Access |
|-------|--------|
|Admin  | Create,Read,Update,Delete Post, Create Comment        |
|Member | Create Comment       |

## How To Deploy
To deploy this application, perform the following steps:
- Installing packages
     Run the command below to install the required packages
     ```sh
     composer install
     ```
- Env file configuration
     Please copy the file ```.env.example``` to ```.env```.
     ```sh
     cp .env.example .env
     ```
- Do laravel key generation
     run command
     ```sh
     php artisan key:generate
     ```
- Database configuration
     please open the ```.env``` file.
     change the following line and adjust the configuration you have
     ```env
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=
     DB_USERNAME=
     DB_PASSWORD=
     ```
- Migrate database
     run the command below to process the database migrate
     ```sh
     php artisan db:migrate
     ```
- Initialize Passport
     run the command below to install Passport
     ```sh
     php artisan passport:install
     ```
- Running queue process
     In running the queue requires [supervisord](http://supervisord.org/) as a process in the background.
     Run the command below to install supervisord
     ```sh
     sudo apt-get install supervisor
     cd /etc/supervisor/conf.d #process goes into the supervisord directory
     ```
     After that, create a file named ```laravel-worker.conf``` in the ```conf.d``` folder.
     Open the file, and enter the code below.
     ```conf
     [program:laravel-worker]
     process_name=%(program_name)s_%(process_num)02d
     command=/usr/bin/php <your_project_directory>/artisan queue:listen --sleep=3 --tries=3
     autostart=true
     autorestart=true
     user=root
     numprocs=5
     redirect_stderr=true
     stdout_logfile=<your_project_directory>/storage/logs/worker.log
     ```
     Please change ```<your_project_directory>``` with your directory address. Then save the file.
     Then run the following command to run the process from the supervisord.
     ```sh
     sudo supervisorctl reread
     sudo supervisorctl update
     sudo supervisorctl start laravel-worker.conf
     ```
- Run servers
     To run the application, run the following command.
     ```sh
     php artisan serve
     ```
     If you are at the production level, you can directly configure virtual hosts on web server.
     - Example of Apache
        ```conf
        NameVirtualHost *:80
        Listen 8080
        
        <VirtualHost *:80>
            ServerAdmin admin@example.com
            ServerName newmanagement.dev
            ServerAlias www.newmanagement.dev
            DocumentRoot <your_project_directory>/public
            
            <Directory <your_project_directory>/public/>
                    Options Indexes FollowSymLinks MultiViews
                    AllowOverride All
                    Order allow,deny
                    allow from all
                    Require all granted
            </Directory>
            
            LogLevel debug
            ErrorLog ${APACHE_LOG_DIR}/error.log
            CustomLog ${APACHE_LOG_DIR}/access.log combined
        </VirtualHost>
        ```
    - Example of Nginx
        ```conf
        server {
            listen 80;
            server_name server_domain_or_IP;
            root <your_project_directory>/public;

            add_header X-Frame-Options "SAMEORIGIN";
            add_header X-XSS-Protection "1; mode=block";
            add_header X-Content-Type-Options "nosniff";

            index index.html index.htm index.php;

            charset utf-8;

            location / {
                try_files $uri $uri/ /index.php?$query_string;
            }

            location = /favicon.ico { access_log off; log_not_found off; }
            location = /robots.txt  { access_log off; log_not_found off; }

            error_page 404 /index.php;

            location ~ \.php$ {
                fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
                fastcgi_index index.php;
                fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
                include fastcgi_params;
            }

            location ~ /\.(?!well-known).* {
                deny all;
            }
        }
        ```
        Please change ```<your_project_directory>``` with your directory address.
## Documentation
Via postman
https://documenter.getpostman.com/view/8073012/2s93mATeiL
