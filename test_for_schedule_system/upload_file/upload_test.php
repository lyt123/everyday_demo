<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<?php echo $_SERVER['DOCUMENT_ROOT']?>
<form method="post" action=<?php echo $_SERVER['DOCUMENT_ROOT']?>"/scheduleSystem/Admin/Course/importCourseExcel">
    <input type="file" >
    <input type="submit" value="提交">
</form>
</body>
</html>