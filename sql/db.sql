CREATE TABLE users (
  username   VARCHAR(50) NOT NULL,
  password   VARCHAR(50) NOT NULL,
  first_name VARCHAR(50) NOT NULL,
  last_name  VARCHAR(50) NOT NULL,
  email      VARCHAR(80) NOT NULL,
  PRIMARY KEY (username),
  UNIQUE INDEX (username),
  UNIQUE INDEX (email)
)
  ENGINE = InnoDB;

CREATE TABLE user_sessions (
  uuid          VARCHAR(50) NOT NULL,
  username      VARCHAR(50) NOT NULL,
  ip_address    VARCHAR(50) NOT NULL,
  last_activity DATETIME    NOT NULL,
  PRIMARY KEY (uuid),
  UNIQUE INDEX (uuid),
  INDEX (username),
  FOREIGN KEY (username) REFERENCES users (username)
    ON DELETE CASCADE
)
  ENGINE = InnoDB;