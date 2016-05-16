psql -U postgres -At gis > functions.sql <<"__END__"
SELECT pg_get_functiondef('call_calculate'::regproc);
SELECT pg_get_functiondef('update_score'::regproc);
__END__

