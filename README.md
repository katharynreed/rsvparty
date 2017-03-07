# _{Application Name}_

#### _{Brief description of application}, {Date of current version}_

#### By _**{List of contributors}**_

## Description

_{This is a detailed description of your application. Its purpose and usage.  Give as much detail as needed to explain what the application does, and any other information you want users or other developers to have. }_

## Setup/Installation Requirements

* _This is a great place_
* _to list setup instructions_
* _in a simple_
* _easy-to-understand_
* _format_

_{Leave nothing to chance! You want it to be easy for potential users, employers and collaborators to run your app. Do I need to run a server? How should I set up my databases? Is there other code this app depends on?}_

## Known Bugs

_{Are there issues that have not yet been resolved that you want to let users know you know?  Outline any issues that would impact use of your application.  Share any workarounds that are in place. }_

## Database SQL Constructors

CREATE DATABASE rsvparty_test;
USE rsvparty_test;
CREATE TABLE users (id serial PRIMARY KEY, name VARCHAR (255), password VARCHAR (255));
CREATE TABLE events (id serial PRIMARY KEY, user_id INT, name VARCHAR (255), date_time DATETIME, description VARCHAR (255), location VARCHAR (255), guest_key VARCHAR (255));
CREATE TABLE tasks (id serial PRIMARY KEY, name VARCHAR (255), description VARCHAR (255), event_id INT);
CREATE TABLE attendees (id serial PRIMARY KEY, name VARCHAR (255), event_id INT);
CREATE TABLE attendees_tasks (id serial PRIMARY KEY, attendee_id INT, task_id INT);
CREATE DATABASE rsvparty;
USE rsvparty;
CREATE TABLE users (id serial PRIMARY KEY, name VARCHAR (255), password VARCHAR (255));
CREATE TABLE events (id serial PRIMARY KEY, user_id INT, name VARCHAR (255), date_time DATETIME, description VARCHAR (255), location VARCHAR (255), guest_key VARCHAR (255));
CREATE TABLE tasks (id serial PRIMARY KEY, name VARCHAR (255), description VARCHAR (255), event_id INT);
CREATE TABLE attendees (id serial PRIMARY KEY, name VARCHAR (255), event_id INT);
CREATE TABLE attendees_tasks (id serial PRIMARY KEY, attendee_id INT, task_id INT);

## Support and contact details

_{Let people know what to do if they run into any issues or have questions, ideas or concerns.  Encourage them to contact you or make a contribution to the code.}_

## Technologies Used

_{Tell me about the languages and tools you used to create this app. Assume that I know you probably used HTML and CSS. If you did something really cool using only HTML, point that out.}_

### License

*{Determine the license under which this application can be used.  See below for more details on licensing.}*

Copyright (c) 2017 **_{List of contributors or company name}_**
