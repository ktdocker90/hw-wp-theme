<?php
/**
 * Class HW_File_Directory
 */
class HW_File_Directory {
    /**
     * Applies dirname() multiple times.
     * @author Jorge Orpinel <jorge@orpinel.com>
     *
     * @param string $path file/directory path to beggin at
     * @param number $depth number of times to apply dirname(), 2 by default
     *
     * @todo validate params
     */
    static function dirname2( $path, $depth = 2 ) {

        for( $d=1 ; $d <= $depth ; $d++ )
            $path = dirname( $path );

        return $path;
    }
    /**
     * list folders in folder
     * @param $path
     * @return array
     */
    public static  function list_folders($path) {
        #$path = dirname(dirname(__FILE__)). '/uploader/images';
        $results = scandir($path);
        $groups = array();
        foreach ($results as $result) {
            if ($result === '.' or $result === '..') continue;

            if (is_dir($path . '/' . $result)) {
                //code to use if directory
                $groups[$path . '/' . $result] = $result;
            }
        }
        return $groups;
    }

    /**
     * delete recursively a tree.
     * @param $dir
     * @return bool
     */
    public function delTree($dir) {
        if(! is_dir($dir)) return ;
        //Glob function doesn't return the hidden files, therefore scandir can be more useful
        $files = array_diff(scandir($dir), array('.','..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? $this->delTree("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }

    /**
     * removes any contents of a Directory but not the target Directory itself
     * helpful if you want to clean a BackupDirectory or Log.
     * @param $path
     * @return bool
     */
    public function deleteContent($path){
        try{
            $iterator = new DirectoryIterator($path);
            foreach ( $iterator as $fileinfo ) {
                if($fileinfo->isDot())continue;
                if($fileinfo->isDir()){
                    if($this->deleteContent($fileinfo->getPathname()))
                        @rmdir($fileinfo->getPathname());
                }
                if($fileinfo->isFile()){
                    @unlink($fileinfo->getPathname());
                }
            }
        } catch ( Exception $e ){
            // write log
            return false;
        }
        return true;
    }

    /**
     * Copy entire contents of a directory to another
     * @param $src
     * @param $dst
     */
    public function recurse_copy($src,$dst) {
        $dir = opendir($src);
        @mkdir($dst);
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . '/' . $file) ) {
                    $this->recurse_copy($src . '/' . $file,$dst . '/' . $file);
                }
                else {
                    copy($src . '/' . $file,$dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }

    /**
     * @param $name
     * @return bool
     */
    public static function has_extension($name) {
        return self::getExtension($name)? true: false;
    }
    /**
     * @param $pattern
     * @param int $flags
     * @return array
     */
    public static function glob_recursive($pattern, $flags = 0)
    {
        $files = glob($pattern, $flags);
        foreach (glob(dirname($pattern).'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir)
        {
            $files = array_merge($files, self::glob_recursive(rtrim($dir, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR .basename($pattern), $flags));
        }
        return $files;
    }
    /**
     * list all files in folder
     * @param $path
     */
    public static function list_files_in_folder($path) {
        $dh  = opendir($path);
        $files = array();
        while (false !== ($filename = readdir($dh))) {
            $files[] = $filename;
        }
        return $files ;
    }

    /**
     * generate path string using this method
     * @return string
     */
    public static function generate_path() {
        $paths = func_get_args();
        $str = '';
        if(class_exists('hwArray') && hwArray::is_multi($paths)) $paths = $paths[0];
        foreach($paths as $path) {
            # ltrim(trim($path),'\/') -> wrong because linux start with /home
            $str .= trim($path). DIRECTORY_SEPARATOR;
        }
        //wrong for http schema http://
        $str = preg_replace('%[\\\]+%', '\\', $str);
        $str = preg_replace('%[/]+%', '/', $str);
        //fix for http://
        if(strpos($str, 'http:/') ===0 || !strpos($str, 'http://') !==0 ) {
            $str = preg_replace('%^http:/%', 'http://', trim($str));
        }
        if(strpos($str, 'https:/') ===0 || !strpos($str, 'https://') !==0 ) {
            $str = preg_replace('%^https:/%', 'https://', trim($str));
        }
        return $str;
    }

    /**
     * generate url
     * @return string
     */
    public static function generate_url() {
        $paths = func_get_args();
        $str = '';
        if(class_exists('hwArray') && hwArray::is_multi($paths)) $paths = $paths[0];
        foreach($paths as $path) {
            if(trim($path) === '') continue;
            $str .= ltrim(trim($path),'\/'). '/';
        }
        //wrong for http schema http://
        $str = preg_replace('%[\\\]+%', '\\', $str);
        $str = preg_replace('%[/]+%', '/', $str);
        $str = rtrim($str, '\/');
        //fix for http://
        if(strpos($str, 'http:/') ===0 || !strpos($str, 'http://') !==0 ) {
            $str = preg_replace('%^http:/%', 'http://', trim($str));
        }
        if(strpos($str, 'https:/') ===0 || !strpos($str, 'https://') !==0 ) {
            $str = preg_replace('%^https:/%', 'https://', trim($str));
        }
        return $str;
    }

    /**
     * @param $file
     * @return string
     */
    public static function split_filename($file) {
        if(file_exists($file)) $file = basename($file);
        $pos = strrpos($file, '.');
        if ($pos === false)
        { // dot is not found in the filename
            return array($file, ''); // no extension
        }
        else
        {
            $basename = substr($file, 0, $pos);
            $extension = substr($file, $pos+1);
            return array($basename, $extension);
        }
    }

    /**
     * get file extension
     * @param $file
     * @return string
     */
    static function getExtension($file) {
        $pos = strrpos($file, '.');
        return substr($file, $pos+1);
    }

    /**
     * get file name without extension
     * @param $file
     * @return mixed
     */
    static function get_filename_withoutExt($file) {
        return preg_replace('/\\.[^.\\s]{3,4}$/', '', $file);
    }
}