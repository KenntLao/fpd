<?php

namespace App\Exports;

use App\hris_overtime;
use App\hris_overtime_types;
use App\roles;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;




class OvertimeExport implements FromView,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $date_from;
    protected $date_to;

    public function __construct($date_from, $date_to, $employee_id, $type) {
        $this->date_from = $date_from;
        $this->date_to = $date_to;
        $this->employee_id = $employee_id;
        $this->type = $type;
    }

    public function view(): View
    {
        $roles = roles::all();
        $hr_officer_role_id = roles::where('role_name', 'hr officer')->get('id')->toArray();
        $hr_officer_id = implode(' ', $hr_officer_role_id[0]);
        $roles = explode(',', $_SESSION['sys_role_ids']);
        if ( $_SESSION['sys_role_ids'] == ',1,' OR in_array($hr_officer_id, $roles) ) {
            if ( $this->type != 'All' AND $this->employee_id != '0' ) {
                $f = str_replace('>', '', $this->type);
                return view('pages.time.overtime.table', [
                'types' => hris_overtime_types::all(),
                'overtimes' => 
                $overtimes = hris_overtime::groupBy('employee_id')->selectRaw(
                'sum('. $f .') as '. $f .'_SUM, 
                employee_id'
                )->where('status', '1')->where('employee_id', $this->employee_id)->whereBetween('ot_date', [$this->date_from, $this->date_to])->get()
                ]);
            }
            if ( $this->type == 'All' AND $this->employee_id == '0' ) {
                return view('pages.time.overtime.table', [
                'types' => hris_overtime_types::all(),
                'overtimes' => 
                $overtimes = hris_overtime::groupBy('employee_id')->selectRaw(
                    'sum(REG) as REG_SUM, 
                    sum(REG_8) as REG_8_SUM, 
                    sum(REG_ND1) as REG_ND1_SUM, 
                    sum(REG_ND2) as REG_ND2_SUM, 
                    sum(RST) as RST_SUM, 
                    sum(RST_8) as RST_8_SUM, 
                    sum(RST_ND1) as RST_ND1_SUM, 
                    sum(RST_ND2) as RST_ND2_SUM, 
                    sum(LGL) as LGL_SUM, 
                    sum(LGL_8) as LGL_8_SUM, 
                    sum(LGL_ND1) as LGL_ND1_SUM, 
                    sum(LGL_ND2) as LGL_ND2_SUM, 
                    sum(LGLRST) as LGLRST_SUM, 
                    sum(LGLRST_8) as LGLRST_8_SUM, 
                    sum(LGLRST_ND1) as LGLRST_ND1_SUM, 
                    sum(LGLRST_ND2) as LGLRST_ND2_SUM, 
                    sum(SPL) as SPL_SUM, 
                    sum(SPL_8) as SPL_8_SUM, 
                    sum(SPL_ND1) as SPL_ND1_SUM, 
                    sum(SPL_ND2) as SPL_ND2_SUM, 
                    sum(SPLRST) as SPLRST_SUM, 
                    sum(SPLRST_8) as SPLRST_8_SUM, 
                    sum(SPLRST_ND1) as SPLRST_ND1_SUM, 
                    sum(SPLRST_ND2) as SPLRST_ND2, 
                    sum(SPRS_CLIEN) as SPRS_CLIEN_SUM, 
                    sum(SPRS_CLIEN_8) as SPRS_CLIEN_8_SUM, 
                    sum(SPRS_CLIEN_ND1) as SPRS_CLIEN_ND1_SUM, 
                    sum(SPRS_CLIEN_ND2) as SPRS_CLIEN_ND2_SUM, 
                    sum(LGRS_CLIEN) as LGRS_CLIEN_SUM, 
                    sum(LGRS_CLIEN_8) as LGRS_CLIEN_8_SUM, 
                    sum(LGRS_CLIEN_ND1) as LGRS_CLIEN_ND1_SUM, 
                    sum(LGRS_CLIEN_ND2) as LGRS_CLIEN_ND2_SUM, 
                    sum(SPL_CLIENT) as SPL_CLIENT_SUM, 
                    sum(SPL_CLIENT_8) as SPL_CLIENT_8_SUM, 
                    sum(SPL_CLIENT_ND1) as SPL_CLIENT_ND1_SUM, 
                    sum(SPL_CLIENT_ND2) as SPL_CLIENT_ND2_SUM, 
                    sum(RST_CLIENT) as RST_CLIENT_SUM, 
                    sum(RST_CLIENT_8) as RST_CLIENT_8_SUM, 
                    sum(RST_CLIENT_ND1) as RST_CLIENT_ND1_SUM, 
                    sum(RST_CLIENT_ND2) as RST_CLIENT_ND2_SUM, 
                    sum(REG_CLIENT) as REG_CLIENT_SUM, 
                    sum(REG_CLIENT_8) as REG_CLIENT_8_SUM, 
                    sum(REG_CLIENT_ND1) as REG_CLIENT_ND1_SUM, 
                    sum(REG_CLIENT_ND2) as REG_CLIENT_ND2_SUM, 
                    sum(REGND_CLIE) as REGND_CLIE_SUM, 
                    sum(REGND_CLIE_8) as REGND_CLIE_8_SUM, 
                    sum(REGND_CLIE_ND1) as REGND_CLIE_ND1_SUM, 
                    sum(REGND_CLIE_ND2) as REGND_CLIE_ND2_SUM, 
                    sum(LG_CLIENT) as LG_CLIENT_SUM, 
                    sum(LG_CLIENT_8) as LG_CLIENT_8_SUM, 
                    sum(LG_CLIENT_ND1) as LG_CLIENT_ND1_SUM, 
                    sum(LG_CLIENT_ND2) as LG_CLIENT_ND2_SUM, 
                    sum(LGLSPL) as LGLSPL_SUM, 
                    sum(LGLSPL_8) as LGLSPL_8_SUM, 
                    sum(LGLSPL_ND1) as LGLSPL_ND1_SUM, 
                    sum(LGLSPL_ND2) as LGLSPL_ND2_SUM, 
                    sum(LGLSPLRST) as LGLSPLRST_SUM, 
                    sum(LGLSPLRST_8) as LGLSPLRST_8_SUM, 
                    sum(LGLSPLRST_ND1) as LGLSPLRST_ND1_SUM, 
                    sum(LGLSPLRST_ND2) as LGLSPLRST_ND2_SUM, 
                    sum(LGLSPL_CLI) as LGLSPL_CLI_SUM, 
                    sum(LGLSPL_CLI_8) as LGLSPL_CLI_8_SUM, 
                    sum(LGLSPL_CLI_ND1) as LGLSPL_CLI_ND1_SUM, 
                    sum(LGLSPL_CLI_ND2) as LGLSPL_CLI_ND2_SUM, 
                    sum(LGLSPL_ND1_2) as LGLSPL_ND1_2_SUM, 
                    sum(LGLSPL_ND1_2_8) as LGLSPL_ND1_2_8_SUM, 
                    sum(LGLSPL_ND1_2_ND1) as LGLSPL_ND1_2_ND1_SUM, 
                    sum(LGLSPL_ND1_2_ND2) as LGLSPL_ND1_2_ND2_SUM,
                    employee_id'
                )->where('status', '1')->whereBetween('ot_date', [$this->date_from, $this->date_to])->get()
                ]);
            }
            if ( $this->type != 'All' AND $this->employee_id == '0' ) {
                $f = str_replace('>', '', $this->type);
                return view('pages.time.overtime.table', [
                'types' => hris_overtime_types::all(),
                'overtimes' => 
                $overtimes = hris_overtime::groupBy('employee_id')->selectRaw(
                'sum('. $f .') as '. $f .'_SUM, 
                employee_id'
                )->where('status', '1')->whereBetween('ot_date', [$this->date_from, $this->date_to])->get()
                ]);
            }
            if ( $this->type == 'All' AND $this->employee_id != '0' ) {
                return view('pages.time.overtime.table', [
                'types' => hris_overtime_types::all(),
                'overtimes' => 
                $overtimes = hris_overtime::groupBy('employee_id')->selectRaw(
                    'sum(REG) as REG_SUM, 
                    sum(REG_8) as REG_8_SUM, 
                    sum(REG_ND1) as REG_ND1_SUM, 
                    sum(REG_ND2) as REG_ND2_SUM, 
                    sum(RST) as RST_SUM, 
                    sum(RST_8) as RST_8_SUM, 
                    sum(RST_ND1) as RST_ND1_SUM, 
                    sum(RST_ND2) as RST_ND2_SUM, 
                    sum(LGL) as LGL_SUM, 
                    sum(LGL_8) as LGL_8_SUM, 
                    sum(LGL_ND1) as LGL_ND1_SUM, 
                    sum(LGL_ND2) as LGL_ND2_SUM, 
                    sum(LGLRST) as LGLRST_SUM, 
                    sum(LGLRST_8) as LGLRST_8_SUM, 
                    sum(LGLRST_ND1) as LGLRST_ND1_SUM, 
                    sum(LGLRST_ND2) as LGLRST_ND2_SUM, 
                    sum(SPL) as SPL_SUM, 
                    sum(SPL_8) as SPL_8_SUM, 
                    sum(SPL_ND1) as SPL_ND1_SUM, 
                    sum(SPL_ND2) as SPL_ND2_SUM, 
                    sum(SPLRST) as SPLRST_SUM, 
                    sum(SPLRST_8) as SPLRST_8_SUM, 
                    sum(SPLRST_ND1) as SPLRST_ND1_SUM, 
                    sum(SPLRST_ND2) as SPLRST_ND2, 
                    sum(SPRS_CLIEN) as SPRS_CLIEN_SUM, 
                    sum(SPRS_CLIEN_8) as SPRS_CLIEN_8_SUM, 
                    sum(SPRS_CLIEN_ND1) as SPRS_CLIEN_ND1_SUM, 
                    sum(SPRS_CLIEN_ND2) as SPRS_CLIEN_ND2_SUM, 
                    sum(LGRS_CLIEN) as LGRS_CLIEN_SUM, 
                    sum(LGRS_CLIEN_8) as LGRS_CLIEN_8_SUM, 
                    sum(LGRS_CLIEN_ND1) as LGRS_CLIEN_ND1_SUM, 
                    sum(LGRS_CLIEN_ND2) as LGRS_CLIEN_ND2_SUM, 
                    sum(SPL_CLIENT) as SPL_CLIENT_SUM, 
                    sum(SPL_CLIENT_8) as SPL_CLIENT_8_SUM, 
                    sum(SPL_CLIENT_ND1) as SPL_CLIENT_ND1_SUM, 
                    sum(SPL_CLIENT_ND2) as SPL_CLIENT_ND2_SUM, 
                    sum(RST_CLIENT) as RST_CLIENT_SUM, 
                    sum(RST_CLIENT_8) as RST_CLIENT_8_SUM, 
                    sum(RST_CLIENT_ND1) as RST_CLIENT_ND1_SUM, 
                    sum(RST_CLIENT_ND2) as RST_CLIENT_ND2_SUM, 
                    sum(REG_CLIENT) as REG_CLIENT_SUM, 
                    sum(REG_CLIENT_8) as REG_CLIENT_8_SUM, 
                    sum(REG_CLIENT_ND1) as REG_CLIENT_ND1_SUM, 
                    sum(REG_CLIENT_ND2) as REG_CLIENT_ND2_SUM, 
                    sum(REGND_CLIE) as REGND_CLIE_SUM, 
                    sum(REGND_CLIE_8) as REGND_CLIE_8_SUM, 
                    sum(REGND_CLIE_ND1) as REGND_CLIE_ND1_SUM, 
                    sum(REGND_CLIE_ND2) as REGND_CLIE_ND2_SUM, 
                    sum(LG_CLIENT) as LG_CLIENT_SUM, 
                    sum(LG_CLIENT_8) as LG_CLIENT_8_SUM, 
                    sum(LG_CLIENT_ND1) as LG_CLIENT_ND1_SUM, 
                    sum(LG_CLIENT_ND2) as LG_CLIENT_ND2_SUM, 
                    sum(LGLSPL) as LGLSPL_SUM, 
                    sum(LGLSPL_8) as LGLSPL_8_SUM, 
                    sum(LGLSPL_ND1) as LGLSPL_ND1_SUM, 
                    sum(LGLSPL_ND2) as LGLSPL_ND2_SUM, 
                    sum(LGLSPLRST) as LGLSPLRST_SUM, 
                    sum(LGLSPLRST_8) as LGLSPLRST_8_SUM, 
                    sum(LGLSPLRST_ND1) as LGLSPLRST_ND1_SUM, 
                    sum(LGLSPLRST_ND2) as LGLSPLRST_ND2_SUM, 
                    sum(LGLSPL_CLI) as LGLSPL_CLI_SUM, 
                    sum(LGLSPL_CLI_8) as LGLSPL_CLI_8_SUM, 
                    sum(LGLSPL_CLI_ND1) as LGLSPL_CLI_ND1_SUM, 
                    sum(LGLSPL_CLI_ND2) as LGLSPL_CLI_ND2_SUM, 
                    sum(LGLSPL_ND1_2) as LGLSPL_ND1_2_SUM, 
                    sum(LGLSPL_ND1_2_8) as LGLSPL_ND1_2_8_SUM, 
                    sum(LGLSPL_ND1_2_ND1) as LGLSPL_ND1_2_ND1_SUM, 
                    sum(LGLSPL_ND1_2_ND2) as LGLSPL_ND1_2_ND2_SUM,
                    employee_id'
                )->where('status', '1')->where('employee_id', $this->employee_id)->whereBetween('ot_date', [$this->date_from, $this->date_to])->get()
                ]);
            }
        } else {
            if ( $this->type != 'All' AND $this->employee_id != '0' ) {
                $f = str_replace('>', '', $this->type);
                return view('pages.time.overtime.table', [
                'types' => hris_overtime_types::all(),
                'overtimes' => 
                $overtimes = hris_overtime::groupBy('employee_id')->selectRaw(
                'sum('. $f .') as '. $f .'_SUM, 
                employee_id'
                )->where('status', '1')->where('supervisor_id', $_SESSION['sys_id'])->where('employee_id', $this->employee_id)->whereBetween('ot_date', [$this->date_from, $this->date_to])->get()
                ]);
            }
            if ( $this->type == 'All' AND $this->employee_id == '0' ) {
                return view('pages.time.overtime.table', [
                'types' => hris_overtime_types::all(),
                'overtimes' => 
                $overtimes = hris_overtime::groupBy('employee_id')->selectRaw(
                    'sum(REG) as REG_SUM, 
                    sum(REG_8) as REG_8_SUM, 
                    sum(REG_ND1) as REG_ND1_SUM, 
                    sum(REG_ND2) as REG_ND2_SUM, 
                    sum(RST) as RST_SUM, 
                    sum(RST_8) as RST_8_SUM, 
                    sum(RST_ND1) as RST_ND1_SUM, 
                    sum(RST_ND2) as RST_ND2_SUM, 
                    sum(LGL) as LGL_SUM, 
                    sum(LGL_8) as LGL_8_SUM, 
                    sum(LGL_ND1) as LGL_ND1_SUM, 
                    sum(LGL_ND2) as LGL_ND2_SUM, 
                    sum(LGLRST) as LGLRST_SUM, 
                    sum(LGLRST_8) as LGLRST_8_SUM, 
                    sum(LGLRST_ND1) as LGLRST_ND1_SUM, 
                    sum(LGLRST_ND2) as LGLRST_ND2_SUM, 
                    sum(SPL) as SPL_SUM, 
                    sum(SPL_8) as SPL_8_SUM, 
                    sum(SPL_ND1) as SPL_ND1_SUM, 
                    sum(SPL_ND2) as SPL_ND2_SUM, 
                    sum(SPLRST) as SPLRST_SUM, 
                    sum(SPLRST_8) as SPLRST_8_SUM, 
                    sum(SPLRST_ND1) as SPLRST_ND1_SUM, 
                    sum(SPLRST_ND2) as SPLRST_ND2, 
                    sum(SPRS_CLIEN) as SPRS_CLIEN_SUM, 
                    sum(SPRS_CLIEN_8) as SPRS_CLIEN_8_SUM, 
                    sum(SPRS_CLIEN_ND1) as SPRS_CLIEN_ND1_SUM, 
                    sum(SPRS_CLIEN_ND2) as SPRS_CLIEN_ND2_SUM, 
                    sum(LGRS_CLIEN) as LGRS_CLIEN_SUM, 
                    sum(LGRS_CLIEN_8) as LGRS_CLIEN_8_SUM, 
                    sum(LGRS_CLIEN_ND1) as LGRS_CLIEN_ND1_SUM, 
                    sum(LGRS_CLIEN_ND2) as LGRS_CLIEN_ND2_SUM, 
                    sum(SPL_CLIENT) as SPL_CLIENT_SUM, 
                    sum(SPL_CLIENT_8) as SPL_CLIENT_8_SUM, 
                    sum(SPL_CLIENT_ND1) as SPL_CLIENT_ND1_SUM, 
                    sum(SPL_CLIENT_ND2) as SPL_CLIENT_ND2_SUM, 
                    sum(RST_CLIENT) as RST_CLIENT_SUM, 
                    sum(RST_CLIENT_8) as RST_CLIENT_8_SUM, 
                    sum(RST_CLIENT_ND1) as RST_CLIENT_ND1_SUM, 
                    sum(RST_CLIENT_ND2) as RST_CLIENT_ND2_SUM, 
                    sum(REG_CLIENT) as REG_CLIENT_SUM, 
                    sum(REG_CLIENT_8) as REG_CLIENT_8_SUM, 
                    sum(REG_CLIENT_ND1) as REG_CLIENT_ND1_SUM, 
                    sum(REG_CLIENT_ND2) as REG_CLIENT_ND2_SUM, 
                    sum(REGND_CLIE) as REGND_CLIE_SUM, 
                    sum(REGND_CLIE_8) as REGND_CLIE_8_SUM, 
                    sum(REGND_CLIE_ND1) as REGND_CLIE_ND1_SUM, 
                    sum(REGND_CLIE_ND2) as REGND_CLIE_ND2_SUM, 
                    sum(LG_CLIENT) as LG_CLIENT_SUM, 
                    sum(LG_CLIENT_8) as LG_CLIENT_8_SUM, 
                    sum(LG_CLIENT_ND1) as LG_CLIENT_ND1_SUM, 
                    sum(LG_CLIENT_ND2) as LG_CLIENT_ND2_SUM, 
                    sum(LGLSPL) as LGLSPL_SUM, 
                    sum(LGLSPL_8) as LGLSPL_8_SUM, 
                    sum(LGLSPL_ND1) as LGLSPL_ND1_SUM, 
                    sum(LGLSPL_ND2) as LGLSPL_ND2_SUM, 
                    sum(LGLSPLRST) as LGLSPLRST_SUM, 
                    sum(LGLSPLRST_8) as LGLSPLRST_8_SUM, 
                    sum(LGLSPLRST_ND1) as LGLSPLRST_ND1_SUM, 
                    sum(LGLSPLRST_ND2) as LGLSPLRST_ND2_SUM, 
                    sum(LGLSPL_CLI) as LGLSPL_CLI_SUM, 
                    sum(LGLSPL_CLI_8) as LGLSPL_CLI_8_SUM, 
                    sum(LGLSPL_CLI_ND1) as LGLSPL_CLI_ND1_SUM, 
                    sum(LGLSPL_CLI_ND2) as LGLSPL_CLI_ND2_SUM, 
                    sum(LGLSPL_ND1_2) as LGLSPL_ND1_2_SUM, 
                    sum(LGLSPL_ND1_2_8) as LGLSPL_ND1_2_8_SUM, 
                    sum(LGLSPL_ND1_2_ND1) as LGLSPL_ND1_2_ND1_SUM, 
                    sum(LGLSPL_ND1_2_ND2) as LGLSPL_ND1_2_ND2_SUM,
                    employee_id'
                )->where('status', '1')->where('supervisor_id', $_SESSION['sys_id'])->whereBetween('ot_date', [$this->date_from, $this->date_to])->get()
                ]);
            }
            if ( $this->type != 'All' AND $this->employee_id == '0' ) {
                $f = str_replace('>', '', $this->type);
                return view('pages.time.overtime.table', [
                'types' => hris_overtime_types::all(),
                'overtimes' => 
                $overtimes = hris_overtime::groupBy('employee_id')->selectRaw(
                'sum('. $f .') as '. $f .'_SUM, 
                employee_id'
                )->where('status', '1')->where('supervisor_id', $_SESSION['sys_id'])->whereBetween('ot_date', [$this->date_from, $this->date_to])->get()
                ]);
            }
            if ( $this->type == 'All' AND $this->employee_id != '0' ) {
                return view('pages.time.overtime.table', [
                'types' => hris_overtime_types::all(),
                'overtimes' => 
                $overtimes = hris_overtime::groupBy('employee_id')->selectRaw(
                    'sum(REG) as REG_SUM, 
                    sum(REG_8) as REG_8_SUM, 
                    sum(REG_ND1) as REG_ND1_SUM, 
                    sum(REG_ND2) as REG_ND2_SUM, 
                    sum(RST) as RST_SUM, 
                    sum(RST_8) as RST_8_SUM, 
                    sum(RST_ND1) as RST_ND1_SUM, 
                    sum(RST_ND2) as RST_ND2_SUM, 
                    sum(LGL) as LGL_SUM, 
                    sum(LGL_8) as LGL_8_SUM, 
                    sum(LGL_ND1) as LGL_ND1_SUM, 
                    sum(LGL_ND2) as LGL_ND2_SUM, 
                    sum(LGLRST) as LGLRST_SUM, 
                    sum(LGLRST_8) as LGLRST_8_SUM, 
                    sum(LGLRST_ND1) as LGLRST_ND1_SUM, 
                    sum(LGLRST_ND2) as LGLRST_ND2_SUM, 
                    sum(SPL) as SPL_SUM, 
                    sum(SPL_8) as SPL_8_SUM, 
                    sum(SPL_ND1) as SPL_ND1_SUM, 
                    sum(SPL_ND2) as SPL_ND2_SUM, 
                    sum(SPLRST) as SPLRST_SUM, 
                    sum(SPLRST_8) as SPLRST_8_SUM, 
                    sum(SPLRST_ND1) as SPLRST_ND1_SUM, 
                    sum(SPLRST_ND2) as SPLRST_ND2, 
                    sum(SPRS_CLIEN) as SPRS_CLIEN_SUM, 
                    sum(SPRS_CLIEN_8) as SPRS_CLIEN_8_SUM, 
                    sum(SPRS_CLIEN_ND1) as SPRS_CLIEN_ND1_SUM, 
                    sum(SPRS_CLIEN_ND2) as SPRS_CLIEN_ND2_SUM, 
                    sum(LGRS_CLIEN) as LGRS_CLIEN_SUM, 
                    sum(LGRS_CLIEN_8) as LGRS_CLIEN_8_SUM, 
                    sum(LGRS_CLIEN_ND1) as LGRS_CLIEN_ND1_SUM, 
                    sum(LGRS_CLIEN_ND2) as LGRS_CLIEN_ND2_SUM, 
                    sum(SPL_CLIENT) as SPL_CLIENT_SUM, 
                    sum(SPL_CLIENT_8) as SPL_CLIENT_8_SUM, 
                    sum(SPL_CLIENT_ND1) as SPL_CLIENT_ND1_SUM, 
                    sum(SPL_CLIENT_ND2) as SPL_CLIENT_ND2_SUM, 
                    sum(RST_CLIENT) as RST_CLIENT_SUM, 
                    sum(RST_CLIENT_8) as RST_CLIENT_8_SUM, 
                    sum(RST_CLIENT_ND1) as RST_CLIENT_ND1_SUM, 
                    sum(RST_CLIENT_ND2) as RST_CLIENT_ND2_SUM, 
                    sum(REG_CLIENT) as REG_CLIENT_SUM, 
                    sum(REG_CLIENT_8) as REG_CLIENT_8_SUM, 
                    sum(REG_CLIENT_ND1) as REG_CLIENT_ND1_SUM, 
                    sum(REG_CLIENT_ND2) as REG_CLIENT_ND2_SUM, 
                    sum(REGND_CLIE) as REGND_CLIE_SUM, 
                    sum(REGND_CLIE_8) as REGND_CLIE_8_SUM, 
                    sum(REGND_CLIE_ND1) as REGND_CLIE_ND1_SUM, 
                    sum(REGND_CLIE_ND2) as REGND_CLIE_ND2_SUM, 
                    sum(LG_CLIENT) as LG_CLIENT_SUM, 
                    sum(LG_CLIENT_8) as LG_CLIENT_8_SUM, 
                    sum(LG_CLIENT_ND1) as LG_CLIENT_ND1_SUM, 
                    sum(LG_CLIENT_ND2) as LG_CLIENT_ND2_SUM, 
                    sum(LGLSPL) as LGLSPL_SUM, 
                    sum(LGLSPL_8) as LGLSPL_8_SUM, 
                    sum(LGLSPL_ND1) as LGLSPL_ND1_SUM, 
                    sum(LGLSPL_ND2) as LGLSPL_ND2_SUM, 
                    sum(LGLSPLRST) as LGLSPLRST_SUM, 
                    sum(LGLSPLRST_8) as LGLSPLRST_8_SUM, 
                    sum(LGLSPLRST_ND1) as LGLSPLRST_ND1_SUM, 
                    sum(LGLSPLRST_ND2) as LGLSPLRST_ND2_SUM, 
                    sum(LGLSPL_CLI) as LGLSPL_CLI_SUM, 
                    sum(LGLSPL_CLI_8) as LGLSPL_CLI_8_SUM, 
                    sum(LGLSPL_CLI_ND1) as LGLSPL_CLI_ND1_SUM, 
                    sum(LGLSPL_CLI_ND2) as LGLSPL_CLI_ND2_SUM, 
                    sum(LGLSPL_ND1_2) as LGLSPL_ND1_2_SUM, 
                    sum(LGLSPL_ND1_2_8) as LGLSPL_ND1_2_8_SUM, 
                    sum(LGLSPL_ND1_2_ND1) as LGLSPL_ND1_2_ND1_SUM, 
                    sum(LGLSPL_ND1_2_ND2) as LGLSPL_ND1_2_ND2_SUM,
                    employee_id'
                )->where('status', '1')->where('employee_id', $this->employee_id)->where('supervisor_id', $_SESSION['sys_id'])->whereBetween('ot_date', [$this->date_from, $this->date_to])->get()
                ]);
            }
        }
        
    }
}
  




  