<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Task Management System API

This project is a **RESTful API** for a Task Management System built with **Laravel 10**.  
It demonstrates clean architecture, proper separation of concerns, and real-world business rules.

The system supports **role-based access control**, **task dependencies**, and **token-based authentication**.

## Features

- RESTful API design
- Laravel 10
- Repository Design Pattern
- Role-Based Access Control (Manager / User)
- Task Dependencies with cycle prevention
- Task status workflow (pending / completed / canceled)
- Token-based authentication (Laravel Sanctum)
- API Resources for consistent responses
- Form Request validation
- Database migrations, seeders, and factories

## Requirements

- PHP >= 8.2
- Composer
- MySQL (or compatible database)
- Laravel 10
- Postman / cURL (for testing API)


## Installation & Setup

### Clone the repository

git clone <repository-url>
cd softxpert-api

## Install dependencies
composer install

## Create environment file
cp .env.example .env

## Configure database in .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_db
DB_USERNAME=root
DB_PASSWORD=

## Generate application key
php artisan key:generate

## Run migrations & seeders
php artisan migrate --seed

## Start the development server
php artisan serve

## Api Available
http://127.0.0.1:8000/api


