<?php
/*delete the files in the folder, cannot delete the directories in the folder*/
function deleteFiles($dirPath)
{

    if(substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
        $dirPath .= '/';
    }

    $files = glob($dirPath . '*');

    foreach($files as $file) {
        if(is_file($file))
            unlink($file);
    }
}
//deleteFiles('directory_to_delete');

/*delete a folder and everything in the folder*/
function deleteDir($dirPath)
{
    if(! is_dir($dirPath)) {
        throw new InvalidArgumentException("$dirPath must be a directory");
    }

    if(substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
        $dirPath .= '/';
    }

    $files = glob($dirPath . '*', GLOB_MARK);
    foreach($files as $file) {
        if(is_dir($file)) {
            deleteDir($file);
        } else {
            unlink($file);
        }
    }

    rmdir($dirPath);//delete the empty directories in the dirctory to delete
}
deleteDir('directory_to_delete');