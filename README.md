# Hospital Management System

An individual first-year university coursework project by Khaldoon Qasim, built with PHP, HTML/CSS, JavaScript and SQLite. It explores staff workflows, appointments and patient-record management in a small web application.

This is a **legacy educational prototype**, not clinical software. The original implementation is retained so its design and limitations can be discussed honestly.

## Main workflows

- Staff login and role-dependent navigation for administrators, doctors and receptionists.
- Create, view and update patient and staff records.
- Create and manage appointments.
- Create and update medical-history records.

## Code walkthrough

- [Login and session setup](login.php)
- [Appointment form](createNewAppointmentPage.php)
- [Appointment database write](createNewAppointmentRecord.php)
- [Patient listing](viewPatientPage.php)
- [Medical-history entry](createMedHistoryRecord.php)

The appointment handler illustrates the request-to-database flow: read POST fields, validate required values, prepare an SQLite insert and execute it. Prepared queries are used in these examples; that alone does not establish application-wide security.

## Local exploration

Use PHP with PDO SQLite and SQLite3 extensions enabled. Keep the bundled wosp.db alongside the PHP files, and use an isolated local copy with fictional data only.

```bash
php -S 127.0.0.1:8000
```

Then open http://127.0.0.1:8000/login.php. No demo credentials are published here. The PHP runtime was not available during the documentation review, so this setup has not been freshly verified end to end.

## What this project demonstrates

A first implementation of server-rendered forms, session-based navigation, relational data and CRUD workflows. It provides an early baseline for discussing how my engineering approach has developed since first year.

## Limitations and next improvements

The legacy login compares the submitted password directly with a database value; it should be replaced with password hashing and verification. A further review should cover session handling, CSRF protection and authorisation checks on every modifying endpoint. Do not deploy this prototype publicly or use real patient information.

For an internship portfolio, my more recent [SmartQuote team project](https://github.com/Khaldoonq19/SmartQuote) is the stronger starting point for frontend engineering, with this repository providing earlier coursework context.
