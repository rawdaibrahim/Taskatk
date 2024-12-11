CREATE TABLE `subscription` (
    `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `name` varchar(20) NOT NULL UNIQUE,
    `max_lists` int(11) NOT NULL
);

CREATE TABLE `user` (
    `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `username` varchar(30) NOT NULL UNIQUE,
    `password` char(60) NOT NULL,
    `subscription_id` int(11) NOT NULL,
  	FOREIGN KEY (subscription_id) REFERENCES subscription(id)
);

CREATE TABLE `list` (
    `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `name` varchar(50) NOT NULL,
    `created_at` datetime NOT NULL DEFAULT current_timestamp(),
    `user_id` int(11) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES user(id)
);

CREATE TABLE `task` (
    `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `name` varchar(50) NOT NULL,
    `description` varchar(250) DEFAULT "",
    `due_date` date DEFAULT NULL,
    `flg_completed` tinyint(4) NOT NULL DEFAULT 0,
    `list_id` int(11) NOT NULL,
    FOREIGN KEY (list_id) REFERENCES list(id)
);

INSERT INTO subscription (name, max_lists) VALUES ('basic', 3);
INSERT INTO subscription (name, max_lists) VALUES ('premium', 5);