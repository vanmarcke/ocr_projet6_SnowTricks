# Project 6 OpenClassrooms - SnowTricks

## Application Developer Formation - PHP / Symfony

Develop from A to Z the SnowTricks community site

## App

![php](https://img.shields.io/badge/php-8.1.1-blue)
![symfony](https://img.shields.io/badge/symfony-6.0.2-succes)
![webpack-encore](https://img.shields.io/badge/webpack--encore--bundle-%5E1.13-blue)
![google-mailer](https://img.shields.io/badge/symfony/googlemailer-%5E6.0-succes)
![doctrine](https://img.shields.io/badge/doctrine-%5E3.4-succes)

## Serveur Web

![php-unit](https://img.shields.io/badge/serveur-MariaDB-green)
![Apache](<https://img.shields.io/badge/Apache-2.4.51%20(Win64)%20OpenSSL%2F1.1.1l%20PHP%2F8.1.1-green>)
![phpMyAdmin](https://img.shields.io/badge/phpMyAdmin-5.1.1-green)

## Code Quality

![php-cs-fixer](https://img.shields.io/badge/php--cs--fixer-%5E3.4-succes)

**SymfonyInsight:**

[![SymfonyInsight](https://insight.symfony.com/projects/6053a1ee-b6d1-4207-a44b-ae807be0c2e8/big.svg)](https://insight.symfony.com/projects/6053a1ee-b6d1-4207-a44b-ae807be0c2e8)

## Context

Jimmy Sweat is an ambitious entrepreneur with a passion for snowboarding. Its objective is the creation of a collaborative site to make this sport known to the general public and help in learning figures (tricks).

He wants to capitalize on content provided by Internet users in order to develop rich content that arouses the interest of site users. Subsequently, Jimmy wants to develop a business of connecting with snowboard brands thanks to the traffic that the content will have generated.

## Project description

Features available according to the different statuses:

**Visitor:**

- Visit the home page and open the various links available.
- Browse the list of the figures and its comments.

**User:**

- Prerequisite: to have registered via the registration form.
- Access to the same features as the visitor.
- Add comments and figures SonwTricks

## Information

- Blog Theme: Squadfree
- Template URL: 'https://bootstrapmade.com/squadfree-free-bootstrap-template-creative/'
- PHP Version: 8.1.1

## Libraries added 

- symfony/google-mailer
- symfony/rate-limiter
- symfony/webpack-encore-bundle
- doctrine/doctrine-fixtures-bundle
- friendsofphp/php-cs-fixer
- symfony/var-dumper


## Installation

### Prerequisites

- Symfony CLI version v4.28.1
- PHP version 8.1.1
- Composer version 2.2.5
- A Google account for configuring symfony/google-mailer
- A Management System (SGBD) type 'phpMyAdmin'

### Step 1: Clone your machine's repository to a folder of your choice

        C:\desktop> git clone git@github.com:vanmarcke/ocr_projet6_SnowTricks.git

### Step 2: Configure google-mailer and database access:

- Create an .env.local file in the root of the project.
- In this file copy/paste the code below.
- Modify the 'DATABASE_URL' and 'Gmail' lines by putting your database and Gmail identifiers.

      `DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=mariadb-10.4.11"`
      
        Example: DATABASE_URL="mysql://root:@127.0.0.1:3306/snow-tricks?serverVersion=mariadb-10.4.11"

      ###> symfony/google-mailer ###
      # Gmail MUST NOT be used in production, use it only in development.
      `MAILER_DSN=gmail://USERNAME:PASSWORD@smtp.gmail.com?verify_peer=0`
      ###< symfony/google-mailer ###

        Example: MAILER_DSN=smtp://vmkdev@gmail.com:vmkdev2022!@smtp.gmail.com?verify_peer=0

### Step 3: Make sure your Apache and Mysql Modules (or others depending on your configuration) are running. In a powershell-like terminal or that of your code editor, run the command below at the root of the project

This command will install all dependencies, webpack-encore-bundle, database with Fixtures dataset and start the web server

      `composer run-script install-projet --dev`

### Step 4: The site is now functional, you can create an account with your own identifiers or use the identifiers below:

* Pseudo: Fred
* Password: 123456

## Future Developments

- Create a role and an admin page for user management.
- Create the database translation system.

## Author

**Frédéric Vanmarcke** - Student Openclassrooms school path PHP / Symfony application developer
