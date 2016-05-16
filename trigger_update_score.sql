BEGIN
IF(TG_OP = 'UPDATE') THEN
   UPDATE banner_route set score=NEW.weight where osm_id=new.osm_id;
END IF;
RETURN NEW;
END;

