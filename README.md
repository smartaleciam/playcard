# Playcard - Is a RFID Card Transaction System

Currently Developing a new type of system due to
1. Loads of wires from the Rasp pi
2. Needing Rasp pi with rfid scanner close to public (theft of rasp pi would loose everything)

Result, use the built in rasp pi 3+ Bluetooth.

Multi bluetooth module systems could be,
- Rfid_Scanner (sits next to monitor),
- Till (bluetooth module to trigger till),
- Card_Dispencer (card storer / rfid scanner),
- LED Sign control (general messages etc)
- Mp3 Player Anouncement (Advertising messages or Fire Alerts etc)

Now able to leave the rasp pi in a secure location (within bluetooth distance)

Access to the Webpage is via https://playcard an it's LAN IP is setup on 192.168.10.1, The System also creates its own DHCP LAN network for RFID Wifi Device's.
Access to the Internet is enabled via the Rasp Pi Wifi to connect to a hotspot. (This enables Online Updates an Backup's)

Use's a Wifi Access Point to talk to all the Rfid scanners,
Rasp Pi can also have internet access (via its built in Wifi to connect to Internet Hotspot) (for online updates an online backups)

# Playcard - Machine Rfid System
rfid/oled/pixel ring scanner goes on Machine to replace coin mech or to assist the coin mech

#
How it all works.. Pure Magic at the moment..More Documentation to come

Using Wifi Access Point's on that network to talk to all the Rfid scanners.

The Rasp Pi can also have Internet Access (via its built in Wifi to connect to a Internet Hotspot) (for online Updates an Backups)

# How to install on a rasp pi with rasbian


```
wget https://raw.githubusercontent.com/smartaleciam/playcard/main/Install_PlayCard_Packages.sh
chmod -R 744 Install_PlayCard_Packages.sh
sudo ./Install_PlayCard_Packages.sh
```

