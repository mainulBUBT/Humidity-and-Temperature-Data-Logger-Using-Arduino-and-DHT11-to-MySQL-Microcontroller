import serial
import time
import schedule
import mysql.connector


def main_func():
    arduino = serial.Serial('com3', 9600)
    print('Established serial connection to Arduino')
    arduino_data = arduino.readline()

    decoded_values = str(arduino_data[0:len(arduino_data)].decode("utf-8"))
    list_values = decoded_values.split('x')

    for item in list_values:
        list_in_floats.append(float(item))

    print(f'Collected readings from Arduino: {list_in_floats}')

    mydb = mysql.connector.connect(
        host="localhost",
        user="root",
        password="",
        database="pyserial"
    )

    mycursor = mydb.cursor()

    sql = "INSERT INTO sensor (humidity,temperature) VALUES (%s, %s)"
    val = (list_in_floats[1], list_in_floats[0])
    mycursor.execute(sql, val)

    mydb.commit()

    print(mycursor.rowcount, "record inserted.")

    arduino_data = 0
    list_in_floats.clear()
    list_values.clear()
    arduino.close()
    print('Connection closed')
    print('<----------------------------->')


# ----------------------------------------Main Code------------------------------------
# Declare variables to be used
list_values = []
list_in_floats = []

print('Program started')

# Setting up the Arduino
schedule.every(10).seconds.do(main_func)

while True:
    schedule.run_pending()
    time.sleep(1)
