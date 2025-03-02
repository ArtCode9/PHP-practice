--hello this sql playground

-- this is how we add data in Database table :
-- batman_t is the name of the table with 4 columns = id, firstName, lastName, mobile
INSERT INTO `batman_t` (`id`, `firstName`, `lastName`, `mobile`) VALUES (NULL, 'john', 'johny', '0234982');
INSERT INTO `batman_t` (`id`, `firstName`, `lastName`, `mobile`) VALUES (NULL, 'man', 'Done', '09234587');
INSERT INTO `batman_t` (`id`, `firstName`, `lastName`, `mobile`) VALUES (NULL, 'hook', 'man', '023872435');

/*
    CRUD:
    C => Create
        INSERT INTO sample (``, ``, ``, ``) VALUES (null, '', '', '');

    R => Read
        SELECT * FROM  nameOFTable >>>> means select all
        SELECT firstName FROM nameOFTable   >>> this just select firstName from database
        SELECT mobile FROM nameOFTable      >>> this just select mobile from database
        SELECT mobile, firstName FROM nameOFTable   >>>>  this select mobile and firstName from database

    U => Update
        UPDATE batman_t SET lastName = 'updateLastName';   >>> this is change all columns lastName values to new
                                                               we are selected
        UPDATE batman_t SET lastName = 'updateLastName', mobile = '0923457';  >>> this is change all lastName and mobile

    D => Delete
        DELETE FROM batman_t    >>> this is delete all data from database
        DELETE FROM batman_t WHERE firstName = 'Hulk';   >>>>     this just delete a row with the name of Hulk
        DELETE FROM batman_t WHERE firstName = 'Hulk' AND lastName = 'man';   >>>>  we select firstName and lastName
*/
-------------------------------------------------------------------------------------------------------------
-- SELECT Syntax
SELECT columns FROM table_name WHERE condition;

-- Examples
SELECT fullname FROM users WHERE age > 40;
SELECT * FROM users WHERE fullname LIKE 'ali%' AND age < 10;
SELECT id, age FROM users;
SELECT * FROM users WHERE email LIKE '%@yahoo%';
SELECT * FROM products WHERE category = 'mobile' AND price < 50000;
SELECT ip, access_date FROM access_log WHERE user_id = 7463;
-- use distinct to select unique values (remove duplicate values)
SELECT DISTINCT city FROM addresses;
-------------------------------------------------------------------------------------------------------------

-- SELECT Syntax (OrderTypes: ASC|DESC)
SELECT columns FROM table_name WHERE condition
ORDER BY column1 order_type, column2 order_type, ....

-- order user by age (Young first)
SELECT * FROM users ORDER BY age ASC;
-- order posts by date (latest first)
SELECT * FROM posts ORDER BY publish_date DESC;
-- order products (cheapest)
SELECT * FROM products ORDER BY price ASC;
-- order products (most expensive)
SELECT * FROM products ORDER BY price DESC, created_at DESC;
-------------------------------------------------------------------------------------------------------------

-- Aggregate functions

-- AVG(column) Calculates the average of a set of values
-- MIN(column) Gets the minimum value in a set of values
-- MAX(column) Gets the maximum value in a set of values
-- SUM(column) Calculates the sum of values
-- COUNT(column) Counts rows in a specified table or view

SELECT aggr(column) FROM table WHERE ...

-- Aggregate Function Examples
SELECT max(xp) FROM students;
SELECT min(degree) FROM daily_stats;
SELECT sum(pay_amount) FROM orders;
SELECT avg(age) FROM users;
-- total users
SELECT count(*) FROM users;
-- total users with mobile
SELECT count(Mobile) FROM users;
-- total users with unique mobile
SELECT count(distinct mobile) FROM users;
-------------------------------------------------------------------------------------------------------------

-- Count users for each city in table users
SELECT city, COUNT(*) AS city_users FROM users
GROUP BY city;

-- Show city with city_users > 10
SELECT city, COUNT(*) AS city_count FROM users
GROUP BY city HAVING city_count > 10
ORDER BY city_count DESC;
-------------------------------------------------------------------------------------------------------------



