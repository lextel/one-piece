<?php

namespace app\extensions\helper;

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

        $dirs = explode(DS, $dir);
        $dir = '';
        foreach($dirs as $d) {
            $dir .= $d . DS;
            if(!is_dir($dir)) {
                @mkdir($dir);
            }
        }

        @chmod($dir, 0755);

        return $dir . $filename;
    }

    /**
     * 上传文件
     *
     * @param: $file        array           文件数组
     * @param: $targetname  string          存放文件名
     * @param: $filetype    array|string    验证文件类型
     *
     * @return array
     */
    public function upload($file, $typeDir, $fileType='') {

        $error = $this->errorHandler($file, $fileType);

        if(empty($error)) {
            $name = $file['name'];
            $filename = $file['tmp_name'];
            $dir = $this->uploadPath($name, $typeDir);
            $result = move_uploaded_file($filename, $dir);

            if(!$result) {
                $error = '上传失败';
            } else {
                $dir = str_replace(UPLOAD_PATH, '', $dir);
                $dir = '/images' . str_replace(DS, '/', $dir);
            }
        }
   
        return $error ? ['status' => false, 'data' => $error] : ['status' => true, 'data' => $dir];
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
