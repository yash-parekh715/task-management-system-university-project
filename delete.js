const sqlite3 = require('sqlite3').verbose();
const _ = require('lodash');
const yargs = require('yargs');

const argv = yargs.argv;
var rowid = argv._[0];
//var id = argv._[1];

// open a database connection
var taskdb = './db/tasks.db';
let db = new sqlite3.Database(taskdb);

let db = new sqlite3.Database('./db/tasks.db');
let sql = `SELECT `+ rowid + ` FROM tasks`;

db.all(sql, [], (err, row) => {
  if (err) {
    throw err;
  }
  console.log(JSON.stringify(row));
});

// console.log(items);

db.close();
