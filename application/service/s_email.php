<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by Tim.
 * User: Tim
 * Date: 2015/10/10
 * Time: 9:16
 * 也可以在model中扩展
 */

class s_email extends CI_Service{

    private $subject;

    public function __construct(){
    }

    public function sendEmail($info,$template)
    {
        //加载CI的email类
        $this->load->library('email');
        //以下设置Email参数
        $config=$this->config->item('email');
        $this->email->initialize($config);
        $this->email->from($config['smtp_user'], 'Email Service');

        //以下设置Email内容
        //$this->email->reply_to('email@email.com','Email Service');
        $T = self::parseTemplate($info,$template);
        $this->email->to($info['to'],$info['user_name']);
        $this->email->subject($this->subject);
        $this->email->message($T);
        //$this->email->attach('application\controllers\1.jpeg');			//相对于index.php的路径

        if( $this->email->send()){
            return Constant::SUCCESS;
        }
        //echo $this->email->print_debugger();		//返回包含邮件内容的字符串，包括EMAIL头和EMAIL正文。用于调试。

        file_put_contents('./SendEmailLog.txt',$this->email->print_debugger(),FILE_APPEND);

        return Constant::SEND_EMAIL_ERROR;
    }

    private function parseTemplate($info,$template){
        foreach($info as $key=>$val){
            $this->cismarty->assign($key,$val);
        }
        $this->subject = $template['subject'];
//        switch($template){
//            case "forget_password":
//                $template = 'email/forget_password.html';
//                break;
//            case "":
//                break;
//            default :
//                $template = '';
//                break;
//        }
        return $this->cismarty->display2($template['email']);
    }
}