<?php
/* User:lyt123; Date:2017/2/26; QQ:1067081452 */
abstract class File
{
    abstract function getSize();
}

class TextFile extends File
{
    public function getSize()
    {
        return 2;
    }
}

class ImageFile extends File
{
    public function getSize()
    {
        return 100;
    }
}
class Dir
{
    private $files = [];

    // 传入参数必须为File文件对象
    public function addFile(File $file)
    {
        $this->files[] = $file;
    }

    public function getSize()
    {
        $size = 0;
        foreach ($this->files as $file) {
            $size += $file->getSize();
        }

        return $size;
    }
}
class NewDir
{
    private $files = [];
    private $dirs = [];

    public function addFile(File $file)
    {
        $this->files[] = $file;
    }

    public function addDir(NewDir $newDir) {
        $this->dirs = $newDir;
    }

    public function getSize()
    {
        $size = 0;
        foreach ($this->files as $file) {
            $size += $file->getSize();
        }

        foreach ($this->dirs as $dir) {
            $size += $dir->getSize();
        }

        return $size;
    }
}