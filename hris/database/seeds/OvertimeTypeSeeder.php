<?php

use Illuminate\Database\Seeder;

class OvertimeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('hris_overtime_types')->delete();

    	$types = array(

            array('name' => 'REG'),
            array('name' => 'REG_>8'),
            array('name' => 'REG_ND1'),
            array('name' => 'REG_ND2'),
            array('name' => 'RST'),
            array('name' => 'RST_>8'),
            array('name' => 'RST_ND1'),
            array('name' => 'RST_ND2'),
            array('name' => 'LGL'),
            array('name' => 'LGL_>8'),
            array('name' => 'LGL_ND1'),
            array('name' => 'LGL_ND2'),
            array('name' => 'LGLRST'),
            array('name' => 'LGLRST_>8'),
            array('name' => 'LGLRST_ND1'),
            array('name' => 'LGLRST_ND2'),
            array('name' => 'SPL'),
            array('name' => 'SPL_>8'),
            array('name' => 'SPL_ND1'),
            array('name' => 'SPL_ND2'),
            array('name' => 'SPLRST'),
            array('name' => 'SPLRST_>8'),
            array('name' => 'SPLRST_ND1'),
            array('name' => 'SPLRST_ND2'),
            array('name' => 'SPRS_CLIEN'),
            array('name' => 'SPRS_CLIEN_>8'),
            array('name' => 'SPRS_CLIEN_ND1'),
            array('name' => 'SPRS_CLIEN_ND2'),
            array('name' => 'LGRS_CLIEN'),
            array('name' => 'LGRS_CLIEN_>8'),
            array('name' => 'LGRS_CLIEN_ND1'),
            array('name' => 'LGRS_CLIEN_ND2'),
            array('name' => 'SPL_CLIENT'),
            array('name' => 'SPL_CLIENT_>8'),
            array('name' => 'SPL_CLIENT_ND1'),
            array('name' => 'SPL_CLIENT_ND2'),
            array('name' => 'RST_CLIENT'),
            array('name' => 'RST_CLIENT_>8'),
            array('name' => 'RST_CLIENT_ND1'),
            array('name' => 'RST_CLIENT_ND2'),
            array('name' => 'REG_CLIENT'),
            array('name' => 'REG_CLIENT_>8'),
            array('name' => 'REG_CLIENT_ND1'),
            array('name' => 'REG_CLIENT_ND2'),
            array('name' => 'REGND_CLIE'),
            array('name' => 'REGND_CLIE_>8'),
            array('name' => 'REGND_CLIE_ND1'),
            array('name' => 'REGND_CLIE_ND2'),
            array('name' => 'LG_CLIENT'),
            array('name' => 'LG_CLIENT_>8'),
            array('name' => 'LG_CLIENT_ND1'),
            array('name' => 'LG_CLIENT_ND2'),
            array('name' => 'LGLSPL'),
            array('name' => 'LGLSPL_>8'),
            array('name' => 'LGLSPL_ND1'),
            array('name' => 'LGLSPL_ND2'),
            array('name' => 'LGLSPLRST'),
            array('name' => 'LGLSPLRST_>8'),
            array('name' => 'LGLSPLRST_ND1'),
            array('name' => 'LGLSPLRST_ND2'),
            array('name' => 'LGLSPL_CLI'),
            array('name' => 'LGLSPL_CLI_>8'),
            array('name' => 'LGLSPL_CLI_ND1'),
            array('name' => 'LGLSPL_CLI_ND2'),
            array('name' => 'LGLSPL_ND1(2)'),
            array('name' => 'LGLSPL_ND1(2)_>8'),
            array('name' => 'LGLSPL_ND1(2)_ND1'),
            array('name' => 'LGLSPL_ND1(2)_ND2')

    	);

    	DB::table('hris_overtime_types')->insert($types);
    }
}
