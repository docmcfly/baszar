----
-- phpLiteAdmin database dump (http://www.phpliteadmin.org/)
-- phpLiteAdmin version: 1.9.7.1
-- Exported: 2:14pm on November 29, 2017 (CET)
-- database file: bazaardatabase.sqlite
----
BEGIN TRANSACTION;

----
-- Drop table for voucher_details
----
DROP TABLE IF EXISTS "voucher_details";

----
-- Table structure for voucher_details
----
CREATE TABLE "voucher_details" ('voucher_id' INTEGER NOT NULL, 'seller_id' INTEGER NOT NULL, 'amount' NUMERIC NOT NULL);

----
-- Data dump for voucher_details, a total of 37 rows
----

----
-- Drop table for bazaars
----
DROP TABLE IF EXISTS "bazaars";

----
-- Table structure for bazaars
----
CREATE TABLE 'bazaars' ('id' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 'name' TEXT NOT NULL, 'year' INTEGER NOT NULL, 'comment' TEXT,'sellers' INTEGER NOT NULL,'create_time' DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP  );


----
-- Drop table for users
----
DROP TABLE IF EXISTS "users";

----
-- Table structure for users
----
CREATE TABLE 'users' ('id' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 'nick' TEXT NOT NULL, 'password' TEXT NOT NULL, 'create_time'  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP  );

----
-- Data dump for users, a total of 3 rows
----
INSERT INTO "users" ("id","nick","password","create_time") VALUES ('0','admin','601f1889667efaebb33b8c12572835da3f027f78','2017-11-12 19:42:52');

----
-- Drop table for vouchers
----
DROP TABLE IF EXISTS "vouchers";

----
-- Table structure for vouchers
----
CREATE TABLE 'vouchers' ('id' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,'bazaar_id' INTEGER NOT NULL,'till_id' INTEGER NOT NULL,'create_time' DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP  );

----
-- Data dump for vouchers, a total of 9 rows
----

COMMIT;
