#!/usr/bin/env bash

db_name=$1
db_user=$2
db_pass=$3
schema=$4
seed=$5

echo ">>> MySQL: Granting Privileges to Root"
mysql --user="root" --password=secret -e "GRANT ALL ON *.* TO 'root'@'%' IDENTIFIED BY 'root' WITH GRANT OPTION; FLUSH PRIVILEGES;" 1>/dev/null 2>&1

mysql --user="root" --password="secret" -e "CREATE DATABASE $db_name;" 1>/dev/null 2>&1
mysql --user="root" --password="secret" -e "CREATE USER '$db_user'@'localhost' IDENTIFIED BY '$db_pass';" 1>/dev/null 2>&1
mysql --user="root" --password="secret" -e "GRANT ALL PRIVILEGES ON $db_name.* TO '$db_user'@'localhost';" 1>/dev/null 2>&1
mysql --user="root" --password="secret" -e "FLUSH PRIVILEGES;" 1>/dev/null 2>&1
mysql --user="root" --password="secret" --database="$db_name" -e "source $schema;"
mysql --user="root" --password="secret" --database="$db_name" -e "source $seed;"

service mysql restart 1>/dev/null 2>&1
