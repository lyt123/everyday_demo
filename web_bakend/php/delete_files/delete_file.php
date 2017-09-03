<?php
/*delete the files in the folder, cannot delete the directories in the folder*/
function deleteFiles($dirPath)
{
    //add a slash to the end of path if not exist
    if(substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
        $dirPath .= '/';
    }

    //gets all the path in $dirPath
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
            //delete recursively
            deleteDir($file);
        } else {
            unlink($file);
        }
    }

    //delete the empty directories in the dirctory to delete
    rmdir($dirPath);
}

//call the function
deleteDir('directory_to_delete');
