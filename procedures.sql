delimiter //
DROP PROCEDURE IF EXISTS Search//
CREATE PROCEDURE Search(IN SchName VARCHAR(120), SAT_MIN INTEGER, SAT_MAX INTEGER, ACT_MIN INTEGER,
	ACT_MAX INTEGER, State VARCHAR(2), City VARCHAR(30))
BEGIN
SELECT College_info.SchID, College_info.SchName, URL, SchType, (SAT.SATVRMID+SAT.SATMTMID+SAT.SATWRMID) as SAT_Median,
ACT.ACTCMMID as ACT_Median, Location.City, Location.State,
Tuition.in_state, Tuition.out_of_state
FROM College_info, SAT, Location, ACT, Tuition
WHERE CASE WHEN SchName IS NOT NULL THEN College_info.SchName = SchName 
        ELSE true END
	AND CASE WHEN SAT_MIN IS NOT NULL THEN (SAT.SATVRMID+SAT.SATMTMID+SAT.SATWRMID) >= SAT_MIN
        ELSE TRUE END
    AND CASE WHEN SAT_MAX IS NOT NULL THEN (SAT.SATVRMID+SAT.SATMTMID+SAT.SATWRMID) <= SAT_MAX
        ELSE TRUE END
    AND CASE WHEN ACT_MIN IS NOT NULL THEN ACT.ACTCMMID >= ACT_MIN
        ELSE TRUE END
    AND CASE WHEN ACT_MAX IS NOT NULL THEN ACT.ACTCMMID <= ACT_MAX
        ELSE TRUE END
    AND CASE WHEN State IS NOT NULL THEN Location.State = State
        ELSE TRUE END
    AND CASE WHEN City IS NOT NULL THEN Location.City = City
        ELSE TRUE END
	AND SAT.SchID = College_info.SchID
	AND ACT.SchID = College_info.SchID
	AND Location.SchID = College_info.SchID
	AND Tuition.SchID = College_info.SchID;
END//
delimiter ;

delimiter //
DROP PROCEDURE IF EXISTS MatchSchool//
CREATE PROCEDURE MatchSchool(IN SatScore INT, IN ActScore INT, IN Public INT, IN Ethnic NUMERIC(6,4), IN Retent NUMERIC(6,4), IN Fee INT)
BEGIN
 
     (SELECT c.SchName, c.URL, c.SchType, Location.City, Location.State, s.Adm_rate
      FROM College_info AS c, SAT, ACT, Undergraduate AS u, Statistics AS s, Tuition AS t, Location
      WHERE c.SchID=SAT.SchID
      AND c.SchID=ACT.SchID
      AND c.SchID=u.SchID
      AND c.SchID=s.SchID
      AND c.SchID=t.SchID
      AND Location.SchID = c.SchID

      AND CASE WHEN Ethnic IS NOT NULL THEN u.UGDS_BLACK > Ethnic
      ELSE TRUE END
      AND CASE WHEN Ethnic IS NOT NULL THEN u.UGDS_HISP > Ethnic
      ELSE TRUE END
      AND CASE WHEN Ethnic IS NOT NULL THEN u.UGDS_ASIAN > Ethnic/3
      ELSE TRUE END
      AND CASE WHEN Retent IS NOT NULL THEN s.Retention_rate_FT4 > Retent
      ELSE TRUE END
      AND CASE WHEN Fee IS NOT NULL THEN t.out_of_state < Fee
      ELSE TRUE END
      AND CASE WHEN SatScore IS NOT NULL THEN (SAT.SATVRMID+SAT.SATMTMID+SAT.SATWRMID) < SatScore+100 
      ELSE TRUE END
      AND CASE WHEN SatScore IS NOT NULL THEN (SAT.SATVRMID+SAT.SATMTMID+SAT.SATWRMID) > SatScore-100
      ELSE TRUE END
    )
     UNION (
      SELECT c.SchName, c.URL, c.SchType, Location.City, Location.State, s.Adm_rate
      FROM College_info AS c, SAT, ACT, Undergraduate AS u, Statistics AS s, Tuition AS t, Location
      WHERE c.SchID=SAT.SchID
      AND c.SchID=ACT.SchID
      AND c.SchID=u.SchID
      AND c.SchID=s.SchID
      AND c.SchID=t.SchID
      AND Location.SchID = c.SchID

      AND CASE WHEN Ethnic IS NOT NULL THEN u.UGDS_BLACK > Ethnic
      ELSE TRUE END
      AND CASE WHEN Ethnic IS NOT NULL THEN u.UGDS_HISP > Ethnic
      ELSE TRUE END
      AND CASE WHEN Ethnic IS NOT NULL THEN u.UGDS_ASIAN > Ethnic/3
      ELSE TRUE END
      AND CASE WHEN Retent IS NOT NULL THEN s.Retention_rate_FT4 > Retent
      ELSE TRUE END
      AND CASE WHEN Fee IS NOT NULL THEN t.out_of_state < Fee
      ELSE TRUE END

      AND CASE WHEN ActScore IS NOT NULL THEN ACT.ACTCMMID < ActScore+2
      ELSE TRUE END
      AND CASE WHEN ActScore IS NOT NULL THEN ACT.ACTCMMID > ActScore-2
      ELSE TRUE END
    
      );
     
      

END;
//
delimeter ;

