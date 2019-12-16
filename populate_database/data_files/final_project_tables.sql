DROP TABLE IF EXISTS Company;
CREATE TABLE Company (                  -- Sample data
rank            INTEGER,                -- 1
name            VARCHAR(40) NOT NULL,   -- Walmart
previous_rank   INTEGER,                -- 1
profit_mil      FLOAT,                  -- 9862
profit_change   FLOAT,                  -- -27.7
num_employees   INTEGER,                -- 2300000
ceo             VARCHAR(40),            -- C. Douglas McMillon
sector          VARCHAR(22),            -- Retailing
industry        VARCHAR(46),            -- General Merchandisers
hq_city         VARCHAR(50),            -- Bentonville
hq_state_code   VARCHAR(2),             -- AR
latitude        FLOAT,                  -- 36.3729
longitude       FLOAT,                  -- -94.2088
PRIMARY KEY (name)
);

DROP TABLE IF EXISTS CityInfo;
CREATE TABLE CityInfo (                     -- Sample data
state_name          VARCHAR(21) NOT NULL,   -- Alabama
city_name           VARCHAR(50) NOT NULL,   -- Abbeville
city_population     INTEGER,                -- 2551
num_murders         INTEGER,                -- 0
num_rapes           INTEGER,                -- 2
num_robbery         INTEGER,                -- 0
num_assaults        INTEGER,                -- 16
num_burglaries      INTEGER,                -- 14
num_larcenies       INTEGER,                -- 33
num_motor_thefts    INTEGER,                -- 2
num_arsons          INTEGER,                -- 0
PRIMARY KEY (state_name, city_name)
);

DROP TABLE IF EXISTS StateInfo;
CREATE TABLE StateInfo (                -- Sample data
state_name      VARCHAR(21) NOT NULL,   -- Alabama
state_code      VARCHAR(2) NOT NULL,    -- AL
dollar_parity   FLOAT,                  -- 91.6
goods_parity    FLOAT,                  -- 96.5
rent_parity     FLOAT,                  -- 63.1
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
