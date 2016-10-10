<?php
/* upload single picture */
if(!empty($_FILES['picture']) && is_uploaded_file($_FILES['picture']['tmp_name'])) {
    $uploaded_file = $_FILES['picture']['tmp_name'];
    $move_to_file = $_SERVER['DOCUMENT_ROOT'].'/everyday_demo/upload_picture/picture/'.$_FILES['picture']['name'];

    if(move_uploaded_file($uploaded_file, iconv("utf-8", "gb2312", $move_to_file))) {
        /*
         * iconv() to enable file name to chinese
         * move_uploaded_file() to move uploaded file from 'E:\wamp64\tmp\phpDC53.tmp'
         * to 'E:/wamp64/www1/everyday_demo/upload_picture/picture/1.jpg'
        */
        var_dump('nice');
    }
}

/* upload multiple photo */
if(!empty($_FILES['photo'])) {
    $photo_sum = count($_FILES['photo']['name']);

    for($i = 0; $i < $photo_sum; $i++) {
        /* foreach cannot be used here, echo $_FILES['photo'] will validate my idea
        */
        $uploaded_file = $_FILES['photo']['tmp_name'][$i];
        $move_to_file = $_SERVER['DOCUMENT_ROOT'].'/everyday_demo/upload_picture/photo/'.$_FILES['photo']['name'][$i];

        if(move_uploaded_file($uploaded_file, iconv("utf-8", "gb2312", $move_to_file))) {
            var_dump('nice');
        }
    }
} else {
    var_dump('no file uploaded or system error');
}

//tips : the picture sizes and types can also be restricted