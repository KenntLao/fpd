<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\hris_system_logs;

class SystemLogController extends Controller
{
	public function index() 
	{
        $logs = hris_system_logs::orderBy('created_at','desc')->paginate(30);
		return view('pages.admin.auditLog.index', compact('logs'));
	}
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
}
