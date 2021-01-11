<?php

namespace App\Imports;

use App\hris_candidates;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class CandidateImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

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
        ]);
    }
}
