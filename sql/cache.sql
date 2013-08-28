SHOW VARIABLES LIKE 'query_cache_size';
	
SET GLOBAL query_cache_size = 201326592;

SHOW STATUS LIKE 'Qcache%';

RESET QUERY CACHE;