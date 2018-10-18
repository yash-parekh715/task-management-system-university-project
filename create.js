const sqlite3 = require('sqlite3').verbose();

// create the database
var taskdb = './db/tasks.db';
let db = new sqlite3.Database(taskdb);

// create the initial tasks table

db.run(('CREATE TABLE IF NOT EXISTS tasks(taskID INTEGER PRIMARY KEY AUTOINCREMENT, task text, date text)'), (err) => {
	if (err) {
		return console.error(err.message);
	}
	console.log('Created tasks table.');
});

// close the database connection

db.close((err) => {
	if (err) {
		return console.error(err.message);
	}
	console.log('Closed the database connection.');
});
