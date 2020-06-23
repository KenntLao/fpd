<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\hris_system_logs;

class FunctionController extends Controller
{

    public function systemLog($module,$action,$id)
    {
        $user = $_SESSION['sys_login_uname'];
        $account_mode = $_SESSION['sys_account_mode'];
        $datetime = date("Y/m/d H:i:s");
        if ( $action == 'add' ) {
            $description = $module.' ID: '.$id.' has been added by '.$user.'.';
        }
        if ( $action == 'delete' ) {
            $description = $module.' ID: '.$id.' has been deleted by '.$user.'.';
        }
        $systemLog = new hris_system_logs();
        $systemLog->user = $user;
        $systemLog->account_mode = $account_mode;
        $systemLog->action = $action;
        $systemLog->description = $description;
        $systemLog->log_date_time = $datetime;
        $systemLog->save();
    }
    public function updateSystemLog($model,$module,$id)
    {
        //CREATE ARRAY MSG FOR UPDATED FIELDS
        $msg = array();
        //GET COLUMN FIELDS
        $field = array_keys($model->getAttributes());
        foreach ($field as $f) {
            if( $f != 'created_at' && $f != 'updated_at' && $f != 'id' && $f != 'resume' && $f != 'profile_image' && $f != 'attachment' && $f != 'receipt' && $f != 'attachment_1' && $f != 'attachment_2') {
                if ( $model->getOriginal($f) != request($f) ) {
                    if ( $model->getOriginal($f) == '' ) {
                        if ( is_array(request($f)) ) {
                            $msg[] = '. Updated blank data to '.implode(",", request($f));
                        } else {
                            $msg[] = '. Updated blank data to '.request($f);
                        }
                    } elseif ( request($f) == '' ) {
                        $msg[] = '. Updated '.$model->getOriginal($f).' to blank data';
                    } else {
                        if ( is_array(request($f)) ) {
                            $msg[] = '. Updated '.$model->getOriginal($f).' to '.implode(",", request($f));
                        } else {
                            $msg[] = '. Updated '.$model->getOriginal($f).' to '.request($f);
                        }
                    }
                }
            }
        }
        $user = $_SESSION['sys_login_uname'];
        $account_mode = $_SESSION['sys_account_mode'];
        $datetime = date("Y/m/d H:i:s");
        $description = $module.' ID: '.$id.' has been updated by '.$user.''.implode("", $msg).'.';
        $systemLog = new hris_system_logs();
        $systemLog->user = $user;
        $systemLog->account_mode = $account_mode;
        $systemLog->action = 'update';
        $systemLog->description = $description;
        $systemLog->log_date_time = $datetime;
        $systemLog->save();
    }


    public function decryptStr($str) {
        $key = '4507';
        $c = base64_decode($str);
        $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
        $iv = substr($c,0,$ivlen);
        $hmac = substr($c,$ivlen,$sha2len=32);
        $ciphertext_raw = substr($c,$ivlen+$sha2len);
        $original_plaintext = openssl_decrypt($ciphertext_raw,$cipher,$key,$options=OPENSSL_RAW_DATA,$iv);
        $calcmac = hash_hmac('sha256',$ciphertext_raw,$key,$as_binary=true);
        
        if (hash_equals($hmac,$calcmac)) { 
            return $original_plaintext; 
        }
    }
    
}
