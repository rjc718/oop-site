<?php 
namespace Haskris\Base\Models;

use Exception;

class Database
{  
    public const COMMON_DB = 'COMMON';
    public const HC1_DB    = 'HC1';
    public const PLA_DB    = 'PLA';
    public const TEST_DB   = 'TEST';

    private static ?Database $instance = null;
    
    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function fetchFromGlobalShop(
        string $sql, 
        bool $assoc = false,
        string $code = self::HC1_DB 
    )
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://gssapi.haskris1.local/get',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_POSTFIELDS => array(
                'auth' => '$2y$10$o4OdEqahnn.uJOvA.SWEv.cf.gyjkjvACw4QDTRSt12yQ1A2Bfg.a',
                'code' => $code,
                'sql' => $sql
            ),
        ));

        $response = curl_exec($curl);

        if ($response === false) {
            throw new Exception('Curl error: ' . curl_error($curl));
        }

        curl_close($curl);

        //Returns object by default unless assoc is true
        $data = json_decode($response, $assoc);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('JSON decode error: ' . json_last_error_msg());
        }

        return $data;
    }

    public function sayHi(): string
    {
        return '<p>Hello World</p>';
    }
}
