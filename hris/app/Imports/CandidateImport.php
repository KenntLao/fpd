<?php

namespace App\Imports;

use App\hris_candidates;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class CandidateImport implements ToModel, WithStartRow, WithValidation, SkipsOnFailure
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    use Importable,
        SkipsFailures;

    public function startRow(): int
    {
        return 3;
    }
    public function model(array $row)
    {
        return new hris_candidates([
            //
            'careers_app_fname' => $row[0],
            'careers_app_lname' => $row[1],
            'careers_app_email' => $row[2],
            'careers_app_number' => $row[3],
            'careers_app_gender' => $row[4],
            'careers_app_position' => $row[5],
            'careers_app_file' => $row[6],
            'date_apply' => date("Y-m-d",strtotime($row[7])),
            'status' => 0,
            'careers_app_nationality' => $row[8],
            'careers_app_marital' => $row[9],
            'careers_app_company_name' => $row[10],
            'careers_app_company_position_title' => $row[11],
            'careers_app_position_level' => $row[12],
            'careers_app_industry' => $row[13],
            'careers_app_company_date_from' => date("Y-m-d", strtotime($row[14])),
            'careers_app_company_date_to' => date("Y-m-d", strtotime($row[15])),
            'careers_app_position_desc' => $row[16],
            'careers_app_university' => $row[17],
            'careers_app_major' => $row[18],
            'careers_app_qualification' => $row[19],
            'careers_app_field' => $row[20],
            'careers_app_study_date_from' => date("Y-m-d", strtotime($row[21])),
            'careers_app_study_date_to' => date("Y-m-d", strtotime($row[22])),
        ]);
    }

    public function rules(): array
    {
        return [
            '2' => Rule::unique('table_careers_applications', 'careers_app_email'),
        ];
    }
    public function customValidationMessages()
    {
        return [
            '2.unique' => 'Candidate already exist.',
        ];
    }

}
