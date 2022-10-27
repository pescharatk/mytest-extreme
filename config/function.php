<?php
if (!function_exists('call_api')) {
    function call_api($method="", $url="", $data = false) {
        $curl = curl_init();
    
        switch ($method) {
            case "POST" :
                curl_setopt($curl, CURLOPT_POST, 1);
                if($data){
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                }
                break;
                
            case "PUT" :
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
                
            default :
                if($data){
                    $url = sprintf("%s?%s", $url, http_build_query($data));
                }
        }
    
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    
        $result = curl_exec($curl);
    
        curl_close($curl);
    
        return $result;
    }
}

if (!function_exists('dates')) {
    function dates($str = "") {
        if ($str == "0000-00-00" || $str == "") {
            return "";
        } else {
            $time = strtotime($str);
    
            $thai_month_arr = array(
                "0" => "",
                "1" => "ม.ค.",
                "2" => "ก.พ.",
                "3" => "มี.ค.",
                "4" => "เม.ย.",
                "5" => "พ.ค.",
                "6" => "มิ.ย.",
                "7" => "ก.ค.",
                "8" => "ส.ค.",
                "9" => "ก.ย.",
                "10" => "ต.ค.",
                "11" => "พ.ย.",
                "12" => "ธ.ค."
            );
    
            $date_return = "" . date("j", $time);
            $date_return .= " " . $thai_month_arr[date("n", $time)];
            $date_return .= " " . (date("Y", $time) + 543);
    
        return $date_return;
        }
    }
}

if (!function_exists('datetime')) {
    function datetime($str) {
    if ($str == "0000-00-00 00:00:00" || $str == "") {
        return "";
    } else {
        $time = strtotime($str);
        $thai_month_arr = array(
            "0" => "",
            "1" => "ม.ค.",
            "2" => "ก.พ.",
            "3" => "มี.ค.",
            "4" => "เม.ย.",
            "5" => "พ.ค.",
            "6" => "มิ.ย.",
            "7" => "ก.ค.",
            "8" => "ส.ค.",
            "9" => "ก.ย.",
            "10" => "ต.ค.",
            "11" => "พ.ย.",
            "12" => "ธ.ค."
        );
    
        $date_return = "" . date("j", $time);
        $date_return .= " " . $thai_month_arr[date("n", $time)];
        $date_return .= " " . (date("Y", $time) + 543);
        $date_return .= " " . date("H:i:s", $time) . "";
    
        return $date_return;
        }
    }
}
?>