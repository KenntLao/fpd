<table>
    <thead>
    <tr>
        <th>COMPANY ID</th>
        <th>EMPLOYEE NO</th>
        <th>LASTNAME</th>
        <th>FIRSTNAME</th>
        <th>DEPARTMENT</th>
        @foreach($types as $type)
        <th>{{$type->name}}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($overtimes as $overtime)
        <tr>
            <td>FPD ASIA</td>
            <td>{{ $overtime->employee->employee_number }}</td>
            <td>{{ $overtime->employee->lastname }}</td>
            <td>{{ $overtime->employee->firstname }}</td>
            <td>{{ $overtime->employee->department->code }}</td>
            <td>{{ $overtime->REG_SUM }}</td>
            <td>{{ $overtime->REG_8_SUM }}</td>
            <td>{{ $overtime->REG_ND1_SUM }}</td>
            <td>{{ $overtime->REG_ND2_SUM }}</td>
            <td>{{ $overtime->RST_SUM }}</td>
            <td>{{ $overtime->RST_8_SUM }}</td>
            <td>{{ $overtime->RST_ND1_SUM }}</td>
            <td>{{ $overtime->RST_ND2_SUM }}</td>
            <td>{{ $overtime->LGL_SUM }}</td>
            <td>{{ $overtime->LGL_8_SUM }}</td>
            <td>{{ $overtime->LGL_ND1_SUM }}</td>
            <td>{{ $overtime->LGL_ND2_SUM }}</td>
            <td>{{ $overtime->LGLRST_SUM }}</td>
            <td>{{ $overtime->LGLRST_8_SUM }}</td>
            <td>{{ $overtime->LGLRST_ND1_SUM }}</td>
            <td>{{ $overtime->LGLRST_ND2_SUM }}</td>
            <td>{{ $overtime->SPL_SUM }}</td>
            <td>{{ $overtime->SPL_8_SUM }}</td>
            <td>{{ $overtime->SPL_ND1_SUM }}</td>
            <td>{{ $overtime->SPL_ND2_SUM }}</td>
            <td>{{ $overtime->SPLRST_SUM }}</td>
            <td>{{ $overtime->SPLRST_8_SUM }}</td>
            <td>{{ $overtime->SPLRST_ND1_SUM }}</td>
            <td>{{ $overtime->SPLRST_ND2 }}</td>
            <td>{{ $overtime->SPRS_CLIEN_SUM }}</td>
            <td>{{ $overtime->SPRS_CLIEN_8_SUM }}</td>
            <td>{{ $overtime->SPRS_CLIEN_ND1_SUM }}</td>
            <td>{{ $overtime->SPRS_CLIEN_ND2_SUM }}</td>
            <td>{{ $overtime->LGRS_CLIEN_SUM }}</td>
            <td>{{ $overtime->LGRS_CLIEN_8_SUM }}</td>
            <td>{{ $overtime->LGRS_CLIEN_ND1_SUM }}</td>
            <td>{{ $overtime->LGRS_CLIEN_ND2_SUM }}</td>
            <td>{{ $overtime->SPL_CLIENT_SUM }}</td>
            <td>{{ $overtime->SPL_CLIENT_8_SUM }}</td>
            <td>{{ $overtime->SPL_CLIENT_ND1_SUM }}</td>
            <td>{{ $overtime->SPL_CLIENT_ND2_SUM }}</td>
            <td>{{ $overtime->RST_CLIENT_SUM }}</td>
            <td>{{ $overtime->RST_CLIENT_8_SUM }}</td>
            <td>{{ $overtime->RST_CLIENT_ND1_SUM }}</td>
            <td>{{ $overtime->RST_CLIENT_ND2_SUM }}</td>
            <td>{{ $overtime->REG_CLIENT_SUM }}</td>
            <td>{{ $overtime->REG_CLIENT_8_SUM }}</td>
            <td>{{ $overtime->REG_CLIENT_ND1_SUM }}</td>
            <td>{{ $overtime->REG_CLIENT_ND2_SUM }}</td>
            <td>{{ $overtime->REGND_CLIE_SUM }}</td>
            <td>{{ $overtime->REGND_CLIE_8_SUM }}</td>
            <td>{{ $overtime->REGND_CLIE_ND1_SUM }}</td>
            <td>{{ $overtime->REGND_CLIE_ND2_SUM }}</td>
            <td>{{ $overtime->LG_CLIENT_SUM }}</td>
            <td>{{ $overtime->LG_CLIENT_8_SUM }}</td>
            <td>{{ $overtime->LG_CLIENT_ND1_SUM }}</td>
            <td>{{ $overtime->LG_CLIENT_ND2_SUM }}</td>
            <td>{{ $overtime->LGLSPL_SUM }}</td>
            <td>{{ $overtime->LGLSPL_8_SUM }}</td>
            <td>{{ $overtime->LGLSPL_ND1_SUM }}</td>
            <td>{{ $overtime->LGLSPL_ND2_SUM }}</td>
            <td>{{ $overtime->LGLSPLRST_SUM }}</td>
            <td>{{ $overtime->LGLSPLRST_8_SUM }}</td>
            <td>{{ $overtime->LGLSPLRST_ND1_SUM }}</td>
            <td>{{ $overtime->LGLSPLRST_ND2_SUM }}</td>
            <td>{{ $overtime->LGLSPL_CLI_SUM }}</td>
            <td>{{ $overtime->LGLSPL_CLI_8_SUM }}</td>
            <td>{{ $overtime->LGLSPL_CLI_ND1_SUM }}</td>
            <td>{{ $overtime->LGLSPL_CLI_ND2_SUM }}</td>
            <td>{{ $overtime->LGLSPL_ND1_2_SUM }}</td>
            <td>{{ $overtime->LGLSPL_ND1_2_8_SUM }}</td>
            <td>{{ $overtime->LGLSPL_ND1_2_ND1_SUM }}</td>
            <td>{{ $overtime->LGLSPL_ND1_2_ND2_SUM }}</td>
        </tr>
    @endforeach
    </tbody>
</table>