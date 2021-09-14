-- Database setup --

-- Create the database --
CREATE DATABASE IF NOT EXISTS theBasePHPTest;

-- Decide which database that you will use --
USE theBasePHPTest;

-- Create a user with access to the database, independant of hostname
-- Pword: pass
CREATE USER IF NOT EXISTS 'user'@'%'
      IDENTIFIED
    WITH mysql_native_password -- MySQL with version > 8.0.4
      BY 'pass'
;

-- Give all the privilegies to the user, for the database
GRANT ALL PRIVILEGES
    ON
      theBasePHPTest.*
      TO 'user'@'%'
;
