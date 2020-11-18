// ------------------------------------------- User Config Area -------------------------------------------------------
//           Wemo's D1 R1 - pin out                    |             Wemo's D1 Mini - should be, pin out
// --------------------------------------------------------------------------------------------------------------------
//  pin gpio3 D0 -                                     |  pin RXD 
//  pin gpio1 D1 -                                     |  pin TXD 
//  pin gpio16 D2 -      - { HC-SR04 } echo            |  pin D0   - buzzer pin (cheap mode)
//  pin gpio5  D3 - scl  - { pcf8574 } + {oled screen} |  pin D1
//  pin gpio4  D4 - sda  - { pcf8574 } + {oled screen} |  pin D2
//  pin gpio14 D5 - sck  (in use) {rfid}               |  pin D5
//  pin gpio12 D6 - miso (in use) {rfid}               |  pin D6
//  pin gpio13 D7 - mosi (in use) {rfid}               |  pin D7
//  pin gpio0  D8 -      - reset  {rfid}               |  pin D3
//  pin gpio2  D9 -      - Pixel Data                  |  pin D4   - relay pin (cheap mode)
// pin gpio15  D10 - ss   - sda {rfid}                 |  pin D8

// pin spi D11 - mosi - mosi {rfid}
// pin spi D12 - miso - miso {rfid}
// pin spi D13 - sck  - sck {rfid}
// pin gnd
// pin n/c
// pin D14 - sda  - {oled screen}
// pin D15 - scl  - {oled screen}
// --------------------------------------------------------------------------------------------------------------------
//                                           PCF8574 Pin settings
// pin 1 - Input - 
// pin 2 - Output - Relay trigger #1 - Apply Machine Credit - (1=off,0=on)
// pin 3 - Output - Relay trigger #2 -                      - (1=off,0=on)
// pin 4 - Output - { HC-SR04 } trigger
// pin 5 - 
// pin 6 - 
// pin 7 - 
// pin 8 - 
// --------------------------------------------------------------------------------------------------------------------
#define ARDUINO_Type  0            // (1 = Wemos D1 R1, 0 = Wemos D1 Mini)
#define DEBUG         0            // turns on/off serial output - (1=off,0=on)
#define Version       1.4          // controls the version numbering system ( Manual Update)
// --------------------------------------------------------------------------------------------------------------------
#include <Arduino.h>
#include <ArduinoJson.h>
#include <ESP8266WiFi.h>          // Enables the ESP8266 to connect to the local network (via WiFi)
#include <ESP8266HTTPClient.h>
#include <ESP8266httpUpdate.h>
#include <PubSubClient.h>         // Allows us to connect to, and publish to the MQTT broker
#include <SPI.h>
#include <MFRC522.h>              // RC522 RFID scanner
#include "SSD1306Wire.h"
#include "images.h"               // WiFi image + others
#include <IoAbstraction.h>        // IO extender board
#include <IoAbstractionWire.h>    // IO extender board
#include <Wire.h>
#define msgwait         150       // delay messages are left on screen + UltraSonic distance reading delay
#include <FastLED.h>              // led ring setup
#define NUM_LEDS 24               // 24 leds in ring
#define Buzzer_PIN D2                // relay pin in cheap version
#define RELAY_PIN D9                // relay pin in cheap version
#define PIXEL_PIN D9                // pixel data output pin
#define LED_TYPE    WS2811
#define COLOR_ORDER GRB
 CRGB leds[NUM_LEDS];


// ------------------------------------------- User Config Area -------------------------------------------------------
//#define BRIGHTNESS  50   // brightness of pixel leds
long BRIGHTNESS=50;   // brightness of pixel leds
long COLOUR1=CRGB::Black;   // Ring of Led Sweeping Colours
long COLOUR2=CRGB::Purple;   // Black, Yellow, Purple, Red, Green, Blue, White
long COLOUR3=CRGB::Black;
long COLOUR4=CRGB::Black;
const char* ssid = "Pretty Fly for a Wi-Fi";   // WiFi - Setting Username
const char* password = "smartalec";            // WiFi - Setting Password
#define WIFISSID "Pretty Fly for a Wi-Fi"
#define PASSWORD "smartalec"
// Make sure to update this for your own MQTT Broker!
const char* mqtt_server = "192.168.10.1";
const char* mqtt_topic = "Machine";
const char* mqtt_username = "smartlink";
const char* mqtt_password = "smartalec";
String sonic;  // Turn on ultrasonic distance, True=on, False=off
// --------------------------------------------------------------------------------------------------------------------

CRGBPalette16 currentPalette;
TBlendType    currentBlending;

int32_t RSSI;
int32_t h=0;
int32_t m=0;
int32_t s=0;

//MFRC522::MIFARE_Key key;

//if (ARDINO=="0") { // Wemos R1 D1 Mini 
//    MFRC522 rfid(D8, D3);  // Create MFRC522 instance
//    SSD1306Wire display(0x3c, D2, D1);
//    }; 

//if (ARDINO=="1") { // Wemos R1 D1
    MFRC522 rfid(D10, D8);  // Create MFRC522 instance
    SSD1306Wire display(0x3c, D4, D3);
    IoAbstractionRef ioExpander = ioFrom8574(0x38); // IO extender board
//};
// MQTT
const char* clientID = WiFi.macAddress().c_str();  //makes the clientID the esp mac address

// Initialise the WiFi and MQTT Client objects

WiFiClient WiFiClient;
PubSubClient client(mqtt_server, 1883, WiFiClient); // 1883 is the listener port for the Broker
String UPDATE = "0";
int tack = 0;
int tock = 0;
int Ecount, error=0, counter = 1;
String Sys_Error,Error,Error_Msg,ip,mac,ssi;
int randNumber,rndwait;
String StartSent="False";
String Opp,Rmac,Rname,RMname;
int Rcost,Rcredit,Rtime,lb;
String card_read="False";
String Cw1,Cw2,Cw3,Cw4;
long duration;
int distance;

void loading_screen(int tic) {
  display.drawXbm(34, 8, WiFi_Logo_width, WiFi_Logo_height, WiFi_Logo_bits);
  tock += tic;
  display.drawProgressBar(0, 52, 120, 8, tock);
  display.display();
}

void settings_screen( String ip, String mac, String ssi) {
    display.clear();
    display.setTextAlignment(TEXT_ALIGN_LEFT);
    display.setFont(ArialMT_Plain_10);
    display.drawString(0, 10, "IP:");    display.drawString(15, 10, ip);
    display.drawString(0, 20, "MAC:");    display.drawString(25, 20, mac);
    display.drawString(0, 30, "SSI:");    display.drawString(25, 30, ssi);
    display.display();
  delay(1000);
}

bool Connect() {
  // Connect to MQTT Server and subscribe to the topic
  if (client.connect(clientID, mqtt_username, mqtt_password)) {
      return true;  //connected
      error=0;
    } else {
      return false;  // trying to connect
  }
}

void setup() {
if (ARDUINO_Type==1) {
  FastLED.addLeds<WS2811, PIXEL_PIN, COLOR_ORDER>(leds, NUM_LEDS).setCorrection( TypicalLEDStrip );  FastLED.setBrightness(BRIGHTNESS);  FastLED.clear ();  FastLED.show();
  currentPalette = RainbowColors_p;  currentBlending = LINEARBLEND;
  Wire.begin();      // IO extender board
}
if (ARDUINO_Type==0) {    pinMode(RELAY_PIN, OUTPUT);    pinMode(Buzzer_PIN, OUTPUT);    digitalWrite(RELAY_PIN, HIGH);    digitalWrite(Buzzer_PIN, HIGH);  }
if (DEBUG==0) { Serial.begin(115200); };
  SPI.begin();      // Init SPI bus

  display.init();
  display.flipScreenVertically();
  display.setFont(ArialMT_Plain_10);
  display.clear();
  loading_screen(5);

  if (DEBUG==0) { Serial.println();  Serial.print("Connecting to ");  Serial.print(ssid); };

  // Connect to the WiFi
  WiFi.begin(ssid, password);
  // Wait until the connection has been confirmed before continuing
  while (WiFi.status() != WL_CONNECTED) {    delay(500);    loading_screen(10);  if (DEBUG==0) {  Serial.print("."); };  }

  // Debugging - Output the IP Address of the ESP8266
if (DEBUG==0) { Serial.println("WiFi connected");
   Serial.print("System Firmware: v");  Serial.println(Version); 
   Serial.print("IP address: ");  Serial.println(WiFi.localIP());
  Serial.print("MAC address: ");  Serial.println(WiFi.macAddress());
 };
  mac = WiFi.macAddress();
if (DEBUG==0) { Serial.print("Wifi Signal: ");  Serial.print(WiFi.RSSI());  Serial.println(" dBm");  };
  loading_screen(5);
 
  // Connect to MQTT Broker
  // setCallback sets the function to be called when a message is received.
  client.setCallback(ReceivedMessage);
  if (Connect()) {
    if (DEBUG==0) {  Serial.print("Connected to MQTT Broker: ");  Serial.println(mqtt_server); };
  }
  else {
    if (DEBUG==0) { Serial.println("MQTT Connection Failed!"); };
  }

// start up RFID gear
  rfid.PCD_Init();   // Init MFRC522
  delay(150);
  rfid.PCD_CalcCRC;
 rfid.PCD_SetAntennaGain(rfid.RxGain_max);   // Increase the antenna gain per firmware:
  if (DEBUG==0) { Serial.print("RFID Dump :- ");  rfid.PCD_DumpVersionToSerial(); };
  byte readReg = rfid.PCD_ReadRegister(rfid.VersionReg);  if (DEBUG==0) { Serial.print(F("RFID Ver: 0x"));   Serial.println(readReg, HEX); };
  if (readReg==255 ||readReg==0) { Sys_Error="True";  if (DEBUG==0) { Serial.println("Error - Defected or Unknown RFID Reader"); }; }
   
  tock=99;
  loading_screen(1);
  ip = WiFi.localIP().toString();
  ssi = WiFi.RSSI();
if (ARDUINO_Type==1) {
  ioDevicePinMode(ioExpander, 0, INPUT);  //Declaire ioExpander - pin 0 - input
  ioDevicePinMode(ioExpander, 1, OUTPUT);  //Declaire ioExpander - pin 1 - relay output 1 - credit
  ioDevicePinMode(ioExpander, 2, OUTPUT);  //Declaire ioExpander - pin 2 - relay output 2
  ioDevicePinMode(ioExpander, 3, OUTPUT);  //Declaire ioExpander - pin 3 - Ultrasonic Trigger Pin
  ioDeviceDigitalWrite(ioExpander, 1, 1); //Turn off output 1 (inverted relay output)
  ioDeviceDigitalWrite(ioExpander, 2, 1); //Turn off output 2 (inverted relay output)
  ioDeviceDigitalWrite(ioExpander, 3, 0); //Turn off output 3 (UltraSonic Trigger)
  delay(50);
};  
  settings_screen(ip,mac,ssi);
  StartSent="False";
 }
 
void ReceivedMessage(char* topic, byte* payload, unsigned int length) {
  // Output the first character of the message to serial (debug)
//  fill_solid( leds, NUM_LEDS, CRGB::Red);  FastLED.show();  // Light LED Ring Blue to show MQTT received info
  StaticJsonDocument<200> root;
  char inData[length]; 
  if (DEBUG==0) {  Serial.println("");  Serial.print("Reciving Data from server: ");  };
  for (int i=0;i<length;i++) {
    inData[i] = (char)payload[i]; if (DEBUG==0) { Serial.print(inData[i]); };
  }
    deserializeJson(root, inData);
 // JsonObject& root = jsonBuffer.parseObject(inData);  
  Opp = (const char*)root["Opp"];
  if (Opp=="Start") {  error=0;    Rmac = (const char*)root["mac"];    RMname = (const char*)root["name"];    Rcost = root["cost"];  }
  if (Opp=="Wheel") {
    Cw1 = (const char*)root["Cw1"];
    Cw2 = (const char*)root["Cw2"];
    Cw3 = (const char*)root["Cw3"];
    Cw4 = (const char*)root["Cw4"];
    BRIGHTNESS = root["LB"];
    if (Cw1=="Yellow") { COLOUR1=CRGB::Yellow;  };   if (Cw1=="Purple") { COLOUR1=CRGB::Purple;  };   if (Cw1=="Red") { COLOUR1=CRGB::Red;  };   if (Cw1=="Green") { COLOUR1=CRGB::Green;  };
    if (Cw1=="Blue") { COLOUR1=CRGB::Blue;  };   if (Cw1=="White") { COLOUR1=CRGB::White;  };   if (Cw1=="Black") { COLOUR1=CRGB::Black;  };
    if (Cw2=="Yellow") {COLOUR2=CRGB::Yellow;  };   if (Cw2=="Purple") {COLOUR2=CRGB::Purple;  };   if (Cw2=="Red") {COLOUR2=CRGB::Red;  };   if (Cw2=="Green") {COLOUR2=CRGB::Green;  };
    if (Cw2=="Blue") {COLOUR2=CRGB::Blue;  };   if (Cw2=="White") {COLOUR2=CRGB::White;  };   if (Cw2=="Black") {COLOUR2=CRGB::Black;  };
    if (Cw3=="Yellow") { COLOUR3=CRGB::Yellow;  };   if (Cw3=="Purple") { COLOUR3=CRGB::Purple;  };   if (Cw3=="Red") { COLOUR3=CRGB::Red;  };   if (Cw3=="Green") { COLOUR3=CRGB::Green;  };
    if (Cw3=="Blue") { COLOUR3=CRGB::Blue;  };   if (Cw3=="White") { COLOUR3=CRGB::White;  };   if (Cw3=="Black") { COLOUR3=CRGB::Black;  };
    if (Cw4=="Yellow") { COLOUR4=CRGB::Yellow;  };   if (Cw4=="Purple") { COLOUR4=CRGB::Purple;  };   if (Cw4=="Red") { COLOUR4=CRGB::Red;  };   if (Cw4=="Green") { COLOUR4=CRGB::Green;  };
    if (Cw4=="Blue") { COLOUR4=CRGB::Blue;  };   if (Cw4=="White") { COLOUR4=CRGB::White;  };   if (Cw4=="Black") { COLOUR4=CRGB::Black;  };
  }
  if (Opp=="Data") { 
 //   Rmac = root["mac"];
    Rname = (const char*)root["name"];
    Rcredit = root["price"];
    Rtime = root["time"];
    if (Rcredit>=0) { // not out of credit
        display.clear();  MsgDisp2();  display.display(); // display all that has been set into the display
        if (ARDUINO_Type==1) { 
          fill_solid( leds, NUM_LEDS, CRGB::Blue);  FastLED.show();  // Light LED Ring Blue to show MQTT received info
          ioDeviceDigitalWriteS(ioExpander, 1, 0);    delay(1000);   ioDeviceDigitalWriteS(ioExpander, 1, 1); //Turn on / off output 1 - Relay Credit
        };
        if (DEBUG==0) { Serial.println("Triggering Relay - from Credit"); };
        if (ARDUINO_Type==0) {  digitalWrite(RELAY_PIN, LOW);  delay(1000);  digitalWrite(RELAY_PIN, HIGH);  };
        display.clear();  MsgDisp3();  display.display(); // display all that has been set into the display
        delay(2000);
    } else {
        error=5; AlertDisp(5);  counter++; if (counter>=100){ counter=0; Opp=""; Error=""; error=0; } // out of credit message delay
    }
    if (Rtime>=0) { // not out of time
        display.clear();  MsgDisp2();  display.display(); // display all that has been set into the display
        if (ARDUINO_Type==1) { 
          fill_solid( leds, NUM_LEDS, CRGB::Blue);  FastLED.show();  // Light LED Ring Blue to show MQTT received info
          ioDeviceDigitalWriteS(ioExpander, 1, 0);   delay(1000);   ioDeviceDigitalWriteS(ioExpander, 1, 1); //Turn on / off output 1 - Relay Credit
        };
        if (DEBUG==0) { Serial.println("Triggering Relay - from Timed"); };
        if (ARDUINO_Type==0) {  digitalWrite(RELAY_PIN, LOW);  delay(1000);  digitalWrite(RELAY_PIN, HIGH);  };
        display.clear();  MsgDisp5();  display.display(); // display all that has been set into the display
        delay(2000);
    } else {
        AlertDisp(4); //error=4; counter++; if (counter>=100){ counter=0; Opp=""; Error=""; error=0; } // out of time message delay
    }
  }
  if (Opp=="Error") {
    Error = (const char*)root["name"];    Rname = Error;
    if ( ARDUINO_Type==1) {    fill_solid( leds, NUM_LEDS, CRGB::Red);  FastLED.show(); }; // Light LED Ring -Red- to show Error info received 
  }
  if (Opp=="Update") {
        UPDATE = "1";
  }
  if (Opp=="Reboot") {
        reboot();
  }
card_read="False";
}
  
void MsgDisp(){  // scrolls randomly 1 of 3 messages
  rndwait++;
  if (rndwait>=msgwait) { randNumber = random(1,4); rndwait=0; } // message delay on screen
  if (Rcost==0) { randNumber=0; }
  if (randNumber==1) {
    display.setTextAlignment(TEXT_ALIGN_LEFT);    display.setFont(ArialMT_Plain_24);
    display.drawString(40, 0, "Tap");       display.drawString(35, 20, "Card");        display.drawString(12, 40, "-To PlaY-");
  } else if (randNumber==2) {
    display.setTextAlignment(TEXT_ALIGN_LEFT);    display.setFont(ArialMT_Plain_24);
    display.drawString(40, 0, "Tap");       display.drawString(35, 20, "Card"); 
    String amount="<  $"+String(Rcost)+"  >";
    display.drawString(21, 40, amount);
  } else if (randNumber==3) {
    display.setTextAlignment(TEXT_ALIGN_LEFT);    display.setFont(ArialMT_Plain_24);
    String amount="Only $"+String(Rcost);
    display.drawString(25, 10, amount);       display.drawString(7, 37, "Per Game");
  } else if (randNumber==0) {
    display.setTextAlignment(TEXT_ALIGN_LEFT);    display.setFont(ArialMT_Plain_24);
    display.drawString(0, 0, "Loading");       display.drawString(40, 21, "System");
    display.drawString(35-RMname.length()*3, 40, RMname); 
  }
}

void MsgDisp2(){
    display.setTextAlignment(TEXT_ALIGN_LEFT);    display.setFont(ArialMT_Plain_24);
    display.drawString(15, 20, "Welcome");   display.drawString(35-Rname.length()*3, 40, Rname);
}
void MsgDisp3(){
    display.setTextAlignment(TEXT_ALIGN_LEFT);    display.setFont(ArialMT_Plain_24);
    display.drawString(20, 0, "Credit");    display.drawString(40, 20, "left");   display.drawString(35, 40, "$"+String(Rcredit));
}
void MsgDisp5(){
    TimeCalc(Rtime);
    display.setTextAlignment(TEXT_ALIGN_LEFT);    display.setFont(ArialMT_Plain_24);
    display.drawString(29, 0, "Time");    display.drawString(40, 20, "left");   display.drawString(5, 40, String(h)+"H "+String(m)+"M "+String(s)+"s");
}
void TimeCalc( long unsigned int secs ) {
    uint32_t rem;
    h = secs / 3600;
    rem = secs % 3600;
    m = rem / 60;
    s = rem % 60;
}

void MsgDisp6(){
    display.setTextAlignment(TEXT_ALIGN_LEFT);    display.setFont(ArialMT_Plain_24);
    display.drawString(35, 7, "Top");       display.drawString(24, 30, "Score");
}

void AlertDisp(int y){
  if (y==1){
    display.setTextAlignment(TEXT_ALIGN_LEFT);    display.setFont(ArialMT_Plain_24);
    display.drawString(25, 10, "System");       display.drawString(40, 35, "Error");
  }
  if (y==2){
    display.setTextAlignment(TEXT_ALIGN_LEFT);    display.setFont(ArialMT_Plain_24);
    display.drawString(20, 10, "DB Error");       display.drawString(0, 35, "No Machine");
  }
  if (y==3){
    display.setTextAlignment(TEXT_ALIGN_LEFT);    display.setFont(ArialMT_Plain_24);
    display.drawString(10, 10, "Scan Error");       display.drawString(5, 35, "No Member");
  }
  if (y==4){
    display.setTextAlignment(TEXT_ALIGN_LEFT);    display.setFont(ArialMT_Plain_24);
    display.drawString(20, 0, "Out");    display.drawString(40, 20, "of");   display.drawString(35, 40, "Time");
  }
  if (y==5){
    display.setTextAlignment(TEXT_ALIGN_LEFT);    display.setFont(ArialMT_Plain_24);
    display.drawString(20, 0, "Out");    display.drawString(40, 20, "of");   display.drawString(30, 40, "Credit");
  }
  if (y==6){
    display.setTextAlignment(TEXT_ALIGN_LEFT);    display.setFont(ArialMT_Plain_24);
    display.drawString(25, 0, "RFID");       display.drawString(40, 20, "Error");  
    byte readReg = rfid.PCD_ReadRegister(rfid.VersionReg);  display.drawString(30, 40, "0x"+String(readReg,HEX));
  }
  if (y==7){
    display.setTextAlignment(TEXT_ALIGN_LEFT);    display.setFont(ArialMT_Plain_24);
    display.drawString(20, 0, "MQTT");    display.drawString(40, 20, "Failed");   display.drawString(20, 40, "No Feed");
  }
}

void SigDisp(){  //  Signal strength status update
  int bars;
  RSSI = WiFi.RSSI();
  display.setTextAlignment(TEXT_ALIGN_RIGHT);    display.setFont(ArialMT_Plain_10);    display.drawString(125, 0, String(RSSI));
//  int bars = map(RSSI,-80,-44,1,6); // this method doesn't reflect the Bars well
  if (RSSI > -30) {     bars = 7;
    } else if (RSSI < -35 & RSSI > -45) {    bars = 6;
    } else if (RSSI < -45 & RSSI > -55) {    bars = 5;
    } else if (RSSI < -55 & RSSI > -65) {    bars = 4;
    } else if (RSSI < -65 & RSSI > -70) {    bars = 3;
    } else if (RSSI < -70 & RSSI > -78) {    bars = 2;
    } else if (RSSI < -78 & RSSI > -82) {    bars = 1;
    } else {    bars = 0;
  }
  for (int b=0; b <= bars; b++) {    display.fillRect(92 + (b*2),11 - (b*2),1,b*2);   }
}
void SonicDisp(){  //  Signal strength status update
  display.setTextAlignment(TEXT_ALIGN_LEFT);    display.setFont(ArialMT_Plain_10);    display.drawString(0, 0, String(distance)+"cm");
}
void SystemStart() {
  if (ARDUINO_Type==1) { sonic="True"; };
  if (ARDUINO_Type==0) { sonic="False"; };

  if (Sys_Error == "True") {            // if RFID scanner shits itself bit
       tack++;
       error=6; AlertDisp(6);
       if (ARDUINO_Type==1) { delay(600);  fill_solid( leds, NUM_LEDS, CRGB::Red);  FastLED.show(); delay(600);  fill_solid( leds, NUM_LEDS, CRGB::Black);  FastLED.show(); }; // Flash LED Ring Red to show RFID ERROR 
       if (tack==5) {                   // send Mqtt message to system - error rfid is down
         String wifi = String(WiFi.RSSI());
         char mmac[19];    mac.toCharArray(mmac, 19);
         byte readReg = rfid.PCD_ReadRegister(rfid.VersionReg); Error_Msg="RFID Error 0x"+String(readReg,HEX);
         String message = "{\"Opp\":\"Error\",\"mac\":\""+mac+"\",\"type\":\""+Error_Msg+"\",\"ssi\":\""+wifi+"\"}";
         char mesage[message.length()+1];
         message.toCharArray(mesage, message.length()+1);
         client.subscribe(mmac);    client.publish("Machine",mesage);
       };                               // send Mqtt message - error rfid is down
       if (tack==30000) { reboot(); };  //  after 1hr maybe the rfid card reader wants to work this time so lets reboot
   } else {                             // if everything is working fine section
    String wifi = String(WiFi.RSSI());
    char mmac[19];
    mac.toCharArray(mmac, 19);
    String message = "{\"Opp\":\"Start\",\"mac\":\""+mac+"\",\"uid\":\""+Version+"\",\"ssi\":\""+wifi+"\"}"; // send mqtt data to server anouncing who we are
    char mesage[message.length()+1];
    message.toCharArray(mesage, message.length()+1);
//   Serial.println(message);
    client.subscribe(mmac);
    client.publish("Machine",mesage);
    if (DEBUG==0) {  Serial.println("Asking server for Machine info"); };
    StartSent="True";
  }
}

void update_started() {   // OTA update status section
if (ARDUINO_Type==1) {   fill_solid( leds, NUM_LEDS, CRGB::Yellow);  FastLED.show(); }; // Light LED Ring Yellow to show OTA Update is Starting 
}

void update_finished() {   // OTA update status section
if (ARDUINO_Type==1) {  FastLED.clear (); FastLED.show(); display.clear(); };  UPDATE = "0";
}

void update_progress(int cur, int total) {   // OTA update status section
   display.clear();
   display.setTextAlignment(TEXT_ALIGN_LEFT);    display.setFont(ArialMT_Plain_16);   display.drawString(15, 10, "UPLOADING:");
   display.setTextAlignment(TEXT_ALIGN_LEFT);    display.setFont(ArialMT_Plain_10);   display.drawString(20, 30, "System Firmware");
   tock = map(cur, 0, total, 0, 100);   display.drawProgressBar(0, 52, 120, 8, tock);   display.display();
}

void update_error(int err) {   // OTA update status section
   display.clear();
   display.setTextAlignment(TEXT_ALIGN_LEFT);    display.setFont(ArialMT_Plain_16);   display.drawString(35, 10, "ERROR:");
   display.setTextAlignment(TEXT_ALIGN_LEFT);    display.setFont(ArialMT_Plain_10);   display.drawString(20, 30, "Code : "+String(err));
//  USE_SERIAL.printf("CALLBACK:  HTTP update fatal error code %d\n", err);
   UPDATE = "0";
}

void Sonic() {
  if (rndwait==(msgwait-1)){  
   ioDeviceDigitalWriteS(ioExpander, 3, 1); //Turn on output 3
   delayMicroseconds(5);                    // delay 5 microseconds - enables reset of device
   ioDeviceDigitalWriteS(ioExpander, 3, 0); //Turn off output 3
   delayMicroseconds(5);                    // delay 5 microseconds - quick rest
   ioDeviceDigitalWriteS(ioExpander, 3, 1); //Turn on output 3
   delayMicroseconds(10);                   // delay 10 microseconds - measurement time
   ioDeviceDigitalWriteS(ioExpander, 3, 0); //Turn off output 3
   duration = pulseIn(D2, HIGH);            //Get duration value from echo pin
   distance = duration * 0.034 / 2;         // do math an work out distance
//   if (DEBUG==0) { Serial.print("Distance = ");   Serial.print(distance);   Serial.println(" cm");  };
  };
}

void loop() {
  display.clear();
  if (ARDUINO_Type==1) {  FastLED.show(); };
  SigDisp(); // displays the wifi signal status
  if (StartSent=="False") {  SystemStart();  }   // run things you only want run once at startup
    else {
  if (Opp!="Error") { // if No Errors
    if (sonic=="True") { SonicDisp(); };  // displays the distance on the screen
    if (error==0) { MsgDisp(); }; // displays random 'play me' messages with price, if No mqtt error is needing to be displayed
    if (ARDUINO_Type==1) { Setup4StripedPalette();  currentBlending = LINEARBLEND;  static uint8_t startIndex = 0;  startIndex = startIndex + 1;   FillLEDsFromPaletteColors( startIndex);   };  // led color ring
  } else {  // if Errors found
//    error=3; AlertDisp(3);
    counter++; if (counter>=100){ counter=0; Opp=""; Error="";  }
    if (Rname=="Error")  error=1; AlertDisp(1);  // displays System alert error message
    if (Rname=="No Machine")  error=2; AlertDisp(2);  // displays No machine in DB error message
    if (RMname=="" || Rcost==0 && error==0) {Ecount++; if (Ecount>=500){ if (DEBUG==0) { Serial.println("Error no MQTT feed"); };  error=7; AlertDisp(7); Ecount=0;} }  // Error Checking no MQTT after clicks
  }

  if (sonic=="True"){  Sonic(); }; // read ultrasonic distance from machine to person,- if True = Turned on

  if (card_read=="False") {  handleRFID(); } // check RFID scanner, - if False = ready

  if (!client.connected()) {      // If the Mqtt connection is lost, try to connect again
  if ( ARDUINO_Type==1) {   fill_solid( leds, NUM_LEDS, CRGB::Red);  FastLED.show(); }; // Light LED Ring Red to show MQTT error
     display.clear();   display.setTextAlignment(TEXT_ALIGN_LEFT);    display.setFont(ArialMT_Plain_24);
     display.drawString(40, 0, "MQTT");       display.drawString(30, 20, "Failed");        display.drawString(2, 40, "Connecting");
     Connect();
  }
  if (UPDATE == "1") { DownOTA();  }   // OTA update sected, goto subsection
  client.loop();  // client.loop() just tells the MQTT client code to do what it needs to do itself (i.e. check for messages, etc.)
 }
if (error==1) { AlertDisp(1);   };  // If MQTT error has happened, display alert message
if (error==2) { AlertDisp(2);   };  // If MQTT error has happened, display alert message
if (error==3) { AlertDisp(3);   };  // If MQTT error has happened, display alert message
if (error==4) { AlertDisp(4);   };  // If MQTT error has happened, display alert message
if (error==5) { AlertDisp(5);   };  // If MQTT error has happened, display alert message
if (error==6) { AlertDisp(6);   };  // If MQTT error has happened, display alert message
if (error==7) { AlertDisp(7);   };  // If MQTT error has happened, display alert message
display.display(); // display all that has been set into the display
  
}

void DownOTA() {  // OTA update Firmware section
      ESPhttpUpdate.onStart(update_started);
      ESPhttpUpdate.onEnd(update_finished);
      ESPhttpUpdate.onProgress(update_progress);
      ESPhttpUpdate.onError(update_error);
      ESPhttpUpdate.update("http://192.168.10.1/update/RFID_System.ino.d1.bin");  // file location an name for OTA arduino BIN file
}

void handleRFID() {
  if ( ! rfid.PICC_IsNewCardPresent()) return;
  if ( ! rfid.PICC_ReadCardSerial()) return;
  card_read="True";
  if (ARDUINO_Type==1) {  fill_solid( leds, NUM_LEDS, CRGB::Green);  FastLED.show(); }; // Light LED Ring Green to show card scanned
  if (ARDUINO_Type==0) {  digitalWrite(Buzzer_PIN, LOW); delay(100); digitalWrite(Buzzer_PIN, HIGH); };

  String card_uid = printHex(rfid.uid.uidByte, rfid.uid.size);
  char carduid[12];
  card_uid.toCharArray(carduid, 12);
  String uid = String(carduid);
  String wifi = String(WiFi.RSSI());
    char mmac[19];
    mac.toCharArray(mmac, 19);
  String message = "{\"Opp\":\"Data\",\"mac\":\""+mac+"\",\"uid\":\""+uid+"\",\"ssi\":\""+wifi+"\"}";
  char mesage[message.length()+1];
  message.toCharArray(mesage, message.length()+1);
  client.subscribe(carduid);
  client.publish("Machine",mesage);
}

String printHex(byte *buffer, byte bufferSize) {
  String id = "";
  for (byte i = 0; i < bufferSize; i++) {
    id += buffer[i] < 0x10 ? "0" : "";
    id += String(buffer[i], HEX);
  }
  return id;
}

void FillLEDsFromPaletteColors( uint8_t colorIndex)
{
    for( int i = 0; i < NUM_LEDS; i++) {
        leds[i] = ColorFromPalette( currentPalette, colorIndex, BRIGHTNESS, currentBlending);
        colorIndex += 3;
    }
}

void Setup4StripedPalette()
{
    // 'black out' all 16 palette entries...
    fill_solid( currentPalette, 16, CRGB::Black);
    // and set every fourth one to white.
    currentPalette[0] = COLOUR1;
    currentPalette[4] = COLOUR2;
    currentPalette[8] = COLOUR3;
    currentPalette[12] = COLOUR4;
    
}

void reboot() {
  wdt_disable();
  wdt_enable(WDTO_15MS);
  while (1) {}
}
