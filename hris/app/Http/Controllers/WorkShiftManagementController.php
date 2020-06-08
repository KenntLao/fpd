<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\hris_work_shift_management;
use App\users;

class WorkShiftManagementController extends Controller
{
    //
    public function index(hris_work_shift_management $work_shift){
        $work_shift = hris_work_shift_management::paginate(10);
        return view('pages.time.workshiftManagement.index', compact('work_shift'));
    }
    public function create(hris_work_shift_management $work_shift)
    {
        return view('pages.time.workshiftManagement.create', compact('work_shift'));
    }
    public function store(Request $request, hris_work_shift_management $work_shift){
        if($this->validatedData()){

            if(request('monday_shift') == NULL) {
                $monday_shift = 0;
            } else {
                $monday_shift = 1;
            }

            if (request('tuesday_shift') == NULL) {
                $tuesday_shift = 0;
            } else {
                $tuesday_shift = 1;
            }

            if (request('wednesday_shift') == NULL) {
                $wednesday_shift = 0;
            } else {
                $wednesday_shift = 1;
            }

            if (request('thursday_shift') == NULL) {
                $thursday_shift = 0;
            } else {
                $thursday_shift = 1;
            }

            if (request('friday_shift') == NULL) {
                $friday_shift = 0;
            } else {
                $friday_shift = 1;
            }

            if (request('saturday_shift') == NULL) {
                $saturday_shift = 0;
            } else {
                $saturday_shift = 1;
            }

            if (request('sunday_shift') == NULL) {
                $sunday_shift = 0;
            } else {
                $sunday_shift = 1;
            }

            $work_shift->workshift_name = request('workshift_name');
            $work_shift->monday_shift = $monday_shift;
            $work_shift->monday_time_in = strtotime(request('monday_time_in'));
            $work_shift->monday_time_out = strtotime(request('monday_time_out'));
            $work_shift->tuesday_shift = $tuesday_shift;
            $work_shift->tuesday_time_in = strtotime(request('tuesday_time_in'));
            $work_shift->tuesday_time_out = strtotime(request('tuesday_time_out'));
            $work_shift->wednesday_shift = $wednesday_shift;
            $work_shift->wednesday_time_in = strtotime(request('wednesday_time_in'));
            $work_shift->wednesday_time_out = strtotime(request('wednesday_time_out'));
            $work_shift->thursday_shift = $thursday_shift;
            $work_shift->thursday_time_in = strtotime(request('thursday_time_in'));
            $work_shift->thursday_time_out = strtotime(request('thursday_time_out'));
            $work_shift->friday_shift = $friday_shift;
            $work_shift->friday_time_in = strtotime(request('friday_time_in'));
            $work_shift->friday_time_out = strtotime(request('friday_time_out'));
            $work_shift->saturday_shift = $saturday_shift;
            $work_shift->saturday_time_in = strtotime(request('saturday_time_in'));
            $work_shift->saturday_time_out = strtotime(request('saturday_time_out'));
            $work_shift->sunday_shift = $sunday_shift;
            $work_shift->sunday_time_in = strtotime(request('sunday_time_in'));
            $work_shift->sunday_time_out = strtotime(request('sunday_time_out'));

            $work_shift->save();
            return redirect('/hris/pages/time/workshiftManagement/index')->with('success', 'Work Shift successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }
    public function edit(hris_work_shift_management $work_shift)
    {
        return view('pages.time.workshiftManagement.edit', compact('work_shift'));
    }
    public function update(Request $request, hris_work_shift_management $work_shift){
        if ($this->validatedData()) {

            if (request('monday_shift') == NULL) {
                $monday_shift = 0;
                $monday_time_in = '00:00';
                $monday_time_out = '00:00';
            } else {
                $monday_shift = 1;
                $monday_time_in = request('monday_time_in');
                $monday_time_out = request('monday_time_out');
            }

            if (request('tuesday_shift') == NULL) {
                $tuesday_shift = 0;
                $tuesday_time_in = '00:00';
                $tuesday_time_out = '00:00';
            } else {
                $tuesday_shift = 1;
                $tuesday_time_in = request('tuesday_time_in');
                $tuesday_time_out = request('tuesday_time_out');
            }

            if (request('wednesday_shift') == NULL) {
                $wednesday_shift = 0;
                $wednesday_time_in = '00:00';
                $wednesday_time_out = '00:00';
            } else {
                $wednesday_shift = 1;
                $wednesday_time_in = request('wednesday_time_in');
                $wednesday_time_out = request('wednesday_time_out');
            }

            if (request('thursday_shift') == NULL) {
                $thursday_shift = 0;
                $thursday_time_in = '00:00';
                $thursday_time_out = '00:00';
            } else {
                $thursday_shift = 1;
                $thursday_time_in = request('thursday_time_in');
                $thursday_time_out = request('thursday_time_out');
            }

            if (request('friday_shift') == NULL) {
                $friday_shift = 0;
                $friday_time_in = '00:00';
                $friday_time_out = '00:00';
            } else {
                $friday_shift = 1;
                $friday_time_in = request('friday_time_in');
                $friday_time_out = request('friday_time_out');
            }

            if (request('saturday_shift') == NULL) {
                $saturday_shift = 0;
                $saturday_time_in = '00:00';
                $saturday_time_out = '00:00';
            } else {
                $saturday_shift = 1;
                $saturday_time_in = request('saturday_time_in');
                $saturday_time_out = request('saturday_time_out');
            }

            if (request('sunday_shift') == NULL) {
                $sunday_shift = 0;
                $sunday_time_in = '00:00';
                $sunday_time_out = '00:00';
            } else {
                $sunday_shift = 1;
                $sunday_time_in = request('sunday_time_in');
                $sunday_time_out = request('sunday_time_out');
            }

            $work_shift->workshift_name = request('workshift_name');
            $work_shift->monday_shift = $monday_shift;
            $work_shift->monday_time_in = strtotime($monday_time_in);
            $work_shift->monday_time_out = strtotime($monday_time_out);
            $work_shift->tuesday_shift = $tuesday_shift;
            $work_shift->tuesday_time_in = strtotime(request('tuesday_time_in'));
            $work_shift->tuesday_time_out = strtotime(request('tuesday_time_out'));
            $work_shift->wednesday_shift = $wednesday_shift;
            $work_shift->wednesday_time_in = strtotime(request('wednesday_time_in'));
            $work_shift->wednesday_time_out = strtotime(request('wednesday_time_out'));
            $work_shift->thursday_shift = $thursday_shift;
            $work_shift->thursday_time_in = strtotime(request('thursday_time_in'));
            $work_shift->thursday_time_out = strtotime(request('thursday_time_out'));
            $work_shift->friday_shift = $friday_shift;
            $work_shift->friday_time_in = strtotime(request('friday_time_in'));
            $work_shift->friday_time_out = strtotime(request('friday_time_out'));
            $work_shift->saturday_shift = $saturday_shift;
            $work_shift->saturday_time_in = strtotime(request('saturday_time_in'));
            $work_shift->saturday_time_out = strtotime(request('saturday_time_out'));
            $work_shift->sunday_shift = $sunday_shift;
            $work_shift->sunday_time_in = strtotime(request('sunday_time_in'));
            $work_shift->sunday_time_out = strtotime(request('sunday_time_out'));

            $work_shift->update();
            return redirect('/hris/pages/time/workshiftManagement/index')->with('success', 'Work Shift successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }
    public function destroy(hris_work_shift_management $work_shift)
    {
        $id = $_SESSION['sys_id'];
        $upass = $this->decryptStr(users::find($id)->upass);
        if ($upass == request('upass')) {
            $work_shift->delete();
            return redirect('/hris/pages/time/workshiftManagement/index')->with('success', 'Work Shift successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
    }

    // decrypt string
    function decryptStr($str)
    {
        $key = '4507';
        $c = base64_decode($str);
        $ivlen = openssl_cipher_iv_length($cipher = "AES-128-CBC");
        $iv = substr($c, 0, $ivlen);
        $hmac = substr($c, $ivlen, $sha2len = 32);
        $ciphertext_raw = substr($c, $ivlen + $sha2len);
        $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, $options = OPENSSL_RAW_DATA, $iv);
        $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary = true);
        if (hash_equals($hmac, $calcmac)) {
            return $original_plaintext;
        }
    }
    protected function validatedData()
    {
        return request()->validate([
            'workshift_name' => 'required',
            'monday_shift' => 'nullable',
            'monday_time_in' => 'nullable',
            'monday_time_out' => 'nullable',
            'tuesday_shift' => 'nullable',
            'tuesday_time_in' => 'nullable',
            'tuesday_time_out' => 'nullable',
            'wednesday_shift' => 'nullable',
            'wednesday_time_in' => 'nullable',
            'wednesday_time_out' => 'nullable',
            'thursday_shift' => 'nullable',
            'thursday_time_in' => 'nullable',
            'thursday_time_out' => 'nullable',
            'friday_shift' => 'nullable',
            'friday_time_in' => 'nullable',
            'friday_time_out' => 'nullable',
            'saturday_shift' => 'nullable',
            'saturday_time_in' => 'nullable',
            'saturday_time_out' => 'nullable',
            'sunday_shift' => 'nullable',
            'sunday_time_in' => 'nullable',
            'sunday_time_out' => 'nullable',
        ]);
    }
}