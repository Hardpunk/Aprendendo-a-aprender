<?php

if (!function_exists('format_cpf_cnpj')) {
    /**
     * Format CPF/CNPJ
     *
     * @param $value
     * @return string|string[]|null
     */
    function format_cpf_cnpj($value)
    {
        $cnpj_cpf = preg_replace("/\D/", '', $value);

        if (strlen($cnpj_cpf) === 11) {
            return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cnpj_cpf);
        }

        return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj_cpf);
    }
}

if (!function_exists('getFirstName')) {
    /**
     * Get First Name
     *
     * @param $name
     * @return String
     */
    function getFirstName($name): string
    {
        preg_match('/\p{L}+/ui', $name, $matches);
        return $matches[0];
    }
}

if (!function_exists('getLastName')) {
    /**
     * Get First Name
     *
     * @param $name
     * @return String
     */
    function getLastName($name): string
    {
        return substr(str_replace('.', '.', str_replace('\'', '', $name)), 0, 30);
    }
}

if (!function_exists('remove_special_char')) {
    /**
     * Get First Name
     *
     * @param $value
     * @return String
     */
    function remove_special_char($value)
    {
        $value = str_replace('-', ' ', $value);
        $result = preg_replace('/[^a-zA-Z0-9 ]/s', '', $value);
        return $result;
    }
}

if (!function_exists('get_language_country_flag')) {
    /**
     * Get First Name
     *
     * @param $code
     * @return String
     */
    function get_language_country_flag($code)
    {
        $language_codes = [
            'ar' => [
                'country'  => 'Arábia Saudita',
                'language' => 'Árabe',
                'file'     => 'saudi-arabia',
            ],
            'en' => [
                'country'  => 'Estados Unidos',
                'language' => 'Inglês',
                'file'     => 'united-states-of-america',
            ],
            'es' => [
                'country'  => 'Espanha',
                'language' => 'Espanhol',
                'file'     => 'spain',
            ],
            'de' => [
                'country'  => 'Alemanha',
                'language' => 'Alemão',
                'file'     => 'germany',
            ],
            'fr' => [
                'country'  => 'França',
                'language' => 'Francês',
                'file'     => 'france',
            ],
            'it' => [
                'country'  => 'Itália',
                'language' => 'Italiano',
                'file'     => 'italy',
            ],
            'ja' => [
                'country'  => 'Japão',
                'language' => 'Japonês',
                'file'     => 'japan',
            ],
            'nl' => [
                'country'  => 'Holanda',
                'language' => 'Holandês',
                'file'     => 'netherlands',
            ],
            'pl' => [
                'country'  => 'Polônia',
                'language' => 'Polonês',
                'file'     => 'republic-of-poland',
            ],
            'pt' => [
                'country'  => 'Brasil',
                'language' => 'Português',
                'file'     => 'brazil',
            ],
            'ru' => [
                'country'  => 'Rússia',
                'language' => 'Russo',
                'file'     => 'russia',
            ],
            'zh' => [
                'country'  => 'China',
                'language' => 'Chinês',
                'file'     => 'china',
            ],
        ];

        $language = (array_key_exists($code, $language_codes) === true) ? $language_codes[$code] : [];
        return $language;
    }
}

if (!function_exists('truncate_text_at_word')) {
    /**
     * Truncate text at word
     *
     * @param  mixed  $string
     * @param  mixed  $limit
     * @param  string  $break
     * @param  string  $pad
     * @return mixed
     */
    function truncate_text_at_word($string, $limit, $break = ".", $pad = "...")
    {
        if (strlen($string) <= $limit) {
            return $string;
        }
        if (false !== ($max = strpos($string, $break, $limit))) {
            if ($max < strlen($string) - 1) {
                $string = substr($string, 0, $max).$pad;
            }
        }
        return $string;
    }
}

if (!function_exists('check_remote_file')) {
    /**
     * Check if remote file exists
     *
     * @param  string  $url
     * @return bool
     */
    function check_remote_file($url)
    {
        $content_type = '';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_NOBODY, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $results = explode("\n", trim(curl_exec($ch)));
        foreach ($results as $line) {
            if (strtolower(strtok($line, ':')) == 'content-type') {
                $parts = explode(":", $line);
                $content_type = trim($parts[1]);
            }
        }
        curl_close($ch);
        $status = strpos($content_type, 'image') !== false;

        return $status;
    }
}

if (!function_exists('only_numbers')) {
    /**
     * Returns only numbers
     *
     * @param  string  $number
     * @return string
     */
    function only_numbers($number)
    {
        return (string)preg_replace('/\D/', '', $number);
    }
}

if (!function_exists('generateAvatar')) {
    /**
     * Generate avatar by user name
     *
     * @param  string  $fullname
     * @return string
     */
    function generateAvatar($fullname)
    {
        $avatarName = urlencode("{$fullname}");
        return "https://ui-avatars.com/api/?name={$avatarName}&background=838383&color=FFFFFF&size=140&rounded=true";
    }
}

if (!function_exists('get_payment_status')) {
    /**
     * Get status message
     *
     * @param  string  $code
     * @return string
     */
    function get_payment_status($code)
    {
        switch ($code) {
            case 'processing':
                $status = 'Em processo';
                break;
            case 'authorized':
                $status = 'Autorizada';
                break;
            case 'paid':
                $status = 'Aprovado';
                break;
            case 'refunded':
                $status = 'Estornada';
                break;
            case 'waiting_payment':
                $status = 'Aguardando pagamento';
                break;
            case 'pending_refund':
                $status = 'Estorno boleto';
                break;
            case 'refused':
                $status = 'Recusado';
                break;
            case 'chargedback':
                $status = 'Chargeback';
                break;
            case 'analyzing':
                $status = 'Em análise';
                break;
            case 'pending_review':
                $status = 'Em revisão';
                break;
            default:
                $status = '';
        }

        return $status;
    }
}

if (!function_exists('get_payment_status_label')) {
    /**
     * Get status message
     *
     * @param  string  $status
     * @return string
     */
    function get_payment_status_label($status)
    {
        switch ($status) {
            case 'Aguardando pagamento':
            case 'Em análise':
            case 'Em revisão':
            case 'Em processo':
                $class = 'info';
                break;
            case 'Aprovado':
            case 'Autorizada':
                $class = 'success';
                break;
            case 'Estorno boleto':
            case 'Estornada':
                $class = 'warning';
                break;
            case 'Chargeback':
            case 'Recusado':
                $class = 'danger';
                break;
            default:
                $status = '';
                $class = '';
        }

        return "<span class='badge badge-{$class}'>{$status}</span>";
    }
}

if (!function_exists('get_payment_type')) {
    /**
     * Get payment type
     *
     * @param  string  $type
     * @return string
     */
    function get_payment_type($type)
    {
        switch ($type) {
            case 'credit_card':
                $payment_type = 'Cartão de crédito';
                break;
            case 'boleto':
                $payment_type = 'Boleto';
                break;
            default:
                $payment_type = '';
        }

        return $payment_type;
    }
}

if (!function_exists('numberFormatPrecision')) {
    /**
     * Number round hack
     *
     * @param $number
     * @param  int  $precision
     * @param  string  $separator
     * @param  string  $replace
     * @return string
     */
    function numberFormatPrecision($number, $precision = 2, $separator = '.', $replace = ',')
    {
        $numberParts = explode($separator, $number);
        $response = $numberParts[0];
        if (count($numberParts) > 1 && $precision > 0) {
            $response .= $replace;
            $response .= substr($numberParts[1], 0, $precision);
        }
        return $response;
    }
}

if (!function_exists('round_up')) {
    /**
     * @param $number
     * @param  int  $precision
     * @return string
     */
    function round_up($number, $precision = 2)
    {
        $fig = (int)str_pad('1', $precision, '0');
        $rounded = (ceil($number * $fig) / $fig);
        return number_format($rounded, 2, ',', '.');
    }
}

if (!function_exists('round_down')) {
    /**
     * @param $number
     * @param  int  $precision
     * @return string
     */
    function round_down($number, $precision = 2)
    {
        $fig = (int)str_pad('1', $precision, '0');
        $rounded = (floor($number * $fig) / $fig);
        return number_format($rounded, 2, ',', '.');
    }
}

if (!function_exists('format_phone')) {
    /**
     * @param $phone
     * @return mixed|string
     */
    function format_phone($phone)
    {
        $formatedPhone = preg_replace('/[^0-9]/', '', $phone);
        $matches = [];
        preg_match('/^([0-9]{2})([0-9]{4,5})([0-9]{4})$/', $formatedPhone, $matches);
        if ($matches) {
            return '('.$matches[1].') '.$matches[2].'-'.$matches[3];
        }

        return $phone;
    }
}

if (!function_exists('format_zipcode')) {
    /**
     * @param $zipcode
     * @return mixed|string
     */
    function format_zipcode($zipcode)
    {
        $formatedZipcode = preg_replace('/[^0-9]/', '', $zipcode);
        $matches = [];
        preg_match('/^([0-9]{5})([0-9]{3})$/', $formatedZipcode, $matches);
        if ($matches) {
            return $matches[1].'-'.$matches[2];
        }

        return $zipcode;
    }
}
