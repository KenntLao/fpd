<?php
// language array
$language_arr = array(
	array(0,'English'),
	array(1,'日本語')
);

// allowed attachments
$allowed_attachments_arr = array('jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx', 'txt', 'csv', 'xla', 'xlam', 'xls', 'xlsb', 'xlsm', 'xlsx');

// status array
$status_arr = array(
	array(0,
		array(
			'Active',
			'アクティブ'
		)
	),
	array(1,
		array(
			'Deactivated',
			'無効化'
		)
	)
);

// gender array
$gender_arr = array(
	array(0,
		array(
			'Female',
			'女性'
		)
	),
	array(1,
		array(
			'Male',
			'男性'
		)
	)
);

// yes no array
$yesno_arr = array(
	array(0,
		array(
			'No',
			'いや'
		)
	),
	array(1,
		array(
			'Yes',
			'はい'
		)
	)
);

// vacant type array
$vacancy_type_arr = array(
    array(0,
        array(
            'Unsold',
            '売れ残り'
        )
    ),
    array(1,
        array(
            'Sold but Vacant',
            '販売済みだが空いている'
        )
    )
);

// civil status array
$civil_status_arr = array(
	array(0,
		array(
			'Single',
			'独身'
		)
	),
	array(1,
		array(
			'Married',
			'既婚'
		)
	),
	array(2,
		array(
			'Separated/Divorced',
			'別居/離婚'
		)
	),
	array(3,
		array(
			'Widow/er',
			'男やもめ'
		)
	),
    array(4,
        array(
            'Rather not to say',
            '言うのではなく'
        )
    )
);

// unit type array
$unit_type_arr = array(
	array(0,
		array(
			'Residential',
			'居住の'
		)
	),
	array(1,
		array(
			'Commercial',
			'商業の'
		)
	),
	array(2,
		array(
			'Office',
			''
		)
	)
);

// equipments name array
$equipments_arr = array(
    array('a.',
        array(
            'title' => array(
                'Generator Set',
                '発電機セット'
            ),
            'options' => array()
        )
    ),
    array('b.',
        array(
            'title' => array(
                'ATS/Units',
                'ATS /ユニット'
            ),
            'options' => array()
        )
    ),
    array('c.',
        array(
            'title' => array(
                'Power Transformer/s',
                '電源トランス'
            ),
            'options' => array()
        )
    ),
    array('d.',
        array(
            'title' => array(
                'Telephone System',
                '電話システム'
            ),
            'options' => array(
                'd.1' => array(
                    'Video Entry Phone',
                    'ビデオエントリー電話'
                 ),
                'd.2' => array(
                    'PABX',
                    'PABX'
                 ),
                'd.3' => array(
                    'Intercon',
                    'インターコン'
                 ),
                'd.4' => array(
                    'Paging System',
                    'ページングシステム'
                 ),
                'd.5' => array(
                    'Internet/LAN',
                    'インターネット/ LAN'
                 )
            )
        )
     ),
    array('e.',
        array(
            'title' => array(
                'Mechanical System',
                '機械システム'
            ),
        'options' => array(
                'e.1' => array(
                    'Aircon System',
                    'エアコンシステム'
                ),
                'e.2' => array(
                    'Cooling Tower/Chiller',
                    '冷却塔/チラー'
                ),
                'e.3' => array(
                    'AHU',
                    'AHU'
                ),
                'e.4' => array(
                    'Boiler',
                    'ボイラー'
                ),
                'e.5' => array(
                    'Exhaust Fans',
                    '排気ファン'
                ),
                'e.6' => array(
                    'Supply Fans',
                    '供給ファン'
                )
            )
        )
    ),
    array('f.',
        array(
            'title' => array(
                'Fire Protection System',
                '防火システム'
            ),
            'options' => array(
                'f.1' => array(
                    'Sprinkle System',
                    'スプリンクラーのシステム'
                ),
                'f.2' => array(
                    'FDAS',
                    'FDAS'
                )
            )
        )
    ),
    array('g.',
        array(
            'title' => array(
                'Water System (Pumps and Equipment)',
                '水システム（ポンプと機器）'
            ),
            'options' => array(
                'g.1' => array(
                    'Transfer Pumps',
                    '移送ポンプ'
                ),
                'g.2' => array(
                    'Jockey Pump',
                    'ジョッキーポンプ'
                ),
                'g.3' => array(
                    'Main Fire Pump',
                    'メイン消防ポンプ'
                ),
                'g.4' => array(
                    'Sump Pump/s',
                    'サンプポンプ'
                ),
                'g.5' => array(
                    'Sewage Pump/s',
                    '下水ポンプ'
                ),
                'g.6' => array(
                    'Hydro Pump/s',
                    'ハイドロポンプ'
                ),
                'g.7' => array(
                    'Booster Pump/s',
                    'ブースターポンプ'
                ),
                'g.8' => array(
                    'Deep well Pump/s',
                    '深井戸ポンプ'
                ),
                'g.9' => array(
                    'Water Chlorination System',
                    '水塩素化システム'
                    )
            )
        )
    ),
    array('h.',
        array(
            'title' => array(
                'STP/WWTP',
                'STP/WWTP'
            ),
            'options' => array()
        )
    ),
    array('i.',
        array(
            'title' => array(
                'BMS',
                'BMS'
            ),
            'options' => array()
        )
    ),
    array('j.',
        array(
            'title' => array(
                'CCTV',
                'CCTV'
            ),
            'options' => array()
        )
    ),
    array('k.',
        array(
            'title' => array(
                'Cable TV',
                'ケーブルテレビ'
            ),
            'options' => array()
        )
    ),
    array('l.',
        array(
            'title' => array(
                'Elevator System',
                'エレベーターシステム'
            ),
            'options' => array()
        )
    ),
    array('m.',
        array(
            'title' => array(
                'Escalator System',
                'エスカレーターシステム'
            ),
            'options' => array()
        )
    ),
    array('n.',
        array(
            'title' => array(
                'Gondola',
                'ゴンドラ'
            ),
            'options' => array()
        )
    ),
    array('o.',
        array(
            'title' => array(
                'Communication Tower',
                'コミュニケーションタワー'
            ),
            'options' => array()
        )
    ),
    array('p.',
        array(
            'title' => array(
                'Others',
                'Others'
            ),
            'options' => array()
        )
    )
);
//equipments no fields row
$equipment_no_fields_letters = array('d.','e.','f.','g.');

$nature_of_job_arr = array(
	array(
		'Civil',
		''
	),
	array(
		'Electrical',
		''
	),
	array(
		'Sanitary/Plumbing',
		''
	),
	array(
		'Others',
		''
	)
);

// PAYMENT TYPES ARRAY
$payment_types_arr = array(
    '0' => array(
        'Cash',
        ''
    ),
    '1' => array(
        'Direct Deposit/Online Banking',
        ''
    ),
    '2' => array(
        'Check',
        ''
    ),
    '3' => array(
        'Credit Card',
        ''
    ),
    '4' => array(
        'Bills Payment',
        ''
    )
);
$payment_types_color_arr = array(
    '0' => 'info',
    '1' => 'success',
    '2' => 'warning',
    '3' => 'primary',
    '4' => 'danger'
);
// REFERENCE NUMBER ARRAY
$reference_number_arr = array(
    '1' => array(
        'AR',
        ''
    ),
    '2' => array(
        'OR',
        ''
    ),
    '3' => array(
        'PR',
        ''
    )
);
//MONTHS ARRAY
$months_arr = array(
	'01' => array(
		'January',
		''
	),
	'02' => array(
		'February',
		''
	),
	'03' => array(
		'March',
		''
	),
	'04' => array(
		'April',
		''
	),
	'05' => array(
		'May',
		''
	),
	'06' => array(
		'June',
		''
	),
	'07' => array(
		'july',
		''
	),
	'08' => array(
		'August',
		''
	),
	'09' => array(
		'September',
		''
	),
	'10' => array(
		'October',
		''
	),
	'11' => array(
		'November',
		''
	),
	'12' => array(
		'December',
		''
	)
);

// PROSPECTING PROPERTY CATEGORY
$prospecting_property_category_arr = array(
	array(
		'Residential',
		''
	),
	array(
		'Residential/Commercial',
		''
	),
	array(
		'Office/Commercial',
		''
	),
	array(
		'Mixed Use',
		''
	),
	array(
		'Commercial',
		''
	),
	array(
		'School/Institution',
		''
	),
	array(
		'Embassy',
		''
	),
    array(
        'Manufacturing',
        ''
    ),
    array(
        'Others',
        ''
    )
);
// PROSPECTING NUMBER OF BUILDING ARRAY
$prospecting_number_of_building_arr = array(
	array(
		'One',
		''
	),
	array(
		'Two',
		''
	),
	array(
		'Three',
		''
	),
	array(
		'Four',
		''
	),
	array(
		'Five',
		''
	)
);

// PROSPECTING SERVICE REQUIRED BDMD ARRAY
$prospecting_service_required_arr = array(
	array(
		'Property Management',
		''
	),
	array(
		'Facilities Management',
		''
	),
	array(
		'Engineering Services',
		''
	),
	array(
		'Consultancy - PM',
		''
	),
	array(
		'Consultancy - Retail',
		''
	),
	array(
		'Leasing Services',
		''
	),
	array(
		'Retail Consultancy and Leasing Services',
		''
	),
	array(
		'Accounting / Financial Management',
		''
	)
);

// PROSPECTING SERVICE REQUIRED ESD
$prospecting_esd_service_required_arr = array(
    '0' => array(
        'Technical & Safety Audit',
        ''
    ),
    '1' => array(
        'Power Quality Audit',
        ''
    ),
    '2' => array(
        'Electrical Audit',
        ''
    ),
    '3' => array(
        'Electrical Thermal Scanning',
        ''
    ),
    '4' => array(
        'Vetting',
        ''
    ),
    '5' => array(
        'Fit-Out Management',
        ''
    ),
    '6' => array(
        'Aircon Services',
        ''
    ),
    '7' => array(
        'Generator Services',
        ''
    ),
    '8' => array(
        'Electrical Repairs & Installation',
        ''
    ),
    '9' => array(
        'Plumbing Repairs & Installation',
        ''
    ),
    '10' => array(
        'Civil Works',
        ''
    )
);
// PROSPECTING OTHER REMARKS ARRAY
$prospecting_other_remarks_arr = array(
	array(
		'Active Lead',
		''
	),
	array(
		'Cold Lead',
		''
	),
	array(
		'Inactive Lead',
		''
	)
);
// PROSPECTING LEAD RECEIVED THROUGH ARRAY
$prospecting_lead_received_through_arr = array(
    array(
        'Call-in',
        ''
    ),
    array(
        'Email Inquiry',
        ''
    ),
    array(
        'Referral - Employee',
        ''
    ),
    array(
        'Referral - External',
        ''
    ),
    array(
        'Existing Client',
        ''
    ),
    array(
        'Newspaper/Magazine',
        ''
    ),
    array(
        'Mailer',
        ''
    ),
    array(
        'Internet Search',
        ''
    ),
    array(
        'Social Media',
        ''
    )
);
// PREVENTIVE MAINTENANCE FREQUENCY ARRAY
$preventive_maintenance_frequency_arr = array(
	array('D',
		array(
            'Daily',
            ''
        )
    ),
    array('W',
        array(
            'Weekly',
            ''
        )
    ),
    array('M',
        array(
            'Monthly',
            ''
        )
    ),
	array('Q',
       array(
            'Quarterly',
            ''
        )
    ),
    array('S',
        array(
            'Semi Annual',
            ''
        )
    ),
    array('A',
        array(
            'Annual',
            ''
        )
    )
);
// PRIORITY ARRAY
$priority_arr = array(
	array(
		'Low',
		''
	),
	array(
		'Medium',
		''
	),
	array(
		'High',
    ''
  )
);
 // NOTICE TO PROCEED ARRAY  
$notice_to_proceed_status_arr = array(
	array(
		'Sent',
		''
	),
	array(
		'Received',
		''
	)
);
// CONTRACT STATUS ARRAY
$contract_status_arr = array(
	array(
		'Active',
		''
	),
	array(
		'For Approval',
		''
	),
	array(
		'Lapsed',
		''
	),
	array(
		'Expired',
		''
	),
	array(
		'Terminated',
		''
	),
	array(
		'For Renewal',
		''
	)
);

// DOWNPAYMENTS TERMS ARRAY
$contract_terms_arr = array(
	array(
		'Monthly',
		''
	),
	array(
		'Quarterly',
		''
	),
	array(
		'Semi Annual',
		''
	),
	array(
		'Annual',
		''
	)
);

// PROSPECT STATUS ARRAY
$prospect_status_arr = array(
    '0' => array(
        'Active',
        ''
    ),
    '3' => array(
        'Closed',
        ''
    ),
    '1' => array(
        'Inactive',
        ''
    ),
    '2' => array(
        'Declined by FPD',
        ''
    ),
    '4' => array(
        'Declined by Client',
        ''
    )
);
// DOWNPAYMENTS TERMS ARRAY
$downpayments_terms_arr = array(
	array(
		'Monthly',
		''
	),
	array(
		'Quarterly',
		''
	),
	array(
		'Semi Annual',
		''
	),
	array(
		'Annual',
		''
	)
);

// Pre oeration audit categories
$pre_operation_audit_categories_arr = array(
    array(
        'Administration',
        ''
    ),
    array(
        'Engineering',
        ''
    ),
    array(
        'Housekeeping',
        ''
    ),
    array(
        'Security',
        ''
    ),
    array(
        'Carpark',
        ''
    ),
    array(
        'Swimming Pool',
        ''
    )
);

// 30-60-90 Days
$day_plans_arr = array(
    array('A.30',
        array(
            '30 Day Goals',
            ''
        )
    ),
    array('B.60',
        array(
            '60 Day Goals',
            ''
        )
    ),
    array('C.90',
        array(
            '90 Day Goals',
            ''
        )
    )
);

// VISITORS STATUS
$visitors_status_arr = array(
    array(
        'For Approval',
        ''
    ),
    array(
        'Approved',
        ''
    ),
    array(
        'Declined',
        ''
    )
);
// BTN VISITORS STATUS ARRAY
$visitors_status_status_arr = array(
        ' btn-info',
        ' btn-success',
        ' btn-danger'
);

// MOVE IN/OUT REQUEST
$move_inout_request_arr = array(
    array(
        'Move In',
        ''
    ),
    array(
        'Move Out',
        ''
    ),
    array(
        'Gate Pass Person',
        ''
    ),
    array(
        'Gate Pass Item',
        ''
    )
);

// BOARDROOM STATUS
$boardroom_status_arr = array(
    array(
        'For Approval',
        ''
    ),
    array(
        'Approved',
        ''
    ),
    array(
        'Declined',
        ''
    )
);

// amenities STATUS
$amenities_arr = array(
    array(
        'For Approval',
        ''
    ),
    array(
        'Approved',
        ''
    ),
    array(
        'Declined',
        ''
    )
);

// BTN STATUS ARRAY
$btn_status_arr = array(
    ' btn-success',
    ' btn-info',
    ' btn-warning',
    ' btn-ff6600',
    ' btn-danger',
    ' btn-secondary'
);
// MOVE IN/OUT REQUEST
$move_inout_request_status_arr = array(
    array(
        'For Approval',
        ''
    ),
    array(
        'Approved',
        ''
    ),
    array(
        'Declined',
        ''
    )
);
// BTN MOVE IN/OUT REQUEST STATUS ARRAY
$btn_move_inout_request_status_arr = array(
        ' btn-info',
        ' btn-success',
        ' btn-danger'
);

// PERMITS AND LICENCES
$permits_and_licences_arr = array(
    array(
        'Annual',
        ''
    ),
    array(
        'Quarterly',
        ''
    ),
    array(
        'Monthly',
        ''
    )
);

// 30 60 90 days actions
$day_plan_actions_arr = array(
    '30' => array(
        array(
            'Conduct Technical Safety Audit with testing and commissioning',
            ''
        ),
        array(
            'Conduct QEHS Take -Over audit',
            ''
        ),
        array(
            'Conduct Accounting Take-Over',
            ''
        ),
        array(
            'Deploy Interim BM ',
            ''
        ),
        array(
            'Meet and Greet Board of Directors and Committee Heads',
            ''
        ),
        array(
            'Generate the Gap Analysis Report',
            ''
        ),
        array(
            'Meet with APMC team on any noted deficiences with the Turn-over',
            ''
        ),
        array(
            'Follow-up or firm up deployment status',
            ''
        ),
        array(
            'Deploy interim for shadowing of Accounting Officer/Asst, Admin Asst and BLdg Engineer',
            ''
        ),
        array(
            'Install Accumatica',
            ''
        ),
        array(
            'Rectify  noted audit findings',
            ''
        ),
        array(
            'Create the Property Handbook',
            ''
        ),
        array(
            'Collect the deposit',
            ''
        ),
        array(
            'Finalize the contract.',
            ''
        ),
        array(
            'Review House Rules, Master Deed of Restrictions and By Laws.',
            ''
        ),
        array(
            'Submission of Proposed House Rules Revisions for Board\'s/Client\'s Approval',
            ''
        ),
        array(
            'Review all operational procedures being implemented.',
            ''
        ),
        array(
            'Review of OPEX and CAPEX for 2020.',
            ''
        ),
        array(
            'Review Collection policy.',
            ''
        )
    ),
    '60' => array(
        array(
            'set up of TCAA outlook email address for BM ',
            ''
        ),
        array(
            'Implement Administrative Forms (Gate Pass, Delivery Permit, Work Permit, etc.)',
            ''
        ),
        array(
            'Implement Visitor\'s ID System',
            ''
        ),
        array(
            'Implement Complaint Registry',
            ''
        ),
        array(
            'Implement Preventive Maintenance program for all equipment',
            ''
        ),
        array(
            'Implement tagging of all equipment',
            ''
        ),
        array(
            'Implement 5S in the building.',
            ''
        ),
        array(
            'Ensure BM has access to QMS documents in the server.',
            ''
        ),
        array(
            'Implement EMS and QMS requirement',
            ''
        ),
        array(
            'Present to the Board the Gap Analyis Report and Accumatica',
            ''
        ),
        array(
            'Deployment of direct employee',
            ''
        ),
        array(
            'Conduct monthly staff meeting',
            ''
        ),
        array(
            'Implement proper waste/garbage disposal',
            ''
        ),
        array(
            'Review manning deployment of Security, Housekeeping and technical personnel',
            ''
        ),
        array(
            'Review all encroachment in the common areas.',
            ''
        ),
        array(
            'TCAA Contract Management Review',
            ''
        ),
        array(
            '<b>SECURITY</b>',
            ''
        ),
        array(
            'Initial deployment of Security personnel',
            ''
        ),
        array(
            'Security Plan',
            ''
        ),
        array(
            'Security Personnel 201 File',
            ''
        ),
        array(
            'Review contract and SLA',
            ''
        ),
        array(
            '<b>HOUSEKEEPING</b>',
            ''
        ),
        array(
            'Initial review of Housekeeping deployment',
            ''
        ),
        array(
            'Housekeeping Plan Activity',
            ''
        ),
        array(
            'Housekeeping Personnel 201 File',
            ''
        ),
        array(
            'Review contract and SLA',
            ''
        ),
        array(
            '<b>PEST CONTROL</b>',
            ''
        ),
        array(
            'Review contract and SLA',
            ''
        )
    ),
    '90' => array(
        array(
            'Update the Board on the status of the Gap Analysis Report',
            ''
        ),
        array(
            'Submit Monthly Report ',
            ''
        ),
        array(
            'Submit any recommendation on House Rules improvement',
            ''
        ),
        array(
            'Submit status and recommendation on the review made on any encroachment in common areas.',
            ''
        ),
        array(
            'Submit recommendation of any changes if any in the operational procedures.',
            ''
        ),
        array(
            'Update and ensure accuracy of Billing statements.',
            ''
        ),
        array(
            'Submit recommendations of any changes if any in the collection policy.',
            ''
        ),
        array(
            'Deploy permanent on site personnel for TCAA.',
            ''
        ),
        array(
            'Conduct staff meeting to set expectations and goals.',
            ''
        )
    )
);


// PROSPECTING ACTIVITIES
$prospect_activity_arr = array(
    'LOI' => array(
            'Letter Of Intent',
            ''
        ),
    'ACT_1' => array(
            'Follow Up 1',
            ''
        ),
    'ACT_2' => array(
            'Follow Up 2',
            ''
        ),
    'ACT_3' => array(
        'Follow Up 3',
        ''
    ),
    'ACT' => array(
        'Activities',
        ''
    )
);

// BTN SERVICE REQUEST SERVICE ARRAY
$service_request_service_arr = array(
    array(
        'Civil',
        ''
    ),
    array(
        'Electrical',
        ''
    ),
    array(
        'Sanitary/Plumbing',
        ''
    )
);
// BTN SERVICE REQUEST REMARKS ARRAY
$service_request_remarks_arr = array(
    array(
        'Job Order',
        ''
    ),
    array(
        'Work Order',
        ''
    ),
    array(
        'Endorsed To Third Party',
        ''
    )
);
// BTN SERVICE REQUEST STATUS ARRAY
$btn_service_request_status_arr = array(
        ' btn-danger',
        ' btn-success'
);
// SERVICE REQUEST STATUS
$service_request_status_arr = array(
    array(
        'Open',
        ''
    ),
    array(
        'Closed',
        ''
    )
);

// TSA PRE OPERATION AUDIT
//SECTION 3
$tsa_section_3_arr = array(
    'aircon' => array(
        array(
            'AIR-CONDITIONING SYSTEM',
            ''
        ),
        array(
            array(
                'Brand',
                ''
            ),
            array(
                'Type',
                ''
            ),
            array(
                'Capacity',
                ''
            ),
            array(
                'Phase',
                ''
            ),
            array(
                'Voltage',
                ''
            ),
            array(
                'Current',
                ''
            ),
            array(
                'Frequency',
                ''
            ),
            array(
                'Refrigerant',
                ''
            )
        )
    ),
    'electrical' => array(
        array(
            'ELECTRICAL SYSTEM',
            ''
            ),
        array(
            array(
                'Brand',
                ''
            ),
            array(
                'Phase',
                ''
            )
        )
    ),
    'mechanical' => array(
        array(
            'MECHANICAL SYSTEM',
            ''
        ),
        array(
            array(
                'Brand',
                ''
            ),
            array(
                'Model',
                ''
            ),
            array(
                'Serial',
                ''
            ),
            array(
                'Type',
                ''
            ),
            array(
                'KW',
                ''
            ),
            array(
                'Voltage',
                ''
            ),
            array(
                'Current',
                ''
            ),
            array(
                'Frequency',
                ''
            ),
            array(
                'Phase',
                ''
            ),
            array(
                'RPM',
                ''
            ),
            array(
                'PF',
                ''
            ),
            array(
                'Capacity',
                ''
            ),
            array(
                'Total Running Hours',
                ''
            ),
            array(
                'KVA',
                ''
            ),
            array(
                'Cut In',
                ''
            ),
            array(
                'Cut off',
                ''
            ),
            array(
                'Speed',
                ''
            )
        )
    ),
    'fabrics' => array(
        array(
            'BUILDING FABRICS',
            ''
        ),
        array(
            array(
                '',
                ''
            )
        )
    ),
    'water' => array(
        array(
            'WATER SYSTEM',
            ''
        ),
        array(
            array(
                '',
                ''
            )
        )
    ),
    'drainage_and_sewage' => array(
        array(
            'DRAINAGE AND SEWER SYSTEM',
            ''
        ),
        array(
            array(
                'Brand',
                ''
            )
        )
    ),
    'fire_safety_and_security' => array(
        array(
            'FIRE SAFETY AND SECURITY SYSTEM',
            ''
        ),
        array(
            array(
                'Brand',
                ''
            )
        )
    )  
);

// TSA PRE OPERATION AUDIT
//SECTION 4
$tsa_section_4_arr = array(
    array(
        'Fire Safety Inspection Certificate',
         ''
    ),
    array(
        'Business Permit',
         ''
    ),
    array(
        'Sanitary Permit',
         ''
    ),
    array(
        'Air-Conditioning',
         ''
    ),
    array(
        'Internal Combustion Engine',
         ''
    ),
    array(
        'Machinery (Pumps)',
         ''
    ),
    array(
        'Elevator Certificate',
         ''
    ),
    array(
        'Electrical Certificate',
         ''
    ),
    array(
        'Mechanical Certificate',
         ''
    ),
    array(
        'ERC (Genset)',
         ''
    ),
    array(
        'Certificate of Occupancy',
         ''
    ),
    array(
        'ECC',
         ''
    ),
    array(
        'PTO Genset',
         ''
    ),
    array(
        'MWSS Certificate of Exemption',
         ''
    ),
    array(
        'Hazardous Waste Registration Certificate',
         ''
    ),
    array(
        'Seismograph Installation Certificate',
         ''
    )
);
// CITIZENSHIP
$citizenship_arr = array(
    array(
        'Filipino',
        ''
    ),
    array(
        'United States',
        ''
    ),
    array(
        'Chinese',
        ''
    ),
    array(
        'Russian',
        ''
    )
);

// SOCIAL STATUS
$social_status_arr = array(
    array(
        'Senior',
        ''
    ),
    array(
        'PWD',
        ''
    )
);

// RALATIONSHIP TO TENANT
$relationship_to_tenant_arr = array(
    array(
        'Niece',
        ''
    ),
    array(
        'Brother',
        ''
    ),
    array(
        'Sister',
        ''
    ),
    array(
        'Parents',
        ''
	),
	array(
		'Grandparents',
		''
	),
	array(
		'Cousin',
		''
	),
	array(
		'Driver',
		''
	),
	array(
		'Cleaner',
		''
	),
	array(
		'Household',
		''
	),
	array(
		'Messenger',
		''
	),
	array(
		'Friends',
		''
	),
    array(
        'Others',
        ''
    )
);

// RALATIONSHIP TO OWNER
$relationship_to_owner_arr = array(
    array(
        'Niece',
        ''
    ),
    array(
        'Brother',
        ''
    ),
    array(
        'Sister',
        ''
    ),
    array(
        'Parents',
        ''
	),
	array(
		'Grandparents',
		''
	),
	array(
		'Relative',
		''
	),
	array(
		'Friends',
		''
	),
    array(
        'Others',
        ''
    )
);

// PRF STATUS
$prf_status_arr = array(
    array(
        'Pending',
        ''
    ),
    array(
        'Deployed',
        ''
    )
);

// BTN PRF STATUS ARRAY
$btn_prf_status_arr = array(
    ' btn-primary',
    ' btn-success'
);

// PCC cash on hand
$pcc_cash_on_hand_arr = array(
    array(
        array(
            'Bills',
            ''
        ),
        '1,000.00'
    ),
    array(
        array(
            '',
            ''
        ),
        '500.00'
    ),
    array(
        array(
            '',
            ''
        ),
        '200.00'
    ),
    array(
        array(
            '',
            ''
        ),
        '100.00'
    ),
    array(
        array(
            '',
            ''
        ),
        '50.00'
    ),
    array(
        array(
            '',
            ''
        ),
        '20.00'
    ),
    array(
        array(
            'Coins',
            ''
        ),
        '10.00'
    ),
    array(
        array(
            '',
            ''
        ),
        '5.00'
    ),
    array(
        array(
            '',
            ''
        ),
        '1.00'
    ),
    array(
        array(
            '',
            ''
        ),
        '0.25'
    ),
    array(
        array(
            '',
            ''
        ),
        '0.10'
    ),
    array(
        array(
            '',
            ''
        ),
        '0.05'
    ),
    array(
        array(
            '',
            ''
        ),
        '0.01'
    )
);

// PCC items to be checked
$pcc_items_to_be_checked_arr = array(
    array(
        'PCF is kept in vault or safety deposit box.',
        ''
    ),
    array(
        'Building Manager and Accounting Assistant are not the custodian of PCF.',
        ''
    ),
    array(
        'PCF is separated from other funds and/or personal funds. Collections are not used as PCF.',
        ''
    ),
    array(
        'PCF is established in accordance with approved termstated on the Property Management Services Contract.',
        ''
    ),
    array(
        'Standardized PC advance is prepared before release of fund signed by BM for approval.',
        ''
    ),
    array(
        'PC advance is liquidated within 3 days from actual cash issuance.',
        ''
    ),
    array(
        'All disbursements are attached with standardized form of PCV and supported by OR. PCV, OR and other supporting documents are stamped "PAID" once actual payment is made.',
        ''
    ),
    array(
        'Operations Manager approves expenses which exceeds Php 1,000.00.',
        ''
    ),
    array(
        'Replenishment of PCF is done when PC vouchers reach 50% of the total amount of PCF.',
        ''
    ),
    array(
        'Copy of the signed acknowledgement receipt I kept by the custodian upon receipt of PC amount.',
        ''
    ),
    array(
        'The approving authority is different from the PCF custodian.',
        ''
    ),
    array(
        'The amount of PCF is approved by the Board.',
        ''
    ),
    array(
        'The PCF per count is the same as PCF per Book.',
        ''
    )
);

// PCV legends arr
$pre_op_audit_pcv_legend_arr = array(
    'A' => array(
        'With PCV',
        ''
    ),
    'B' => array(
        'PCV properly filled up',
        ''
    ),
    'C' => array(
        'PCV consecutively numbered',
        ''
    ),
    'D' => array(
        'PCV approved',
        ''
    ),
    'E' => array(
        'PCV Received',
        ''
    ),
    'F' => array(
        'With supporting documents',
        ''
    ),
    'G' => array(
        'Supporting documents agree with petty cash vocuhers',
        ''
    ),
    'H' => array(
        'Did not exceed P1,000.00 or the maximum',
        ''
    ),
    'I' => array(
        'Disbursement not split off to qualify as petty cash expense',
        ''
    ),
    'J' => array(
        'Documents stamped "PAID"',
        ''
    ),
    'K' => array(
        'PCV and supporting documents free from alterations',
        ''
    )
);

// PCV status legend arr
$pre_op_audit_pcv_status_legend_arr = array(
    'a' => array(
        'Complied',
        ''
    ),
    'r' => array(
        'Not Complied',
        ''
    )
);

// SCOPE OF SERVICE
$scope_of_service_arr = array(
    array(
        'Consulting',
        ''
    ),
    array(
        'Fil-out Management',
        ''
    ),
    array(
        'Facilities Management',
        ''
    ),
    array(
        'Property Management',
        ''
    ),
    array(
        'Engineering',
        ''
    ),
    array(
        'Others',
        ''
    )
);

// FOR HR's INFORMATION
$hr_information_arr = array(
    array(
        'Building Manager III',
        ''
    ),
    array(
        'Building Engineer II',
        ''
    ),
    array(
        'Accounting Officer II',
        ''
    ),
    array(
        'Billing and Collection Assistant I',
        ''
    ),
    array(
        'Administrative Assistant I',
        ''
    )
);

// CAD INFORMATION
$inclusions_arr = array(
    '0' => array(
        'Acumatica',
        ''
    ),
    '1' => array(
        'TSA',
        ''
    ),
    '2' => array(
        'PQA and Thermal Scanning',
        ''
    )
);

// REFERENCE DOCUMENTS
$reference_documents_arr = array(
    array(
        'Labor Cost Breakdown',
        ''
    ),
    array(
        'Detailed Scope of Work',
        ''
    ),
    array(
        'Sign Notice to Proceed',
        ''
    )
);
// PROSPECTING CATEGORY
$prospecting_category_arr = array(
    array(
        'bdmd',
        ''
    ),
    array(
        'esd',
        ''
    ),
    array(
        'pod',
        ''
    )
);


// BOARDROOM NUMBER
$boardroom_number_arr = array(
    array(
        'Glassroom One',
        ''
    ),
    array(
        'Glassroom Two',
        ''
    ),
    array(
        'Glassroom 1 and 2',
        ''
    ),
    array(
        'Boardroom',
        ''
    ),
    array(
        'Zoom Meeting',
        ''
    )
);
// NNI CONTRACT DURATION
$nni_contract_duration_arr = array(
    array(
        '1 Year',
        ''
    ),
    array(
        '2 Years',
        ''
    ),
    array(
        '3 Years',
        ''
    )
);

// NNI IT INFO STATUS 
$nni_it_info_status_arr = array(
    array(
        'Pending',
        ''
    ),
    array(
        'Done',
        ''
    )
);
// AUDIT STATUS
$audit_status_arr = array(
    '0' => array(
        'Draft',
        ''
    ),
    '1' => array(
        'Submitted',
        ''
    ),
    '2' => array(
        'Returned'.
        ''
    ),
    '3' => array(
        'Approved',
        ''
    )
);

$audit_status_color_arr = array(
    '0' => 'secondary',
    '1' => 'info',
    '2' => 'danger',
    '3' => 'success'
);

// OTHER TASK STATUS
$other_task_status_arr = array(
    array(
        'Pending',
        ''
    ),
    array(
        'Done',
        ''
    )
);

// QEHS checklist legend
$pre_op_audit_qehs_legend_arr = array(
    '0' => array('warning',
        array(
            'Documentation requirements needed and other minor findings for action',
            ''
        )
    ),
    '1' => array('success',
        array(
           'Legal requirements for completion',
            '' 
        )
    ),
    '2' => array('danger',
        array(
            'Critical findings/matters for immediate action',
            ''
        )
    )
);

// NNI status
$nni_status_arr = array(
    '0' => array(
        'Draft',
        ''
    ),
    '1' => array(
        'Endorsed',
        ''
    ),
    '2' => array(
        'Assigned',
        ''
    ),
    '3' => array(
        'Pending',
        ''
    ),
    '4' => array(
        'Completed',
        ''
    ),
    '5' => array(
        'Pending',
        ''
    )
);

$nni_status_color_arr = array(
    '0' => 'secondary',
    '1' => 'info',
    '2' => 'primary',
    '3' => 'dark',
    '4' => 'success',
    '5' => 'warning'
);

$nni_departments_status_arr = array(
    '0' => array(
        'Pending',
        ''
    ),
    '1' => array(
        'Completed',
        ''
    ),
    '3' => array(
        'For Implementation',
        ''
    )
);

$proposal_scope_of_service_arr = array(
    'title' => array(
        'Scope of Services',
        ''
    ),
    'list' => array(
        array(
            'Clean air filter',
            ''
        ),
        array(
            'Cooling coil cleaning',
            ''
        ),
        array(
            'Drain pan and drainage line cleaning',
            ''
        ),
        array(
            'Check refrigerant charge and get suction discharge pressure',
            ''
        ),
        array(
            'Obtain current reading, to determine energy efficiency of the air-con unit',
            ''
        ),
        array(
            'Clean blower blade',
            ''
        ),
        array(
            'Clean condenser coil',
            ''
        ),
        array(
            'Test all control thermostats and switches',
            ''
        ),
        array(
            'Check and service electrical controls',
            ''
        ),
        array(
            'Testing and commissioning',
            ''
        ),
        array(
            'Turn over to the client',
            ''
        )
    )
);

//SEVERITY LEVEL
$severity_level_arr = array(
    '1' => array(
        'Minor',
        ''
    ),
    '2' => array(
        'Normal',
        ''
    ),
    '3' => array(
        'High',
        ''
    ),
    '4' => array(
        'Critical',
        ''
    )
);
$severity_level_color_arr = array(
    '1' => array(
        'secondary',
        ''
    ),
    '2' => array(
        'primary',
        ''
    ),
    '3' => array(
        'warning',
        ''
    ),
    '4' => array(
        'danger',
        ''
    )
);

//OPERATION AUDIT
$operation_audit_section_1 = array(
    'aircon' => array(
        'Air-Conditioning',
        ''
    ),
    'electrical' => array(
        'Electrical',
        ''
    ),
    'mechanical' => array(
        'Mechanical',
        ''
    ),
    'fabrics' => array(
        'Building Fabrics',
        ''
    ),
    'water' => array(
        'Water System',
        ''
    ),
    'drainage_and_sewage' => array(
        'Drainage and Sewer System',
        ''
    ),
    'fire_safety_and_security' => array(
        'Fire Safety and Security System',
        ''
    ),
    'other' => array(
        'Others',
        ''
    )
);

// TSA AUDIT FINDINGS
$tsa_audit_fingings_arr = array(
    '1' => array(
        'findings' => array(
            'The unit is in normal operating condition.',
            ''
        ),
        'proiritization' => '5'
    ),
    '2' => array(
        'findings' => array(
            'The part needs to be replaced to improve its operation.',
            ''
        ),
        'proiritization' => '3'
    ),
    '3' => array(
        'findings' => array(
            'No permit to operate.',
            ''
        ),
        'proiritization' => '2'
    ),
    '4' => array(
        'findings' => array(
            'The unit is dirty.',
            ''
        ),
        'proiritization' => '4'
    ),
    '5' => array(
        'findings' => array(
            'No access, the unit cant be tested.',
            ''
        ),
        'proiritization' => '5'
    ),
    '6' => array(
        'findings' => array(
            'The unit has leaks with damages, need elect/rewiring.',
            ''
        ),
        'proiritization' => '1'
    ),
    '7' => array(
        'findings' => array(
            'The unit conforms to the manufacturers specification.',
            ''
        ),
        'proiritization' => '5'
    ),
    '8' => array(
        'findings' => array(
            'The unit is operating with high current reading/ exceeded the parameters.',
            ''
        ),
        'proiritization' => '1'
    ),
    '9' => array(
        'findings' => array(
            'Corroded / damaged power supply conduit or panel board',
            ''
        ),
        'proiritization' => '1'
    ),
    '10' => array(
        'findings' => array(
            'The equipment/ Breaker /control panel is difficult to access',
            ''
        ),
        'proiritization' => '1'
    ),
    '11' => array(
        'findings' => array(
            'Burnt circuit breaker / Burnt wires / Burnt terminals / Undersized wires / Undersized Circuit Breaker / Open Wires',
            ''
        ),
        'proiritization' => '1'
    ),
    '12' => array(
        'findings' => array(
            'No Thermal scanning conducted / Failed Thermal',
            ''
        ),
        'proiritization' => '1'
    ),
    '13' => array(
        'findings' => array(
            'Loosed / dislodged / damaged and uncovered convenience outlet, pull box, terminal box, panel board and circuit breaker.',
            ''
        ),
        'proiritization' => '1'
    ),
    '14' => array(
        'findings' => array(
            'Not appropriate type of convenience outlet',
            ''
        ),
        'proiritization' => '1'
    ),
    '15' => array(
        'findings' => array(
            'Exposed, disorganized and dangling power supply wires',
            ''
        ),
        'proiritization' => '1'
    ),
    '16' => array(
        'findings' => array(
            'Dangling / Dislodged / insufficient support lighting fixture',
            ''
        ),
        'proiritization' => '1'
    ),
    '17' => array(
        'findings' => array(
            'Seismic sensor not functioning',
            ''
        ),
        'proiritization' => '1'
    ),
    '18' => array(
        'findings' => array(
            'The unit has unguarded moving or rotating part',
            ''
        ),
        'proiritization' => '1'
    ),
    '19' => array(
        'findings' => array(
            'Oil / fuel leak',
            ''
        ),
        'proiritization' => '1'
    ),
    '20' => array(
        'findings' => array(
            'Wet and slippery flooring due to leak problem',
            ''
        ),
        'proiritization' => '1'
    ),
    '21' => array(
        'findings' => array(
            'Corroded/damaged flat forms / hand rails / supports',
            ''
        ),
        'proiritization' => '1'
    ),
    '22' => array(
        'findings' => array(
            'Defective panic device / misaligned exit door panel',
            ''
        ),
        'proiritization' => '1'
    ),
    '23' => array(
        'findings' => array(
            'Corroded door panels and accessories exposing sharp edges',
            ''
        ),
        'proiritization' => '1'
    ),
    '24' => array(
        'findings' => array(
            'Obstructed fire exit/ main stair',
            ''
        ),
        'proiritization' => '1'
    ),
    '25' => array(
        'findings' => array(
            'The room / area has insufficient ventilation / light',
            ''
        ),
        'proiritization' => '1'
    ),
    '26' => array(
        'findings' => array(
            'Defective Fire Alarm Control Panel / Fire Alarm System.',
            ''
        ),
        'proiritization' => '1'
    ),
    '27' => array(
        'findings' => array(
            'FACP being set to silent mode due to faults troubles indicated in the display module',
            ''
        ),
        'proiritization' => '1'
    ),
    '28' => array(
        'findings' => array(
            'Defective fire annunciator panel/ Supervisory and flow switch of sprinkler.',
            ''
        ),
        'proiritization' => '1'
    ),
    '29' => array(
        'findings' => array(
            'Defective / missing smoke detector device or manual station.',
            ''
        ),
        'proiritization' => '1'
    ),
    '30' => array(
        'findings' => array(
            'Closed isolation valve of sprinkler pipe',
            ''
        ),
        'proiritization' => '1'
    ),
    '31' => array(
        'findings' => array(
            'Sprinkler head above control/electrical panel',
            ''
        ),
        'proiritization' => '1'
    ),
    '32' => array(
        'findings' => array(
            'Nut functioning / missing emergency light or exit light',
            ''
        ),
        'proiritization' => '1'
    ),
    '33' => array(
        'findings' => array(
            'Discharged / missing fire extinguisher',
            ''
        ),
        'proiritization' => '1'
    ),
    '34' => array(
        'findings' => array(
            'Sprinkler type fire extinguishers installed above/ near electrical panel/s.',
            ''
        ),
        'proiritization' => '1'
    ),
    '35' => array(
        'findings' => array(
            'Not functioning / stock up gate or check valve',
            ''
        ),
        'proiritization' => '1'
    ),
    '36' => array(
        'findings' => array(
            'Damaged fire hose',
            ''
        ),
        'proiritization' => '1'
    ),
    '37' => array(
        'findings' => array(
            'No safety markings',
            ''
        ),
        'proiritization' => '1'
    ),
    '38' => array(
        'findings' => array(
            'Defective CCTV System',
            ''
        ),
        'proiritization' => '1'
    ),
    '39' => array(
        'findings' => array(
            'Defective CCTV Camera',
            ''
        ),
        'proiritization' => '1'
    ),
    '40' => array(
        'findings' => array(
            'The equipment is not yet turned over',
            ''
        ),
        'proiritization' => '2'
    ),
    '41' => array(
        'findings' => array(
            'Waste segregation not implemented',
            ''
        ),
        'proiritization' => '2'
    ),
    '42' => array(
        'findings' => array(
            'No proper storage for Hazardous waste materials',
            ''
        ),
        'proiritization' => '2'
    ),
    '43' => array(
        'findings' => array(
            'No DENR accredited hauler for hazardous waste materials',
            ''
        ),
        'proiritization' => '2'
    ),
    '44' => array(
        'findings' => array(
            'Deviates from safety Standards and National Code/Standards',
            ''
        ),
        'proiritization' => '2'
    ),
    '45' => array(
        'findings' => array(
            'No Water Potability test conducted',
            ''
        ),
        'proiritization' => '2'
    ),
    '46' => array(
        'findings' => array(
            'No Seismograph',
            ''
        ),
        'proiritization' => '2'
    ),
    '47' => array(
        'findings' => array(
            'No Permit to Operate',
            ''
        ),
        'proiritization' => '2'
    ),
    '48' => array(
        'findings' => array(
            'Expired permit/license',
            ''
        ),
        'proiritization' => '2'
    ),
    '49' => array(
        'findings' => array(
            'No as-built plan / Not signed and sealed As-Built',
            ''
        ),
        'proiritization' => '2'
    ),
    '50' => array(
        'findings' => array(
            'No Fire Drill or Emergency Drill/ No Fire Safety Seminar conducted',
            ''
        ),
        'proiritization' => '2'
    ),
    '51' => array(
        'findings' => array(
            'The unit is not operational due to defective/missing parts',
            ''
        ),
        'proiritization' => '3'
    ),
    '52' => array(
        'findings' => array(
            'The unit is not operational because the control has defective/missing part/s.',
            ''
        ),
        'proiritization' => '3'
    ),
    '53' => array(
        'findings' => array(
            'The equipment is not operational because it has no power/disconnected power supply.',
            ''
        ),
        'proiritization' => '3'
    ),
    '54' => array(
        'findings' => array(
            'The unit is operational but it has defective/damaged/missing parts.',
            ''
        ),
        'proiritization' => '3'
    ),
    '55' => array(
        'findings' => array(
            'The equipment was pulled out',
            ''
        ),
        'proiritization' => '3'
    ),
    '56' => array(
        'findings' => array(
            'Defective capacitor bank / Transformer/ Main Breaker',
            ''
        ),
        'proiritization' => '3'
    ),
    '57' => array(
        'findings' => array(
            'Discharged/defective battery.',
            ''
        ),
        'proiritization' => '3'
    ),
    '58' => array(
        'findings' => array(
            'Changed oil and filter not conducted regularly',
            ''
        ),
        'proiritization' => '3'
    ),
    '59' => array(
        'findings' => array(
            'Defective / damaged pressure gauge',
            ''
        ),
        'proiritization' => '3'
    ),
    '60' => array(
        'findings' => array(
            'The unit is not cooling due to lack of Freon.',
            ''
        ),
        'proiritization' => '3'
    ),
    '61' => array(
        'findings' => array(
            'The unit is operating with unusual noise',
            ''
        ),
        'proiritization' => '3'
    ),
    '62' => array(
        'findings' => array(
            'The unit is operating with strong vibration',
            ''
        ),
        'proiritization' => '3'
    ),
    '63' => array(
        'findings' => array(
            'The unit / equipment has insufficient support',
            ''
        ),
        'proiritization' => '3'
    ),
    '64' => array(
        'findings' => array(
            'The drain / sewer pipe has leak',
            ''
        ),
        'proiritization' => '3'
    ),
    '65' => array(
        'findings' => array(
            'Leak on the water pipeline/fitting/tank',
            ''
        ),
        'proiritization' => '3'
    ),
    '66' => array(
        'findings' => array(
            'Water leak/ seepage due to defective waterproofing',
            ''
        ),
        'proiritization' => '3'
    ),
    '67' => array(
        'findings' => array(
            'Defective or missing door closers/ loose or defective hinges/ defective door knob /misaligned door',
            ''
        ),
        'proiritization' => '3'
    ),
    '68' => array(
        'findings' => array(
            'Damaged ceiling/wall due to leak problem',
            ''
        ),
        'proiritization' => '3'
    ),
    '69' => array(
        'findings' => array(
            'Water tank cleaning not regularly carried out',
            ''
        ),
        'proiritization' => '3'
    ),
    '70' => array(
        'findings' => array(
            'Insufficient water supply pressure',
            ''
        ),
        'proiritization' => '3'
    ),
    '71' => array(
        'findings' => array(
            'Missing pipe fittings and fixtures.',
            ''
        ),
        'proiritization' => '3'
    ),
    '72' => array(
        'findings' => array(
            'Floor drain has no / not appropriate strainer cover',
            ''
        ),
        'proiritization' => '3'
    ),
    '73' => array(
        'findings' => array(
            'Clogged floor drain / pipeline',
            ''
        ),
        'proiritization' => '3'
    ),
    '74' => array(
        'findings' => array(
            'Insufficient support of pipeline',
            ''
        ),
        'proiritization' => '3'
    ),
    '75' => array(
        'findings' => array(
            'Corroded pipelines / valve',
            ''
        ),
        'proiritization' => '3'
    ),
    '76' => array(
        'findings' => array(
            'Not visible exit light',
            ''
        ),
        'proiritization' => '3'
    ),
    '77' => array(
        'findings' => array(
            'Expired/ Overcharged/ defective pressure gauge/ damaged discharge hose fire extinguisher',
            ''
        ),
        'proiritization' => '3'
    ),
    '78' => array(
        'findings' => array(
            'Fire Hose cabinet has defective/missing parts or accessories.',
            ''
        ),
        'proiritization' => '3'
    ),
    '79' => array(
        'findings' => array(
            'No equipment manual',
            ''
        ),
        'proiritization' => '3'
    ),
    '80' => array(
        'findings' => array(
            'The equipment/control panel has no tag',
            ''
        ),
        'proiritization' => '0'
    ),
    '81' => array(
        'findings' => array(
            'Rusty power supply conduit/ Rusty panel board',
            ''
        ),
        'proiritization' => '0'
    ),
    '82' => array(
        'findings' => array(
            'Not properly connected/ dislodged/ disconnected power supply conduit',
            ''
        ),
        'proiritization' => '0'
    ),
    '83' => array(
        'findings' => array(
            'Loose circuit breaker, terminals/wires',
            ''
        ),
        'proiritization' => '0'
    ),
    '84' => array(
        'findings' => array(
            'The unit is dusty / dirty',
            ''
        ),
        'proiritization' => '0'
    ),
    '85' => array(
        'findings' => array(
            'Dirty lighting fixtures',
            ''
        ),
        'proiritization' => '0'
    ),
    '86' => array(
        'findings' => array(
            'Not functioning / busted light',
            ''
        ),
        'proiritization' => '0'
    ),
    '87' => array(
        'findings' => array(
            'Corrosive / Dirty battery terminals',
            ''
        ),
        'proiritization' => '0'
    ),
    '88' => array(
        'findings' => array(
            'Test run / Testing not conducted regularly',
            ''
        ),
        'proiritization' => '0'
    ),
    '89' => array(
        'findings' => array(
            'The unit / equipment was not tested because it is not utilized.',
            ''
        ),
        'proiritization' => '0'
    ),
    '90' => array(
        'findings' => array(
            'The oil lubricant is insufficient (below minimum level)',
            ''
        ),
        'proiritization' => '0'
    ),
    '91' => array(
        'findings' => array(
            'Rusty base frames / supports',
            ''
        ),
        'proiritization' => '0'
    ),
    '92' => array(
        'findings' => array(
            'Peeled off / bubbled / damaged paint',
            ''
        ),
        'proiritization' => '0'
    ),
    '93' => array(
        'findings' => array(
            'Floor, Wall and Ceiling cracks',
            ''
        ),
        'proiritization' => '0'
    ),
    '94' => array(
        'findings' => array(
            'Rusty flat forms / hand rails / fence / supports',
            ''
        ),
        'proiritization' => '0'
    ),
    '95' => array(
        'findings' => array(
            'Rusty door panel / Detached door closer/ loose or defective hinges / defective door knob',
            ''
        ),
        'proiritization' => '0'
    ),
    '96' => array(
        'findings' => array(
            'Dirty or disorganized room / area',
            ''
        ),
        'proiritization' => '0'
    ),
    '97' => array(
        'findings' => array(
            'Open and unrestored wall / ceiling ; Dirt stained wall / ceiling',
            ''
        ),
        'proiritization' => '0'
    ),
    '99' => array(
        'findings' => array(
            'Rotten / dilapidated wood finish',
            ''
        ),
        'proiritization' => '0'
    ),
    '100' => array(
        'findings' => array(
            'Rusty plumbing lines',
            ''
        ),
        'proiritization' => '0'
    ),
    '101' => array(
        'findings' => array(
            'Busted pilot light /indicator light',
            ''
        ),
        'proiritization' => '0'
    ),
    '102' => array(
        'findings' => array(
            'Dislodged / dangling smoke detector device or Manual station.',
            ''
        ),
        'proiritization' => '0'
    ),
    '103' => array(
        'findings' => array(
            'No end cap cover',
            ''
        ),
        'proiritization' => '0'
    ),
    '104' => array(
        'findings' => array(
            'Dislodged/dangling emergency light or exit light',
            ''
        ),
        'proiritization' => '0'
    ),
    '105' => array(
        'findings' => array(
            'No refill or purchased date/ No inspection tag of fire extinguisher',
            ''
        ),
        'proiritization' => '0'
    ),
    '106' => array(
        'findings' => array(
            '',
            ''
        ),
        'proiritization' => '0'
    ),
    '107' => array(
        'findings' => array(
            'Missing/ Damaged / Loose floor finish',
            ''
        ),
        'proiritization' => '3'
    ),
    '108' => array(
        'findings' => array(
            'Combustible items stored near or inside electrical equipment',
            ''
        ),
        'proiritization' => '1'
    ),
    '109' => array(
        'findings' => array(
            'Sharp corner edges of frames/supports',
            ''
        ),
        'proiritization' => '1'
    )

);
$tsa_audit_prioritization_arr = array(
    '1' => array(
        'Safety',
        ''
    ),
    '2' => array(
        'Compliance to Legal Requirement',
        ''
    ),
    '3' => array(
        'Efficiency',
        ''
    ),
    '0' => array(
        'Regular Maintenance/Checking',
        ''
    ),
    '4' => array(
        'Cleanliness',
        ''
    ),
    '5' => array(
        'Others',
        ''
    )
);

// nni status color code
$nni_dep_status_color = array(
    '0' => 'info',
    '1' => 'success',
    '3' => 'warning'
);

// CONTRACT TYPE OF SERVICES
$contract_type_of_services_arr = array(
    '0' => array(
        'Security Services',
        ''
    ),
    '1' => array(
        'Housekeeping / Janitorian Services',
        ''
    ),
    '2' => array(
        'Pest-Control Services',
        ''
    ),
    '3' => array(
        'Manpower Services',
        ''
    ),
    '4' => array(
        'Elevator PM Services',
        ''
    ),
    '5' => array(
        'Generator set PM and Supplies Services',
        ''
    ),
    '6' => array(
        'Haulers / Transporters',
        ''
    ),
    '7' => array(
        'Others',
        ''
    )
    
);

$calibration_category_and_equipment_arr = array(
    '0' => array(
        'category' => array(
            'Electrical',
            ''
        ),
        'equipment' => array(
            'Voltmeter',
            ''
        )
    ),
    '1' => array(
        'category' => array(
            'Electrical',
            ''
        ),
        'equipment' => array(
            'Ampmeter',
            ''
        )
    ),
    '2' => array(
        'category' => array(
            'Electrical',
            ''
        ),
        'equipment' => array(
            'Clampmeter',
            ''
        )
    ),
    '3' => array(
        'category' => array(
            'Electrical',
            ''
        ),
        'equipment' => array(
            'Digital Multi-meter',
            ''
        )
    ),
    '4' => array(
        'category' => array(
            'Electrical',
            ''
        ),
        'equipment' => array(
            'Resistance / Ohm Meter',
            ''
        )
    ),
    '5' => array(
        'category' => array(
            'Electrical',
            ''
        ),
        'equipment' => array(
            'Frequency Meter (HZ)',
            ''
        )
    ),
    '6' => array(
        'category' => array(
            'Electrical',
            ''
        ),
        'equipment' => array(
            'Megger / Insulation
            resistance test',
            ''
        )
    ),
    '7' => array(
        'category' => array(
            'Electrical',
            ''
        ),
        'equipment' => array(
            'Earth Resistance Test',
            ''
        )
    ),
    '8' => array(
        'category' => array(
            'Electrical',
            ''
        ),
        'equipment' => array(
            'Capacitance meter',
            ''
        )
    ),
    '9' => array(
        'category' => array(
            'Electrical',
            ''
        ),
        'equipment' => array(
            'Phase sequence meter',
            ''
        )
    ),
    '10' => array(
        'category' => array(
            'Electrical',
            ''
        ),
        'equipment' => array(
            'Power Quality Analyzer',
            ''
        )
    ),
    '11' => array(
        'category' => array(
            'Electrical',
            ''
        ),
        'equipment' => array(
            'Thermal Scanner',
            ''
        )
    ),
    '12' => array(
        'category' => array(
            'Electrical',
            ''
        ),
        'equipment' => array(
            'Infrared Scanner',
            ''
        )
    ),
    '13' => array(
        'category' => array(
            'Electrical',
            ''
        ),
        'equipment' => array(
            'Watt Meter',
            ''
        )
    ),
    '14' => array(
        'category' => array(
            'Electrical',
            ''
        ),
        'equipment' => array(
            'Power Factor Meter',
            ''
        )
    ),
    '15' => array(
        'category' => array(
            'Electrical',
            ''
        ),
        'equipment' => array(
            'Lux Meter',
            ''
        )
    ),
    '16' => array(
        'category' => array(
            'Mechanical',
            ''
        ),
        'equipment' => array(
            'Tacho Meter',
            ''
        )
    ),
    '17' => array(
        'category' => array(
            'Mechanical',
            ''
        ),
        'equipment' => array(
            'Air Flow Meter',
            ''
        )
    ),
    '18' => array(
        'category' => array(
            'Mechanical',
            ''
        ),
        'equipment' => array(
            'Refrigerant Leak Detector',
            ''
        )
    ),
    '19' => array(
        'category' => array(
            'Mechanical',
            ''
        ),
        'equipment' => array(
            'Pressure Gauge(s)',
            ''
        )
    ),
    '20' => array(
        'category' => array(
            'Mechanical',
            ''
        ),
        'equipment' => array(
            'Pressure release valve',
            ''
        )
    ),
    '21' => array(
        'category' => array(
            'Mechanical',
            ''
        ),
        'equipment' => array(
            'Pressure regulating valve',
            ''
        )
    ),
    '22' => array(
        'category' => array(
            'Mechanical',
            ''
        ),
        'equipment' => array(
            'Hygrometer',
            ''
        )
    ),
    '23' => array(
        'category' => array(
            'Mechanical',
            ''
        ),
        'equipment' => array(
            'Thermal Gun',
            ''
        )
    ),
    '24' => array(
        'category' => array(
            'Mechanical',
            ''
        ),
        'equipment' => array(
            'Vibration Analyzer',
            ''
        )
    ),
    '25' => array(
        'category' => array(
            'Mechanical',
            ''
        ),
        'equipment' => array(
            'LPG Leak Detector',
            ''
        )
    ),
    '26' => array(
        'category' => array(
            'Mechanical',
            ''
        ),
        'equipment' => array(
            'Fire Pump Flow Meter',
            ''
        )
    ),
    '27' => array(
        'category' => array(
            'Others',
            ''
        ),
        'equipment' => array(
            'Sound level / Decibel/
             Noise Meter',
            ''
        )
    )
);

// MANAGEMENT REPORT EXECUTIVE SUMMARY
$management_report_executive_summary_arr = array(
    'I' => array(
        'title' => array(
            'FINANCIALS',
            ''
        ),
        'items' => array(
            'A' => array(
                'title' => array(
                    'Financial Performance',
                    ''
                ),
                'highlights' => array(
                    array(
                        'Net Excess of Revenues Over Expenses:',
                        ''
                    ),
                    array(
                        'Collection Efficiency:',
                        ''
                    ),
                    array(
                        'Unrestricted Cash:',
                        ''
                    )
                )
            )
        )
    ),
    'II' => array(
        'title' => array(
            'ADMINISTRATION',
            ''
        ),
        'items' => array(
            'A' => array(
                'title' => array(
                    'Contracts Monitoring',
                    ''
                ),
                'highlights' => array(
                    array(
                       'Expired Contracts:',
                        '' 
                    )
                )
            ),
            'B' => array(
                'title' => array(
                    'Permits & Licenses',
                    ''
                ),
                'highlights' => array(
                    array(
                        'Expired Permits:',
                        ''
                    )
                )
            ),
            'C' => array(
                'title' => array(
                    'Occupancy',
                    ''
                ),
                'highlights' => array(
                    array(
                       'Total Occupied Units:',
                        '' 
                    ),
                    array(
                        'Total Vacant Units:',
                        ''
                    )
                )
            )
        )
    ),
    'III' => array(
        'title' => array(
            'ENGINEERING',
            ''
        ),
        'items' => array(
            'A' => array(
                'title' => array(
                    'Equipment Uptime',
                    ''
                ),
                'highlights' => array(
                    array(
                        'Equipment recommended for immediate repair/replacement:',
                        ''
                    ),
                    array(
                        'Equipment:',
                        ''
                    ),
                    array(
                        'YTD Downtime Hours',
                        ''
                    ),
                    array(
                        'Reason:',
                        ''
                    ),
                    array(
                        'Recommendation:',
                        ''
                    )
                )
            ),
            'B' => array(
                'title' => array(
                    'Major/CAPEX Projects',
                    ''
                ),
                'highlights' => array(
                    array(
                        'List of On-Going Major Projects:',
                        ''
                    )
                )
            )
        )
    ),
    'IV' => array(
        'title' => array(
            'SAFETY & SECURITY',
            ''
        ),
        'items' => array(
            'A' => array(
                'title' => array(
                    'Incidents',
                    ''
                ),
                'highlights' => array(
                    array(
                        'Type of Incident:',
                        ''
                    ),
                    array(
                        'Date:',
                        ''
                    ),
                    array(
                        'Status:',
                        ''
                    )
                )
            ),
            'B' => array(
                'title' => array(
                    'Emergency Response',
                    ''
                ),
                'highlights' => array(
                    array(
                        'Type of Emergency:',
                        ''
                    ),
                    array(
                        'Date:',
                        ''
                    ),
                    array(
                        'Status:',
                        ''
                    )
                )
            )
        )
    )
);

// NNI CAD TERMS
$nni_cad_term_arr = array(
    '0' => array(
        'Security Deposit',
        ''
    ),
    '1' => array(
        'Due Date',
        ''
    ),
    '2' => array(
        'Penalty',
        ''
    )
);
$nni_cad_term_downpayment_arr = array(
    '1' =>  array(
        '1 Month',
        ''
    ),
    '2' => array(
        '2 Months'
    )
);
$nni_cad_term_due_date_arr = array(
    '1' =>  array(
        '11th of the month',
        ''
    ),
    '2' => array(
        'Month end'
    )
);

// 30 60 90 day plans status
$day_plan_status_arr = array(
    '0' => array(
        'label' => array(
           'Draft',
            '' 
        ),
        'color' => 'secondary'
    ),
    '1' => array(
        'label' => array(
            'Submitted',
             '' 
         ),
         'color' => 'warning'
    ),
    '2' => array(
        'label' => array(
            'Completed',
             '' 
         ),
         'color' => 'success'
    )
);

// Add unit options
$add_unit_options_arr = array(
    '0' => array(
        'Vacant',
        ''
    ),
    '1' => array(
        'Occupied',
        ''
    ),
    '2' => array(
        'Sold',
        ''
    ),
    '3' => array(
        'Unsold',
        ''
    ),
    '4' => array(
        'Tenanted',
        ''
    )
);

// VISITOR purpose
$visitor_purpose_arr = array(
    'Delivery' => array(
        'Delivery',
        ''
    ),
    'Applicant' => array(
        'Applicant',
        ''
    ),
    'Project' => array(
        'Project',
        ''
    ),
    'Contractor' => array(
        'Contractor',
        ''
    ),
    'Others' => array(
        'Others',
        ''
    )
);

// BILLING ADVICE
$billing_advice_labor_type_arr = array(
	'F' => array(
		'FPD',
		''
	),
	'O' => array(
		'Outsourced',
		''
	)
);
$billing_advice_nature_arr = array(
	'0' => array(
		'title' => array(
			'New Account',
			''
		),
		'list' => array(
			array(
				'Notice of New Instruction',
				''
			),
			array(
				'Notice to Proceed',
				''
			),
			array(
				'Approved LC Breakdown',
				''
			)
		)
	),
	'1' => array(
		'title' => array(
			'Contract Renewal',
			''
		),
		'list' => array(
			array(
				'Signed Confirmation Letter',
				''
			),
			array(
				'Approved LC Breakdown',
				''
			)
		)
	),
	'2' => array(
		'title' => array(
			'Manpower Movement',
			''
		),
		'list' => array(
			array(
				'Approved LC Breakdown',
				''
			)
		)
	),
	'3' => array(
		'title' => array(
			'Additional Manpower (For Client Proposal)',
			''
		),
		'list' => array(
			array(
				'Signed Proposal Letter',
				''
			),
			array(
				'Approved LC Breakdown',
				''
			),
			array(
				'PRF',
				''
			)
		)
	),
	'4' => array(
		'title' => array(
			'Additional Manpower (Pre-Approved by Client)',
			''
		),
		'list' => array(
			array(
				'Client\'s Proof of Approval',
				''
			),
			array(
				'Copy of PRF Submitted to HR',
				''
			),
			array(
				'Approved LC Breakdown',
				''
			)
		)
	),
	'5' => array(
		'title' => array(
			'NCR Wage/ Mandatory Benefits Adjustment',
			''
		),
		'list' => array(
			array(
				'Approved LC Breakdown',
				''
			)
		)
	),
	'6' => array(
		'title' => array(
			'BOD Approved Salary Adjustment',
			''
		),
		'list' => array(
			array(
				'Client\'s Proof of Approval',
				''
			),
			array(
				'Approved LC Breakdown',
				''
			)
		)
	)
);
// PREVENTIVE MAINTENANCE STATUS
$preventive_maintenance_status_arr = array(
    '0' => array(
        'Scheduled for Maintenance',
        ''
    ),
    '1' => array(
        'Done',
        ''
    )
);

// SUBPROPERTY AMENITIES ARRAY
$sub_property_amenities_arr = array(
    array(
        'Swimming Pool',
        ''
    ),
    array(
        'Function Rooms',
        ''
    ),
    array(
        'Clubhouse',
        ''
    ),
    array(
        'Gym',
        ''
    ),
    array(
        'Sauna',
        ''
    ),
    array(
        'Jacuzzi',
        ''
    )
);

// BANKS
$banks_arr = array(
    '0' => array(
        'BDO',
        ''
    ),
    '1' => array(
        'Unionbank',
        ''
    ),
    '2' => array(
        'Chinabank',
        ''
    ),
    '3' => array(
        'EastWest',
        ''
    ),
    '4' => array(
        'Security Bank',
        ''
    ),
    '5' => array(
        'AUB',
        ''
    ),
    '6' => array(
        'Metrobank',
        ''
    ),
    '7' => array(
        'PNB',
        ''
    ),
    '8' => array(
        'BPI',
        ''
    ),
    '9' => array(
        'Sterling',
        ''
    ),
    '10' => array(
        'BPI Family Savings Bank',
        ''
    ),
    '11' => array(
        'BPI Direct Savings Bank',
        ''
    ),
    '12' => array(
        'BPI Maxi',
        ''
    ),
    '13' => array(
        'RCBC Savings',
        ''
    ),
    '14' => array(
        'RCBC',
        ''
    ),
    '15' => array(
        'UCPB',
        ''
    ),
    '999' => array(
        'Others',
        ''
    )
);

$website_arr = array(
    '0' => 'Webpage Access',
    '1' => 'MyFPD',
    '2' => 'FPD Nexus',
    '3' => 'Acumatica'
);

// PROPOSAL ESD STATUS
$proposal_esd_status_arr = array(
    '0' => array(
        'Draft',
        ''
    ),
    '1' => array(
        'For Checking',
        ''
    ),
    '2' => array(
        'For Revision',
        ''
    ),
    '3' => array(
        'Approved by the Director',
        ''
    ),
    '4' => array(
        'Submitted to Client',
        ''
    ),
    '5' => array(
        'Approved by Client',
        ''
    )
);
$proposal_esd_status_color_arr = array(
    '0' => 'secondary',
    '1' => 'warning',
    '2' => 'danger',
    '3' => 'info',
    '4' => 'primary',
    '5' => 'success'
);

// proposal esd service type
$esd_proposal_service_type_arr = array(
    'ACU/PM Services' => array(
        'ACU/PM Services',
        ''
    ),
    'Subcontracting Services' => array(
        'Subcontracting Services',
        ''
    ),
    'Other Technical Services' => array(
        'Other Technical Services',
        ''
    )
);

// salutation array
$salutation_arr = array(
    '0' => array(
        'Mr.',
        ''
    ),
    '1' => array(
        'Ms.',
        ''
    ),
    '2' => array(
        'Mrs.',
        ''
    ),
    '3' => array(
        'Sir',
        ''
    ),
    '4' => array(
        'Ma\'am',
        ''
    ),
    '5' => array(
        'Atty.',
        ''
    ),
    '6' => array(
        'Engr.',
        ''
    ),
    '7' => array(
        'Arch',
        ''
    ),
    '8' => array(
        'Dr.',
        ''
    ),
);
$tsa_operations_audit_fire_safety_and_security = array(
    'fire_extinguishers' => array(
        'Fire Extinguishers',
        ''
    ),
    'emergency_lights' => array(
        'Emergency Lights',
        ''
    ),
);

// PAD AUDITS -----------------------------------------
include($_SERVER['DOCUMENT_ROOT'].'/includes/arrays/PAD-audits.php');

// LABOR COST ------------------------------------------
include($_SERVER['DOCUMENT_ROOT'].'/includes/arrays/labor-cost.php');

// IAD AUDITS ------------------------------------------
include($_SERVER['DOCUMENT_ROOT'].'/includes/arrays/IAD-audits.php');

// COLLECTIONS -----------------------------------------
include($_SERVER['DOCUMENT_ROOT'].'/includes/arrays/collections.php');

// INSPECTIONS -----------------------------------------
include($_SERVER['DOCUMENT_ROOT'].'/includes/arrays/inspections.php');

?>