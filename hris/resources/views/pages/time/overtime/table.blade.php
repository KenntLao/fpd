<table>
    <thead>
        <tr>
            <th>COMPANY ID</th>
            <th>EMPLOYEE NO</th>
            <th>LASTNAME</th>
            <th>FIRSTNAME</th>
            <th>DEPARTMENT</th>
            <th>REG</th>
            <th>REG_>8</th>
            <th>REG_ND1</th>
            <th>REG_ND2</th>
            <th>RST</th>
            <th>RST_>8</th>
            <th>RST_ND1</th>
            <th>RST_ND2</th>
            <th>LGL</th>
            <th>LGL_>8</th>
            <th>LGL_ND1</th>
            <th>LGL_ND2</th>
            <th>LGLRST</th>
            <th>LGLRST_>8</th>
            <th>LGLRST_ND1</th>
            <th>LGLRST_ND2</th>
            <th>SPL</th>
            <th>SPL_>8</th>
            <th>SPL_ND1</th>
            <th>SPL_ND2</th>
            <th>SPLRST</th>
            <th>SPLRST_>8</th>
            <th>SPLRST_ND1</th>
            <th>SPLRST_ND2 }}</th>
            <th>SPRS_CLIEN</th>
            <th>SPRS_CLIEN_>8</th>
            <th>SPRS_CLIEN_ND1</th>
            <th>SPRS_CLIEN_ND2</th>
            <th>LGRS_CLIEN</th>
            <th>LGRS_CLIEN_8</th>
            <th>LGRS_CLIEN_ND1</th>
            <th>LGRS_CLIEN_ND2</th>
            <th>SPL_CLIENT</th>
            <th>SPL_CLIENT_>8</th>
            <th>SPL_CLIENT_ND1</th>
            <th>SPL_CLIENT_ND2</th>
            <th>RST_CLIENT</th>
            <th>RST_CLIENT_>8</th>
            <th>RST_CLIENT_ND1</th>
            <th>RST_CLIENT_ND2</th>
            <th>REG_CLIENT</th>
            <th>REG_CLIENT_>8</th>
            <th>REG_CLIENT_ND1</th>
            <th>REG_CLIENT_ND2</th>
            <th>REGND_CLIE</th>
            <th>REGND_CLIE_>8</th>
            <th>REGND_CLIE_ND1</th>
            <th>REGND_CLIE_ND2</th>
            <th>LG_CLIENT</th>
            <th>LG_CLIENT_>8</th>
            <th>LG_CLIENT_ND1</th>
            <th>LG_CLIENT_ND2</th>
            <th>LGLSPL</th>
            <th>LGLSPL_>8</th>
            <th>LGLSPL_ND1</th>
            <th>LGLSPL_ND2</th>
            <th>LGLSPLRST</th>
            <th>LGLSPLRST_>8</th>
            <th>LGLSPLRST_ND1</th>
            <th>LGLSPLRST_ND2</th>
            <th>LGLSPL_CLI</th>
            <th>LGLSPL_CLI_>8</th>
            <th>LGLSPL_CLI_ND1</th>
            <th>LGLSPL_CLI_ND2</th>
            <th>LGLSPL_ND1_2</th>
            <th>LGLSPL_ND1_2_>8</th>
            <th>LGLSPL_ND1_2_ND1</th>
            <th>LGLSPL_ND1_2_ND2</th>
        </tr>
    </thead>
    <tbody>
        @foreach($overtimes as $overtime)
        <tr>
            <td>FPD ASIA</td>
            <td>{{ $overtime->employee->employee_number }}</td>
            <td>{{ $overtime->employee->lastname }}</td>
            <td>{{ $overtime->employee->firstname }}</td>
            <td>
                  @if($overtime->employee->department)
                  {{ $overtime->employee->department->code }}
                  @else
                  ----
                  @endif
            </td>
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