# Playcard - A RFID Card Transaction System

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

- Access to the Webpage is via https://playcard an it's LAN IP is setup on 192.168.10.1,
- The System also creates its own DHCP LAN network for RFID Wifi Device's to connect to.
- Access to the Internet is enabled via the Rasp Pi Onboard Wifi to connect to any wifi hotspots.
- (This enables Online Updates an Backup's)

### Machine Rfid Scanner System
- Consists of a Rfid scanner a Oled Screen and a Pixel Ring Indicator, (can also include distance sensor)
- Replaces Exsisting Coin Mech OR Can be used to assist the coin mech in transactions

### How it all works.. Pure Magic at the moment..More Documentation to come
- Rfid scanner sences card, sends info via Wifi using MQTT.
- System checks Mqtt data for correct MAC address an Card ID against database.
- System them says if the card has Credit or Not, an Informs the User.

### Extra's Bits
- Timed Card function (Countdowns from time of purchase)
- Booking System (Keeps track of Bookings)
- MemberShip Cards have photo attached in system (via webcam)
- % Discount System (after a member has spent X dollars in past)
- GST Calculation Switch (Include GST in price or not)

# How to install 
- Download a copy of Rasbian onto a SD card. `https://www.raspberrypi.org/software/`
```
wget https://raw.githubusercontent.com/smartaleciam/playcard/main/Install_PlayCard_Packages.sh
chmod -R 744 Install_PlayCard_Packages.sh
sudo ./Install_PlayCard_Packages.sh
```

