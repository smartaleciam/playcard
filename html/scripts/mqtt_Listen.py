#!/usr/bin/env python3
# loaded from file location /etc/rc.local

import paho.mqtt.client as mqtt
import logging, time, json, datetime
import mysql.connector
import time
#logging.basicConfig(level=logging.DEBUG)

# MQTT Settings
MQTT_Broker = "192.168.10.1"
MQTT_Port = 1883
Keep_Alive_Interval = 75
MQTT_Topic = "Machine"
MQTT_Username = "smartlink"
MQTT_Password = "smartalec"

# Recieved Mqtt Messgae
def on_message(mosq, obj, msg):
    msg = msg.payload.decode("utf-8")
    m_in = json.loads(msg)
    if m_in["Opp"] !="":
	    Opp = m_in["Opp"]
	    db = mysql.connector.connect( host="localhost", user="pi", passwd="smartalec", database="playcard" )
	    err = '0'

    if Opp =="Start":
	    if m_in["mac"] != "":
		    cursor = db.cursor()
		    cursor.execute("SELECT * FROM config")
		    result1 = cursor.fetchone()
		    lb=str(result1[15])
		    cursor.execute("SELECT * FROM machine WHERE machine_mac='"+m_in["mac"]+"'")
		    result = cursor.fetchone()
		    if result == None:
			    print("Machine not found in Database")  # get credit value
			    message='{"Opp":"Error","mac":"'+m_in["mac"]+'","name":"No Machine","cost":"0"}'
			    mqttc.publish(m_in["mac"],message)
			    message='{"Opp":"Wheel","Cw1":"'+result1[11]+'","Cw2":"'+result1[12]+'","Cw3":"'+result1[13]+'","Cw4":"'+result1[14]+'","LB":"'+lb+'"}'
			    mqttc.publish(m_in["mac"],message)
		    while result is not None:
			    message='{"Opp":"Start","mac":"'+result[1]+'","name":"'+result[2]+'","cost":"'+str(result[3])+'"}'
			    mqttc.publish(m_in["mac"],message)
			    message='{"Opp":"Wheel","Cw1":"'+result1[11]+'","Cw2":"'+result1[12]+'","Cw3":"'+result1[13]+'","Cw4":"'+result1[14]+'","LB":"'+lb+'"}'
			    mqttc.publish(m_in["mac"],message)
			    result = cursor.fetchone()

    if Opp =="Data":
	    if m_in["uid"] !="0":
		    cursor = db.cursor()
		    cursor.execute("SELECT * FROM machine WHERE machine_mac='"+m_in["mac"]+"'")
		    result1 = cursor.fetchone()
		    cos=int(result1[3])  # get machine cost
		    cursor.execute("SELECT * FROM users WHERE rfid_uid='"+m_in["uid"]+"'")
		    result = cursor.fetchone()
#		    print(result)
		    if result == None:
			    cursor.execute("SELECT * FROM tags WHERE rfid_uid='"+m_in["uid"]+"'")
			    result = cursor.fetchone()
			    print(result)
			    if result == None:
				    if err=='0':
					    message1='{"Opp":"Error","mac":"'+m_in["mac"]+'","name":"No User","cost":"0"}'
					    mqttc.publish(m_in["mac"],message1)  #send the Mqtt msg
					    print("Error cant find uid- "+m_in["uid"])
					    err='1'
		    while result is not None:
			    nam=result[1]  # get users name
			    created=result[11]  # get date/time created
			    TimeGot=result[10]  # get Time Remaining - if group or timed person
			    cred=str(result[8])  # get users credit
			    cre=int(cred)  # turn into integer
			    Tcred = cre-cos  # subtract total
			    TimeLeft = datetime.datetime.now() - result[11]
			    message1='{"Opp":"Data","name":"'+nam+'","price":"'+str(Tcred)+'","time":"'+str(TimeGot-TimeLeft.seconds)+'"}'
			    mqttc.publish(m_in["mac"],message1)  #send the Mqtt msg
			    cursor.execute("UPDATE users SET credit='"+str(Tcred)+"' WHERE rfid_uid='"+m_in["uid"]+"'")  # remove the credit cost
			    db.commit()
			    result = cursor.fetchone()

    if Opp =="Error":
	    if m_in["mac"] != "":
		    cursor = db.cursor()
		    cursor.execute("SELECT * FROM config")
		    result1 = cursor.fetchone()
		    lb=str(result1[15])
		    cursor.execute("SELECT * FROM machine WHERE machine_mac='"+m_in["mac"]+"'")
		    result = cursor.fetchone()
		    if result == None:
			    print("Error from Unknown Mac not found in Database")  # get credit value
		    while result is not None:
			    message='{"Time" : "'+str(time.asctime( time.localtime(time.time()) ))+'", "Machine" : "'+result[2]+'", "Error Code" : "'+m_in["type"]+'", "Signal" : "'+m_in["ssi"]+'"}\r\n'
#			    print (message)
			    error_file = open('/var/www/html/logs/error.log','a')
			    error_file.write(message)
			    error_file.close()
			    result = cursor.fetchone()

def on_subscribe(mosq, obj, mid, granted_qos):
    print("Listening...")
    pass

mqttc = mqtt.Client()

mqttc.on_message = on_message

#mqttc.on_connect = on_connect

mqttc.on_subscribe = on_subscribe

mqttc.username_pw_set(MQTT_Username,MQTT_Password)  # Mqtt UserName/Password

# Enable Logging
logger = logging.getLogger(__name__)
mqttc.enable_logger(logger)

# Connect
mqttc.connect(MQTT_Broker, int(MQTT_Port), int(Keep_Alive_Interval))
mqttc.subscribe(MQTT_Topic)

# Continue the network loop
mqttc.loop_forever()
