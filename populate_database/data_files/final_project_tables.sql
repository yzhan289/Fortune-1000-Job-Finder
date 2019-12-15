DROP TABLE IF EXISTS Company;
CREATE TABLE Company (
name            VARCHAR(40),
rank            INTEGER,
change_in_rank  INTEGER,
profit_mil      FLOAT,
profit_change   FLOAT,
num_employees   INTEGER,
ceo             VARCHAR(40),
sector          VARCHAR(22),
industry        VARCHAR(46),
hq_state        VARCHAR(12),
hq_city         VARCHAR(25),
latitude        FLOAT,
longitude       INTEGER
);

DROP TABLE IF EXISTS CityInfo;
CREATE TABLE CityInfo (
state_name              VARCHAR(12),
city_name               VARCHAR(25),
city_population         INTEGER,
num_murders             INTEGER,
num_rapes               INTEGER,
num_robbery             INTEGER,
num_assaults            INTEGER,
num_burglaries          INTEGER,
num_larcenies           INTEGER,
num_motor_thefts        INTEGER,
num_arsons              INTEGER
);

DROP TABLE IF EXISTS StateInfo;
CREATE TABLE StateInfo (
state_name          VARCHAR(12),
state_code          VARCHAR(2),
dollar_parity       FLOAT,
goods_parity        FLOAT,
rent_parity         FLOAT
);
