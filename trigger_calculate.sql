DECLARE
t_id	int4;
t_protocol	varchar(128);
t_deviceid	int4;
t_servertime	timestamp;
t_devicetime	timestamp;
t_fixtime	timestamp;
t_valid	bool;
t_latitude	float8;
t_longitude	float8;
t_altitude	float8;
t_speed	float8;
t_course	float8;
t_address	varchar(512);
t_attributes	varchar(4096);
t_osmid int8 default 0;
t_score int4 default 0;
r RECORD;
BEGIN
IF(TG_OP = 'INSERT') THEN
 t_id=NEW.id;
 t_deviceid=NEW.deviceid;
 t_servertime=NEW.servertime;
 t_latitude=NEW.latitude;
 t_longitude=NEW.longitude;

 -- get road name of this latitude and longitude
 SELECT osm_id,name AS street_name,ST_XMin(ST_PointN(ST_TRANSFORM(way,4326),3)) as longitude,
 ST_YMin(ST_PointN(ST_TRANSFORM(way,4326),3)) as latitude INTO r FROM planet_osm_roads 
 WHERE name is not null AND ST_Distance(ST_TRANSFORM(way,4326),ST_SetSRID(ST_MakePoint(t_longitude,t_latitude),4326)) < 0.001 and osm_id>0
 ORDER BY ST_Distance(ST_TRANSFORM(way,4326),ST_SetSRID(ST_MakePoint(t_longitude,t_latitude),4326)) ASC LIMIT 1;

 
 
 IF(r IS NOT NULL) THEN 

   -- cek t_score if exists then insert
   SELECT weight INTO t_score FROM roadweight WHERE osm_id=r.osm_id;
   IF(t_score IS NULL) THEN
     t_score=0;
     INSERT INTO roadweight(osm_id,name,weight,latitude,longitude)values(r.osm_id,r.street_name,0,r.latitude,r.longitude);
   END IF;

  -- check banner_route was inserted BEFORE
   t_osmid=null;
   SELECT osm_id INTO t_osmid FROM banner_route WHERE device_id=t_deviceid AND osm_id=r.osm_id AND checkin_time::date=now()::date;
   
   -- insert banner route score if not exists
   IF(t_osmid IS NULL) THEN
     INSERT INTO banner_route(device_id,osm_id,name,checkin_time,checkout_time,score,latitude,longitude)VALUES(t_deviceid,r.osm_id,r.street_name,t_servertime,t_servertime,t_score,r.latitude,r.longitude);
   END IF;

 END IF;

 


END IF; 

RETURN NEW;
END;

