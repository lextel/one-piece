<?php
/**
 * 上传工具
 *
 * @author weelion<weelion@qq.com>
 * @version 1.0
 */
namespace app\extensions\helper;

use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Imagine\Gd\Imagine;

class Uploader {

    /**
     * 获取文件类型
     *
     * @param: $filename string 文件名
     *
     * @return string 文件类型
     */
    public function fileType($filename) {

        $type = exif_imagetype($filename);

        switch ($type){
            case IMAGETYPE_PNG:
                 $fileType = 'png';
                 break;
            case IMAGETYPE_GIF:
                 $fileType = 'gif';
                 break;
            case IMAGETYPE_JPEG:
                 $fileType = 'jpg';
                 break;
            default:
                 $fileType = "UNKOWN IMAGE TYPE";
                 break;
        }

        return $fileType;
    }

    /**
     * 上传目录
     *
     * @param: $filename string       文件名
     * @param: $dirType  string       类型(products,shares)
     * @param: $size     array|string 生成大小
     * 
     * @return string
     */
    public function uploadPath($filename, $dirType) {

        $md5 = MD5($filename);
        $firstDir  = substr($md5, 0, 1);
        $secondDir = substr($md5, 1, 1);

        $dir = UPLOAD_PATH . DS . $dirType . DS .$firstDir . DS . $secondDir;

        $dir = $this->_createPath($dir);

        return $dir . $filename;
    }



    /**
     * 上传文件
     *
     * @param: $file        array           文件数组
     * @param: $typeDir     string          存放文件夹
     * @param: $fileType    array|string    验证文件类型
     *
     * @return array
     */
    public function upload($file, $typeDir, $fileType='') {

        $error = $this->errorHandler($file, $fileType);

        if(empty($error)) {
            $name = $file['name'];
            $filename = $file['tmp_name'];
            $path = $this->uploadPath($name, $typeDir);
            $result = move_uploaded_file($filename, $path);

            // 生成缩略图
            $this->thumbnail($typeDir, $path);

            if(!$result) {
                $error = '上传失败';
            } else {
                $path = str_replace(UPLOAD_PATH, '', $path);
                $path = '/images' . str_replace(DS, '/', $path);
            }
        }
   
        return $error ? ['status' => false, 'data' => $error] : ['status' => true, 'data' => $path];
    }

    /**
     * 生成缩略图
     *
     * @param: $typeDir string 存放文件夹
     * @param: $path     string 服务器路径
     *
     * @return void
     */
    public function thumbnail($typeDir, $path) {

        if(file_exists($path)) {
            $imagine = new Imagine();

            switch ($typeDir) {
                case 'products':
                    $newPath = $this->_thumbPath($path, $typeDir, '200x200');

                    $image = $imagine->open($path);
                    $image->resize(new Box(200, 200));
                    $image->save($newPath);

                    $newPath = $this->_thumbPath($path, $typeDir, '400x400');
                    $image = $imagine->open($path);
                    $image->resize(new Box(400, 400));
                    $image->save($newPath);

                    break;
                case 'shares':
                    $newPath = $this->_thumbPath($path, $typeDir, '200');
                    $image = $imagine->open($path);
                    $image->resize($image->getSize()->widen( 200 ));
                    $image->save($newPath);

                    break;
                
                default:
                    # code...
                    break;
            }
        }
    }

    /**
     * 缩略图路径
     *
     * @param $path     string 原图目录
     * @param $typeDir string 存放文件夹
     * @param $size    string 尺寸
     * 
     * @return string 
     */
    private function _thumbPath($path, $typeDir, $size) {

        $info = pathinfo($path);

        $newDir = str_replace($typeDir, $typeDir. DS . $size, $info['dirname']);
        $newDir = $this->_createPath($newDir);

        return $newDir . $info['basename'];
    }

    /**
     * 自动创建文件夹
     *
     * @param $dir string 文件夹
     *
     * @return string
     */
    private function _createPath($dir) {

        $dirs = explode(DS, $dir);
        $dir = '';
        foreach($dirs as $d) {
            $dir .= $d . DS;
            if(!is_dir($dir)) {
                @mkdir($dir);
            }
        }

        @chmod($dir, 0755);

        return $dir;
    }


    /**
     * 错误处理
     *
     * @param: $file array 上传文件
     *
     * @return string
     */
    public function errorHandler($file, $fileType) {

        // 文件大小错误
        if(empty($file['size'])) return '文件没有内容';

        $error_id = $file['error'];

        // 上传过程错误
        $error = '';
        switch ($error_id) {
            case '1':
                $error ='文件超过服务器限制';
                break;
            case '2':
                $error = '文件超过浏览器限制';
                break;
            case '3':
                $error = '文件没有上传完成';
                break;
            case '4':
                $error = '文件没有被上传';
                break;
        }

        // 上传类型错误
        if(empty($error) && $fileType) {
            $filename = $file['tmp_name'];
            $type = $this->fileType($filename);
            if(is_array($fileType) && !in_array($type, $fileType)) {
                $error = '支持的文件类型有jpg,png,gif';
            }

            if(is_string($fileType) && $type != $fileType) {
                $error = '支持的文件类型有jpg,png,gif';
            }
        }

        return $error;
    }



}
