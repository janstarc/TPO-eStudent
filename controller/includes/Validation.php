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
    
    public static function verifyDatumRojstvaInEMSO($DR, $EMSO) {
        if (strlen($DR) == 10 && strlen($EMSO) == 13 && ($DR[6]==1 || $DR[6]==2) &&
            $DR[0]==$EMSO[0] && $DR[1]==$EMSO[1] &&
            $DR[3]==$EMSO[2] && $DR[4]==$EMSO[3] &&
            $DR[7]==$EMSO[4] && $DR[8]==$EMSO[5] && $DR[9]==$EMSO[6]
        ) return true;
        return false;
    }
}