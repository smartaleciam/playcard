# Playcard - Master Brain System

Developing a new type of system due to
1. Loads of wires from the Rasp pi
2. Needing Rasp pi with rfid scanner close to public (theft of rasp pi would loose everything)

Result, use the built in rasp pi 3+ bluetooth.
Multi bluetooth module systems could be,
Rfid_Scanner (sits next to monitor),
Till (bluetooth module to trigger till),
Card_Dispencer (card storer / rfid scanner),
LED Sign control (general messages etc)

Now able to leave the rasp pi in a secure location (within bluetooth distance)

Access to Rasp Pi Webpage is setup on 192.168.10.1 an is connected to the LAN DHCP network that it create's an manages,
Use's a Wifi Access Point to talk to all the Rfid scanners,
Rasp Pi can also have internet access (via its built in Wifi to connect to Internet Hotspot) (for online updates an online backups)

# Playcard - Machine Rfid payment System
rfid/oled/pixel ring scanner goes on Machine to replace coin mech or to assist the coin mech


# How it all works.. Pure Magic at the moment..More Documentation to come