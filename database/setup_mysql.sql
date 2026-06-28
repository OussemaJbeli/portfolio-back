-- ============================================================
--  One-time MySQL bootstrap for the portfolio backend.
--  Creates the database and the application user referenced in .env
--  (DB_DATABASE=portfolio, DB_USERNAME=OJ-portfolio, DB_PASSWORD=OJ123PRO).
--
--  Requires admin privileges. Run as MySQL root, e.g.:
--      sudo mysql < database/setup_mysql.sql
--  (or: mysql -uroot -p < database/setup_mysql.sql)
-- ============================================================

CREATE DATABASE IF NOT EXISTS `portfolio`
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

CREATE USER IF NOT EXISTS 'OJ-portfolio'@'localhost' IDENTIFIED BY 'OJ123PRO';
CREATE USER IF NOT EXISTS 'OJ-portfolio'@'127.0.0.1' IDENTIFIED BY 'OJ123PRO';

GRANT ALL PRIVILEGES ON `portfolio`.* TO 'OJ-portfolio'@'localhost';
GRANT ALL PRIVILEGES ON `portfolio`.* TO 'OJ-portfolio'@'127.0.0.1';

FLUSH PRIVILEGES;
