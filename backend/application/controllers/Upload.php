<?php

/**
 * 上传控制器
 */
class Upload extends MY_Controller
{

    public $uploadBasicPath = './uploads/';

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model("FilesData");
    }

    public function _createDir()
    {
        $date = date("Y-m-d");
        $path = $this->uploadBasicPath . $date;
        if (!is_dir($path)) {
            mkdir($path);
        }
        return $path . '/';
    }

    /**
     * 单个图片上传POST
     * 输出JSON
     */
    public function image()
    {
        $config['file_ext_tolower'] = true;
        $config['upload_path'] = $this->_createDir();
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '5000';
        $config['encrypt_name'] = true;
        $path = $data = $error = '';
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('image')) {
            $error = $this->upload->display_errors();
            $status = false;
        } else {
            $data = $this->upload->data();
            $date = date("Y-m-d");
            $path = str_replace('./', '/', $this->uploadBasicPath) . $date . '/' . $data['file_name'];
            $dataStr = array(
                'name' => $path,
                'sourcename' => $data['client_name']
            );
            $this->FilesData->addFile($data['file_name'], $data['client_name']);
            $status = true;
        }
        $name = $this->security->get_csrf_token_name();
        $hash = $this->security->get_csrf_hash();
        $json = array(
            'error' => strip_tags($error),
            'data' => $dataStr,
            'status' => $status,
            $name => $hash
        );
        echo json_encode($json);
    }

    /**
     * 多个图片上传POST
     * 输出JSON
     */
    public function images()
    {
        $name = $this->security->get_csrf_token_name();
        $hash = $this->security->get_csrf_hash();

        if (!isset($_FILES['imagesArray'])) {
            $json = array(
                'error' => "找不到您上传的文件，请重新上传",
                'data' => '',
                'status' => 'failed',
                $name => $hash
            );
            echo json_encode($json);
            die;
        }
        if ($this->usersystem->get('id') === null) {
            $json = array(
                'error' => "用户id没找到",
                'data' => '',
                'status' => 'failed',
                $name => $hash
            );
            echo json_encode($json);
            die;
        }
        $config['file_ext_tolower'] = true;
        $config['upload_path'] = $this->_createDir();
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '5000';
        $config['encrypt_name'] = true;
        $path = $data = $error = '';
        $this->load->library('upload', $config);

        $fileData = $this->_resetFilesArray('imagesArray');
        $dataStr = array();
        $error = array();
        $status = true;
        if (count($fileData) > 0) {
            foreach ($fileData as $k => $each) {
                $_FILES['each' . $k] = $each;
                if (!$this->upload->do_upload('each' . $k)) {
                    $error[] = $this->upload->display_errors();
                    $status = false;
                } else {
                    $data = $this->upload->data();
                    $date = date("Y-m-d");
                    $dataStr[] = array(
                        'name' => str_replace('./', '/', $this->uploadBasicPath) . $date . '/' . $data['file_name'],
                        'sourcename' => $data['client_name']
                    );
                    $this->FilesData->addFile($data['file_name'], $data['client_name']);
                }
            }
        }

        $json = array(
            'error' => strip_tags(implode("\n", $error)),
            'data' => $dataStr,
            'status' => $status,
            $name => $hash
        );
        echo json_encode($json);
    }

    public function _resetFilesArray($key)
    {

        $fileData = $_FILES[$key];
        $tmp = array();
        foreach ($fileData as $k => $v) {
            foreach ($v as $num => $v1) {
                $tmp[$num][$k] = $v1;
            }
        }
        return $tmp;
    }

    /**
     * 文件上传
     */
    public function file()
    {
        $config['file_ext_tolower'] = true;
        $config['upload_path'] = $this->_createDir();
        $config['allowed_types'] = 'gif|jpg|png|zip|rar|pdf|doc|docx|xls|xlsx|txt';
        $config['max_size'] = '50000';
        $config['encrypt_name'] = true;
        $dataStr = $path = $data = $error = '';
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('onefile')) {
            $error = $this->upload->display_errors();
            $status = false;
        } else {
            $data = $this->upload->data();
            $date = date("Y-m-d");
            $path = str_replace('./', '/', $this->uploadBasicPath) . $date . '/' . $data['file_name'];
            $dataStr = array(
                'name' => $path,
                'sourcename' => $data['client_name']
            );
            $this->FilesData->addFile($data['file_name'], $data['client_name']);
            $status = true;
        }
        $name = $this->security->get_csrf_token_name();
        $hash = $this->security->get_csrf_hash();
        $json = array(
            'error' => strip_tags($error),
            'data' => $dataStr,
            'status' => $status,
            $name => $hash
        );
        echo json_encode($json);
    }

    public function files()
    {
        try {
            $name = $this->security->get_csrf_token_name();
            $hash = $this->security->get_csrf_hash();
            if (!isset($_FILES['filesArray'])) {
                $json = array(
                    'error' => "找不到您上传的文件，请重新上传",
                    'data' => '',
                    'status' => false,
                    $name => $hash
                );
            }
            $config['file_ext_tolower'] = true;
            $config['upload_path'] = $this->_createDir();
            $config['allowed_types'] = 'gif|jpg|png|zip|rar|pdf|doc|docx|xls|xlsx|lnk|txt';
            $config['max_size'] = '5000';
            $config['encrypt_name'] = true;
            $path = $data = $error = '';
            $this->load->library('upload', $config);
            $this->upload->display_errors('', '<br/>');
            $fileData = $this->_resetFilesArray('filesArray');
            $dataStr = array();
            $error = array();
            $status = true;
            if (count($fileData) > 0) {
                foreach ($fileData as $k => $each) {
                    $_FILES['each' . $k] = $each;
                    if (!$this->upload->do_upload('each' . $k)) {
                        $error[] = $this->upload->display_errors();
                        $status = false;
                    } else {
                        $data = $this->upload->data();
                        $date = date("Y-m-d");
                        $dataStr[] = array(
                            'name' => str_replace('./', '/', $this->uploadBasicPath) . $date . '/' . $data['file_name'],
                            'sourcename' => $data['client_name']
                        );
                        $this->FilesData->addFile($data['file_name'], $data['client_name']);
                    }
                }
            }

            $json = array(
                'error' => implode("\n", $error),
                'data' => $dataStr,
                'status' => $status,
                $name => $hash
            );
            echo json_encode($json);
        } catch (Exception $e) {
            echo $e;
        }
    }

    public function doUpload()
    {
        $config['upload_path'] = '/uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '100';
        $config['max_width'] = '1024';
        $config['max_height'] = '768';
        $this->load->library('upload', $config);
    }

    public function index()
    {
        $this->load->view('upload/upload_form', array('error' => ' '));
    }

    public function do_upload()
    {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 100;
        $config['max_width'] = 1024;
        $config['max_height'] = 768;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('imagesArray')) {
            $error = array('error' => $this->upload->display_errors());

            $this->load->view('upload/upload_form', $error);
        } else {
            $data = array('upload_data' => $this->upload->data());

            $this->load->view('upload/upload_success', $data);
        }
    }

    /*
    public function test(){
        ob_start();
        echo "<pre>";
        var_dump($_POST);
        var_dump($_FILES);
        $input = file_get_contents("php://input");
        file_put_contents(APPPATH.'/cache/input.jpg',$input);
        if(count($_POST)>0){
            foreach($_POST as $k=>$v){
                $byte=$v;
                $byte = str_replace(' ','',$byte);   //处理数据
                $byte = str_ireplace("<",'',$byte);
                $byte = str_ireplace(">",'',$byte);
                $byte=pack("H*",$byte);      //16进制转换成二进制
                file_put_contents(APPPATH.'/cache/'.$k.'.jpg',$byte);//写入文件中！

            }
        }
        echo "</pre>";
        $info=ob_get_contents();
        file_put_contents(APPPATH.'/cache/text.txt',$info);
        ob_end_flush();
    }

    public function test2(){
        echo file_get_contents(APPPATH.'/cache/text.txt');
    }
    */


}

?>