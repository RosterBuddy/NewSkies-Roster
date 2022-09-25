from datetime import datetime, timedelta
import csv
import mysql.connector
import json

data = {}
people = {}
date_tmp = None
now = datetime.now()
formatted_date = now.strftime('%Y-%m-%d %H:%M:%S')



# with open('J:\\Development\\RosterBuddy\\NewskiesRoster\\public\\Python\\config_live.json') as f:
#     d = json.load(f)
mydb = mysql.connector.connect(
    host="localhost",
    user="virtu120_work_calendar",
    password="Aer&w+kEOBKC",
    database="virtu120_workcalendar",
)



mycursor = mydb.cursor()
mycursor1 = mydb.cursor()

def standardise_hour(hour) -> int:
    return hour if hour != 0 else 24

with open('J:\\Development\\RosterBuddy\\NewskiesRoster\\public\\Python\\nskroster.csv', 'r') as file:

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
            day_off = None
            desc = None
            shift_map = {'AL': { 'day_off': 1, 'desc': 'A/L' }, 'BH': { 'day_off': 2, 'desc': 'B/H' }, 'X': { 'day_off': 0, 'desc': 'off' } }

            
            if any([shift == "X",shift == "BH", shift == "AL"]):
                day_off = shift_map[shift]['day_off']
                desc = shift_map[shift]['desc']
                
                odd_day = date + " 00:00:00"

                sql = "INSERT INTO rosters (user_id, description, day_off,shift_start,shift_end, last_edited, created_at, updated_at) VALUES (%s,%s,%s,%s,%s,%s,%s,%s)"
                val = (name,desc,day_off,odd_day,odd_day,formatted_date,formatted_date,formatted_date)
                
                
                #print(f"{name}: {shift}")
            else:
                start_time,end_time = shift.split("-")
                #print(f"{name} is starting work at {start_time} and finishing at {end_time}")
                if end_time == "24:00":
                    shift_end = date + " 23:59:00"
                else: 
                    shift_end = date + " " + end_time

                shift_start = date + " " + start_time
                

                
                sql = "INSERT INTO rosters (user_id, day_off,shift_start,shift_end,last_edited, created_at, updated_at) VALUES (%s,%s,%s,%s,%s,%s,%s)"
                val = (name, 0,shift_start,shift_end,formatted_date,formatted_date,formatted_date)


            shift_counter += 1
            
            mycursor.execute(sql, val)

            mydb.commit()
            print(mycursor.rowcount, "record inserted.")

        date_tmp = date