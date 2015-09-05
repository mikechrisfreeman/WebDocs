INSERT INTO ControllerPluginTypes (name) VALUES ('VIEW');
INSERT INTO ControllerPluginTypes (name) VALUES ('DATA');
INSERT INTO ControllerPluginTypes (name) VALUES ('ACTION');

INSERT INTO Pages (name) values ("Home");

INSERT INTO Controllers (name, type) values ('homeController', 1);

INSERT INTO Plugins (name, type) values ('testPlugin', 1);

INSERT INTO PagePluginController(pageID, pluginID, controllerID) values (1,1,1);

INSERT INTO Plugins (name, type, override, after) VALUES (curseWords, 2, 0, 0);

INSERT INTO Pages (pageID, name) VALUES (999, "Data");

INSERT INTO Controllers (name, type) values ('formDataController', 2);

INSERT INTO PagePluginController(pageID, pluginID, controllerID) values (999,2,2);

INSERT INTO PAGES (pageID, name) VALUES (888, "Admin");

INSERT INTO Controllers (name, type) values ('adminController', 1);

INSERT INTO UninstalledPlugins (name) values ('test');

INSERT INTO Controllers (name, type) values ('adminContentController', 1);

INSERT INTO Controllers (name, type) values ('scriptController', 1);

insert into pagecontroller (pageID, controllerID) VALUES (1,1);

insert into pagecontroller (pageID, controllerID) VALUES (999,2);
insert into pagecontroller (pageID, controllerID) VALUES (888,3);
insert into pagecontroller (pageID, controllerID) VALUES (888,4);
insert into pagecontroller (pageID, controllerID) VALUES (888,5);
insert into pagecontroller (pageID, controllerID) VALUES (1,4);

insert into protectedController(adminController);
insert into users (lastName, firstName, email, salt, hash) values ("freeman", "michael", "mike.c.freeman@gmail.com", "Michael", "Mio657Xn.CizE");
insert into pages (p[ageID, name) VALUES (777, 'login');




