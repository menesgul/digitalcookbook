<?php
class ApiHandler {
    // API'den veri çekmek için genel bir metod
    public function fetchData($url) {
        try {
            // API isteğini yap
            $response = file_get_contents($url);

            // İstek başarısızsa hata döndür
            if ($response === FALSE) {
                throw new Exception("API isteği başarısız oldu.");
            }

            // JSON verisini PHP dizisine çevir
            $data = json_decode($response, true);

            // JSON decode sırasında hata oluşursa
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception("JSON verisi çözümlenemedi: " . json_last_error_msg());
            }

            return $data;
        } catch (Exception $e) {
            // Hata mesajını döndür
            echo "Hata: " . $e->getMessage();
            return null;
        }
    }
}
?>
