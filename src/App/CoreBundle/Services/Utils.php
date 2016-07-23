<?php

namespace App\CoreBundle\Services;


class Utils
{
    /**
     * @param array $dirs
     * @return array
     */
    public function getBundlesList(array $dirs = ['src/App'])
    {
        $folders = array();
        foreach ($dirs as $dir) {
            $currentDirectory = getcwd();
            if (false !== strpos($currentDirectory, 'web')){
                $dir = '../' . $dir;
            }
            if (is_dir($dir)) {
                $subDir = scandir($dir);
                foreach ($subDir as $folder) {
                    if (strpos($folder, '.') === false && is_dir($dir.DIRECTORY_SEPARATOR.$folder)) {
                        $folders[] = $folder;
                    }
                }
            }
        }
        return $folders;
    }
}