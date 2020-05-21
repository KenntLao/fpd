<?php 

// TASK ENGINEER INSPECTION
$engineering_inspection_category_arr = array(
    '0' => array(
        'General Inspection & Function Check',
        ''
    ),
    '1' => array(
        'Proper Installation, General Inspection & Function Check',
        ''
    ),
    '2' => array(
        'Supply Voltage & Load Current Reading',
        ''
    ),
    '3' => array(
        'Power & Grounding Wirings',
        ''
    )
);

// FCU MONTHLY INSPECTION ARRAY
$fcu_monthly_inspection_arr = array(
    array(
        'Log temperature setting before cleaning (°C).',
        ''
    ),
    array(
        'Record room temperature before cleaning (°C).',
        ''
    ),
    array(
        'Conduct cleaning of filters and decorative panel.',
        ''
    ),
    array(
        'Conduct general cleaning of the unit.',
        ''
    ),
    array(
        'Check leaks and accessories of the branch pipe lines.',
        ''
    ),
    array(
        'Check controls and electrical components.',
        ''
    ),
    array(
        'Check unit during start up and running condition.',
        ''
    ),
    array(
        'Check operating sound, vibrations and high temperature. Make necessary corrections and adjustments.',
        ''
    ),
    array(
        'Record discharge air temperature diffuser.',
        ''
    ),
    array(
        'Log temperature setting after cleaning (°C)',
        ''
    ),
    array(
        'Record room temperature after cleaning (after one (1) hour) (°C).',
        ''
    )
);


// FIRE EXTINGUISHER INSPECTION CHECKLIST
$fire_extinguisher_inspection_checklist_arr = array(
    '1' => array(
        'The handle/operating levers must be intact and not bent broken.',
        ''
    ),
    '2' => array(
        'The safety locking pin must be intact and not lost as well for the tamper seal is  
        not broken.',
        ''
    ),
    '3' => array(
        'The pressure gauge must be in operating range or position (pointing in the green) 
        with no damage or showing if it is discharged or overcharged.',
        ''
    ),
    '4' => array(
        'The label must be clear and extinguisher type and instruction can be read easily.',
        ''
    ),
    '5' => array(
        'The rubber discharge hose and nozzle must be in good shape, not clogged, bent 
        and cracked or broken.',
        ''
    ),
    '6' => array(
        'The body of the fire extinguisher must have no visible cracks, dents, corrosion  
        and leakage.',
        ''
    ),
    '7' => array(
        'The chemical content must not be solidified in the canister base.',
        ''
    ),
    '8' => array(
        'The inspection tag must be completely filled up every monthly inspection along 
        with the initial of the person performing  the inspection.',
        ''
    ),
    '9' => array(
        'The fire extinguisher unti must be easily seen or notice in the area and not
        obstructed as well accessible for inspection/checking if inside the Fire Hose Cabinet.',
        ''
    )
    
);

// FIRE EXTINGUISHER INSPECTION CHECKLIST
$emergency_light_inspection_checklist_arr = array(
    '1' => array(
        'The emergency light must be properly mounted and stable.',
        ''
    ),
    '2' => array(
        'The emergency light must be installed facing the hallway leading to the egress door.',
        ''
    ),
    '3' => array(
        'The emergency light must be function when the power supply is disconnected or unplugged.',
        ''
    ),
    '4' => array(
        'The test button must be functioning and intact.',
        ''
    ),
    '5' => array(
        'The battery charger must be functioning.',
        ''
    ),
    '6' => array(
        'The battery charging indicator light must be functioning and not busted.',
        ''
    ),
    '7' => array(
        'The bulbs must be functioning and illuminate clearly ang brightly and maintain its luminance for a given period of time (at least 30 seconds)',
        ''
    ),
    '8' => array(
        'The bulbs must be cleaned and not blackened.',
        ''
    )
    
);

// SAFETY INSPECTION CHECKLIST
$operation_safety_inspection_checklist_arr = array(
    '1' => array(
        'title' => array(
            'Fire Protection',
            ''
        ),
        'list' => array(
            array(
                'Extinguishing Equipment',
                ''
            ),
            array(
                'Standpipes, hoses and valves',
                ''
            ),
            array(
                'Sprinkler heads',
                ''
            ),
            array(
                'Exits, stairs emergency lights, and signs',
                ''
            ),
            array(
                'Storage of flammable materials and hazardous materials',
                ''
            )
        )
    ),
    '2' => array(
        'title' => array(
            'Emergency Preparedness',
            ''
        ),
        'list' => array(
            array(
                'Emergency Drills (2x a year)',
                ''
            ),
            array(
                'Emergency Brigade Organizational Chart',
                ''
            ),
            array(
                'Emergency Seminars',
                ''
            )
        )
    ),
    '3' => array(
        'title' => array(
            'First Aid',
            ''
        ),
        'list' => array(
            array(
                'First Aid Kit Room',
                ''
            ),
            array(
                'Stretchers/wheelchairs
                 Fire Blankets',
                ''
            ),
            array(
                'First Aider Training',
                ''
            )
        )
    ),
    '4' => array(
        'title' => array(
            'Housekeeping',
            ''
        ),
        'list' => array(
            array(
                'Aisles, stairs and floors',
                ''
            ),
            array(
                'Storage and piling of materials',
                ''
            ),
            array(
                'Wash and locker rooms',
                ''
            ),
            array(
                'Lights
                 Ventilation',
                ''
            ),
            array(
                'Disposal of Waste',
                ''
            ),
            array(
                'Yards and Parking areas',
                ''
            ),
            array(
                'Comfort Rooms',
                ''
            ),
            array(
                'Kitchen/Pantry',
                ''
            )
        )
    ),
    '5' => array(
        'title' => array(
            'Tools',
            ''
        ),
        'list' => array(
            array(
                'Power tools',
                ''
            ),
            array(
                'Hand tools',
                ''
            ),
            array(
                'Use and storage of tools',
                ''
            )
        )
    ),
    '6' => array(
        'title' => array(
            'Personal Protective Equipment',
            ''
        ),
        'list' => array(
            array(
                'Gloves',
                ''
            ),
            array(
                'Respirators/gas mask',
                ''
            ),
            array(
                'Protective clothing',
                ''
            ),
            array(
                'Earmuffs',
                ''
            ),
            array(
                'Safety Shoes',
                ''
            ),
            array(
                'Goggles or face shields',
                ''
            )
        )
    ),
    '7' => array(
        'title' => array(
            'Machineries',
            ''
        ),
        'list' => array(
            array(
                'Point of operation guards',
                ''
            ),
            array(
                'Belts, pulleys, gears, shafts, etc.',
                ''
            ),
            array(
                'Noise Level',
                ''
            ),
            array(
                'Lighting Level',
                ''
            ),
            array(
                'Maintenance',
                ''
            ),
            array(
                'Safety Signs',
                ''
            ),
            array(
                'Room Temperature',
                ''
            )
        )
    ),
    '8' => array(
        'title' => array(
            'Electrical',
            ''
        ),
        'list' => array(
            array(
                'Tagging of equipment and controls',
                ''
            ),
            array(
                'Room Temperature',
                ''
            ),
            array(
                'Lock out - tag out',
                ''
            ),
            array(
                'Panel Boards/ Circuit
                 Breakers/meters',
                ''
            ),
            array(
                'Power outlets and cables',
                ''
            ),
            array(
                'Transformers',
                ''
            ),
            array(
                'Lighting Level',
                ''
            ),
            array(
                'Lightning Arrester/Grounding',
                ''
            )
        )
    ),
    '9' => array(
        'title' => array(
            'Unsafe Practices',
            ''
        ),
        'list' => array(
            array(
                'Smoking in Danger areas',
                ''
            ),
            array(
                'Over speeding of vehicles',
                ''
            )
        )
    )

);

// Building manager inspection checklist
$inspection_bm_checklist_legend_arr = array(
    '0' => array(
        'legend-color' => 'success',
        'legend' => array(
            'Working',
            ''
        )
    ),
    '1' => array(
        'legend-color' => 'warning',
        'legend' => array(
            'Moderate',
            ''
        )
    ),
    '2' => array(
        'legend-color' => 'danger',
        'legend' => array(
            'Critical',
            ''
        )
    )
);


// INSPECTIONS CHECKLIST ARRAY
$inspection_checklist_arr = array(
	array(
		'symbol' => 'I.',
		'name' => 'ADMINISTRATION', 
        'list' => array(
            array(
                '1.',
                array(
                    'Appearance, courtesy and uniform of Personnel / Staff',
                    ''
                )
            ),
            array(
                '1.1',
                array(
                    'Administration',
                    ''
                )
            ),
            array(
                '1.2',
                array(
                    'Accounting',
                    ''
                )
            ),
            array(
                '1.3',
                array(
                    'Housekeeping/Pest Control/Landscaping',
                    ''
                )
            ),
            array(
                '1.4',
                array(
                    'Security',
                    ''
                )
            ),
            array(
                '1.5',
                array(
                    'Engineering Personnel',
                    ''
                )
            ),
            array(
                '2.',
                array(
                    'Compliance',
                    ''
                )
            ),
            array(
                '2.1',
                array(
                    'Administration & Accounting Office',
                    ''
                )
            ),
            array(
                '2.2',
                array(
                    'Engineering Office/Workshop/ Stockrooms',
                    ''
                )
            ),
            array(
                '2.3',
                array(
                    'Reception Areas',
                    ''
                )
            ),
            array(
                '2.4',
                array(
                    'Machine Rooms, i.e. Elevator, etc.',
                    ''
                )
            ),
            array(
                '2.5',
                array(
                    'Electrical Rooms, i.e. HVSG, LVSG, Genset, MDP, etc.',
                    ''
                )
            ),
            array(
                '2.6',
                array(
                    'Mechanical Rooms, i.e. Chillers, CDA, Cooling Tower, Boiler, etc.',
                    ''
                )
            ),
            array(
                '2.7',
                array(
                    'TELCO Rooms',
                    ''
                )
            ),
            array(
                '2.8',
                array(
                    'Power Transformer Rooms',
                    ''
                )
            ),
            array(
                '2.9',
                array(
                    'BMS/CCTV Rooms',
                    ''
                )
            ),
            array(
                '2.10',
                array(
                    'STP or WWTP',
                    ''
                )
            ),
            array(
                '2.11',
                array(
                    'Housekeeping Quarters/Stockrooms',
                    ''
                )
            ),
            array(
                '2.12',
                array(
                    'Security Quarters',
                    ''
                )
            )
        )
    ),
    array(
        'symbol' => 'II.',
		'name' => 'ENGINEERING', 
        'list' => array(
            array(
                '1.',
                array(
                    'Preventive Maintenance Compliance & Documentation',
                    ''
                )
            ),
            array(
                '2.',
                array(
                    'Operational Status of all Equipment',
                    ''
                )
            ),
            array(
                '3.',
                array(
                    'WRS / Job Order Procedure Compliance<br>
                    Check for the following:<br>
                    -  Proper recording of job order / WRS.<br>
                    -  Duly acknowledged by the complainant / requesting party.',
                    ''
                )
            ),
            array(
                '4.',
                array(
                    'Engineering Tools and Equipment Inventory Management',
                    ''
                )
            ),
            array(
                '5.',
                array(
                    'Stock Supply Management<br>
                    - Check the required format for proper monitoring of stocks.',
                    ''
                )
            ),
            array(
                '6.',
                array(
                    'Fire Exits<br>
                    - Check cleanliness and orderliness
                    ',
                    ''
                )
            ),
            array(
                '7.',
                array(
                    'Amenity Areas <br>
                    - Check cleanliness and orderliness of swimming pool, function room, gym, sauna, basketball or other courts, and other amenities.
                    ',
                    ''
                )
            ),
            array(
                '8.',
                array(
                    'Common Wash Rooms<br>
                    - Check cleanliness and orderliness.
                    ',
                    ''
                )
            ),
            array(
                '9.',
                array(
                    'Landscaping<br>
                    - Proper maintenance, pruning, watering, etc.',
                    ''
                )
            ),
            array(
                '10.',
                array(
                    'Garbage Handling<br>
                    - Implementation of waste segregation',
                    ''
                )
            ),
        )
    ),
    array(
        'symbol' => 'III.',
		'name' => 'HOUSEKEEPING', 
        'list' => array(
            array(
                '1.',
                array(
                    'Parking Areas<br> 
                    Check the following:<br>
                    - Clear of any obstruction, i.e. debris, storage area, etc.',
                    ''
                )
            ),
            array(
                '2.',
                array(
                    'Building Perimeter <br>
                    - Check cleanliness and orderliness
                    ',
                    ''
                )
            ),
            array(
                '3.',
                array(
                    'Main Lobby <br>
                    - Check cleanliness and orderliness
                    ',
                    ''
                )
            ),
            array(
                '4.',
                array(
                    'Upper Corridors<br>
                    - Check cleanliness of elevator lobbies, elevator cars, hallways, and corridors.
                    ',
                    ''
                )
            ),
            array(
                '5.',
                array(
                    'Helipad & Roof deck<br>
                    - Check cleanliness and orderliness
                    ',
                    ''
                )
            ),
        ) 
    ),
    array(
        'symbol' => 'IV.',
		'name' => 'SECURITY', 
        'list' => array(
            array(
                '1.',
                array(
                    'Visitors Screening System<br>
                    - Implementation of ID system
                    ',
                    ''
                )
            ),
            array(
                '2.',
                array(
                    'Parking Screening System<br>
                    - Implementation of car pass and sticker.
                    ',
                    ''
                )
            ),
            array(
                '3.',
                array(
                    'Material Gate Pass System',
                    ''
                )
            ),
            array(
                '4.',
                array(
                    'Move In / Move Out System',
                    ''
                )
            ),
            array(
                '5.',
                array(
                    'Emergency Preparedness<br>
                    Check for:<br>
                    -  Fire fighting equipment (fireman suit, ax, fire extinguishers, breathing apparatus, etc.)<br>
                    -  Conduct of Fire Drill and Safety Seminars',
                    ''
                )
            ),
            array(
                '6.',
                array(
                    'Fire Brigade Organization',
                    ''
                )
            ),
            array(
                '7.',
                array(
                    'Evacuation Drills & Safety Seminars',
                    ''
                )
            ),
            array(
                '8.',
                array(
                    'Security Reporting System',
                    ''
                )
            )
        )
    )
                
);

// GENERAL INSPECTION AND FUNCTION SHEET ARRAY
$general_inspection_sheet_arr = array(
    array('general',
        array(
            'General Inspection, & Function Check',
            ''
        ),
        array(
            array(
                'Free from rust, damage, dust and dirt',
                ''
            ),
            array(
                'Function check',
                ''
            )
        )
    )
);

// Proper Installation, General Inspection, & Function SHEET ARRAY
$proper_installation_sheet_arr = array(
    array('power-installation',
        array(
            'Proper Installation, General Inspection, & Function Check',
            ''
        ),
        array(
            array(
                'Complaince to electrical codes and recommended practice',
                ''
            ),
            array(
                'Easy access check',
                ''
            ),      
            array(
                'Free from rust, damage, dust and dirt',
                ''
            ),
            array(
                'Function',
                ''
            )
        )
    )
);

// INSPECTION SHEET LEGENDS
$inspection_sheet_legends_arr = array(
    array('OK',
        array(
            'Conformed',
            ''
        )
    ),
    array('NC',
        array(
            'Not Conformed',
            ''
        )
    ),
    array('N/A',
        array(
            'Not Applicable',
            ''
        )
    )
);

// FCU MONTHLY INSPECTIONS
$inspections_fcu_scope_of_work = array(
    array('Monthly',
        array(
            array(
                'Log temperature setting before cleaning (°C).',
                ''
            ),
            array(
                'Record room temperature before cleaning (°C).',
                ''
            ),
            array(
                'Conduct cleaning of filters and decorative panel.',
                ''
            ),
            array(
                'Conduct general cleaning of the unit.',
                ''
            ),
            array(
                'Check leaks and accessories of the branch pipe lines.',
                ''
            ),
            array(
                'Check controls and electrical components.',
                ''
            ),
            array(
                'Check unit during start up and running condition.',
                ''
            ),
            array(
                'Check operating sound, vibrations and high temperature. Make necessary corrections and adjustments.',
                ''
            ),
            array(
                'Record discharge air temperature diffuser.',
                ''
            ),
            array(
                'Log temperature setting after cleaning (°C)',
                ''
            ),array(
                'Record room temperature after cleaning (after one (1) hour) (°C).',
                ''
            )
        )
    ),
    array('Quarterly',
        array(
            array(
                'FCU FAN MOTOR',
                ''
            ),
            array(
                'Voltage',
                ''
            )
        )
    )
    
);
?>