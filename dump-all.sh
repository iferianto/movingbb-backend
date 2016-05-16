nohup pg_dump -U postgres gis | gzip -c > gis-dump.sql.gz &

