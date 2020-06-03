#!/usr/bin/env bash
#
# Set and reset the db for the system


#echo ">>> Set / reset database oophp"
#echo ">>> Create / Recreate the database (as root)"
#mysql -uroot -p oophp < setup.sql > /dev/null

file="ddl_all.sql"
echo ">>> Create tables and views (ddl_all.sql) ($file)"
mysql -uuser -ppass oophp < $file > /dev/null

file="insert.sql"
echo ">>> Insert data (insert.sql) ($file)"
mysql -uuser -ppass oophp < $file > /dev/null
