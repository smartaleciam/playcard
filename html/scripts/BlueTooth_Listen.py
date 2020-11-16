import time, json, logging
import mysql.connector
import serial

ser = serial.Serial(
    port='/dev/rfcomm0',
    baudrate=115200,
    parity=serial.PARITY_ODD,
    stopbits=serial.STOPBITS_TWO,
    bytesize=serial.SEVENBITS
)

ser.isOpen()

print('Waiting for Bluetooth Talk.')

while 1 :
#    user_input = input("You message >> ")
#    if user_input == 'exit':
#        ser.close()
#        exit()
#    else:
#        user_input = user_input + '\r'
#        ser.write(user_input.encode())
        recv = ''
        tic = time.time()
#        while time.time() - tic < 15 and ser.inWaiting() == 0: 
#            time.sleep(1)
        if ser.inWaiting() > 0:
            recv = ser.readline()
        if recv != '':
            print("Event Time >> " + str(time.ctime(tic)))
            print("Event Info >> " + str(recv, 'utf-8'))
            msg = recv.decode("utf-8")
            m_in = json.loads(msg)

            if m_in["Opp"] !="":
                Opp = m_in["Opp"]
                db = mysql.connector.connect( host="localhost", user="pi", passwd="smartalec", database="playcard" )

            if Opp =="Close_BlueTooth":
                ser.close()
                exit()

            if Opp =="BlueTooth":
                cursor = db.cursor()
                cursor.execute("SELECT * FROM Tags WHERE rfid_uid='"+m_in["uid"]+"'")
                result = cursor.fetchone()
                if result == None:
                    print("Card \""+m_in["uid"]+"\" Not found in system")
                    ermsg='{"Msg":"Err", "Uid":"'+m_in["uid"]+'", "Error":"Card Not Found"}\r\n'
                    ser.write(ermsg.encode())
                    errmsg='{"Time" : "'+str(time.asctime( time.localtime(time.time()) ))+'", "Unit" : "'+m_in["Unit"]+'", "Uid" : "'+m_in["uid"]+'", "Error Type" : "Card Not Found"}\r\n'
                    error_file = open('/var/www/html/logs/bluetooth.log','a')
                    error_file.write(errmsg)
                    error_file.close()

                while result is not None:
                    print(result)
                    nam=result[1] # get users name
                    created=result[11] # get date/time created
                    TimeGot=result[10] # get Time Remaining - if group or timed person
                    cred=str(result[8]) # get users credit
                    cre=int(cred) # turn credit into integer
                    TimeLeft = datetime.datetime.now() - result[11]
                    print("User Name :"+nam)
                    print("Current Credit :"+str(cre))
                    print("Time Remaining :"+str(TimeGot-TimeLeft.seconds))
#                    errmsg='{"Time" : "'+str(time.asctime( time.localtime(time.time()) ))+'", "Unit" : "'+m_in["Unit"]+'", "Uid" : "'+m_in["uid"]+'", "Error Type" : "Card Not Found"}\r\n'
#                    error_file = open('/var/www/html/logs/bluetooth.log','a')
#                    error_file.write(errmsg)
#                    error_file.close()
