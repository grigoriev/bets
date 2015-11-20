CREATE TABLE users (
  id         INT         NOT NULL AUTO_INCREMENT,
  username   VARCHAR(50) NOT NULL,
  password   VARCHAR(50) NOT NULL,
  first_name VARCHAR(50) NOT NULL,
  last_name  VARCHAR(50) NOT NULL,
  email      VARCHAR(80) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE INDEX (username),
  UNIQUE INDEX (email)
);
