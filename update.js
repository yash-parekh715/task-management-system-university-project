const sqlite3 = require('sqlite3').verbose();

// open a database connection
var taskdb = 'tasks.db';
let db = new sqlite3.Database(taskdb);

//
let data = ['Ansi C', 'C'];
let sql = `UPDATE tasks
           SET name = ?
           WHERE name = ?`;

db.run(sql, data, function(err) {
 if (err) {
   return console.error(err.message);
 }
 console.log(`Row(s) updated: ${this.changes}`);

});

// close the database connection
db.close();
