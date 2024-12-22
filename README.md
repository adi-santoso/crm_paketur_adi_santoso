This project was created for the purpose of taking a job registration test

# Project Dependencies

## Main Dependencies
| Description   | Version  |
|---------------|----------|
| PHP           | V8.2     |
| Laravel       | V11.36   |
| Composer      | V2.4.1   |
| PostgreSql    | V16      |

## Other Dependencies
| Description                     | Version | Usage                           |
|---------------------------------|---------|---------------------------------|
| spatie/laravel-permission       | V6.10   | Role and Permission Management  |
| tymon/jwt-auth                  | V2.1    | Auth                            |
| yaza/laravel-repository-service | V5.1    | Service and repository pattern  |


# Setup Instructions

## a. Composer Install
Please run the command below:
```bash
composer install
```

## b. Env Configuration
Please create a database and add the following configuration to the `.env` file. Here's an example configuration:
```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=crm_paketur
DB_USERNAME=postgres
DB_PASSWORD=root
```

## c. Generate Laravel Key
Run the following command to generate the application key:
```bash
php artisan key:generate
```

## d. Generate JWT Key
Run the following command to generate the JWT secret key:
```bash
php artisan jwt:secret
```

## e. Migrate and Seed
Run the following command to migrate and seed the database:
```bash
php artisan migrate:fresh --seed
```

## f. Running Application
Start the application using the command below:
```bash
php artisan serve
```

## g. Default Superadmin Account
Use the following credentials to log in as the superadmin:
- **Email**: `superadmin@example.com`
- **Password**: `password`
