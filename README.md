# Hamner Creative

![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.1%2B-777BB4?logo=php&logoColor=white)
![Node](https://img.shields.io/badge/Node.js-18%2B-339933?logo=nodedotjs&logoColor=white)
![Livewire](https://img.shields.io/badge/Livewire-3.x-FB70A9?logo=livewire&logoColor=white)
![Pest](https://img.shields.io/badge/Tests-Pest-54B4C8)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5-7952B3?logo=bootstrap&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-4-646CFF?logo=vite&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green.svg)
![GitHub last commit](https://img.shields.io/github/last-commit/bhamner/hamnercreative)
![GitHub stars](https://img.shields.io/github/stars/bhamner/hamnercreative)

Open source repo for a freelance web development website with custom client management, billing and invoice creation, and content management sytem.

## Contributing to Hamner Creative
This repo is the codebase for an existing website made public for portfolio purposes, outside contributions are discouraged

## Services 
An account for each of the following is required:
* Google Analytics API & Spatie Laravel Analytics - providing built-in website analytics for client dashboards
* Google reCAPTCHA v3 - contact form spam control
* Google OAuth - single sign on through google
* Sentry - performance and error reporting

## Prerequisites
Before you begin, ensure you have installed the latest version of the following
* PHP
* Node.js
* Composer
You must also ensure you have accounts and keys set up in google for the required services listed above

## Using Hamner Creative
To install and use Hamner Creative, follow these steps:
* clone this repo
* build your .env from the example.env with your own credentials
* run `composer install` 
* run `npm install && run dev`
* run `php artisan storage:link` to simlink storage to public
 
