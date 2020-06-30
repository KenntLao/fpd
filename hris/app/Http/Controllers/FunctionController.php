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
            $string = substr($f, '-3');
            if ($string == '_id') {
                $data = ucfirst(str_replace("_id", '', $f));
            } else {
                $data = $f;
            }
            if( $f != 'created_at' && $f != 'updated_at' && $f != 'id') {
                if ( $model->getOriginal($f) != request($f) ) {
                    if ( $model->getOriginal($f) == '' ) {
                        if ( is_array(request($f)) ) {
                            $msg[] = '. '. $data .' updated to '.implode(",", request($f));
                        } else {
                            $msg[] = '. '. $data .' updated to '.request($f);
                        }
                    } elseif ( request($f) == '' ) {
                        if ( request('attachment') == '' ?? request('resume') == '' ?? request('profile_image') == '' ?? request('receipt') == '' ?? request('attachment_1') == '' ?? request('attachment_2') == '' ) {
                            $msg[] = '';
                        } else {
                            $msg[] = '. '. $data .' updated from '.$model->getOriginal($f).' to blank data';
                        }
                        
                    } else {
                        if ( is_array(request($f)) ) {
                            $msg[] = '. '. $data .' updated from '.$model->getOriginal($f).' to '.implode(",", request($f));
                        } else {
                            $msg[] = '. '. $data .' updated from '.$model->getOriginal($f).' to '.request($f);
                        }
                    }
                } else {
                    $msg[] = '';
                }
            }
        }
        $user = $_SESSION['sys_login_uname'];
        $account_mode = $_SESSION['sys_account_mode'];
        $datetime = date("Y/m/d H:i:s");
        if (count(array_unique($msg)) === 1 && end($msg) === '') {
            $description = $module.' ID: '.$id.' has been updated by '.$user.'. No changes.';
        } else {
            $description = $module.' ID: '.$id.' has been updated by '.$user.''.implode('', $msg).'.';
        }
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
