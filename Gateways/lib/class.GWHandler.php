<?php
class GWHandler {
    public function __construct()
    {
        $this::loadLibClasses($this::scanLibClasses());
    }

    public function scanLibClasses()
    {
        $lib_dir_files = scandir(GW_PATH . '/lib');
        $i = 0;
        $lib_dir_classes = array();
        foreach ($lib_dir_files as $key => $value)
        {
            if ( preg_match('/^class\..*\.php$/',$value) )
            {
                $lib_dir_classes[$i] = $value;
                $i += 1;
            }
        }
        return $lib_dir_classes;
    }

    public function loadLibClasses( $classes )
    {
        foreach ($classes as $class) {
            if ($class != 'class.GWHandler.php')
            {
                require GW_PATH . '/lib/' .$class;
            }
        }
        return true;
    }

    public function scanGatewayPlugins()
    {

    }
}