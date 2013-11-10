<?php

namespace app\tests\cases\extensions\helper;

use app\extensions\helper\Uploader;

class UploaderTest extends \lithium\test\Unit {

	private $_uploader;
	private $_jpgFile;
	private $_txtFile;
	private $_info;

	public function setUp() {

		$this->_uploader = new Uploader();
        $this->_jpgFile = LITHIUM_APP_PATH.'\resources\tmp\jpgFile.jpg';
        $this->_txtFile = LITHIUM_APP_PATH.'\resources\tmp\txtFIle.jpg';
        $this->_info = pathinfo($this->_jpgFile);
	}

	public function tearDown() {

		$file = $this->_uploader->uploadPath($this->_info['basename'], 'products');
		$file = str_replace(['/','\\'], DS, $file);
		if(file_exists($file)) @unlink($file);
	}

	public function testFileType() {

		$type = $this->_uploader->fileType($this->_jpgFile);
		$this->assertEqual('jpg', $type);

		$type = $this->_uploader->fileType($this->_txtFile);
		$this->assertEqual('UNKOWN IMAGE TYPE', $type);
	}

	public function testUploadPath() {

		$file = $this->_uploader->uploadPath($this->_info['basename'], 'products');
		$this->assertTrue(is_dir(pathinfo($file)['dirname']));
	}

	public function testUpload() {

		$file = $this->_uploader->uploadPath($this->_info['basename'], 'products');
		$this->assertTrue(copy($this->_jpgFile, $file));
		$this->assertTrue(file_exists($file));
	}
}
