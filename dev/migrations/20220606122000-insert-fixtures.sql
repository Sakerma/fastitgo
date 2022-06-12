/* Insert som products */
INSERT INTO products VALUES
(NULL, 'Burger', 'Best Burger', 800),
(NULL, 'Frites', 'Best Frites', 300),
(NULL, 'Coca', 'Coca', 150),
(NULL, 'Glace', 'Glace', 250),
(NULL, 'Café', 'Café', 150);

/* Orders status: new|pending|paid|prepared|delivered|paiement_error */
INSERT INTO orders VALUES
(NULL, 'pending', 1100, 'Sofiene', 'Akerma', 'sof@gmail.com', '1 rue de la paix', '75001', 'Paris'),
(NULL, 'pending', 400, 'John', 'Doe', 'john.doe@gmail.com', '2 rue de la paix', '75001', 'Paris');

INSERT INTO order_items VALUES
(NULL, 1, 'Burger', 800, 'Best Burger', 1),
(NULL, 1, 'Frites', 300, 'Best Frites', 1),
(NULL, 2, 'Glace', 250, 'Glace', 1),
(NULL, 2, 'Café', 150, 'Café', 1);
