-- Create the 'tasks' table to store todo tasks
CREATE TABLE `tasks` (
    `id` int(11) NOT NULL, -- Primary key for each task, an integer that uniquely identifies the task
    `todoTitle` varchar(200) COLLATE utf8_bin NOT NULL, -- Title of the todo task, with a maximum length of 200 characters
    `todoDescription` text COLLATE utf8_bin NOT NULL, -- Description of the todo task, can hold longer text
    `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP -- Timestamp of when the task is created, defaults to the current time
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
-- Use InnoDB engine for ACID compliance and set character set to UTF-8
-- Add a unique key constraint on the 'id' column to ensure each value is unique
ALTER TABLE `tasks` ADD UNIQUE KEY `id` (`id`);

-- Modify the 'id' column to be an auto-incrementing integer, which automatically generates a new value for each new row
ALTER TABLE tasks MODIFY id INT NOT NULL AUTO_INCREMENT;