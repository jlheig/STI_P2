INSERT INTO users (username, password, role) VALUES ('root', '63a9f0ea7bb98050796b649e85481845', 'admin');
INSERT INTO users (username, password) VALUES ('dany', '1b9fc02e98389d29c1506fe944b07d16');
INSERT INTO users (username, password, active) VALUES ('zebra', '69c459dd76c6198f72f0c20ddd3c9447', 0);

INSERT INTO emails (sender, receiver, subject, message, received_date) VALUES (2, 1, 'Hello, World!', 'Hello there!', '14-10-2021 15:00:00');
INSERT INTO emails (sender, receiver, subject, message, received_date, parent_email) VALUES (1, 2, 'Hello, World!', 'General Kenobi', '14-10-2021 15:15:00', 1);
INSERT INTO emails (sender, receiver, subject, message, received_date) VALUES (1, 3, 'Hello, World!', 'Hello there general Kenobi', '14-10-2020 15:20:00');