<?php

class _Config
{

    const ML_SUPPORT_PATH = "lib/ml-support/ml-support.ini";

    const MIN_PASSWORD_LENGTH = 6;

    protected static $instance;

    protected $db;

    protected $ml_support;

    protected function __construct()
    {
        session_start();

        $this->init();
        $this->ml_support = parse_ini_file(self::ML_SUPPORT_PATH, TRUE, INI_SCANNER_RAW);
    }

    protected function init()
    {
        throw new Exception("init funtion is not implement.");
    }

    public function update_ml_support()
    {
        $out = '';
        foreach ($this->ml_support as $group => $entrys) {
            ksort($entrys);
            if (is_array($entrys)) {
                $out .= "[" . $group . "]\n";
                foreach ($entrys as $key => $value) {
                    $out .= $key . ' = ' . $value . "\n";
                }
            }
        }
        file_put_contents(self::ML_SUPPORT_PATH, $out, FILE_USE_INCLUDE_PATH);
        // Tools::debug($out);
    }

    public function get_db()
    {
        return $this->db;
    }

    public function &get_ml_support()
    {
        return $this->ml_support;
    }
}
