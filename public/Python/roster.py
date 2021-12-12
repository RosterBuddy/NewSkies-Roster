from datetime import datetime, timedelta
import csv

data = {}
people = {}
date_tmp = None

def standardise_hour(hour) -> int:
    return hour if hour != 0 else 24

with open('C:\\Users\\Tommy\\Desktop\\WorkCalendar\\public\\Python\\shifts.csv', 'r') as file:

  reader = csv.reader(file)
  counter = 0

  for row in reader:

    counter += 1

    if counter == 1:

        # store the names - shift the first one off the row as it starts with 'name'
        names = row[1:]

        name_counter = 0
        for name in names:

            people[name_counter] = name
            name_counter += 1
    else:

        # grab the shifts - shift the first one off the row as its the date, so store that

        date = row[0]
        shifts = row[1:]


        # match the index of the shift against the people indexes we stored above
        shift_counter = 0

        if date_tmp != date:
            print(f"\n===== {date} =====\n")

        for shift in shifts:

            name = people[shift_counter]

            if any([shift == "X", shift == "", shift == "AL"]):
                print(f"{name}: {shift}")
                shift_counter += 1
                #SQL
                continue
            else:
                start_time,end_time = shift.split("-")
                print(f"{name} is starting work at {start_time} and finishing at {end_time}")
                #SQL

            shift_counter += 1

        date_tmp = date