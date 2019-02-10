CREATE database doingsdone
	DEFAULT CHARACTER SET utf8
	DEFAULT COLLATE utf8_general_ci;

USE doingsdone;

CREATE TABLE user (
	id INT AUTO_INCREMENT PRIMARY KEY,
	date_registration TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	email CHAR(128) NOT NULL UNIQUE,
	name CHAR(128),
	password CHAR(64)
);

CREATE TABLE project (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name CHAR(128),
  author_id INT,
  FOREIGN KEY (author_id) REFERENCES user(id)
);

CREATE TABLE task (
  id INT AUTO_INCREMENT PRIMARY KEY,
	date_create TIMESTAMP,
  date_done TIMESTAMP,
  status INT DEFAULT 0,
  name CHAR(128),
  file CHAR(128),
  deadline TIMESTAMP,
  author_id INT,
  project_id INT,
  FOREIGN KEY (author_id) REFERENCES user(id),
  FOREIGN KEY (project_id) REFERENCES project(id)
);
