Schedulr
========
A tool to make scheduling class at the University of Michigan easier

Schedulr was primarily in php using Facebook's XHP extension.
Styles are done using twitter bootstrap (with slight modifications)

If you plan on contributing to Schedulr, please read the wiki on contributing.

Requirements
------------
- LAMP (or similar)
- [XHP](https://github.com/facebook/xhp)
- Everything you need for bootstrap is in the repo, but for more information, [Twitter Bootstrap](http://twitter.github.com/bootstrap/)

Features
--------
- Record of all courses being offered FA12 including professor, location, and distribution requirement.
- Weekly calendar view of the classes you're going to take.
- Case insensitive search for your classes. Ex: eecs 280 or EECS281
- Special case search terms. Ex: calc2, tech comm 300, orgo1
- Advanced search. Search by distribution requirements, number of credits or professor
- Support for multiple schedules. Allows for alternate schedules, especially in the case that one doesn't work out
- Asynchronous UI. No new page loads for searching, adding or removing classes.

Notes
-----
- You will need to include a util/config.php that defines a couple variables in db.php. Mine looks like: 
    
        <?php
          $db_username = {enter your username};
          $db_password = {enter your password};
          $db_database = {enter your db name};
          $db_server = {enter your server};
        ?>
