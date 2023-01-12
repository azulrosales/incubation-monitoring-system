#include <ESP8266WiFi.h>
#include <ESP8266WebServer.h>
#include "DHT.h"

const char* ssid = "network"; // Network
const char* password = "password"; // Network password
const char* host = "192.168.137"; // IP Address
const int port = 80; // XAMPP port
const int watchdog = 5000;
unsigned long previousMillis = millis();

#define DHTTYPE DHT11
#define dht_pin 14

DHT dht(dht_pin, DHTTYPE);

void setup(){   
  dht.begin();
  Serial.begin(115200);
  Serial.println("Humedad y Temperatura\n\n");
  delay(700);

  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED){
    delay(1000);
    Serial.print(".");  
  }

  Serial.println("");
  Serial.println("WiFi connected");
  Serial.print("IP Adress: ");
  Serial.println(WiFi.localIP());
}

void loop(){
  float h = dht.readHumidity();
  float t = dht.readTemperature();
  
  Serial.print("Temperatura = ");
  Serial.print(t);
  Serial.print(("C "));
  Serial.print("Humedad = ");
  Serial.print(h);
  Serial.println(("%"));

  unsigned long currentMillis = millis();

  if (currentMillis - previousMillis > watchdog){
    previousMillis = currentMillis;
    WiFiClient client;
    
    if (!client.connect(host, port)){
      Serial.println("Fallo al conectar");
      return;
    }
  
    String url = "/incubit/db_write.php?temp=";
    url += t;
    url += "&hum=";
    url += h;

  //http://localhost/incubit/db_write.php?temp=23.7&hum=48.8
    client.print(String("GET ") + url + " HTTP/1.1\r\n" +
                "Host: " + host + "\r\n" + 
                "Connection: close\r\n\r\n");
    unsigned long timeout = millis();
    while (client.available() == 0){
      if(millis() - timeout > 5000){
        Serial.println(">>> Client Timeout !");
        client.stop();
        return;
      }
    }
      
    while(client.available()){
      String line = client.readStringUntil('\r');
      Serial.print(line);
    } 
  }
  delay(10000); // input time delay
}