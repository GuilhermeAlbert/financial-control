# Financial Control

Guia de contribuição para/com habilidades técnicas.

## Before you start

Please, make sure you have read the project description. If don't, read rigth [clicking here](README.md).

## Requirements

This project needs some requirements to works correctly:

-   [Docker](https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-on-ubuntu-18-04)
-   [Docker compose](https://www.digitalocean.com/community/tutorials/how-to-install-docker-compose-on-ubuntu-18-04)
-   [Git](https://www.digitalocean.com/community/tutorials/how-to-install-git-on-ubuntu-18-04-quickstart)

## Settings

This project uses Docker technology to organize the necessary containers for operation. We also use [Laradock](https://laradock.io/), to make it easy to upload containers to Laravel. To configure just follow the steps below:

Clone the Laradock repository:

```shell
git clone https://github.com/Laradock/laradock.git
```

Enter within the context of the cloned folder and copy the contents of the `env-example` file:

```shell
cp env-example .env
```

Start the necessary containers for the application to work:

```shell
docker-compose up -d nginx mysql redis workspace
```

## Installation

Initially, enter the workspace container:

```shell
docker-compose exec workspace bash
```

Clone the back-end repository:

`https://github.com/GuilhermeAlbert/financial-control.git`

Enter the context of the application to perform the next steps:

```shell
cd financial-control
```

### Parameterizations

Copy the contents of the `.env.example` file and add your infrastructure information.

```shell
cp .env.example .env
```

#### Dependencies

Install the project's dependencies by executing the commands below:

```shell
composer install
```

```shell
npm install --save
```

Create a key for .env:

```shell
php artisan key:generate
```

#### Migrations

**Important:** Before starting this step, make sure to create a MySQL database.

In another terminal, enter the MySQL container:

```shell
docker-compose exec mysql bash
```

Create the database;

```sql
CREATE DATABASE financial;
```

Run the required migrations (back to the workspace container):

```shell
php artisan migrate
```

#### Seeders

Run the seeders to populate the tables with standard data:

```shell
php artisan db: seed
```

#### Laravel Passport

Create the API authentication keys with Passport:

```shell
php artisan passport: install
```

#### Queues

To run all queues, execute this following command:

```shell
php artisan queue:work
```

After this step, you have the autonomy to manage the application.
