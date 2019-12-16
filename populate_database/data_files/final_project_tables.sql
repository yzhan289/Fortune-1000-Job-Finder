DROP TABLE IF EXISTS Company;
CREATE TABLE Company (
rank            INTEGER,
name            VARCHAR(40) NOT NULL,
change_in_rank  INTEGER,
profit_mil      FLOAT,
profit_change   FLOAT,
num_employees   INTEGER,
ceo             VARCHAR(40),
sector          VARCHAR(22),
industry        VARCHAR(46),
hq_state        VARCHAR(21),
hq_city         VARCHAR(25),
latitude        FLOAT,
longitude       INTEGER,
PRIMARY KEY (name)
);

DROP TABLE IF EXISTS CityInfo;
CREATE TABLE CityInfo (
state_name              VARCHAR(21) NOT NULL,
city_name               VARCHAR(50) NOT NULL,
city_population         INTEGER,
num_murders             INTEGER,
num_rapes               INTEGER,
num_robbery             INTEGER,
num_assaults            INTEGER,
num_burglaries          INTEGER,
num_larcenies           INTEGER,
num_motor_thefts        INTEGER,
num_arsons              INTEGER,
PRIMARY KEY (state_name, city_name)
);

DROP TABLE IF EXISTS StateInfo;
CREATE TABLE StateInfo (
state_name          VARCHAR(21) NOT NULL,
state_code          VARCHAR(2) NOT NULL,
dollar_parity       FLOAT,
goods_parity        FLOAT,
rent_parity         FLOAT,
PRIMARY KEY (state_name)
);

DROP VIEW IF EXISTS CompactCrimeData;
CREATE VIEW CompactCrimeData AS
SELECT
	state_name,
	city_name,
	((num_murders + num_rapes + num_robbery + num_assaults) / city_population * 100000) AS violent_crimes_per_100000,
	((num_burglaries + num_larcenies + num_motor_thefts + num_arsons) / city_population * 100000) AS property_crime_per_100000,
	((num_murders + num_rapes + num_robbery + num_assaults + num_burglaries + num_larcenies + num_motor_thefts + num_arsons) / city_population * 100000) AS crimes_per_100000
FROM CityInfo;
