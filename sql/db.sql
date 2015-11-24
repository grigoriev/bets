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

CREATE TABLE user_sessions (
  id            VARCHAR(50) NOT NULL,
  username      VARCHAR(50) NOT NULL,
  ip_address    VARCHAR(50) NOT NULL,
  last_activity DATETIME    NOT NULL,
  PRIMARY KEY (id),
  UNIQUE INDEX (id),
  FOREIGN KEY (username) REFERENCES users (username)
    ON DELETE CASCADE
);