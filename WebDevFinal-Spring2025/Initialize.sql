-- Use SQL statements to initialize Your Database Here!

use mysql;

/*
create table Login (
    userID INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30) NOT NULL,
    password VARCHAR(30) NOT NULL
);

create table Income (
    incomeID INT AUTO_INCREMENT PRIMARY KEY,
    salary FLOAT,
    hourly FLOAT,
    hoursWorked FLOAT,
    amount FLOAT,
    userID INT NOT NULL,
    FOREIGN KEY (userID) REFERENCES Login(userID)
);

create table Expense (
    expenseID INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    cost FLOAT NOT NULL,
    dueBy DATE NOT NULL,
    userID INT NOT NULL,
    FOREIGN KEY (userID) REFERENCES Login(userID)
);

create table Extra (
    extraID INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    amount FLOAT NOT NULL,
    userID INT NOT NULL,
    FOREIGN KEY (userID) REFERENCES Login(userID)
);

insert into Login(username, password) values
('admin', 'admin1234'),
('sim_mute', 'password123'),
('nort_yellow', 'ShoutPass456'),
('miguel_huerta','mypassOut789'),
('rem_purple','myBigpassword2025'),
('elfte_green', 'passw0rdYurk1738'),
('ronan_paterson','And@12345'),
('zo_red', 'trigGapassword_2025');

insert into Income(salary, hourly, hoursWorked, amount, userID) values
(100000, NULL, NULL, NULL, 1),
(68599,NULL, NULL, NULL, 2),
(78000,NULL, NULL, NULL, 3),
(NULL, 34.75, 45.00, NULL, 4),
(55873, NULL, NULL, NULL, 5),
(NULL, 35.00, 40.00, NULL, 6),
(50039.00, NULL, NULL, NULL, 7),
(60000, NULL, NULL, NULL, 8);

insert into Expense(name, cost, dueBy, userID) values 
('Rent', 1200, '2025-06-01', 1),
('Internet', 100, '2025-06-10', 1),
('Groceries', 250, '2025-06-20', 1),
('Rent', 1300, '2025-06-01', 2),
('Electricity', 160, '2025-06-15', 2),
('Internet', 120, '2025-06-10', 2),
('Rent', 1100, '2025-06-01', 3),
('Electricity', 140, '2025-06-15', 3),
('Rent', 1500, '2025-06-01', 4),
('Electricity', 170, '2025-06-15', 4),
('Internet', 130, '2025-06-05', 4),
('Electricity', 130, '2025-06-15', 5),
('Internet', 110, '2025-06-10', 5),
('Rent', 675, '2025-06-01', 6),
('Internet', 70, '2025-06-10', 6),
('Groceries', 130, '2025-06-20', 6),
('Rent', 600, '2025-06-01', 7),
('Electricity', 180, '2025-06-15', 7),
('Internet', 150, '2025-06-10', 7),
('Rent', 505, '2025-06-01', 8),
('Electricity', 130, '2025-06-15', 8);

insert into Extra(name, amount, userID) values
('Car Repair', 150, 1),
('Concert Tickets', 250, 1),
('New Laptop', 1200, 2),
('Concert Tickets', 100, 2),
('Cardboard', 800, 3),
('New Phone', 500, 3),
('New GPU', 300, 4),
('New PSU', 700, 4),
('New Keyboard', 600, 5),
('New Phone', 750, 5),
('Transportation Fee', 600, 6),
('New PC', 750, 6),
('Concert Tickets', 400, 7),
('New Chair', 1500, 7),
('Vacation', 1200, 8),
('New Headset', 250, 8);
*/

