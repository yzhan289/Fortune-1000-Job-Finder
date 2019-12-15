#!/usr/bin/env python3

import mysql.connector
import csv
import argparse

def insert_csv(cursor, table_name, num_columns, csv_file_name):
    """Inserts csv values into a table"""

    # get rows from csv file
    with open(csv_file_name, 'r') as csv_fd:
        csv_rows = csv.reader(csv_fd);

        # execute fills in %s with values, need the correct number of %s's
        values_placeholder = '%s'
        for i in range(num_columns - 1):
            values_placeholder += ', %s'

        base_command = 'INSERT INTO {0} VALUES ({1});'.format(
            table_name,
            values_placeholder)

        # inserts each row into table
        for row in csv_rows:
            cursor.execute(base_command, row)


def setup_tables(cursor):
    """Populates database using the final_project_tables.sql file."""

    # gets queries from file
    with open('data_files/final_project_tables.sql', 'r') as table_setup_fd:
        table_setup_queries = table_setup_fd.read().split(';')

    # runs each query
    for query in table_setup_queries:
        if not query.isspace():
            try:
                cursor.execute(query)
            except mysql.connector.Error:
                print('INFO: During table creation, query skipped: ' + query)


def getCredentials(filename):
    """Gets credentials from file.

    Credentials file should be formatted
        <username>
        <password>
        <host>
        <database>

    Example file:
        19_jsmith10
        asdfghjkl
        dbase.cs.jhu.edu
        cs415_fall_19_kkwon14
    """

    with open(filename , 'r') as f:
        return f.read().splitlines()

def main():
    parser = argparse.ArgumentParser(description = 'Create tables')

    help_message = 'credentials file name. \
            format: username\\n password\\n host\\n database'
    parser.add_argument('credentials_filename', help=help_message)

    args = parser.parse_args()

    creds = getCredentials(args.credentials_filename)
    cnx = mysql.connector.connect(user=creds[0],
                                  password=creds[1],
                                  host=creds[2],
                                  database=creds[3])

    cursor = cnx.cursor()

    setup_tables(cursor)
    insert_csv(cursor, 'Company', 13, 'data_files/company_data.csv')
    insert_csv(cursor, 'CityInfo', 11, 'data_files/city_data.csv')
    insert_csv(cursor, 'StateInfo', 5, 'data_files/state_data.csv')

    cnx.commit()
    cursor.close()
    cnx.close()


if __name__ == "__main__":
    main()
