const sqlite3 = require('sqlite3').verbose();

// require lodash and yargs to grab from stdin
const _ = require('lodash');
const yargs = require('yargs');
const argv = yargs.argv;

// get input from stdin
var taskinput = argv._[0];

// open the database
var taskdb = './db/tasks.db';
let db = new sqlite3.Database(taskdb);

//let placeholders = command;
console.log(taskinput);

let sql = 'INSERT INTO tasks(task, date) VALUES ((?), datetime("now", "localtime"))';

// insert one row into the tasks table
db.run(sql, [taskinput], function(err) {
	//`INSERT INTO tasks(task,date) VALUES(?, ?)`
	if (err) {
		return console.log(err.message);
	}
	// get the last insert id
	console.log(`A row has been inserted with rowid ${this.lastID}`);
});

db.close();
