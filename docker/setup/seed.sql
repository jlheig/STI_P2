INSERT INTO users (username, password, role) VALUES ('admin', '$2y$10$A36td147D5wuCgzSiDNAE.QYQok75jsX0I2OWZyz73/BVjzCesrLu', 'admin');
INSERT INTO users (username, password) VALUES ('Jin', '$2y$10$35osfjPpHDio06yxYEQPM.2JbDrq.GTnWk.RoQ/PPxmry5faAyfaq');
INSERT INTO users (username, password, active) VALUES ('Erso', '$2y$10$ycEq31S/.RWMHMwXH1vY0OPskTZKOIW3/xFOETioiw6BhoG7X0t72', 0);

INSERT INTO emails (sender, receiver, subject, message, received_date) VALUES (2, 1, 'Hello, World!', 'Hello there!', '14-10-2021 15:00:00');
INSERT INTO emails (sender, receiver, subject, message, received_date, parent_email) VALUES (1, 2, 'Hello, World!', 'General Kenobi', '14-10-2021 15:15:00', 1);
INSERT INTO emails (sender, receiver, subject, message, received_date) VALUES (1, 3, 'Hello, World!', 'Hello there general Kenobi', '14-10-2020 15:20:00');