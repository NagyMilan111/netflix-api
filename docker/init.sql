FLUSH PRIVILEGES;
-- Create the database if it doesn't exist
CREATE DATABASE IF NOT EXISTS Netflix;
USE Netflix;

-- Create users and grant permissions
CREATE USER IF NOT EXISTS 'senior'@'%' IDENTIFIED BY 'senior_password';
GRANT SELECT, INSERT, UPDATE, DELETE, INDEX, LOCK TABLES, CREATE TEMPORARY TABLES,
 SHOW VIEW, CREATE ROUTINE, ALTER ROUTINE, EXECUTE ON Netflix.* TO 'senior'@'%';
GRANT CREATE USER ON *.* TO 'senior'@'%';
GRANT SELECT ON mysql.user TO 'senior'@'%';

CREATE USER IF NOT EXISTS 'medior'@'%' IDENTIFIED BY 'medior_password';
GRANT SELECT, INSERT, UPDATE, DELETE, INDEX, LOCK TABLES, CREATE TEMPORARY TABLES,
 SHOW VIEW, CREATE ROUTINE, ALTER ROUTINE, EXECUTE ON Netflix.* TO 'medior'@'%';


CREATE USER IF NOT EXISTS 'junior'@'%' IDENTIFIED BY 'junior_password';
GRANT SELECT, INSERT, UPDATE, INDEX, LOCK TABLES, CREATE TEMPORARY TABLES,
 SHOW VIEW, EXECUTE ON Netflix.* TO 'junior'@'%';

CREATE USER IF NOT EXISTS 'api'@'%' IDENTIFIED BY 'topsecret';
GRANT EXECUTE ON Netflix.* TO 'api'@'%';
GRANT SELECT ON Netflix.* TO 'api'@'%';

-- Drop root users (if they exist)
DROP USER IF EXISTS 'root'@'localhost';
DROP USER IF EXISTS 'root'@'%';

-- Flush privileges to apply changes
FLUSH PRIVILEGES;