# Log & display Silverstripe all login attempts

A module to add a system login reports to the CMS, as well as an individual member logins.

**Note:** The `LoginAttempt::Email` field is now deprecated, meaning that Silverstripe only logs a SHA1 hash of the login email,
however this module enforces re-enables it.

This module also exposes member IPs to anyone with access to the reports and/or member data.


## Features

- A report for all websites logins (failed and passed), displaying date, status, IP address and email.
- Adds a `Login attempts` tab to CMS members (Security) specific to that member.
- All data is read-only and cannot be manipulated via the CMS.


## Requirements

- Silverstripe ^4


## Installation

```
composer require axllent/silverstripe-login-attempts
```
