<?php

namespace App\Imports;

use App\hris_employee;
use App\hris_job_titles;
use App\hris_company_structures;
use App\hris_pay_grades;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Faker\Generator as Faker;

class EmployeeImport implements ToModel, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }
    public function model(array $row)
    {
        $department_id = hris_company_structures::where('name', trim($row[32]))->limit(1)->get('id');
        $department_id_int = trim(preg_replace('/[^0-9]/', '', $department_id));

        echo $department_id_int;

        $job_title_id = hris_job_titles::where('name', $row[31])->limit(1)->get('id');
        $job_title_id_int = trim(preg_replace('/[^0-9]/', '', $job_title_id));

        if($job_title_id == '[]'){
            $job_title_id_int = 0;
        }

        $supervisor_id = hris_employee::where('employee_number', $row[33])->get('id');
        $supervisor_id_int = trim(preg_replace('/[^0-9]/', '', $supervisor_id));

        $pay_grade_id = hris_pay_grades::where('name', $row[34])->limit(1)->get('id');
        $pay_grade_id_int = trim(preg_replace('/[^0-9]/', '', $pay_grade_id));

        $username = substr($row[2], 0, 1). substr($row[3], 0, 1). substr($row[4], 0, 1).$row[0];

        if($department_id_int == ""){
            $department_id_int = 0;
        }

        if($pay_grade_id_int == ""){
            $pay_grade_id_int = 0;
        }

        $g = $row[7];
        
        if ($g == 'M') {
            $image = 'pic1.png';
        } else {
            $image = 'pic2.png';
        }

        return new hris_employee([
            'employee_number'     => $row[0],
            'employee_photo' => $image,
            'username'    => $username,
            'firstname'    => $row[2],
            'middlename'    => $row[3],
            'lastname'    => $row[4],
            'nationality'    => $row[5],
            'birthday'    => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[6]),
            'gender'    => $row[7],
            'place_birth'    => $row[8],
            'dependant'    => $row[9],
            'marital_status'    => $row[10],
            'work_address'    => $row[11],
            'home_address'    => $row[12],
            'home_distance'    => $row[13],
            'emergency_contact'    => $row[14],
            'emergency_no'    => $row[15],
            'cert_level'    => $row[16],
            'field_study'    => $row[17],
            'school'    => $row[18],
            'tin'    => $row[19],
            'pagibig'    => $row[20],
            'sss'    => $row[21],
            'phic'    => $row[22],
            'employment_status'    => $row[24],
            'work_no'    => $row[25],
            'work_phone'    => $row[26],
            'work_email'    => $row[27],
            'private_email'    => $row[28],
            'joined_date'    => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[29]),
            'termination_date'    => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[30]),
            'job_title_id'    => $job_title_id_int,
            'department_id'    => $department_id_int,
            'supervisor'    => $supervisor_id_int,
            'pay_grade'    => $pay_grade_id_int,
        ]);
    }
}
