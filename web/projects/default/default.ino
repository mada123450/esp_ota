//
#include <ESP8266WiFi.h>
#include <WiFiClient.h>
#include <ESP8266httpUpdate.h>

#define	OTA_HOST_IP       		"***.***.***.***"
#define	OTA_HOST_PORT     		80
#define OTA_UPDATE_FREQUENCY  	1 /*min*/ * 60 * 1000
#define OTA_PROJECT_NAME    	"default"
#define OTA_BIN_FILE      		"/projects/" OTA_PROJECT_NAME "/deploy/" OTA_PROJECT_NAME ".ino.bin"
  
#define WLAN_SSID       		"******"
#define WLAN_PASS       		"******"
  
#define SERIAL_BAUD				115200

#define MQTT_SERVER				"******"
  
#define COMPILE_DATE			__DATE__ " " __TIME__
    
unsigned long lastCheck = 0;
void OTAHandler();
void CheckForUpdate();
void SetupWifi(); 

void setup() 
{
	delay(1000);
	Serial.begin(SERIAL_BAUD);
	Serial.println(OTA_PROJECT_NAME " Build Date: " COMPILE_DATE);
	SetupWifi();
}

void SetupWifi() 
{
	// We start by connecting to a WiFi network
	Serial.println();
	Serial.print("Connecting to ");
	Serial.println(WLAN_SSID);

	WiFi.begin(WLAN_SSID, WLAN_PASS);

	while (WiFi.status() != WL_CONNECTED) 
	{
		delay(500);
		Serial.print(".");
	}

	Serial.println("");
	Serial.println("WiFi connected");
	Serial.println("IP address: ");
	Serial.println(WiFi.localIP());
}

void loop() 
{
	OTAHandler();
    // put your main code here, to run repeatedly:
}

void OTAHandler()
{
    if( millis() >= lastCheck + OTA_UPDATE_FREQUENCY ||
	  	millis() < lastCheck)
    {
      CheckForUpdate();
      lastCheck = millis();
    }
}

void CheckForUpdate()
{
    //Serial.println("[update] checking for update");
    t_httpUpdate_return ret = ESPhttpUpdate.update(OTA_HOST_IP, OTA_HOST_PORT, "/getBin.php", OTA_BIN_FILE " ## " COMPILE_DATE);
    switch(ret)
    {
        case HTTP_UPDATE_FAILED:
            //Serial.println("[update] Update failed.");
             Serial.println(ESPhttpUpdate.getLastErrorString().c_str());
            break;
        case HTTP_UPDATE_NO_UPDATES:
            //Serial.println("[update] Update no Update.");
            break;
        case HTTP_UPDATE_OK:
            //Serial.println("[update] Update ok."); // may not called we reboot the ESP
            break;
    }
}