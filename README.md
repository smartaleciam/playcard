# Playcard - A RFID Card Transaction System

##### Currently Developing a new type of system due to

<img src="http://www.smartaleclights.com.au/programming/RFID%20-%20Main%20Brain%20-%20Scanner%20module%20-%20Wiring%20of%20Prototype.jpg" align="left" height="100" width="100">

1. Loads of wires (forming the working of the Rasp pi system)
2. Big unit an lots of bulky cables (network,hdmi,power,usb) 
3. Needing Rasp pi with rfid scanner close to public (theft of rasp pi would loose everything)
4. 

#### Result, use the built in Bluetooth for modules. (Rasp pi 3+ & 4 models)

Some of the different bluetooth module's could be,
- Rfid_Scanner (Scan's Rfid Card, Sits next to monitor),
- Till (bluetooth module to trigger till),
- Card_Dispencer (Card Storage Dispencer & Rfid scanner in one),
- LED Sign control (general messages etc)
- Mp3 Player Anouncement (Advertising Messages or Fire Alerts etc)

Now able to leave the rasp pi in a secure location (within bluetooth distance)

- Access to the Webpage is via https://playcard an it's LAN IP is setup on 192.168.10.1,
- The System also creates its own DHCP LAN network for RFID Wifi Device's to connect to.
- Access to the Internet is enabled via the Rasp Pi Onboard Wifi to connect to any wifi hotspots.
- (This enables Online Updates an Backup's)

### Machine Rfid Scanner System

<img src="http://www.smartaleclights.com.au/programming/2020-05-27%2000.29.44.jpg" align="left" height="100" width="100">

- Consists of a Rfid scanner a Oled Screen and a Pixel Ring Indicator,
- (Can include distance sensor for Machine in-use or for Advertising)
- Replaces Exsisting Coin Mech OR Can be used to assist the coin mech in transactions
- OTA Updateable

### How it all works.. Pure Magic at the moment.. More Documentation to come
- Rfid scanner scans the card, sends the info via Wifi using MQTT.
- System checks MQTT data for correct MAC address an Card ID against database.
- System them says if the card has Credit or Not, an Informs the User.

### Extra's Bits
- Timed Card function (Countdowns from time of purchase)
- Booking System (Keeps track of Bookings)
- Membership Cards have photo ID attached in system (via Webcam Snapshot)
- % Discount System (after a member has spent X dollars in past)
- GST Calculation Switch (Include GST in price or not)

# How to install 
Download a copy of 'Rasbian lite' onto a SD card. `https://www.raspberrypi.org/software/`
```
wget https://raw.githubusercontent.com/smartaleciam/playcard/main/Install_PlayCard_Packages.sh
chmod -R 744 Install_PlayCard_Packages.sh
sudo ./Install_PlayCard_Packages.sh
```

### About Me
This is sort of a slow project due to the fact im learning many new things, while developing and faulting along the way.

# Rough Costs
- Each `Rfid Machine Scanner` comes in around $25 each per machine
- The `System Brain` is a Rasp Pi 3+ $70
- Each `Bluetooth System Brain module` would be around $20 depending on what it does
