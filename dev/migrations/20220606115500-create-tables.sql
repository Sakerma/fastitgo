DROP TABLE IF EXISTS order_items;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS products;

CREATE TABLE IF NOT EXISTS orders (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    status VARCHAR(16),
    amount INT,
    firstname VARCHAR(64),
    lastname VARCHAR(64),
    email VARCHAR(64),
    street VARCHAR(255),
    zip VARCHAR(8),
    city VARCHAR(64)
) ENGINE=INNODB CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE IF NOT EXISTS order_items (
    id int PRIMARY KEY NOT NULL AUTO_INCREMENT,
    order_id int NOT NULL,
    name VARCHAR(25),
    price INT,
    description VARCHAR(45),
    quantity INT,
    INDEX order_index (order_id),
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
) ENGINE=INNODB CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE IF NOT EXISTS products (
    id int PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name VARCHAR(16),
    description VARCHAR(45),
    price INT
) ENGINE=INNODB CHARACTER SET utf8 COLLATE utf8_general_ci;
