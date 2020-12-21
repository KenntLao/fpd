<?php

namespace App\Exports;

use App\hris_overtime;
use App\roles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class OvertimeExport implements FromView,ShouldAutoSize
{
    public function __construct($date_from, $date_to, $employee_id, $report) {
        $this->date_from = $date_from;
        $this->date_to = $date_to;
        $this->employee_id = $employee_id;
        $this->report = $report;
    }

    public function view(): View
    {
        $supervisor = roles::where('role_name', 'supervisor')->first();
        $hr_officer = roles::where('role_name', 'hr officer')->first();
        $role_ids = explode(',', $_SESSION['sys_role_ids']);

        $overtimes = hris_overtime::groupBy('employee_id')->selectRaw(
            'sum(REG) as REG_SUM, 
            sum(REG_8) as REG_8_SUM, 
            sum(REG_ND1) as REG_ND1_SUM, 
            sum(RST) as RST_SUM, 
            sum(RST_8) as RST_8_SUM, 
            sum(RST_ND1) as RST_ND1_SUM, 
            sum(LGL) as LGL_SUM, 
            sum(LGL_8) as LGL_8_SUM, 
            sum(LGL_ND1) as LGL_ND1_SUM, 
            sum(LGLRST) as LGLRST_SUM, 
            sum(LGLRST_8) as LGLRST_8_SUM, 
            sum(LGLRST_ND1) as LGLRST_ND1_SUM, 
            sum(SPL) as SPL_SUM, 
            sum(SPL_8) as SPL_8_SUM, 
            sum(SPL_ND1) as SPL_ND1_SUM, 
            sum(SPLRST) as SPLRST_SUM, 
            sum(SPLRST_8) as SPLRST_8_SUM, 
            sum(SPLRST_ND1) as SPLRST_ND1_SUM, 
            sum(SPRS_CLIEN) as SPRS_CLIEN_SUM, 
            sum(SPRS_CLIEN_8) as SPRS_CLIEN_8_SUM, 
            sum(SPRS_CLIEN_ND1) as SPRS_CLIEN_ND1_SUM, 
            sum(LGRS_CLIEN) as LGRS_CLIEN_SUM, 
            sum(LGRS_CLIEN_8) as LGRS_CLIEN_8_SUM, 
            sum(LGRS_CLIEN_ND1) as LGRS_CLIEN_ND1_SUM,  
            sum(SPL_CLIENT) as SPL_CLIENT_SUM, 
            sum(SPL_CLIENT_8) as SPL_CLIENT_8_SUM, 
            sum(SPL_CLIENT_ND1) as SPL_CLIENT_ND1_SUM, 
            sum(RST_CLIENT) as RST_CLIENT_SUM, 
            sum(RST_CLIENT_8) as RST_CLIENT_8_SUM, 
            sum(RST_CLIENT_ND1) as RST_CLIENT_ND1_SUM, 
            sum(REG_CLIENT) as REG_CLIENT_SUM, 
            sum(REG_CLIENT_8) as REG_CLIENT_8_SUM, 
            sum(REG_CLIENT_ND1) as REG_CLIENT_ND1_SUM, 
            sum(REGND_CLIE) as REGND_CLIE_SUM, 
            sum(REGND_CLIE_8) as REGND_CLIE_8_SUM, 
            sum(REGND_CLIE_ND1) as REGND_CLIE_ND1_SUM, 
            sum(LG_CLIENT) as LG_CLIENT_SUM, 
            sum(LG_CLIENT_8) as LG_CLIENT_8_SUM, 
            sum(LG_CLIENT_ND1) as LG_CLIENT_ND1_SUM, 
            sum(LGLSPL) as LGLSPL_SUM, 
            sum(LGLSPL_8) as LGLSPL_8_SUM, 
            sum(LGLSPL_ND1) as LGLSPL_ND1_SUM, 
            sum(LGLSPLRST) as LGLSPLRST_SUM, 
            sum(LGLSPLRST_8) as LGLSPLRST_8_SUM, 
            sum(LGLSPLRST_ND1) as LGLSPLRST_ND1_SUM, 
            sum(LGLSPL_CLI) as LGLSPL_CLI_SUM, 
            sum(LGLSPL_CLI_8) as LGLSPL_CLI_8_SUM, 
            sum(LGLSPL_CLI_ND1) as LGLSPL_CLI_ND1_SUM, 
            sum(LGLSPL_ND1_2) as LGLSPL_ND1_2_SUM, 
            sum(LGLSPL_ND1_2_8) as LGLSPL_ND1_2_8_SUM, 
            sum(LGLSPL_ND1_2_ND1) as LGLSPL_ND1_2_ND1_SUM, 
            employee_id'
        )->whereBetween('ot_date', [$this->date_from, $this->date_to]);
        if ( $this->report == 1 ) {
            $overtimes = $overtimes->where('overtime_category_id', 3);
        } else {
            $overtimes = $overtimes->where('overtime_category_id', '!=' ,3);
        }
        if ( in_array($supervisor->id, $role_ids)  ) {
            if ( $this->employee_id != 0 ) {
                $overtimes = $overtimes->where('employee_id', $this->employee_id);
            } else {
                $overtimes = $overtimes->where('supervisor_id', $_SESSION['sys_id']);
            }
        }
        if ( in_array($supervisor->id, $role_ids) AND in_array($hr_officer->id, $role_ids) OR in_array($hr_officer->id, $role_ids) OR $_SESSION['sys_role_ids'] == ',1,'  ) {
            if ( $this->employee_id != 0 ) {
                $overtimes = $overtimes->where('employee_id', $this->employee_id);
            }
        }
        $overtimes = $overtimes->get();
        return view('pages.time.overtime.table', compact('overtimes'));
    }
}
