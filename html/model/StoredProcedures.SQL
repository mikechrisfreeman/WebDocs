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

