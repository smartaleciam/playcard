# Playcard - Master Brain System

Developing a new type of system due to
1. Loads of wires from the Rasp pi
2. Needing Rasp pi with rfid scanner close to public (theft of rasp pi would loose everything)

Result, use the built in rasp pi 3+ Bluetooth.

Multi bluetooth module systems could be,
1. Rfid_Scanner (sits next to monitor),
2. Till (bluetooth module to trigger till),
3. Card_Dispencer (card storer / rfid scanner),
4. LED Sign control (general messages etc)
5. Mp3 Player Anouncement (Advertising messages or Fire Alerts etc)


Now able to leave the rasp pi in a secure location (within bluetooth distance)

Access to Rasp Pi Webpage is setup on 192.168.10.1 an is connected to the LAN DHCP network that it create's an manages,

Use's a Wifi Access Point to talk to all the Rfid scanners,
Rasp Pi can also have internet access (via its built in Wifi to connect to Internet Hotspot) (for online updates an online backups)

# Playcard - Machine Rfid System
rfid/oled/pixel ring scanner goes on Machine to replace coin mech or to assist the coin mech

#
How it all works.. Pure Magic at the moment..More Documentation to come

Still learning how github works, so github code is only for viewing an not the master scripts/files yet

Using Wifi Access Point's on that network to talk to all the Rfid scanners.

The Rasp Pi can also have Internet Access (via its built in Wifi to connect to a Internet Hotspot) (for online Updates an Backups)

# Playcard - Machine Rfid System
rfid + oled + pixel ring scanner, goes on a Machine to replace coin mech or to assist the coin mech

#
How it all works.. Pure Magic at the moment..More Documentation to come
#

# How to install on a rasp pi with rasbian
wget https://raw.githubusercontent.com/smartaleciam/playcard/main/Install_PlayCard_Packages.sh  for the latest version

chmod -R 744 Install_PlayCard_Packages.sh
sudo ./Install_PlayCard_Packages.sh
