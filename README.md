# Hamner Creative
![Static Badge](https://img.shields.io/badge/Laravel-%5E10.32.1-orange)
![Static Badge](https://img.shields.io/badge/PHP-%5E8.1-blue)
![Node Current](https://img.shields.io/node/v/:packageName)

Open source repo for a freelance web development website with custom client management, billing and invoice creation, and content management sytem.

## Contributing to Hamner Creative
This repo is the codebase for an existing website made public for portfolio purposes, outside contributions are discouraged

## Services 
An account for each of the following is required:
* Google Analytics API & Spatie Laravel Analytics - providing built-in website analytics for client dashboards
* Google reCAPTCHA v3 - contact form spam control
* Google OAuth - single sign on through google
* Enlightn - performance and dependency vulnerability scanner
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
 

	
