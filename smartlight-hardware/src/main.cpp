#include <WiFi.h>
#include <HTTPClient.h>
#include <ArduinoJson.h>

// ===== Konfigurasi WiFi =====
const char* ssid = "Redmi";            // SSID WiFi
const char* password = "abogoboga614";   // Password WiFi

// ===== API Endpoints =====
const char* serverUrl = "http://8d24-36-50-112-172.ngrok-free.app/api/light/status"; // URL server Ngrok
const String apiEndpoint = "http://8d24-36-50-112-172.ngrok-free.app/api/light/status";
const String apiStatusEndpoint = "http://8d24-36-50-112-172.ngrok-free.app/api/light/status";

// ===== Pin Setup =====
#define LDR_PIN 34        // Pin ADC untuk LDR (input)
#define RELAY_PIN 26      // Pin ke relay (output)
int AMBANG_GELAP = 2000;  // Threshold LDR (akan diupdate dari settings)

// ===== Status Variables =====
bool isLightOn = false;
String operationMode = "auto";   // "auto" atau "manual"
bool manualOverride = false;
unsigned long lastStatusCheck = 0;
unsigned long lastDataSend = 0;
const unsigned long STATUS_CHECK_INTERVAL = 3000; // 3 detik
const unsigned long DATA_SEND_INTERVAL = 5000;    // 5 detik

void setup() {
  Serial.begin(115200);
  delay(1000); // Tunggu serial siap

  // Inisialisasi pin
  pinMode(RELAY_PIN, OUTPUT);
  digitalWrite(RELAY_PIN, HIGH); // Relay OFF (aktif LOW)

  // Hubungkan ke WiFi
  WiFi.begin(ssid, password);
  Serial.print("Menghubungkan ke WiFi: ");
  Serial.println(ssid);

  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("\nTerhubung ke WiFi!");
  Serial.print("Alamat IP ESP32: ");
  Serial.println(WiFi.localIP());
}

void loop() {
  unsigned long currentMillis = millis();
  int nilaiLDR = analogRead(LDR_PIN);
  
  // Cek status dari server dan kemungkinan perintah manual setiap 3 detik
  if (currentMillis - lastStatusCheck >= STATUS_CHECK_INTERVAL) {
    lastStatusCheck = currentMillis;
    checkServerStatus();
  }
  
  // Logika kontrol lampu berdasarkan mode operasi
  if (operationMode == "auto" && !manualOverride) {
    // Mode otomatis berdasarkan nilai LDR
    if (nilaiLDR < AMBANG_GELAP) {
      setLightStatus(true);  // Nyalakan lampu jika gelap
      Serial.println("Status: GELAP - Lampu NYALA (AUTO)");
    } else {
      setLightStatus(false); // Matikan lampu jika terang
      Serial.println("Status: TERANG - Lampu MATI (AUTO)");
    }
  } else {
    // Mode manual (status lampu sudah diatur oleh server)
    Serial.println("Mode: MANUAL - Lampu " + String(isLightOn ? "NYALA" : "MATI"));
  }
  
  // Kirim data ke server setiap 5 detik
  if (currentMillis - lastDataSend >= DATA_SEND_INTERVAL) {
    lastDataSend = currentMillis;
    
    // Kirim data ke server Laravel
    if (WiFi.status() == WL_CONNECTED) {
      HTTPClient http;
      http.begin(serverUrl);
      http.addHeader("Content-Type", "application/json");
      
      String jsonData = "{\"is_on\":" + String(isLightOn ? "true" : "false") +
                      ",\"ldr_value\":" + String(nilaiLDR) +
                      ",\"mode\":\"" + operationMode + "\"" +
                      ",\"manual_override\":" + String(manualOverride ? "true" : "false") + "}";
      
      int httpResponseCode = http.POST(jsonData);
      Serial.print("HTTP Response code: ");
      Serial.println(httpResponseCode);
      http.end();
    } else {
      Serial.println("WiFi tidak terhubung!");
    }
  }
  
  // Debug info
  Serial.print("Nilai LDR: ");
  Serial.println(nilaiLDR);
  Serial.print("Mode: ");
  Serial.println(operationMode);
  
  delay(1000);
}

// Fungsi untuk mengatur status lampu (relay)
void setLightStatus(bool turnOn) {
  if (turnOn) {
    digitalWrite(RELAY_PIN, LOW);  // Aktifkan relay (aktif LOW)
  } else {
    digitalWrite(RELAY_PIN, HIGH); // Nonaktifkan relay
  }
  isLightOn = turnOn;
}

// Fungsi untuk cek status dari server (mode dan kontrol manual)
void checkServerStatus() {
  if (WiFi.status() != WL_CONNECTED) {
    Serial.println("WiFi tidak terhubung!");
    return;
  }
  
  HTTPClient http;
  http.begin(apiStatusEndpoint);
  int httpCode = http.GET();
  
  if (httpCode == HTTP_CODE_OK) {
    String payload = http.getString();
    Serial.println("Server response: " + payload);
    
    // Parse JSON response
    DynamicJsonDocument doc(1024);
    DeserializationError error = deserializeJson(doc, payload);
    
    if (!error) {
      if (doc.containsKey("data")) {
        JsonObject data = doc["data"];
        
        // Update operasi mode
        if (data.containsKey("mode")) {
          operationMode = String((const char*)data["mode"]);
        }
        
        // Update manual override status
        if (data.containsKey("manual_override")) {
          manualOverride = data["manual_override"];
        }
        
        // Update light status jika dalam mode manual
        if (operationMode == "manual" || manualOverride) {
          if (data.containsKey("is_on")) {
            bool shouldBeOn = data["is_on"];
            setLightStatus(shouldBeOn);
          }
        }
        
        // Update threshold value dari settings
        if (data.containsKey("settings") && data["settings"].containsKey("threshold")) {
          AMBANG_GELAP = data["settings"]["threshold"];
        }
      }
    } else {
      Serial.println("Gagal parsing JSON");
    }
  } else {
    Serial.print("Gagal mendapatkan status: ");
    Serial.println(httpCode);
  }
  
  http.end();
}