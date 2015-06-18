===== mysql =====

mysql import
local: mysqldump -uxxx -pxxx db > xxx.sql
remote: mysqldump -uxxx -pxxx -hxxx db > xxx.sql

mysql dump:
local: mysql -uxx -pxxx db < xxx.sql
remote: mysql -uxx -pxxx -hxxx db < xxx.sql