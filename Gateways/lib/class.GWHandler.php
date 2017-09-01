<?php
class GWHandler {
    public function __construct()
    {
        $this::loadLibClasses($this::scanLibClasses());
        $this::loadPlugins();
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

    public function scanPlugins()
    {
        $plugins_dir_files = scandir(GW_PLUG_DIR);
        $plugins_info = array();
        foreach ($plugins_dir_files as $key => $value)
        {
            if ( file_exists(GW_PLUG_DIR . '/' . $value . '/' . $value . '.php') ){
                array_push($plugins_info,array("name"=>$value,"filename"=>$value.'.php'));
            }
        }
        return $plugins_info;
    }

    public function loadPlugins()
    {
        $plugins_info = self::scanPlugins();
        foreach ($plugins_info as $key => $value)
        {
            require GW_PLUG_DIR.'/'.$value['name'].'/'.$value['filename'];
        }
        return true;
    }

    public function pluginAction($plugin_name,$action_name)
    {
        return call_user_func($plugin_name.'_'.$action_name);
    }
}