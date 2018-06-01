<?php

class Validation {
    public static function checkValues($input) {
        if (empty($input)) {
            return FALSE;
        }
        $result = TRUE;
        foreach ($input as $value) {
            $result = $result && $value != false;
        }
        return $result;
    }
    
    public static function verifyEMSO($input) {
        if (ctype_digit($input) && strlen($input) == 13) {
            $emso_factor_map = array(7, 6, 5, 4, 3, 2, 7, 6, 5, 4, 3, 2);
            $emso_sum = 0;
            
            for ($x = 0; $x < 12; $x++) {
                $emso_sum = $emso_sum + ((int)$input[$x]) * $emso_factor_map[$x];
            }
            
            if ($emso_sum % 11 == 0) $control_digit = 0;
            else $control_digit = 11 - ($emso_sum % 11);
            
            return $control_digit == (int)$input[12];
        } else {
            return false;
        }
    }
}