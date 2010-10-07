create table $history
(
	item_id int AUTO_INCREMENT NOT NULL,
	url varchar(255) NOT NULL,
	name varchar(255) NOT NULL,
	type int NOT NULL,
	update_timestamp timestamp,
	PRIMARY KEY ( item_id )
);

create table $connect
(
	item_id int AUTO_INCREMENT NOT NULL,
	parent_table varchar(255) NOT NULL,   -- parent column will always be item_id
	parent_display_1 varchar(255), -- column to display in form
	parent_display_2 varchar(255), -- column to display in form
	parent_display_3 varchar(255), -- column to display in form
	child_table varchar(255) NOT NULL,
	child_column varchar(255) NOT NULL,
	update_timestamp timestamp,
	PRIMARY KEY ( item_id )
);

create table phone_calls
(
	item_id int AUTO_INCREMENT NOT NULL,
	first_name varchar(255),
	last_name varchar(255),
	update_timestamp timestamp,
	PRIMARY KEY ( item_id )
);

create table customers
(
	item_id int AUTO_INCREMENT NOT NULL,
	first_name varchar(255),
	last_name varchar(255),
	address varchar(255),
	zip varchar(255),
	home_phone varchar(255),
	office_phone varchar(255),
	email_1 varchar(255),
	email_2 varchar(255),
	update_timestamp timestamp,
	PRIMARY KEY ( item_id )
);

create table events
(
	item_id int AUTO_INCREMENT NOT NULL,
	customer_id int,
	location varchar(255),
	address varchar(255),
	zip varchar(255),	
	update_timestamp timestamp,
	PRIMARY KEY ( item_id )
);


--CREATE TABLE $data_desc (
--	data_desc_id int NOT NULL auto_increment,
--	table_name varchar(255) NOT NULL,
--	column_name varchar(255) NOT NULL,
--	column_desc varchar(255),		-- DESCRIPTION OF THIS FIELD FOR INPUT/EDIT FORMS
--	enum_id int DEFAULT NULL,		-- TOGGLES THIS COLUMN AS AN ENUMERATION
--	data_desc_date datetime NOT NULL,
--	PRIMARY KEY  (data_desc_id)
--);
