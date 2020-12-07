#!/bin/sh
# PlayCard Install Packages Script

# Install Packages
PACKAGES="apache2 php mariadb-server php-mysql phpmyadmin bluetooth pi-bluetooth bluez blueman libbluetooth-dev isc-dhcp-server build-essential tk-dev libncurses5-dev libncursesw5-dev libreadline6-dev libdb5.3-dev libgdbm-dev libsqlite3-dev libssl-dev libc6-dev libbz2-dev libexpat1-dev liblzma-dev zlib1g-dev libffi-dev tar wget vim mc python3 python3-dev python3-setuptools-git python3-mysql.connector python3-pip python3-serial"

apt update
apt upgrade -y
apt install $PACKAGES -y
pip3 install pyserial
mysql_secure_installation
phpenmod mysqli
service apache2 restart

# ======== Get and Install Latest WedPage Code ===========

wget https://github.com/smartaleciam/playcard/archive/main.zip
unzip main.zip
rm main.zip
cd playcard-main

rsync -avx html /var/www/
#ls -lh /var/www/
chown -R pi:www-data /var/www/html/
chmod -R 770 /var/www/html/
#ls -lh /var/www/

# ==================Setup Chrome an Kiosk Mode==================================

apt install --no-install-recommends xserver-xorg x11-xserver-utils xinit openbox chromium-browser -y
mv autostart /etc/X11/openbox/autostart

# ======== Setup Install Database Code ===========
clear
echo "Do you Wish to Install the \"PlayCard\" Default Database Y/N"
read answer
case $answer in
    Y | YES | y | yes | Yes)
        echo "Install Database Created"
        mysql -u root -e "create database playcard"
        mysql -u root -e "create user pi@localhost identified by 'smartalec'"
        mysql -u root -e "GRANT ALL PRIVILEGES ON playcard.* TO pi@localhost IDENTIFIED BY 'smartalec'"
        mysql -u root -p --execute="playcard < playcard.sql; \q"
        mysql -u root -e "FLUSH PRIVILEGES"
    ;;
    N | NO | n | no | No)
        echo "Database Not Setup or Installed"
        ;;
    *)
esac

break

# =================Get and Install Python=================
#wget https://www.python.org/ftp/python/3.8.0/Python-3.8.0.tgz
#tar zxf Python-3.8.0.tgz
#cd Python-3.8.0
#./configure --enable-optimizations
#make -j 4
#make altinstall
python3 -V
#sudo rm -rf Python-3.8.0.tgz
#sudo rm -rf Python-3.8.0

# ==============change /boot settings=====================
CONFIG="/boot/config.txt"

# if a line containing start_x exists
if grep -Fq "start_x" $CONFIG
then
#        echo "start_x exists"
        sed -i "s/start_x=0/start_x=1/" $CONFIG
else
        echo "start_x now added"
        echo "start_x=1" >> $CONFIG
fi

# if a line containing gpu_mem exists
if grep -Fq "gpu_mem" $CONFIG
then
#        echo "gpu_mem exists"
        sed -i "/gpu_mem/c\gpu_mem=128" $CONFIG
else
        echo "gpu_mem now added"
        echo "gpu_mem=128" >> $CONFIG
fi


# if a line containing dtoverlay=disable-bt exists
if grep -Fq "dtoverlay=disable-bt" $CONFIG
then
        echo "dtoverlay=disable-bt exists now changed to dtoverlay=miniuart-bt"
        sed -i "/dtoverlay=disable-bt/c\dtoverlay=miniuart-bt" $CONFIG
else

    if grep -Fq "dtoverlay=miniuart-bt" $CONFIG
    then
	echo ""
    else
        echo "dtoverlay=miniuart-bt now added"
        echo "dtoverlay=miniuart-bt" >> $CONFIG
    fi
fi

# ========================================================
CONFIG="/boot/cmdline.txt"
# if a line containing ipv6.disable exists
        if grep -Fq "ipv6.disable" $CONFIG
        then
            echo "ipv6.disabled"
            sed -i "s/ipv6.disable=0/ipv6.disable=1/" $CONFIG
        else
            echo "ipv6.disable not found"
            echo "ipv6.disable=1" >> $CONFIG
        fi

# ========================================================

echo "Do you Wish to Setup the \"WiFi\" For Backup Internet Y/N"
read answ
case $answ in
    Y | YES | y | yes | Yes)
        echo "Time to setup the Wifi, (for internet backup)"
        read -p 'WiFi SSID Name: ' WiFiSSID
        read -p 'WiFi Password: ' WiFiPsk

	WifiCONFIG="/etc/wpa_supplicant/wpa_supplicant.conf"
# if a line containing country exists, lets change to AU
        if grep -Fq "country" $WifiCONFIG
        then
            sed -i "/country/c\country=AU" $WifiCONFIG
        else
            echo "country=AU" >> $WifiCONFIG
        fi

        if grep -Fq "network" $WifiCONFIG
        then
            sed -i "/network/c\network={ ssid=\"$WiFiSSID\" psk=\"$WiFiPsk\" scan_ssid=1 priority=1 }" $WifiCONFIG
	else
            echo "network={ ssid=\"$WiFiSSID\" psk=\"$WiFiPsk\" scan_ssid=1 priority=1 }" >> $WifiCONFIG
	fi
    ;;
    N | NO | n | no | No)
        echo "Skipped Wifi Setup"
        ;;
    *)
esac

# ========================================================
DhcpCONFIG="/etc/dhcp/dhcpd.conf"
# if a line authoritative; country exists
        if grep -Fq "authoritative;" $DhcpCONFIG
        then
#            echo "authoritative; exists, Setting to authoritative;"
            sed -i "/authoritative;/c\authoritative;" $DhcpCONFIG
        else
#            echo "#authoritative; not found, Setting to authoritative;"
            echo "authoritative;" >> $DhcpCONFIG
        fi

        if grep -Fq "subnet 192" $DhcpCONFIG
        then
	    echo ""
	else
            echo "subnet 192.168.10.0 netmask 255.255.255.0 {
                    range 192.168.10.10 192.168.10.254;
                    option routers 192.168.10.1;
                    interface eth0;
                    }" >> $DhcpCONFIG
	fi

# ===================Not used==============================
#NetworkCONFIG="/etc/network/interfaces.d"

#        if grep -Fq "hostname" $DhcpCONFIG
#        then
#            echo "hostname exists, Setting to smartlink"
#            sed -i "/hostname/c\smartlink" $DhcpCONFIG
#        fi

# ================Network Interfaces Setup=================
    if [ ! -f "/etc/network/interfaces.d/wlan0" ]
    then
	touch /etc/network/interfaces.d/wlan0
        echo "allow-hotplug wlan0
		iface wlan0 inet dhcp
                wpa-conf /etc/wpa_supplicant/wpa_supplicant.conf
                " >> /etc/network/interfaces.d/wlan0
    fi
    if [ ! -f "/etc/network/interfaces.d/eth0" ]
    then
	touch /etc/network/interfaces.d/eth0
        echo "auto eth0
		iface eth0 inet static
                address 192.168.10.1
                netmask 255.255.255.0
                gateway 192.168.10.1
                " >> /etc/network/interfaces.d/eth0
    fi
# =============hosts & hostname file=====================

hostCONFIG="/etc/hosts"
# if a line containing bluetoothd exists
    if grep -Fq "127.0.1.1" $hostCONFIG
    then
            echo "host exists"
 	    sed -i '/127.0.1.1/d'
	    echo "127.0.1.1		Playcard" >> $hostCONFIG
  else
            echo "PlayCard host added"
            echo "127.0.1.1		Playcard" >> $hostCONFIG
    fi

hostsCONFIG="/etc/hostname"
# Blast contents an replace
> $hostsCONFIG
    echo "playcard" >> $hostsCONFIG

# =============MQTT Listening Script=====================
localCONFIG="/etc/rc.local"

    if grep -Fq "python3 /var" $DhcpCONFIG
        then
            echo "mqtt_listen Script exists"
	else
#        echo "python3 /var/www/html/scripts/mqtt_Listen.py &" >> $localCONFIG
	 echo "Mqtt Listening Script Installed"
    fi

# =============dbus-org.bluez.service=====================
blueCONFIG="/etc/systemd/system/dbus-org.bluez.service"
# if a line containing bluetoothd exists
    if grep -Fq "bluetoothd" $blueCONFIG
    then
            echo "bluetoothd exists"
    else
            echo "bluetoothd added"
            echo "ExecStart=/usr/lib/bluetooth/bluetoothd -C" >> $blueCONFIG
    fi
# if a line containing sdptool exists
    if grep -Fq "sdptool" $blueCONFIG
    then
            echo "sdptool exists"
    else
            echo "sdptool added"
            echo "ExecStartPost=/usr/bin/sdptool add SP" >> $blueCONFIG
    fi

systemctl daemon-reload
systemctl enable --now bluetooth

# =============modules loaded=====================
    moduleCONFIG="/etc/modules-load.d/modules.conf"
# if a line containing rfcomm exists
    if grep -Fq "rfcomm" $moduleCONFIG
    then
            echo "rfcomm exists"
    else
            echo "rfcomm added"
            echo "rfcomm" >> $moduleCONFIG
    fi

# =========================================================
cd /home/pi
wget https://github.com/pybluez/pybluez/archive/master.tar.gz
tar zxf master.tar.gz
cd pybluez-master
python3 setup.py install

# =======find Bluetooth Mac Address's ========

#   rfcomm bind rfcomm0 00:20:10:08:39:EA  #=====bluetooth Card_Dispencer 
#   rfcomm bind rfcomm1 <device's MAC>  #=====bluetooth Till_Draw
#   rfcomm bind rfcomm2 <device's MAC>  #=====bluetooth Monitor_Scanner 

# ==============Blue Tooth Discovery - Connection Procedure ===============
#sudo bluetoothctl 

#[bluetooth]# agent on
#[bluetooth]# scan on

#  Discovery started
#  [NEW] Device 00:20:10:08:39:EA 

#[bluetooth]# scan off
#  [CHG] Controller B00:20:10:08:39:EA Discovering: no
#  Discovery stopped

#[bluetooth]# pair 00:20:10:08:39:EA
#  Attempting to pair with 00:20:10:08:39:EA
#  [CHG] Device 00:20:10:08:39:EA Connected: yes
#  Request PIN code
#  [agent] Enter PIN code: 7418
#  [CHG] Device 00:20:10:08:39:EA UUIDs: 00001101-0000-1000-8000-00805f9b34fb
#  [CHG] Device 00:20:10:08:39:EA ServicesResolved: yes
#  [CHG] Device 00:20:10:08:39:EA Paired: yes
#  Pairing successful
#  [CHG] Device 00:20:10:08:39:EA ServicesResolved: no
#  [CHG] Device 00:20:10:08:39:EA Connected: no

#[bluetooth]# trust 00:20:10:08:39:EA
#  [CHG] Device 00:20:10:08:39:EA Trusted: yes
#  Changing 00:20:10:08:39:EA trust succeeded

#[bluetooth]# exit

# =========================================================
rm Install_PlayCard_Packages.sh

echo "Install Finished"
echo "To Access vist http://playcard"
