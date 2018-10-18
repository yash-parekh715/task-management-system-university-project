# todo-list-application
A simple to-do list application that utilizes SQL and allows for CRUD.

### Dependencies
This outdated version of the application requires:
- nodejs
- sqlite3
- npm
  - sqlite3
  - lodash
  - yargs

## How to Use
After installing the base packages, using `npm install lodash sqlite3 yargs --save` in the base directory, you should be able to run a few of the scripts with node in order to create the database, add to it, and view it. Deleting from the database is the only part I wasn't able to implement in time.

### Uses
You can use this to see how I worked with Node.js and SQL to create an interesting way to manage a database from the commandline.

### Takeaway
Had this been more practical, I probably would have continued working on it. Being able to send SQL code to a database as an argument (e.g. `node delete.js 1` would remove the item with the ID of 1, although I was having issues around that point) is an interesting way to approach this, and I'm leaving this on a branch since I actually think that this is a lot cooler than what I was able to do with PHP. Either way, I spent a lot of time working on this, and I have to put it somewhere.
