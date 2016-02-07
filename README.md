Parents Evening Sign In System
==============================

This parents evening system should be stored on a system using SSL and used only by people you trust - it is not fully secured.

Install the database via database.sql.

You will need to fill in the Settings.php class and you will need to create a new user manually. Set the password to md5($appsalt . username . password) (you could use an online service to get this value). Set their status to admin. From then on you can use the interface. 