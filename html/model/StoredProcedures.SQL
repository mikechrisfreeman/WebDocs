/*
    Creating Procedure for Getting PluginID Associated to controller and page
    We use the controllerName because we dont have access to the ID of the controller
    from the parent class.
 */

CREATE PROCEDURE GetPluginIDForController(pageID int, controllerName VARCHAR(32))
  SELECT ppc.pluginID
  FROM PageControllerplugin as ppc, Controllers as C
  WHERE ppc.controllerID = c.controllerID
  AND c.name = controllerName
  AND ppc.pageID = pageID;



/*
    Creating Stored Procedure for Getting Plugin details for ID
 */
CREATE PROCEDURE getPluginDetailsforID(pluginID int)
  SELECT *
  FROM Plugins as p
  WHERE p.pluginID = pluginID;


DELIMITER <<
DROP PROCEDURE IF EXISTS webdep.FormDataInsert<<
CREATE PROCEDURE webdep.FormDataInsert(IN tableName VARCHAR(45))
BEGIN
	DECLARE sqlQuery VARCHAR(1024);
    DECLARE stmtp VARCHAR(1024);
    SET @sqlQuery = CONCAT('INSERT INTO CommentsData (firstname, comment)', 'VALUES(\'michael\', \'comment101\')');
    PREPARE stmtp FROM @sqlQuery;
    EXECUTE stmtp;
END<<
DELIMETER ;

DROP PROCEDURE IF EXISTS webdep.FormDataInsert<<
CREATE PROCEDURE webdep.FormDataInsert( IN tableName VARCHAR(45),
                                        IN columnName1 VARCHAR(45), IN columnValue1 VARCHAR(1024),
                                        IN columnName2 VARCHAR(45), IN columnValue2 VARCHAR(1024),
                                        IN columnName3 VARCHAR(45), IN columnValue3 VARCHAR(1024),
                                        IN columnName4 VARCHAR(45), IN columnValue4 VARCHAR(1024),
                                        IN columnName5 VARCHAR(45), IN columnValue5 VARCHAR(1024),
                                        IN columnName6 VARCHAR(45), IN columnValue6 VARCHAR(1024),
                                        IN columnName7 VARCHAR(45), IN columnValue7 VARCHAR(1024),
                                        IN columnName8 VARCHAR(45), IN columnValue8 VARCHAR(1024),
                                        IN columnName9 VARCHAR(45), IN columnValue9 VARCHAR(1024),
                                        IN columnName10 VARCHAR(45), IN columnValue10 VARCHAR(1024),
                                        IN columnName11 VARCHAR(45), IN columnValue11 VARCHAR(1024),
                                        IN columnName12 VARCHAR(45), IN columnValue12 VARCHAR(1024),
                                        IN columnName13 VARCHAR(45), IN columnValue13 VARCHAR(1024),
                                        IN columnName14 VARCHAR(45), IN columnValue14 VARCHAR(1024),
                                        IN columnName15 VARCHAR(45), IN columnValue15 VARCHAR(1024),
                                        IN columnName16 VARCHAR(45), IN columnValue16 VARCHAR(1024),
                                        IN columnName17 VARCHAR(45), IN columnValue17 VARCHAR(1024),
                                        IN columnName18 VARCHAR(45), IN columnValue18 VARCHAR(1024),
                                        IN columnName19 VARCHAR(45), IN columnValue19 VARCHAR(1024),
                                        IN columnName20 VARCHAR(45), IN columnValue20 VARCHAR(1024))
BEGIN
	DECLARE sqlQueryStart VARCHAR(1024);
    DECLARE sqlQueryColumns VARCHAR(1024);
    DECLARE sqlQUeryValues VARCHAR(1024);
    DECLARE stmtp VARCHAR(1024);
    DECLARE sqlQuery VARCHAR(1024);

    SET @sqlQueryStart = CONCAT('INSERT INTO ', tableName, ' ');
    SET @sqlQueryColumns = '(';
    SET @sqlQueryValues = 'VALUES (';


    IF (columnName1 IS NOT NULL OR columnName1 <> '' ) && (columnValue1 IS NOT NULL OR columnValue1 <> '' ) THEN
    	SET @sqlQueryColumns = CONCAT(@sqlQueryColumns, columnName1);
        SET @sqlQueryValues = CONCAT(@sqlQueryValues, '\'', columnValue1, '\'');
    END IF;

    IF (columnName2 IS NOT NULL OR columnName2 <> '' ) && (columnValue2 IS NOT NULL OR columnValue2 <> '' ) THEN
    	SET @sqlQueryColumns = CONCAT(@sqlQueryColumns, ',',columnName2);
        SET @sqlQueryValues = CONCAT(@sqlQueryValues, ',', '\'', columnValue2, '\'');
    END IF;


    IF (columnName3 IS NOT NULL AND columnName3 <> '' ) && (columnValue3 IS NOT NULL AND columnValue3 <> '' ) THEN
    	SET @sqlQueryColumns = CONCAT(@sqlQueryColumns, ',',columnName3);
        SET @sqlQueryValues = CONCAT(@sqlQueryValues, ',','\'', columnValue3, '\'');
    END IF;

    IF (columnName4 IS NOT NULL AND columnName4 <> '' ) && (columnValue4 IS NOT NULL AND columnValue4 <> '' ) THEN
    	SET @sqlQueryColumns = CONCAT(@sqlQueryColumns,',', columnName4);
        SET @sqlQueryValues = CONCAT(@sqlQueryValues, ',','\'', columnValue4, '\'');
    END IF;

    IF (columnName5 IS NOT NULL AND columnName5 <> '' ) && (columnValue5 IS NOT NULL AND columnValue5 <> '' ) THEN
    	SET @sqlQueryColumns = CONCAT(@sqlQueryColumns,',', columnName5);
        SET @sqlQueryValues = CONCAT(@sqlQueryValues, ',','\'', columnValue5, '\'');
    END IF;

    IF (columnName6 IS NOT NULL AND columnName6 <> '' ) && (columnValue6 IS NOT NULL AND columnValue6 <> '' ) THEN
    	SET @sqlQueryColumns = CONCAT(@sqlQueryColumns,',', columnName6);
        SET @sqlQueryValues = CONCAT(@sqlQueryValues,',', '\'', columnValue6, '\'');
    END IF;

    IF (columnName7 IS NOT NULL AND columnName7 <> '' ) && (columnValue7 IS NOT NULL AND columnValue7 <> '' ) THEN
    	SET @sqlQueryColumns = CONCAT(@sqlQueryColumns, columnName7);
        SET @sqlQueryValues = CONCAT(@sqlQueryValues, '\'', columnValue7, '\'');
    END IF;

    IF (columnName8 IS NOT NULL AND columnName8 <> '' ) && (columnValue8 IS NOT NULL AND columnValue8 <> '' ) THEN
    	SET @sqlQueryColumns = CONCAT(@sqlQueryColumns,',', columnName8);
        SET @sqlQueryValues = CONCAT(@sqlQueryValues,',', '\'', columnValue8, '\'');
    END IF;

    IF (columnName9 IS NOT NULL AND columnName9 <> '' ) && (columnValue9 IS NOT NULL AND columnValue9 <> '' ) THEN
    	SET @sqlQueryColumns = CONCAT(@sqlQueryColumns,',', columnName9);
        SET @sqlQueryValues = CONCAT(@sqlQueryValues, ',','\'', columnValue9, '\'');
    END IF;

    IF (columnName10 IS NOT NULL AND columnName10 <> '' ) && (columnValue10 IS NOT NULL AND columnValue10 <> '' ) THEN
    	SET @sqlQueryColumns = CONCAT(@sqlQueryColumns,',', columnName10);
        SET @sqlQueryValues = CONCAT(@sqlQueryValues,',','\'', columnValue10, '\'');
    END IF;

    IF (columnName11 IS NOT NULL AND columnName11 <> '' ) && (columnValue11 IS NOT NULL AND columnValue11 <> '' ) THEN
    	SET @sqlQueryColumns = CONCAT(@sqlQueryColumns, columnName11);
        SET @sqlQueryValues = CONCAT(@sqlQueryValues, '\'', columnValue11, '\'');
    END IF;

    IF (columnName12 IS NOT NULL AND columnName12 <> '' ) && (columnValue12 IS NOT NULL AND columnValue12 <> '' ) THEN
    	SET @sqlQueryColumns = CONCAT(@sqlQueryColumns,',', columnName12);
        SET @sqlQueryValues = CONCAT(@sqlQueryValues, ',','\'', columnValue12, '\'');
    END IF;

    IF (columnName13 IS NOT NULL AND columnName13 <> '' ) && (columnValue13 IS NOT NULL AND columnValue13 <> '' ) THEN
    	SET @sqlQueryColumns = CONCAT(@sqlQueryColumns,',', columnName13);
        SET @sqlQueryValues = CONCAT(@sqlQueryValues, ',','\'', columnValue13, '\'');
    END IF;

    IF (columnName14 IS NOT NULL AND columnName14 <> '' ) && (columnValue14 IS NOT NULL AND columnValue14 <> '' ) THEN
    	SET @sqlQueryColumns = CONCAT(@sqlQueryColumns,',', columnName14);
        SET @sqlQueryValues = CONCAT(@sqlQueryValues,',', '\'', columnValue14, '\'');
    END IF;

    IF (columnName15 IS NOT NULL AND columnName15 <> '' ) && (columnValue15 IS NOT NULL AND columnValue15 <> '' ) THEN
    	SET @sqlQueryColumns = CONCAT(@sqlQueryColumns,',', columnName15);
        SET @sqlQueryValues = CONCAT(@sqlQueryValues,',', '\'', columnValue15, '\'');
    END IF;

    IF (columnName16 IS NOT NULL AND columnName16 <> '' ) && (columnValue16 IS NOT NULL AND columnValue16 <> '' ) THEN
    	SET @sqlQueryColumns = CONCAT(@sqlQueryColumns,',', columnName16);
        SET @sqlQueryValues = CONCAT(@sqlQueryValues,',', '\'', columnValue16, '\'');
    END IF;

    IF (columnName17 IS NOT NULL AND columnName17 <> '' ) && (columnValue17 IS NOT NULL AND columnValue17 <> '' ) THEN
    	SET @sqlQueryColumns = CONCAT(@sqlQueryColumns,',', columnName17);
        SET @sqlQueryValues = CONCAT(@sqlQueryValues, ',','\'', columnValue17, '\'');
    END IF;

    IF (columnName18 IS NOT NULL AND columnName18 <> '' ) && (columnValue18 IS NOT NULL AND columnValue18 <> '' ) THEN
    	SET @sqlQueryColumns = CONCAT(@sqlQueryColumns,',', columnName18);
        SET @sqlQueryValues = CONCAT(@sqlQueryValues, ',','\'', columnValue18, '\'');
    END IF;

    IF (columnName19 IS NOT NULL AND columnName19 <> '' ) && (columnValue19 IS NOT NULL AND columnValue19 <> '' ) THEN
    	SET @sqlQueryColumns = CONCAT(@sqlQueryColumns, ',',columnName19);
        SET @sqlQueryValues = CONCAT(@sqlQueryValues, ',','\'', columnValue19, '\'');
    END IF;

    IF (columnName20 IS NOT NULL AND columnName20 <> '' ) && (columnValue20 IS NOT NULL AND columnValue20 <> '' ) THEN
    	SET @sqlQueryColumns = CONCAT(@sqlQueryColumns,',', columnName20);
        SET @sqlQueryValues = CONCAT(@sqlQueryValues, ',','\'', columnValue20, '\'');
    END IF;


    SET @sqlQueryColumns = CONCAT(@sqlQueryColumns, ') ');
    SET @sqlQueryValues = CONCAT(@sqlQueryValues, ')');


    SET @sqlQuery = CONCAT(@sqlQueryStart, @sqlQueryColumns, @sqlQueryValues);
    PREPARE stmtp FROM @sqlQuery;
    EXECUTE stmtp;
END<<


