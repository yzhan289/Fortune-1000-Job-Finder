#!/usr/bin/env python3
"""Converts information gathered online to csv files to insert into tables.

Takes csv files from sources gathered online and converts them into the
correct format we need for our database tables.
Some preprocessing was done manually (deleting headers and footnotes, etc.)
"""

import csv
import re

def format_numeric_element(element):
    """Formats an numeric element
    
    Replaces an empty element with NULL.
    Removes symbols from numbers (like commas, dollar signs, etc.).
    """

    if element is '':
        # Replace empty element with NULL.
        return 'NULL'
    else:
        # Remove symbols $%,()
        return re.sub('[$%,()]', '', element)


def format_company_data():
    """Creates a csv file in the correct format from Fortune 1000 data.

    Attributes in original csv from kaggle are:
        rank, title, previous rank, revenues($M), revenues change(%),
        profits($M), profit change(%), assets, mkt value, employees, CEO,
        CEO title, sector, industry, years on list, city, state, latitude,
        longitude

    Attributes in new csv:
        rank, title, previous rank, profits($M), profit change(%), employees, 
        CEO, sector, industry, city, state, latitude, longitude
    """
    
    with open('original_data/fortune1000.csv', 'r') as csv_in, \
            open('company_data.csv', 'w+') as csv_out:
        reader = csv.reader(csv_in)
        writer = csv.writer(csv_out)

        # The indicies that we care about.
        indicies = [0, 1, 2, 5, 6, 9, 10, 12, 13, 15, 16, 17, 18]
        # The numeric indicies that we care about.
        numeric_indicies = [0, 2, 5, 6, 9, 17, 18]
        # Format those indicies.
        for row in reader:
            for i in numeric_indicies:
                row[i] = format_numeric_element(row[i])
            
            writer.writerow([row[index] for index in indicies])


def format_city_data():
    """Creates a csv file in the correct format from the FBI crime data.

    Attributes in original csv are:
        State Name, City, Population, Violent Crime, Murder/Nonnegligent
        Manslaughter, Rape, Robbery, Agg:q
        ravated Assault, Property Crime, Burglary,
        Larceny-theft, Motor Vehicle Theft, Arson
    However, State Name is only included for the first city of the state, some
    elements are empty, numbers have comma separation, and the Violent Crime
    and Property Crime attributes are redundant. Violent crime is
    Murder/Nonnegligent Manslaughter + Rape + Robbery + Aggravated Assault.
    Property Crime = Burglary + Larceny-theft + Motor Vehicle Theft + Arson.
    Thus, removed those two attributes.

    Order of the new csv is:
        State Name, City, Population, Murder/Nonnegligent Manslaughter, Rape,
        Robbery, Aggravated Assault, Burglary, Larceny-theft, Motor Vehicle
        Theft, Arson
    with NULLs replacing blank elements.
    """

    with open('original_data/crime_data_excel.csv', 'r') as csv_in, \
            open('city_data.csv', 'w+') as csv_out:
        reader = csv.reader(csv_in)
        writer = csv.writer(csv_out)

        for row in reader:
            # In the original, only the first city of a state has state name.
            if row[0] is not '':
                state = row[0].title() # Change from all caps to normal caps.
            row[0] = state

            # Remove Violent Crime and Property Crime
            del(row[8])
            del(row[3])
            # Format nums.
            for i in range(2, len(row)):
                row[i] = format_numeric_element(row[i])

            writer.writerow(row)


def format_state_data():
    """Creates a csv file in the correct format using the BEA parity data.

    Dollar parities and price parities are in separate tables in the BEA's
    spreadsheet. Combine then and fix some formatting (such as comma-separated
    numbers).

    The original dollar parity table is of format:
        State, 2016 Personal Income (millions of dollars), 2017 Personal Income
        (millions of dollars), Personal Income % Change, 2016 Real Personal
        Income (millions of dollars), 2017 Real Personal Income (millions of
        dollars), Real Personal Income % Change, 2016 Price Deflator, 2017 Price
        Deflator, Price Deflator % Change
    We do not care about most of this information - only 2017 price deflator.

    The original price parity table is of format:
        State, All Items, Goods, Rents, Other
    We care about goods and rents price parity.

    New csv format:
        State Name, State Code, Dollar Parity, Goods Parity, Rents Parity
    """

    with open('original_data/dollar_parity.csv', 'r') as dollar_parity_csv, \
           open('original_data/price_parity.csv', 'r') as price_parity_csv, \
           open('original_data/state_to_code.csv', 'r') as code_csv, \
           open('state_data.csv', 'w+') as csv_out:
        dollar_reader = csv.reader(dollar_parity_csv)
        price_reader = csv.reader(price_parity_csv)
        code_reader = csv.reader(code_csv)
        writer = csv.writer(csv_out)

        # Note that all csv's are in alphabetic order by state name.
        for code_row, dollar_row, price_row in zip(code_reader, dollar_reader,
                price_reader):
            writer.writerow([code_row[0], code_row[1], dollar_row[8],
                    price_row[2], price_row[3]])

def main():
    format_company_data()
    format_city_data()
    format_state_data()

if __name__ == '__main__':
    main()
