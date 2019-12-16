delimiter //
DROP PROCEDURE IF EXISTS Search//

CREATE PROCEDURE Search(IN StateName VARCHAR(30))(
BEGIN
SELECT * 
FROM Company 
WHERE StateName = Company.hq_city
;
      
END
//
delimiter ;

