<h1 align="center"> Sistem Informasi Persuratan </h1>

## Table of Contents

- [Introduction](#introduction)
- [Features](#features)
- [Role & Permission](#role-and-permission)
- [Setup](#setup)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

## Introduction

This repository contains the source code and documentation for the Sistem Informasi Persuratan designed to manage letters within an organization. The system can handle various stages of letter management, from creation to distribution. I created this project to fulfill a college assignment, using a case study from Pusat Kodifikasi.

![PHP](https://img.shields.io/badge/Built_with-PHP-blue?logo=php)
![HTML](https://img.shields.io/badge/Built_with-HTML-orange?logo=html5)
![CSS](https://img.shields.io/badge/Built_with-CSS-blueviolet?logo=css3)
![JavaScript](https://img.shields.io/badge/Built_with-JavaScript-yellow?logo=javascript)
![jQuery](https://img.shields.io/badge/Built_with-jQuery-blue?logo=jquery)

## Features

A few of the things you can do with this system:

- <b>Letter Creation</b>, Allows users to create and send letters, including the ability to attach PDF documents to the letters.
- <b>Letter Reading</b>, Enables users to read letters sent to them.
- <b>Letter Forwarding</b>, Allows users to forward received letters to others, selecting the recipients of their choice.
- <b>User account management</b>, with supports two roles: Kepala Bidang dan Staff. The system is designed to accommodate the structure of 14 divisions, as per the conditions at the Pusat Kodifikasi.

<p align="center">
  <img src = "https://i.imgur.com/4bqIPrc.jpeg" width=1080>
</p>

## Role and Permission

There are several roles and permissions in this system, created based on the conditions and structure at the Pusat Kodifikasi :

- <b>Tata Usaha :</b> Users with the Tata Usaha role have the highest authority in the system. They can create and send letters to anyone and manage user accounts in the system.

- <b>Kepala Pusat :</b> Users with the Kepala Pusat role have the same authority as the Tata Usaha but can only create and send letters to the Tata Usaha. They can also manage user accounts in the system.

- <b>Kepala Bidang : </b> These users can only create and send letters to the Tata Usaha and the staff within the same division.

- <b>Staff : </b> These users can only read letters sent by the Tata Usaha and their Kepala Bidang.

## Setup

1. Clone this project into the C:\xampp\htdocs directory if you are using XAMPP, or into the C:\laragon\www directory if you are using Laragon.

```
git clone https://github.com/munovrizall/sistem-persuratan-puskod-php.git
```

2. Open phpMyAdmin and import the puskod-db.sql file located in sistem-persuratan-puskod-php/puskod-db.sql.

3. Start XAMPP or Laragon, and open url localhost/sistem-persuratan-puskod-php in your browser

4. Login with email "admin@email.com" and password "admin"

5. You are ready to go!
