INSERT INTO ControllerPluginTypes (name) VALUES ('VIEW');
INSERT INTO ControllerPluginTypes (name) VALUES ('DATA');
INSERT INTO ControllerPluginTypes (name) VALUES ('ACTION');

INSERT INTO Pages (name) values ("Home");

INSERT INTO Controllers (name, type) values ('homeController', 1);

INSERT INTO Plugins (name, type) values ('testPlugin', 1);

INSERT INTO PagePluginController(pageID, pluginID, controllerID) values (1,1,1);

INSERT INTO Plugins (name, type, override, after) VALUES (curseWords, 2, 0, 0);

INSERT INTO Pages (pageID, name) VALUES (999, "Data");

INSERT INTO Controllers (name, type) values ('dataController', 2);

INSERT INTO PagePluginController(pageID, pluginID, controllerID) values (999,2,2);
