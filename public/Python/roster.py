from datetime import datetime, timedelta
import csv
import mysql.connector

data = {}
people = {}
date_tmp = None
day_off = 0

mydb = mysql.connector.connect(
  host="localhost",
  user="root",
  password="",
  database="workcalendar"
)

mycursor = mydb.cursor()

def standardise_hour(hour) -> int:
    return hour if hour != 0 else 24

with open('C:\\Users\\Larry\\Desktop\\RosterBuddy\\NewskiesRoster\\public\\Python\\shifts.csv', 'r') as file:

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
            
            if any([shift == "BH", shift == "AL"]):
                if shift == "AL":
                    day_off = 1
                elif shift == "BH":
                    day_off = 2
                
                #print(f"{name}: {shift}")
                shift_counter += 1
                continue
            else:
                start_time,end_time = shift.split("-")
                print(f"{name} is starting work at {start_time} and finishing at {end_time}")

                
                shift_start = date + " " + start_time
                shift_end = date + " " + end_time

                
                sql = "INSERT INTO rosters (user_id, day_off,shift_start,shift_end) VALUES (%s,%s,%s,%s)"
                val = (name, 0,shift_start,shift_end)


            shift_counter += 1
            mycursor.execute(sql, val)
            mydb.commit()
            print(mycursor.rowcount, "record inserted.")

        date_tmp = date