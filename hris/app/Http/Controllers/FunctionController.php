<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\hris_system_logs;

class FunctionController extends Controller
{

    private $old_id;
    private $new_id;
    private $old_string;
    private $new_string;
    private $old_emp;
    private $new_emp;
    private $old_dep;
    private $new_dep;

    public function addSystemLog($module,$id)
    {
        $user = $_SESSION['sys_login_uname'];
        $datetime = date("Y/m/d H:i:s");
        $systemLog = new hris_system_logs();
        $systemLog->user = $user;
        $systemLog->module = $module;
        $systemLog->action = 'add';
        $systemLog->action_id = $id;
        $systemLog->log_date_time = $datetime;
        $systemLog->save();
    }

    public function getOldData($module,$string,$changes,$id)
    {
        $model = $string::find($id);
        $field = array_keys($model->getAttributes());
        if ( $changes ) {
            foreach ($field as $f) {
                if (  $f != 'created_at' && $f != 'updated_at' && $f != 'id' ) {
                    if ( substr($f, -3) == '_id' ) {
                        $data = str_replace('_id', '', $f);
                        if ( $data != 'employee' AND $data != 'supervisor' AND $data != 'department') {
                            if ( $model->$data != NULL ) {
                                $old_id[] = $model->$data->name;
                                $i[] = $f;
                                $this->old_id = array_combine($i,array_values($old_id));
                            } else {
                                $old_id[] = '';
                                $i[] = $f;
                                $this->old_id = array_combine($i,array_values($old_id));
                            }
                                
                        } else {
                            if ( $data == 'employee' ) {
                                $employees = \App\hris_employee::whereIn('id', explode(',', $model->employee_id))->get();
                                $old_employee = array();
                                if ( $employees == NULL ) {
                                    $this->old_emp = '';
                                } else {
                                    foreach ($employees as $employee) {
                                        $old_employee[] = $employee->firstname.' '.$employee->lastname;
                                    }
                                    $this->old_emp = implode(', ', $old_employee);
                                }
                            }
                            if ( $data == 'department' ) {
                                $departments = \App\hris_company_structures::whereIn('id', explode(',', $model->department_id))->get();
                                $old_department = array();
                                if ( $departments == NULL ) {
                                    $this->old_dep = '';
                                } else {
                                    foreach ($departments as $department) {
                                        $old_department[] = $department->name;
                                    }
                                    $this->old_dep = implode(', ', $old_department);
                                }
                            }
                        }
                    } else {
                        $index[] = $f;
                        $arr[] = $model->getOriginal($f);
                        $this->old_string = array_combine($index,array_values($arr)); 
                    }
                }
            }
        }
    }

    public function updateSystemLog($module,$changed,$string,$id)
    {
        $user = $_SESSION['sys_login_uname'];
        $datetime = date("Y/m/d H:i:s");
        $model = $string::find($id);
        $field = array_keys($model->getAttributes());
        if ( $changed ) {
            foreach ($field as $f) {
                if (  $f != 'created_at' && $f != 'updated_at' && $f != 'id' ) {
                    if ( empty($changed[$f]) ) {
                        if ( substr($f, -3) == '_id' ) {
                            $data = str_replace('_id', '', $f);
                            if (preg_match('/^[a-z]+_[a-z]+$/i', $data)) {
                                $name = str_replace('_', ' ', $data);
                            } else {
                                $name = $data;
                            }
                            if ( $data != 'employee' AND $data != 'supervisor' AND $data != 'department' AND $data != 'role') {
                                if ( $model->$data != $this->old_id[$f] ) {
                                    $systemLog = new hris_system_logs();
                                    $systemLog->user = $user;
                                    $systemLog->module = $module;
                                    $systemLog->action = 'update';
                                    $systemLog->action_id = $id;
                                    $systemLog->field = $name;
                                    $systemLog->old_data = $this->old_id[$f];
                                    $systemLog->new_data = $model->$data->name;
                                    $systemLog->log_date_time = $datetime;
                                    $systemLog->save();
                                }
                            } else {
                                if ( $data == 'employee' ?? $data == 'supervisor' ) {
                                    if ( $model->$data != NULL ) {
                                        $employee = $model->$data->firstname.' '.$model->$data->lastname;
                                    } else {
                                        $employee = '';
                                    }
                                    if ( $employee != $this->old_emp ) {
                                        $this->new_emp = '';
                                        $systemLog = new hris_system_logs();
                                        $systemLog->user = $user;
                                        $systemLog->module = $module;
                                        $systemLog->action = 'update';
                                        $systemLog->action_id = $id;
                                        $systemLog->field = $name;
                                        $systemLog->old_data = $this->old_emp;
                                        $systemLog->new_data = $this->new_emp;
                                        $systemLog->log_date_time = $datetime;
                                        $systemLog->save();
                                    }
                                }
                                if ( $data == 'department' ) {
                                    if ( $model->$data != NULL ) {
                                        $department = $model->$data->name;
                                    } else {
                                        $department = '';
                                    }
                                    if ( $department != $this->old_dep ) {
                                        $this->new_dep = '';
                                        $systemLog = new hris_system_logs();
                                        $systemLog->user = $user;
                                        $systemLog->module = $module;
                                        $systemLog->action = 'update';
                                        $systemLog->action_id = $id;
                                        $systemLog->field = $name;
                                        $systemLog->old_data = $this->old_dep;
                                        $systemLog->new_data = $this->new_dep;
                                        $systemLog->log_date_time = $datetime;
                                        $systemLog->save();
                                    }
                                }
                            }
                        }
                    } else {
                        if ( substr($f, -3) == '_id' ) {
                            $data = str_replace('_id', '', $f);
                            if (preg_match('/^[a-z]+_[a-z]+$/i', $data)) {
                                $name = str_replace('_', ' ', $data);
                            } else {
                                $name = $data;
                            }
                            if ( $data != 'employee' AND $data != 'supervisor' AND $data != 'department') {

                                if ( $model->$data != '' ) {
                                    $this->new_id = $model->$data->name;
                                } else {
                                    $this->new_id = '';
                                }
                                $systemLog = new hris_system_logs();
                                $systemLog->user = $user;
                                $systemLog->module = $module;
                                $systemLog->action = 'update';
                                $systemLog->action_id = $id;
                                $systemLog->field = $name;
                                $systemLog->old_data = $this->old_id[$f];
                                $systemLog->new_data = $this->new_id;
                                $systemLog->log_date_time = $datetime;
                                $systemLog->save();
                            } else {
                                if ( $data == 'employee' ) {
                                    $employees = \App\hris_employee::whereIn('id', explode(',', $model->employee_id))->get();
                                    $new_employee = array();
                                    foreach ($employees as $employee) {
                                        $new_employee[] = $employee->firstname.' '.$employee->lastname;
                                    }
                                    $this->new_emp = implode(', ', $new_employee);
                                    $systemLog = new hris_system_logs();
                                    $systemLog->user = $user;
                                    $systemLog->module = $module;
                                    $systemLog->action = 'update';
                                    $systemLog->action_id = $id;
                                    $systemLog->field = $name;
                                    $systemLog->old_data = $this->old_emp;
                                    $systemLog->new_data = $this->new_emp;
                                    $systemLog->log_date_time = $datetime;
                                    $systemLog->save();
                                }
                                if ( $data == 'department' ) {
                                    $departments = \App\hris_company_structures::whereIn('id', explode(',', $model->department_id))->get();
                                    $new_department = array();
                                    foreach ($departments as $department) {
                                        $new_department[] = $department->name;
                                    }
                                    $this->new_dep = implode(', ', $new_department);
                                    $systemLog = new hris_system_logs();
                                    $systemLog->user = $user;
                                    $systemLog->module = $module;
                                    $systemLog->action = 'update';
                                    $systemLog->action_id = $id;
                                    $systemLog->field = $name;
                                    $systemLog->old_data = $this->old_dep;
                                    $systemLog->new_data = $this->new_dep;
                                    $systemLog->log_date_time = $datetime;
                                    $systemLog->save();
                                }
                            }
                        } else {
                            if (strpos($f, '_')) {
                                $name = str_replace('_', ' ', $f);
                            } else {
                                $name = $f;
                            }
                            if ( $f == 'attachment' OR $f == 'attachment_1' OR $f == 'attachment_2' OR $f == 'attachment_3' OR $f == 'receipt' OR $f == 'profile_image' OR $f == 'resume' OR $f == 'image' ) {
                                $this->new_string = $model->$f;

                            } else {
                                $this->new_string = request($f);
                            }
                            $systemLog = new hris_system_logs();
                            $systemLog->user = $user;
                            $systemLog->module = $module;
                            $systemLog->action = 'update';
                            $systemLog->action_id = $id;
                            $systemLog->field = $name;
                            $systemLog->old_data = $this->old_string[$f];
                            $systemLog->new_data = $this->new_string;
                            $systemLog->log_date_time = $datetime;
                            $systemLog->save();
                        } 

                    }
                }
            }

        }
    }


    public function statusSystemLog($module,$string,$id)
    {
        $user = $_SESSION['sys_login_uname'];
        $datetime = date("Y/m/d H:i:s"); 
        $model = $string::find($id);
        $old = $model->getOriginal('status');
        $new = request('status');
        if ( $old == '0' ) {
            $old = 'Pending';
        }
        if ( $old == '1' ) {
            $old = 'Approved';
        }
        if ( $old == '2' ) {
            $old = 'Denied';
        }
        if ( $new == '0' ) {
            $new = 'Pending';
        }
        if ( $new == '1' ) {
            $new = 'Approved';
        }
        if ( $new == '2' ) {
            $new = 'Denied';
        }
        $systemLog = new hris_system_logs();
        $systemLog->user = $user;
        $systemLog->module = $module;
        $systemLog->action = 'update';
        $systemLog->field = 'status';
        $systemLog->old_data = $old;
        $systemLog->new_data = $new;
        $systemLog->action_id = $id;
        $systemLog->log_date_time = $datetime;
        $systemLog->save();
    }

    public function deleteSystemLog($module,$id)
    {
        $user = $_SESSION['sys_login_uname'];
        $datetime = date("Y/m/d H:i:s");
        $systemLog = new hris_system_logs();
        $systemLog->user = $user;
        $systemLog->module = $module;
        $systemLog->action = 'delete';
        $systemLog->action_id = $id;
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
