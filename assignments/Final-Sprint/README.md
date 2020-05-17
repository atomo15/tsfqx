# Movietheater Project: Final-Sprint

## Download XAMPP 1.0.3:
- https://sourceforge.net/projects/xampp/

### To Start service on XAMPP:
1. General -> Start
2. Services -> Start (MySQL + Apache) 
3. Network -> Enable (localhost:8080 -> 80(Over SSH))
4. Volumes -> Mount

### To Setup the project:
1. Download All file in projectv2 
2. XAMPP -> Volumes -> Explore
3. Iampp -> htdocs 
4. Replace projectv2 folder here!

### To Setup the Database:
if you already create and import movie.sql, you can skip this step
1. Download movie.sql
2. Go to http://localhost:8080/phpmyadmin/
3. Create New Databases:
- Name: **movie**
- Collection: **utf8_unicode_ci**
4. Go to movie -> import -> choose movie.sql -> Go

### To Run the web application:
1. Start service on XAMPP
2. Go to http://localhost:8080/projectv2/member.php
- Note: If it has already login, please click on profile and logout.

## To Test SSO:Progress from Assignment 13b to be Final-Sprint
### Login Member Section
- http://localhost:8080/projectv2/member.php
- Hit sign in google button
### Booking the seat: Redirect to Login First and Back to Theater to Booking
- Logout from http://localhost:8080/projectv2/member.php
- Pick the movie and Branch on the dropdown, then hit the red button (SHOW TIME)
- Pick the showtimes (Timezone based on Bangkok, Thailand(GMT +7))
- Wait until the seats are show.
- Select the seat
- Hit the Checkuot button

## Manage the database:
- http://localhost:8080/phpmyadmin/

## Homepage site:
- http://localhost:8080/projectv2/homepage.php

## Login site:
- http://localhost:8080/projectv2/member.php
