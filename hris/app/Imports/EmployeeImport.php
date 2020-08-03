<?php

namespace App\Imports;

use App\hris_employeee;
use App\hris_job_titles;
use App\hris_company_structures;
use Maatwebsite\Excel\Concerns\ToModel;

class EmployeeImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        return new hris_employeee([
            'employee_number'     => $row[0],
            'username'    => $row[1],
            'password'    => $row[2],
            'firstname'    => $row[3],
            'middlename'    => $row[4],
            'lastname'    => $row[5],
            'nationality'    => $row[6],
            'birthday'    => $row[7],
            'gender'    => $row[8],
            'place_birth'    => $row[9],
            'dependant'    => $row[10],
            'marital_status'    => $row[11],
            'work_address'    => $row[12],
            'home_address'    => $row[13],
            'home_distance'    => $row[14],
            'emergency_contact'    => $row[15],
            'emergency_no'    => $row[16],
            'cert_level'    => $row[17],
            'field_study'    => $row[18],
            'school'    => $row[19],
            'work_permit'    => $row[20],
            'pagibig'    => $row[21],
            'sss'    => $row[22],
            'phic'    => $row[23],
            'bank_acc'    => $row[24],
            'employment_status'    => $row[25],
            'work_no'    => $row[26],
            'work_phone'    => $row[27],
            'work_email'    => $row[28],
            'private_email'    => $row[29],
            'joined_date'    => $row[30],
            'termination_date'    => $row[31],
            'job_title_id'    => $row[32],
            'department_id'    => $row[33],
            'supervisor'    => $row[34],
        ]);
    }
}
