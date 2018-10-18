const sqlite3 = require('sqlite3').verbose();

// require lodash and yargs to grab from stdin
const _ = require('lodash');
const yargs = require('yargs');
const argv = yargs.argv;

// get input from stdin
var command = argv._[0];
var id = argv._[1];

// open the database

var taskdb = './db/tasks.db';

let db = new sqlite3.Database(taskdb);
let sql = `SELECT `+ command + ` FROM tasks WHERE taskid=` + id;


// insert one row into the tasks table
db.all(sql, [], (err, row) => {
	if (err) {
		throw err;
		//return console.log(err.message);
	}
	//console.log(
	console.log(row);
});

db.close();
