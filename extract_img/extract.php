<?php
$html = file_get_contents('page_to_extract.html');
preg_match_all('/<img[^>]+>/i', $html, $result);

$img = array();
foreach ($result[0] as $img_tag)
{
    preg_match_all('/(alt|title|src)=("[^"]*")/i', $img_tag, $img[$img_tag]);
}
//now I extract img, title, and alt tag from the html

//print_r($result);
/*
output :
Array
(
    [0] => Array
        (
            [0] => <img src="./images/1.GIF" title="test" alt="haha"/>
            [1] => <img src="aa.jpg" title="hah" alt="heh">
        )
)
*/

//print_r($img);
/*
output :
Array
(
    [<img src="./images/1.GIF" title="test" alt="haha"/>] => Array
        (
            [0] => Array
                (
                    [0] => src="./images/1.GIF"
                    [1] => title="test"
                    [2] => alt="haha"
                )

            [1] => Array
                (
                    [0] => src
                    [1] => title
                    [2] => alt
                )

            [2] => Array
                (
                    [0] => "./images/1.GIF"
                    [1] => "test"
                    [2] => "haha"
                )

        )

    [<img src="aa.jpg" title="hah" alt="heh">] => Array
        (
            [0] => Array
                (
                    [0] => src="aa.jpg"
                    [1] => title="hah"
                    [2] => alt="heh"
                )

            [1] => Array
                (
                    [0] => src
                    [1] => title
                    [2] => alt
                )

            [2] => Array
                (
                    [0] => "aa.jpg"
                    [1] => "hah"
                    [2] => "heh"
                )

        )

)
*/
