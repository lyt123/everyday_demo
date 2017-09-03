<?php
/* User:lyt123; Date:2017/2/26; QQ:1067081452 */

/**
 * 规范独立对象和组合对象必须实现的方法，保证它们提供给客户端统一的
 * 访问方式
 */
abstract class Filesystem
{
    protected $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public abstract function getName();
    public abstract function getSize();
}

/**
 * 目录类
 */
class Dir extends Filesystem
{
    private $filesystems = [];

    // 组合对象必须实现添加方法。因为传入参数规定为Filesystem类型，
    // 所以目录和文件都能添加
    public function add(Filesystem $filesystem)
    {
        $key = array_search($filesystem, $this->filesystems);
        if ($key === false) {
            $this->filesystems[] = $filesystem;
        }
    }

    // 组合对象必须实现移除方法
    public function remove(Filesystem $filesystem)
    {
        $key = array_search($filesystem, $this->filesystems);
        if ($key !== false) {
            unset($this->filesystems[$key]);
        }
    }

    public function getName()
    {
        return '目录：' . $this->name;
    }

    public function getSize()
    {
        $size = 0;
        foreach ($this->filesystems as $filesystem) {
            $size += $filesystem->getSize();
        }

        return $size;
    }
}

/**
 * 独立对象：文本文件类
 */
class TextFile extends Filesystem
{
    public function getName()
    {
        return '文本文件：' . $this->name;
    }

    public function getSize()
    {
        return 10;
    }
}

/**
 * 独立对象2：图片文件类
 */
class ImageFile extends Filesystem
{
    public function getName()
    {
        return '图片：' . $this->name;
    }

    public function getSize()
    {
        return 100;
    }
}

/**
 * 独立对象：视频文件类
 */
class VideoFile extends Filesystem
{
    public function getName()
    {
        return '视频：'. $this->name;
    }

    public function getSize()
    {
        return 200;
    }
}

// 创建home目录，并加入三个文件
$dir = new Dir('home');
$dir->add(new TextFile('text1.txt'));
$dir->add(new ImageFile('bg1.png'));
$dir->add(new VideoFile('film1.mp4'));

// 在home下创建子目录source
$subDir = new Dir('source');
$dir->add($subDir);

// 创建一个text2.txt，并放到子目录source中
$text2 = new TextFile('text2.txt');
$subDir->add($text2);

// 打印信息
echo $text2->getName(), '-->', $text2->getSize();
echo '<br />';
echo $subDir->getName(), ' --> ',$subDir->getSize();
echo '<br />';
echo $dir->getName(), ' --> ', $dir->getSize();
//when count the size of $subDir, foreach the $subDir