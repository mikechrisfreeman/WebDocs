/*
    The users Table is purely for access, at present this will be only for administrators can be extended to other
    users of the system
 */
 CREATE TABLE Users
(

userID int PRIMARY KEY NOT NULL AUTO_INCREMENT,
lastName varchar(255) NOT NULL,
firstName varchar(255) NOT NULL,
email varchar(255) NOT NULL,
password varchar(255) NOT NULL,
salt varchar(255) NOT NULL

)Engine=innoDB;

/*
  This Table represents pages on the website, this could be a 'Blog' or 'ADMIN' page
 */
CREATE TABLE Pages
(
pageID int PRIMARY KEY NOT NULL AUTO_INCREMENT,
name varchar(255) NOT NULL
)Engine=innoDB;

/*
  Controller Types helps moderate the types of controllers that can instantiate the types of Plugins
 */
CREATE TABLE ControllerPluginTypes
(
  CPTypeID int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  name varchar(255)
)Engine=innoDB;

/*
  Every controller within the system needs to be accounted for - the database assists with this
 */
CREATE TABLE Controllers
(
controllerID int PRIMARY KEY NOT NULL AUTO_INCREMENT,
name varchar(255) NOT NULL UNIQUE,
type int NOT NULL,
FOREIGN KEY (TYPE) REFERENCES ControllerPluginTypes (CPTypeID)
)Engine=innoDB;

/*
  Every plugin that could be enabled needs to be accounted for - the Database Assists with this
 */
CREATE TABLE Plugins
(
pluginID int PRIMARY KEY NOT NULL AUTO_INCREMENT,
name varchar(255) NOT NULL,
type int NOT NULL,
override BIT NOT NULL,
after BIT NOT NULL,
FOREIGN KEY (TYPE) REFERENCES ControllerPluginTypes (CPTypeID)
)Engine=innoDB;


CREATE TABLE PagePluginController
(
pageID int NOT NULL,
pluginID int NOT NULL ,
controllerID int NOT NULL,
FOREIGN KEY (pageID) REFERENCES pages (pageID),
FOREIGN KEY (pluginID) REFERENCES plugins (pluginID),
FOREIGN KEY (controllerID) REFERENCES controllers (controllerID)
)

CREATE TABLE PageController
(
pageID int NOT NULL,
controllerID int NOT NULL,
FOREIGN KEY (pageID) REFERENCES pages (pageID),
FOREIGN KEY (controllerID) REFERENCES controllers (controllerID)
)

/*
CREATE TABLE CommentsData
(
record int PRIMARY KEY NOT NULL AUTO_INCREMENT,
firstname VARCHAR (32) not null,
comment VARCHAR (255) not null
)
*/


CREATE TABLE UninstalledPlugins
(
ID int PRIMARY KEY NOT NULL AUTO_INCREMENT,
name varchar(255) NOT NULL UNIQUE
)






