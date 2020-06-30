<?php
$permissions_arr = array(


	// HRIS EMPLOYEES ===========================================================================
	array(
		array(
			'permission_code' => 'employees',
			'permission_name' => array(
				'Employee Management',
				''
			),
			'permission_description' => array(
				'Allow account to access employees list and view employee profile.',
				''
			)
		),
		array(
			'permission_code' => 'employee-add',
			'permission_name' => array(
				'Create Employee',
				''
			),
			'permission_description' => array(
				'Allow account to access create employee.',
				''
			)
		),
		array(
			'permission_code' => 'employee-edit',
			'permission_name' => array(
				'Update Employee',
				''
			),
			'permission_description' => array(
				'Allow account to access update employee.',
				''
			)
		),
		array(
			'permission_code' => 'employee-delete',
			'permission_name' => array(
				'Delete Employee',
				''
			),
			'permission_description' => array(
				'Allow account to access delete employee.',
				''
			)
		),
	),
	// HRIS TIME MANAGEMENT ===========================================================================
	// HRIS WORK SHIFT MANAGEMENT ===========================================================================
	array(
		array(
			'permission_code' => 'workshift-management',
			'permission_name' => array(
				'Workshift Management',
				''
			),
			'permission_description' => array(
				'Allow account to access Work Shift Management.',
				''
			)
		),
		array(
			'permission_code' => 'workshift-add',
			'permission_name' => array(
				'Add Work Shift',
				''
			),
			'permission_description' => array(
				'Allow account to create work shifts.',
				''
			)
		),
		array(
			'permission_code' => 'workshift-edit',
			'permission_name' => array(
				'Update Work Shift',
				''
			),
			'permission_description' => array(
				'Allow account to update work shifts.',
				''
			)
		),
		array(
			'permission_code' => 'workshift-delete',
			'permission_name' => array(
				'Delete Work Shift',
				''
			),
			'permission_description' => array(
				'Allow account to delete work shifts.',
				''
			)
		),
	),
	// HRIS WORK SHIFT ASSIGNMENT ===========================================================================
	array(
		array(
			'permission_code' => 'workshift-assignment',
			'permission_name' => array(
				'Workshift Assignment',
				''
			),
			'permission_description' => array(
				'Allow account to access Work Shift Assignments.',
				''
			)
		),
		array(
			'permission_code' => 'workshift-add-assignment',
			'permission_name' => array(
				'Assign Work Shifts',
				''
			),
			'permission_description' => array(
				'Allow account to assign work shifts.',
				''
			)
		),
		array(
			'permission_code' => 'workshift-edit-assignment',
			'permission_name' => array(
				'Update Assigned Work Shifts',
				''
			),
			'permission_description' => array(
				'Allow account to update assigned work shifts.',
				''
			)
		),
		array(
			'permission_code' => 'workshift-delete-assignment',
			'permission_name' => array(
				'Delete Assigned Work Shifts',
				''
			),
			'permission_description' => array(
				'Allow account to delete assigned work shifts.',
				''
			)
		),
	),


    // DASHBOARD CALENDAR ===========================================================================
    array(
        array(
            'permission_code' => 'calendar',
            'permission_name' => array(
                'Calendar Management',
                ''
            ),
            'permission_description' => array(
                'Allow account to access calendar.',
                ''
            )
        ),
        array(
            'permission_code' => 'calendar-other-task',
            'permission_name' => array(
                'Other Task Calendar',
                ''
            ),
            'permission_description' => array(
                'Allow account to access other task calendar.',
                ''
            )
        ),
        array(
            'permission_code' => 'calendar-work-order',
            'permission_name' => array(
                'Work Order Calendar',
                ''
            ),
            'permission_description' => array(
                'Allow account to access work-order calendar.',
                ''
            )
        ),
        array(
            'permission_code' => 'calendar-venue-reservation',
            'permission_name' => array(
                'Venue Reservation Calendar',
                ''
            ),
            'permission_description' => array(
                'Allow account to access venue reservation calendar.',
                ''
            )
        ),
    ),
	
	// ROLES =========================================================================================
	array(
		array(
			'permission_code' => 'roles',
			'permission_name' => array(
				'Roles Management',
				'ロール管理'
			),
			'permission_description' => array(
				'Allow account to access roles list and view permissions.',
				'アカウントに役割リストへのアクセスと許可の表示を許可します。'
			)
		),
		array(
			'permission_code' => 'role-add',
			'permission_name' => array(
				'Add Role',
				'役割を追加'
			),
			'permission_description' => array(
				'Allow account to add role group.',
				'アカウントに役割グループの追加を許可します。'
			)
		),
		array(
			'permission_code' => 'role-edit',
			'permission_name' => array(
				'Edit Role',
				'役割を編集'
			),
			'permission_description' => array(
				'Allow account to update role name and permissions.',
				'アカウントがロール名と権限を更新できるようにします。'
			)
		),
		array(
			'permission_code' => 'role-delete',
			'permission_name' => array(
				'Delete Role',
				'役割を削除'
			),
			'permission_description' => array(
				'Allow account to delete role.',
				'アカウントに役割の削除を許可します。'
			)
		)
	),

	// USERS =========================================================================================
	array(
		array(
			'permission_code' => 'users',
			'permission_name' => array(
				'Users Management',
				'ユーザー管理'
			),
			'permission_description' => array(
				'Allow account to access users list and view user profile.',
				'アカウントにユーザーリストへのアクセスとユーザープロファイルの表示を許可します。'
			)
		),
		array(
			'permission_code' => 'user-add',
			'permission_name' => array(
				'Add User',
				'ユーザーを追加する'
			),
			'permission_description' => array(
				'Allow account to add user account.',
				'アカウントにユーザーアカウントの追加を許可します。'
			)
		),
		array(
			'permission_code' => 'user-edit',
			'permission_name' => array(
				'Edit User',
				'ユーザーを編集'
			),
			'permission_description' => array(
				'Allow account to update user account details.',
				'アカウントがユーザーアカウントの詳細を更新できるようにします。'
			)
		),
		array(
			'permission_code' => 'user-delete',
			'permission_name' => array(
				'Delete User',
				'ユーザーを削除'
			),
			'permission_description' => array(
				'Allow account to delete user account.',
				'アカウントにユーザーアカウントの削除を許可します。'
			)
		)
	),

	// CLIENTS =========================================================================================
	array(
		array(
			'permission_code' => 'clients',
			'permission_name' => array(
				'Clients Management',
				'クライアント管理'
			),
			'permission_description' => array(
				'Allow account to access clients list and view client profile.',
				'アカウントにクライアントリストへのアクセスとクライアントプロファイルの表示を許可します。'
			)
		),
		array(
			'permission_code' => 'client-add',
			'permission_name' => array(
				'Add Client',
				'クライアントを追加'
			),
			'permission_description' => array(
				'Allow account to add client account.',
				'アカウントにクライアントアカウントの追加を許可します。'
			)
		),
		array(
			'permission_code' => 'client-edit',
			'permission_name' => array(
				'Edit Client',
				'クライアントを編集'
			),
			'permission_description' => array(
				'Allow account to update client account details.',
				'アカウントがクライアントアカウントの詳細を更新できるようにします。'
			)
		),
		array(
			'permission_code' => 'client-delete',
			'permission_name' => array(
				'Delete Client',
				'クライアントを削除'
			),
			'permission_description' => array(
				'Allow account to delete client account.',
				'アカウントにクライアントアカウントの削除を許可します。'
			)
		)
	),

	// UNIT OWNERS =========================================================================================
	array(
		array(
			'permission_code' => 'unit-owners',
			'permission_name' => array(
				'Unit Owners Management',
				'ユニット所有者管理'
			),
			'permission_description' => array(
				'Allow account to access unit owners list and view tenant profile.',
				'アカウントがユニット所有者リストにアクセスし、テナントプロファイルを表示することを許可します。'
			)
		),
		array(
			'permission_code' => 'unit-owner-add',
			'permission_name' => array(
				'Add Unit Owner',
				'ユニット所有者を追加'
			),
			'permission_description' => array(
				'Allow account to add unit owner account.',
				'アカウントにユニット所有者アカウントの追加を許可します。'
			)
		),
		array(
			'permission_code' => 'unit-owner-edit',
			'permission_name' => array(
				'Edit Unit Owner',
				'ユニット所有者の編集'
			),
			'permission_description' => array(
				'Allow account to update unit owner account details.',
				'アカウントがユニット所有者アカウントの詳細を更新できるようにします。'
			)
		),
		array(
			'permission_code' => 'unit-owner-delete',
			'permission_name' => array(
				'Delete Unit Owner',
				'ユニット所有者を削除'
			),
			'permission_description' => array(
				'Allow account to delete unit owner account.',
				'アカウントにユニット所有者アカウントの削除を許可します。'
			)
		)
	),

	// TENANTS =========================================================================================
	array(
		array(
			'permission_code' => 'tenants',
			'permission_name' => array(
				'Tenants Management',
				'テナント管理'
			),
			'permission_description' => array(
				'Allow account to access tenants list and view tenant profile.',
				'アカウントがテナントリストにアクセスし、テナントプロファイルを表示できるようにします。'
			)
		),
		array(
			'permission_code' => 'tenant-add',
			'permission_name' => array(
				'Add Tenant',
				'テナントを追加'
			),
			'permission_description' => array(
				'Allow account to add tenant account.',
				'アカウントがテナントアカウントを追加できるようにします。'
			)
		),
		array(
			'permission_code' => 'tenant-edit',
			'permission_name' => array(
				'Edit Tenant',
				'テナントを編集'
			),
			'permission_description' => array(
				'Allow account to update tenant account details.',
				'アカウントがテナントアカウントの詳細を更新できるようにします。'
			)
		),
		array(
			'permission_code' => 'tenant-delete',
			'permission_name' => array(
				'Delete Tenant',
				'テナントを削除'
			),
			'permission_description' => array(
				'Allow account to delete tenant account.',
				'アカウントにテナントアカウントの削除を許可します。'
			)
		)
	),

	// OCCUPANTS =========================================================================================
	array(
		array(
			'permission_code' => 'occupants',
			'permission_name' => array(
				'Occupants Management',
				'居住者管理'
			),
			'permission_description' => array(
				'Allow account to access occupants list and view occupant profile.',
				'アカウントが占有者リストにアクセスし、占有者プロファイルを表示できるようにします。'
			)
		),
		array(
			'permission_code' => 'occupant-add',
			'permission_name' => array(
				'Add Occupant',
				'占有者を追加'
			),
			'permission_description' => array(
				'Allow account to add occupant account.',
				'アカウントが居住者アカウントを追加できるようにします。'
			)
		),
		array(
			'permission_code' => 'occupant-edit',
			'permission_name' => array(
				'Edit Occupant',
				'居住者を編集'
			),
			'permission_description' => array(
				'Allow account to update occupant account details.',
				'アカウントが居住者アカウントの詳細を更新できるようにします。'
			)
		),
		array(
			'permission_code' => 'occupant-delete',
			'permission_name' => array(
				'Delete Occupant',
				'占有者を削除'
			),
			'permission_description' => array(
				'Allow account to delete occupant record.',
				'アカウントが居住者レコードを削除することを許可します。'
			)
		)
	),

	// EMPLOYEES =========================================================================================
/*	array(
		array(
			'permission_code' => 'employees',
			'permission_name' => array(
				'Employees Management',
				'従業員管理'
			),
			'permission_description' => array(
				'Allow account to access employees list and view employee profile.',
				'アカウントが従業員リストにアクセスし、従業員プロファイルを表示できるようにします。'
			)
		),
		array(
			'permission_code' => 'employee-timesheet',
			'permission_name' => array(
				'View Employee Timesheet',
				'従業員のタイムシートを表示'
			),
			'permission_description' => array(
				'Allow account to view employee timesheet.',
				'アカウントに従業員のタイムシートの表示を許可します。'
			)
		),
		array(
			'permission_code' => 'employee-add',
			'permission_name' => array(
				'Add Employee',
				'従業員を追加'
			),
			'permission_description' => array(
				'Allow account to add employee account.',
				'アカウントが従業員アカウントを追加できるようにします。'
			)
		),
		array(
			'permission_code' => 'employee-edit',
			'permission_name' => array(
				'Edit Employee',
				'従業員を編集'
			),
			'permission_description' => array(
				'Allow account to update employee account details.',
				'アカウントが従業員アカウントの詳細を更新できるようにします。'
			)
		),
		array(
			'permission_code' => 'employee-delete',
			'permission_name' => array(
				'Delete Employee',
				'従業員を削除'
			),
			'permission_description' => array(
				'Allow account to delete employee record.',
				'アカウントが従業員レコードを削除することを許可します。'
			)
		)
			),
*/

	// DEPARTMENTS =========================================================================================
	array(
		array(
			'permission_code' => 'departments',
			'permission_name' => array(
				'Departments Management',
				'部門管理'
			),
			'permission_description' => array(
				'Allow account to access departments list and view department details.',
				'アカウントが部門リストにアクセスして部門の詳細を表示できるようにします。'
			)
		),
		array(
			'permission_code' => 'department-add',
			'permission_name' => array(
				'Add Department',
				'部門を追加'
			),
			'permission_description' => array(
				'Allow account to add department.',
				'アカウントに部門の追加を許可します。'
			)
		),
		array(
			'permission_code' => 'department-edit',
			'permission_name' => array(
				'Edit Department',
				'部門の編集'
			),
			'permission_description' => array(
				'Allow account to update department details.',
				'アカウントが部門の詳細を更新できるようにします。'
			)
		),
		array(
			'permission_code' => 'department-delete',
			'permission_name' => array(
				'Delete Department',
				'部門を削除'
			),
			'permission_description' => array(
				'Allow account to delete department.',
				'アカウントに部門の削除を許可します。'
			)
		)
	),

	// PROPERTIES =========================================================================================
	array(
		array(
			'permission_code' => 'properties',
			'permission_name' => array(
				'Properties Management',
				'プロパティ管理'
			),
			'permission_description' => array(
				'Allow account to access property list and view department details.',
				'アカウントがプロパティリストにアクセスし、部門の詳細を表示できるようにします。'
			)
		),
		array(
			'permission_code' => 'property-add',
			'permission_name' => array(
				'Add Property',
				'プロパティを追加'
			),
			'permission_description' => array(
				'Allow account to add property.',
				'アカウントがプロパティを追加できるようにします。'
			)
		),
		array(
			'permission_code' => 'property-edit',
			'permission_name' => array(
				'Edit Property',
				'プロパティを編集'
			),
			'permission_description' => array(
				'Allow account to update property details.',
				'アカウントがプロパティの詳細を更新できるようにします。'
			)
		),
		array(
			'permission_code' => 'property-delete',
			'permission_name' => array(
				'Delete Property',
				'プロパティを削除'
			),
			'permission_description' => array(
				'Allow account to delete property.',
				'アカウントにプロパティの削除を許可します。'
			)
		)
    ),
    
    // PROPERTY SUMMARY
    array(
        array(
			'permission_code' => 'property-summary',
			'permission_name' => array(
				'Property Summary',
				''
			),
			'permission_description' => array(
				'Allow account to access property summary.',
				''
			)
        ),
        array(
			'permission_code' => 'property-summary-ntp',
			'permission_name' => array(
				'Property Summary NTP',
				''
			),
			'permission_description' => array(
				'Allow account to access property summary NTP.',
				''
			)
        ),
        array(
			'permission_code' => 'property-summary-nni',
			'permission_name' => array(
				'Property Summary NNI',
				''
			),
			'permission_description' => array(
				'Allow account to access property summary NNI.',
				''
			)
        ),
        array(
			'permission_code' => 'property-summary-contract',
			'permission_name' => array(
				'Property Summary Contract',
				''
			),
			'permission_description' => array(
				'Allow account to access property summary contract.',
				''
			)
        ),
        array(
			'permission_code' => 'property-summary-billing',
			'permission_name' => array(
				'Property Summary Billing Instruction',
				''
			),
			'permission_description' => array(
				'Allow account to access property summary billing instruction.',
				''
			)
        ),
        array(
			'permission_code' => 'property-summary-prf',
			'permission_name' => array(
				'Property Summary PRF',
				''
			),
			'permission_description' => array(
				'Allow account to access property summary PRF.',
				''
			)
        ),
        array(
			'permission_code' => 'property-summary-pre-operation-audit',
			'permission_name' => array(
				'Property Summary Pre Operation Audit',
				''
			),
			'permission_description' => array(
				'Allow account to access property summary pre operation audit.',
				''
			)
        ),
        array(
			'permission_code' => 'property-summary-day-plan',
			'permission_name' => array(
				'Property Summary 30-60-90 day plan',
				''
			),
			'permission_description' => array(
				'Allow account to access property summary NNI.',
				''
			)
        ),
        array(
			'permission_code' => 'property-summary-handbook',
			'permission_name' => array(
				'Property Summary 30-60-90 day plan',
				''
			),
			'permission_description' => array(
				'Allow account to access property summary NNI.',
				''
			)
        )
    ),

	// SUB PROPERTIES =========================================================================================
	array(
		array(
			'permission_code' => 'sub-properties',
			'permission_name' => array(
				'Buildings Management',
				'ビル管理'
			),
			'permission_description' => array(
				'Allow account to access buildings list and view building details.',
				''
			)
		),
		array(
			'permission_code' => 'sub-property-add',
			'permission_name' => array(
				'Add Building',
				'建物を追加'
			),
			'permission_description' => array(
				'Allow account to add building.',
				'アカウントに建物の追加を許可します。'
			)
		),
		array(
			'permission_code' => 'sub-property-edit',
			'permission_name' => array(
				'Edit Building',
				'建物を編集'
			),
			'permission_description' => array(
				'Allow account to update building details.',
				'アカウントが建物の詳細を更新できるようにします。'
			)
		),
		array(
			'permission_code' => 'sub-property-delete',
			'permission_name' => array(
				'Delete Building',
				'建物を削除'
			),
			'permission_description' => array(
				'Allow account to delete building.',
				'アカウントに建物の削除を許可します。'
			)
		)
	),

	// UNITS =========================================================================================
	array(
		array(
			'permission_code' => 'units',
			'permission_name' => array(
				'Units Management',
				'ユニット管理'
			),
			'permission_description' => array(
				'Allow account to access units list and view unit details.',
				'アカウントがユニットリストにアクセスし、ユニットの詳細を表示できるようにします。'
			)
		),
		array(
			'permission_code' => 'unit-add',
			'permission_name' => array(
				'Add Unit',
				'ユニットを追加'
			),
			'permission_description' => array(
				'Allow account to add unit in a specific building of a property.',
				'アカウントがプロパティの特定の建物にユニットを追加できるようにします。'
			)
		),
		array(
			'permission_code' => 'unit-edit',
			'permission_name' => array(
				'Edit Unit',
				''
			),
			'permission_description' => array(
				'Allow account to edit unit in a specific building of a property.',
				''
			)
		),
		array(
			'permission_code' => 'unit-add-eu',
			'permission_name' => array(
				'Add Unit End User',
				'ユニットエンドユーザーの追加'
			),
			'permission_description' => array(
				'Allow access to an Add Unit form for end users.',
				'エンドユーザーの[ユニットの追加]フォームへのアクセスを許可します。'
			)
		),
		array(
			'permission_code' => 'unit-tenant-assign',
			'permission_name' => array(
				'Assign Tenant',
				'テナントを割り当てる'
			),
			'permission_description' => array(
				'Allow access to manage tenant to a specific unit.',
				'特定のユニットへのテナントを管理するアクセスを許可します。'
			)
		),
		array(
			'permission_code' => 'unit-tenant-lease-update',
			'permission_name' => array(
				'Update Tenant Lease',
				'テナントリースの更新'
			),
			'permission_description' => array(
				'Allow access to manage tenant to a specific unit.',
				'特定のユニットへのテナントを管理するアクセスを許可します。'
			)
		),
		array(
			'permission_code' => 'unit-occupant-assign',
			'permission_name' => array(
				'Assign Occupant',
				''
			),
			'permission_description' => array(
				'Allow access to manage occupant to a specific unit.',
				'。'
			)
		),
		array(
			'permission_code' => 'unit-edit',
			'permission_name' => array(
				'Edit Building',
				'建物を編集'
			),
			'permission_description' => array(
				'Allow account to update unit details in a specific building of a property.',
				'アカウントがプロパティの特定の建物のユニットの詳細を更新できるようにします。'
			)
		),
		array(
			'permission_code' => 'unit-delete',
			'permission_name' => array(
				'Delete Unit',
				'ユニットを削除'
			),
			'permission_description' => array(
				'Allow account to delete unit.',
				'アカウントにユニットの削除を許可します。'
			)
		)
    ),
    
    // PROSPECTING ====================================================================================
    array(
        array(
            'permission_code' => 'prospecting',
			'permission_name' => array(
				'Prospecting Management',
				''
			),
			'permission_description' => array(
				'',
				''
			)
        ),
        array(
            'permission_code' => 'prospecting-add',
			'permission_name' => array(
				'Add Prospect',
				''
			),
			'permission_description' => array(
				'',
				''
			)
        ),
        array(
            'permission_code' => 'prospecting-edit',
			'permission_name' => array(
				'Edit Prospect',
				''
			),
			'permission_description' => array(
				'',
				''
			)
        ),
        array(
            'permission_code' => 'prospecting-delete',
			'permission_name' => array(
				'Delete Prospect',
				''
			),
			'permission_description' => array(
				'',
				''
			)
        ),
        array(
            'permission_code' => 'prospecting-activity',
			'permission_name' => array(
				'Prospecting Activities',
				''
			),
			'permission_description' => array(
				'',
				''
			)
        )
    ),

    // PROPOSAL BDD =================================================================================
    array(
        array(
            'permission_code' => 'proposal-bdd',
			'permission_name' => array(
				'BDD Proposal Management',
				''
			),
			'permission_description' => array(
				'Allow account to access BDD proposal list and view BDD proposal details.',
				''
			)
        ),
        array(
            'permission_code' => 'proposal-bdd-add',
			'permission_name' => array(
				'Add BDD Proposal',
				''
			),
			'permission_description' => array(
				'Allow account to add BDD proposal.',
				''
			)
        ),
        array(
            'permission_code' => 'proposal-bdd-edit',
			'permission_name' => array(
				'Edit BDD Proposal',
				''
			),
			'permission_description' => array(
				'Allow account to edit BDD proposal.',
				''
			)
        ),
        array(
            'permission_code' => 'proposal-bdd-labor-cost',
			'permission_name' => array(
				'BDD Proposal Labor Cost Management',
				''
			),
			'permission_description' => array(
				'Allow account to access BDD proposal labor cost list and view BDD proposal labor cost details.',
				''
			)
        ),
        array(
            'permission_code' => 'proposal-bdd-labor-cost-add',
			'permission_name' => array(
				'Add BDD Proposal Labor Cost',
				''
			),
			'permission_description' => array(
				'Allow account to add BDD proposal labor cost.',
				''
			)
        ),
        array(
            'permission_code' => 'proposal-bdd-labor-cost-edit',
			'permission_name' => array(
				'Edit BDD Proposal Labor Cost',
				''
			),
			'permission_description' => array(
				'Allow account to edit BDD proposal labor cost.',
				''
			)
        ),
        array(
            'permission_code' => 'proposal-bdd-labor-cost-approval',
			'permission_name' => array(
				'Approve BDD Proposal Labor Cost',
				''
			),
			'permission_description' => array(
				'Allow account to approve BDD proposal labor cost.',
				''
			)
        ),
        array(
            'permission_code' => 'proposal-bdd-labor-cost-comments',
			'permission_name' => array(
				'Labor Cost Comments',
				''
			),
			'permission_description' => array(
				'Allow account to view labor cost comments.',
				''
			)
        ),
        array(
            'permission_code' => 'proposal-bdd-labor-cost-comment-add',
			'permission_name' => array(
				'Add Labor Cost Comments',
				''
			),
			'permission_description' => array(
				'Allow account to add labor cost comments.',
				''
			)
        )
    ),

    // PROPOSAL ESD =================================================================================
    array(
        array(
            'permission_code' => 'proposal-esd',
			'permission_name' => array(
				'ESD Proposal Management',
				''
			),
			'permission_description' => array(
				'Allow account to access ESD proposal list and view ESD proposal details.',
				''
			)
        ),
        array(
            'permission_code' => 'proposal-esd-add',
			'permission_name' => array(
				'Add ESD Proposal',
				''
			),
			'permission_description' => array(
				'Allow account to add ESD proposal.',
				''
			)
        ),
        array(
            'permission_code' => 'proposal-esd-edit',
			'permission_name' => array(
				'Edit ESD Proposal',
				''
			),
			'permission_description' => array(
				'Allow account to edit ESD proposal.',
				''
			)
        ),
        array(
            'permission_code' => 'proposal-esd-approve',
			'permission_name' => array(
				'Approve ESD Proposal',
				''
			),
			'permission_description' => array(
				'Allow account to approve ESD proposal.',
				''
			)
        ),
        array(
            'permission_code' => 'proposal-esd-update-status',
			'permission_name' => array(
				'Update ESD Proposal Status',
				''
			),
			'permission_description' => array(
				'Allow account to update ESD proposal status.',
				''
			)
        ),
        array(
            'permission_code' => 'proposal-esd-comments',
			'permission_name' => array(
				'ESD Proposal Comments',
				''
			),
			'permission_description' => array(
				'Allow account to view ESD proposal comments.',
				''
			)
        ),
        array(
            'permission_code' => 'proposal-esd-comment-add',
			'permission_name' => array(
				'Add ESD Proposal Comments',
				''
			),
			'permission_description' => array(
				'Allow account to add ESD proposal comments.',
				''
			)
        )
    ),

    // PROPOSAL POD =================================================================================
    array(
        array(
            'permission_code' => 'proposal-pod',
			'permission_name' => array(
				'POD Proposal Management',
				''
			),
			'permission_description' => array(
				'Allow account to access POD proposal list and view POD proposal details.',
				''
			)
        ),
        array(
            'permission_code' => 'proposal-pod-add',
			'permission_name' => array(
				'Add POD Proposal',
				''
			),
			'permission_description' => array(
				'Allow account to add POD proposal.',
				''
			)
        ),
        array(
            'permission_code' => 'proposal-pod-edit',
			'permission_name' => array(
				'Edit POD Proposal',
				''
			),
			'permission_description' => array(
				'Allow account to edit POD proposal.',
				''
			)
        )
    ),

	// NOTICE TO PROCEED ==============================================================================
	array(
		array(
            'permission_code' => 'notice-to-proceed',
			'permission_name' => array(
				'Notice to Proceed Management',
				''
			),
			'permission_description' => array(
				'Allow account to access notice to proceed list and view notice to proceed details.',
				''
			)
        ),
        array(
            'permission_code' => 'notice-to-proceed-add',
			'permission_name' => array(
				'Add Notice to Proceed',
				''
			),
			'permission_description' => array(
				'Allow account to add notice to proceed.',
				''
			)
        ),
        array(
            'permission_code' => 'notice-to-proceed-edit',
			'permission_name' => array(
				'Edit Notice to Proceed',
				''
			),
			'permission_description' => array(
				'Allow account to edit notice to proceed.',
				''
			)
        ),
        array(
            'permission_code' => 'notice-to-proceed-delete',
			'permission_name' => array(
				'Delete Notice to Proceed',
				''
			),
			'permission_description' => array(
				'Allow account to delete notice to proceed.',
				''
			)
        )
	),

	// NOTICE OF NEW INSTRUCTIONS ==============================================================================
	array(
        array(
            'permission_code' => 'notice-of-new-instructions',
			'permission_name' => array(
				'Notice of New Instruction',
				''
			),
			'permission_description' => array(
				'Allow account to Notice of New Instruction.',
				''
			)
        ),
        array(
            'permission_code' => 'notice-of-new-instruction-add',
			'permission_name' => array(
				'Add Notice of New Instruction',
				''
			),
			'permission_description' => array(
				'',
				''
			)
        ),
        array(
            'permission_code' => 'notice-of-new-instruction-edit',
			'permission_name' => array(
				'Edit Notice of New Instruction',
				''
			),
			'permission_description' => array(
				'',
				''
			)
        ),
        array(
            'permission_code' => 'notice-of-new-instruction-comments',
			'permission_name' => array(
				'View Notice of New Instruction Comments',
				''
			),
			'permission_description' => array(
				'Allow account to access / View NNI comments',
				''
			)
        ),
        array(
            'permission_code' => 'notice-of-new-instruction-comment-add',
			'permission_name' => array(
				'Add Notice of New Instruction Comments',
				''
			),
			'permission_description' => array(
				'Allow account to Add NNI comments',
				''
			)
        ),
        array(
            'permission_code' => 'notice-of-new-instruction-BDD',
			'permission_name' => array(
				'Notice of New Instruction BDD',
				''
			),
			'permission_description' => array(
				'Allow account to',
				''
			)
        ),
        array(
            'permission_code' => 'notice-of-new-instruction-POD',
			'permission_name' => array(
				'Notice of New Instruction POD',
				''
			),
			'permission_description' => array(
				'Allow account to',
				''
			)
        ),
        array(
            'permission_code' => 'notice-of-new-instruction-OM',
			'permission_name' => array(
				'Notice of New Instruction OM',
				''
			),
			'permission_description' => array(
				'Allow account to ',
				''
			)
        ),
        array(
            'permission_code' => 'notice-of-new-instruction-CAD',
			'permission_name' => array(
				'Notice of New Instruction CAD',
				''
			),
			'permission_description' => array(
				'Allow account to',
				''
			)
        ),
        array(
            'permission_code' => 'notice-of-new-instruction-HR',
			'permission_name' => array(
				'Notice of New Instruction HR',
				''
			),
			'permission_description' => array(
				'Allow account to',
				''
			)
        ),
        array(
            'permission_code' => 'notice-of-new-instruction-IT',
			'permission_name' => array(
				'Notice of New Instruction IT',
				''
			),
			'permission_description' => array(
				'Allow account to Approve NNI',
				''
			)
        )
    ),
    
    // NNI LIST STATUS PERMISSION
    array(
        array(
            'permission_code' => 'notice-of-new-instructions-draft',
			'permission_name' => array(
				'View draft NNI',
				''
			),
			'permission_description' => array(
				'Allow account to view draft NNI.',
				''
			)
        ),
        array(
            'permission_code' => 'notice-of-new-instructions-endorsed',
			'permission_name' => array(
				'View Endorsed NNI',
				''
			),
			'permission_description' => array(
				'Allow account to view endorsed NNI.',
				''
			)
        ),
        array(
            'permission_code' => 'notice-of-new-instructions-assigned',
			'permission_name' => array(
				'View Assigned NNI',
				''
			),
			'permission_description' => array(
				'Allow account to view assigned NNI.',
				''
			)
        ),
        array(
            'permission_code' => 'notice-of-new-instructions-completed',
			'permission_name' => array(
				'View Completed NNI',
				''
			),
			'permission_description' => array(
				'Allow account to view completed NNI.',
				''
			)
        ),
        array(
            'permission_code' => 'notice-of-new-instructions-pending',
			'permission_name' => array(
				'View Pending NNI',
				''
			),
			'permission_description' => array(
				'Allow account to view pending NNI.',
				''
			)
        )
    ),

    // NNI attachment permissions
    array(
        array(
            'permission_code' => 'NNI-reference-documents',
			'permission_name' => array(
				'View NNI Reference Documents',
				''
			),
			'permission_description' => array(
				'Allow account to view Reference Documents.',
				''
			)
        ),
        array(
            'permission_code' => 'NNI-labor-cost-attachment',
			'permission_name' => array(
				'View NNI Labor Cost Breakdown Attachment',
				''
			),
			'permission_description' => array(
				'Allow account to view Labor Cost Breakdown Attachment.',
				''
			)
        ),
        array(
            'permission_code' => 'NNI-scope-of-work-attachment',
			'permission_name' => array(
				'View NNI Detailed Scope of Work Attachment',
				''
			),
			'permission_description' => array(
				'Allow account to view Detailed Scope of Work Attachment.',
				''
			)
        ),
        array(
            'permission_code' => 'NNI-attachment',
			'permission_name' => array(
				'View NNI Attachment',
				''
			),
			'permission_description' => array(
				'Allow account to view Attachment.',
				''
			)
        ),
        array(
            'permission_code' => 'NTP-attachment',
			'permission_name' => array(
				'View NTP Attachment',
				''
			),
			'permission_description' => array(
				'Allow account to view Attachment.',
				''
			)
        )
    ),
	
	// IT INFORMATIONS ==============================================================================
	array(
        array(
            'permission_code' => 'it-informations',
			'permission_name' => array(
				'IT Informations ',
				''
			),
			'permission_description' => array(
				'Allow account to IT informations.',
				''
			)
        )
	),

	// HR INFORMATIONS ==============================================================================
	array(
        array(
            'permission_code' => 'hr-informations',
			'permission_name' => array(
				'HR Informations ',
				''
			),
			'permission_description' => array(
				'Allow account to HR informations.',
				''
			)
        )
	),

	// CAD INFORMATIONS ==============================================================================
	array(
        array(
            'permission_code' => 'cad-informations',
			'permission_name' => array(
				'CAD Informations ',
				''
			),
			'permission_description' => array(
				'Allow account to CAD informations.',
				''
			)
        )
	),

	// CONTRACT ==============================================================================
	array(
		array(
            'permission_code' => 'contract',
			'permission_name' => array(
				'Contract Management',
				''
			),
			'permission_description' => array(
				'Allow account to access contract list and view contract details.',
				''
			)
        ),
        array(
            'permission_code' => 'contract-add',
			'permission_name' => array(
				'Add Contract',
				''
			),
			'permission_description' => array(
				'Allow account to add contract.',
				''
			)
        ),
        array(
            'permission_code' => 'contract-edit',
			'permission_name' => array(
				'Edit Contract',
				''
			),
			'permission_description' => array(
				'Allow account to edit contract.',
				''
			)
        ),
        array(
            'permission_code' => 'contract-delete',
			'permission_name' => array(
				'Delete Contract',
				''
			),
			'permission_description' => array(
				'Allow account to delete contract.',
				''
			)
        )
	),

    // TERMINATED CONTRACT ============================================================================
    array(
        array(
            'permission_code' => 'contract-terminated',
			'permission_name' => array(
				'Contract Terminated ',
				''
			),
			'permission_description' => array(
				'Allow account to access contract terminated list and details.',
				''
			)
        )
    ),

	// BILLING ADVICE ==============================================================================
	array(
		array(
            'permission_code' => 'billing-advice',
			'permission_name' => array(
				'Billing Advice Management',
				''
			),
			'permission_description' => array(
				'Allow account to access billing advice list and view billing advice details.',
				''
			)
        ),
        array(
            'permission_code' => 'billing-advice-add',
			'permission_name' => array(
				'Add Billing Advice',
				''
			),
			'permission_description' => array(
				'Allow account to add billing advice.',
				''
			)
        ),
        array(
            'permission_code' => 'billing-advice-edit',
			'permission_name' => array(
				'Edit Billing Advice',
				''
			),
			'permission_description' => array(
				'Allow account to edit billing advice.',
				''
			)
        ),
        array(
            'permission_code' => 'billing-advice-delete',
			'permission_name' => array(
				'Delete Billing Advice',
				''
			),
			'permission_description' => array(
				'Allow account to delete billing advice.',
				''
			)
        )
	),
	
	// PRF ==============================================================================
	array(
		array(
            'permission_code' => 'prf',
			'permission_name' => array(
				'PRF Management',
				''
			),
			'permission_description' => array(
				'Allow account to access prf list and view prf details.',
				''
			)
        ),
        array(
            'permission_code' => 'prf-add',
			'permission_name' => array(
				'Add PRF',
				''
			),
			'permission_description' => array(
				'Allow account to add prf.',
				''
			)
        ),
        array(
            'permission_code' => 'prf-edit',
			'permission_name' => array(
				'Edit PRF',
				''
			),
			'permission_description' => array(
				'Allow account to edit prf.',
				''
			)
        ),
        array(
            'permission_code' => 'prf-delete',
			'permission_name' => array(
				'Delete PRF',
				''
			),
			'permission_description' => array(
				'Allow account to delete prf.',
				''
			)
        )
    ),

    // 30-60-90 Day Plan ==============================================================================
    array(
        array(
            'permission_code' => '30-60-90-days',
			'permission_name' => array(
				'30-60-90 Days Management',
				''
			),
			'permission_description' => array(
				'',
				''
			)
        ),
        array(
            'permission_code' => '30-60-90-day-add',
			'permission_name' => array(
				'Add 30-60-90 Day Plan',
				''
			),
			'permission_description' => array(
				'',
				''
			)
        ),
        array(
            'permission_code' => '30-60-90-day-edit',
			'permission_name' => array(
				'Edit 30-60-90 Day Plan',
				''
			),
			'permission_description' => array(
				'',
				''
			)
        ),
        array(
            'permission_code' => '30-60-90-day-delete',
			'permission_name' => array(
				'Delete 30-60-90 Day Plan',
				''
			),
			'permission_description' => array(
				'',
				''
			)
        )
    ),
	
	// MOVE IN/OUT REQUESTS ==============================================================================
	array(
		array(
            'permission_code' => 'move-inout-requests',
			'permission_name' => array(
				'Move In/Out Request Management',
				''
			),
			'permission_description' => array(
				'Allow account to access move in/out request list and view move in/out request details.',
				''
			)
        ),
        array(
            'permission_code' => 'move-inout-request-add',
			'permission_name' => array(
				'Add Move In/Out Request',
				''
			),
			'permission_description' => array(
				'Allow account to add move in/out request.',
				''
			)
        ),
        array(
            'permission_code' => 'move-inout-request-edit',
			'permission_name' => array(
				'Edit Move In/Out Request',
				''
			),
			'permission_description' => array(
				'Allow account to edit move in/out request.',
				''
			)
        ),
        array(
            'permission_code' => 'move-inout-request-delete',
			'permission_name' => array(
				'Delete Move In/Out Request',
				''
			),
			'permission_description' => array(
				'Allow account to delete move in/out request.',
				''
			)
        )
	),
	
	// SERVICE PROVIDERS ==============================================================================
	array(
		array(
            'permission_code' => 'service-providers',
			'permission_name' => array(
				'Service Provider Management',
				''
			),
			'permission_description' => array(
				'Allow account to access move Service Provider list and view Service Provider details.',
				''
			)
        ),
        array(
            'permission_code' => 'service-provider-add',
			'permission_name' => array(
				'Add Service Provider',
				''
			),
			'permission_description' => array(
				'Allow account to add Service Provider.',
				''
			)
        ),
        array(
            'permission_code' => 'service-provider-edit',
			'permission_name' => array(
				'Edit Service Provider',
				''
			),
			'permission_description' => array(
				'Allow account to edit Service Provider.',
				''
			)
        ),
        array(
            'permission_code' => 'service-provider-delete',
			'permission_name' => array(
				'Delete Service Provider',
				''
			),
			'permission_description' => array(
				'Allow account to delete Service Provider.',
				''
			)
        )
	),
	
	// VISITORS ==============================================================================
	array(
		array(
            'permission_code' => 'visitors',
			'permission_name' => array(
				'Visitor Management',
				''
			),
			'permission_description' => array(
				'Allow account to access move visitor list and view visitor details.',
				''
			)
        ),
        array(
            'permission_code' => 'visitor-add',
			'permission_name' => array(
				'Add Visitor',
				''
			),
			'permission_description' => array(
				'Allow account to add visitor.',
				''
			)
        ),
        array(
            'permission_code' => 'visitor-edit',
			'permission_name' => array(
				'Edit Visitor',
				''
			),
			'permission_description' => array(
				'Allow account to edit visitor.',
				''
			)
        ),
        array(
            'permission_code' => 'visitor-delete',
			'permission_name' => array(
				'Delete Visitor',
				''
			),
			'permission_description' => array(
				'Allow account to delete visitor.',
				''
			)
        ),
        array(
            'permission_code' => 'visitor-approve',
			'permission_name' => array(
				'Approve Visitor',
				''
			),
			'permission_description' => array(
				'Allow account to approve visitor.',
				''
			)
        ),
        array(
            'permission_code' => 'visitor-status',
			'permission_name' => array(
				'Show Visitor Status',
				''
			),
			'permission_description' => array(
				'Allow account to show visitor status.',
				''
			)
        )
	),

	// PRE OPERATION AUDIT ==============================================================================
	array(
		array(
            'permission_code' => 'pre-operation-audit',
			'permission_name' => array(
				'Pre Operation Audit Management',
				''
			),
			'permission_description' => array(
				'Allow account to access move pre operation audit list and view pre operation audit details.',
				''
			)
        )
    ),

    // PRE OPERATION AUDIT QEHS
    array(
        array(
            'permission_code' => 'pre-operation-audit-QEHS',
			'permission_name' => array(
				'Pre Operation Audit QEHS Management',
				''
			),
			'permission_description' => array(
				'Allow account to view list and details of QEHS audit.',
				''
			)
        ),
        array(
            'permission_code' => 'pre-operation-audit-QEHS-add',
			'permission_name' => array(
				'Add Pre Operation Audit QEHS',
				''
			),
			'permission_description' => array(
				'Allow account to add QEHS audit.',
				''
			)
        ),
        array(
            'permission_code' => 'pre-operation-audit-QEHS-checklist',
			'permission_name' => array(
				'Pre Operation Audit QEHS Checklist',
				''
			),
			'permission_description' => array(
				'Allow account to access QEHS audit checklist.',
				''
			)
        ),
        array(
            'permission_code' => 'pre-operation-audit-QEHS-edit',
			'permission_name' => array(
				'Edit Pre Operation Audit QEHS',
				''
			),
			'permission_description' => array(
				'Allow account to edit QEHS audit details.',
				''
			)
        ),
        array(
            'permission_code' => 'pre-operation-audit-QEHS-delete',
			'permission_name' => array(
				'Delete Pre Operation Audit QEHS',
				''
			),
			'permission_description' => array(
				'Allow account to delete QEHS audit.',
				''
			)
        ),
        array(
            'permission_code' => 'pre-operation-audit-QEHS-comments',
			'permission_name' => array(
				'View Comment on Pre Operation Audit QEHS',
				''
			),
			'permission_description' => array(
				'Allow account to view comment on QEHS audit.',
				''
			)
        ),
        array(
            'permission_code' => 'pre-operation-audit-QEHS-comment-add',
			'permission_name' => array(
				'Add Comment on Pre Operation Audit QEHS',
				''
			),
			'permission_description' => array(
				'Allow account to add comment on QEHS audit.',
				''
			)
        ),
        array(
            'permission_code' => 'pre-operation-audit-QEHS-approve',
			'permission_name' => array(
				'Approve Pre Operation Audit QEHS',
				''
			),
			'permission_description' => array(
				'Allow account to approve or return QEHS audit.',
				''
			)
        )
    ),

    // PRE OPERATION AUDIT TSA
    array(
        array(
            'permission_code' => 'pre-operation-audit-TSA',
			'permission_name' => array(
				'Pre Operation Audit TSA Management',
				''
			),
			'permission_description' => array(
				'Allow account to view list and details of TSA audit.',
				''
			)
        ),
        array(
            'permission_code' => 'pre-operation-audit-TSA-add',
			'permission_name' => array(
				'Add Pre Operation Audit TSA',
				''
			),
			'permission_description' => array(
				'Allow account to add TSA audit.',
				''
			)
        ),
        array(
            'permission_code' => 'pre-operation-audit-TSA-edit',
			'permission_name' => array(
				'Edit Pre Operation Audit TSA',
				''
			),
			'permission_description' => array(
				'Allow account to edit TSA audit details.',
				''
			)
        ),
        array(
            'permission_code' => 'pre-operation-audit-TSA-delete',
			'permission_name' => array(
				'Delete Pre Operation Audit TSA',
				''
			),
			'permission_description' => array(
				'Allow account to delete TSA audit.',
				''
			)
        ),
        array(
            'permission_code' => 'pre-operation-audit-TSA-comments',
			'permission_name' => array(
				'Pre Operation Audit TSA Comments',
				''
			),
			'permission_description' => array(
				'Allow account to view TSA audit comments.',
				''
			)
        ),
        array(
            'permission_code' => 'pre-operation-audit-TSA-comment-add',
			'permission_name' => array(
				'Add Pre Operation Audit TSA Comments',
				''
			),
			'permission_description' => array(
				'Allow account to add TSA audit comments.',
				''
			)
        ),
        array(
            'permission_code' => 'pre-operation-audit-TSA-approve',
			'permission_name' => array(
				'Approve Pre Operation Audit TSA',
				''
			),
			'permission_description' => array(
				'Allow account to approve TSA audit.',
				''
			)
        )
    ),

    // PRE OPERATION AUDIT PAD
    array(
        array(
            'permission_code' => 'pre-operation-audit-PAD',
			'permission_name' => array(
				'Pre Operation Audit PAD Management',
				''
			),
			'permission_description' => array(
				'Allow account to view list and details of PAD audit.',
				''
			)
        ),
        array(
            'permission_code' => 'pre-operation-audit-PAD-add',
			'permission_name' => array(
				'Add Pre Operation Audit PAD',
				''
			),
			'permission_description' => array(
				'Allow account to add PAD audit.',
				''
			)
        ),
        array(
            'permission_code' => 'pre-operation-audit-PAD-edit',
			'permission_name' => array(
				'Edit Pre Operation Audit PAD',
				''
			),
			'permission_description' => array(
				'Allow account to edit PAD audit details.',
				''
			)
        ),
        array(
            'permission_code' => 'pre-operation-audit-PAD-delete',
			'permission_name' => array(
				'Delete Pre Operation Audit PAD',
				''
			),
			'permission_description' => array(
				'Allow account to delete PAD audit.',
				''
			)
        )
    ),

    // TASKS ===================================================================================
    array(
        array(
            'permission_code' => 'tasks',
			'permission_name' => array(
				'Task Management',
				''
			),
			'permission_description' => array(
				'Allow account to access move tasks list and view tasks details.',
				''
			)
        )
    ),
    
    // INSPECTIONS ==================================================================
    array(
        array(
            'permission_code' => 'inspections',
			'permission_name' => array(
				'Inspections Management',
				''
			),
			'permission_description' => array(
				'Allow account to access move inspections list and inspections tasks details.',
				''
			)
        ),
        array(
            'permission_code' => 'inspection-add',
			'permission_name' => array(
				'Add Inspection',
				''
			),
			'permission_description' => array(
				'Allow account to add inspection.',
				''
			)
        ),
        array(
            'permission_code' => 'inspection-edit',
			'permission_name' => array(
				'Edit Inspection',
				''
			),
			'permission_description' => array(
				'Allow account to edit inspection.',
				''
			)
        ),
        array(
            'permission_code' => 'inspection-delete',
			'permission_name' => array(
				'Delete Inspection',
				''
			),
			'permission_description' => array(
				'Allow account to delete inspection.',
				''
			)
        )
    ),

    // INSPECTION BM
    array(
        array(
            'permission_code' => 'inspection-BM',
			'permission_name' => array(
				'BM Inspections Management',
				''
			),
			'permission_description' => array(
				'Allow account to access building manager inspections list and inspections tasks details.',
				''
			)
        ),
        array(
            'permission_code' => 'inspection-BM-add',
			'permission_name' => array(
				'Add BM Inspections',
				''
			),
			'permission_description' => array(
				'Allow account to add building manager inspection.',
				''
			)
        ),
        array(
            'permission_code' => 'inspection-BM-edit',
			'permission_name' => array(
				'Edit BM Inspections',
				''
			),
			'permission_description' => array(
				'Allow account to edit building manager inspection.',
				''
			)
        ),
        array(
            'permission_code' => 'inspection-BM-delete',
			'permission_name' => array(
				'Delete BM Inspections',
				''
			),
			'permission_description' => array(
				'Allow account to delete building manager inspection.',
				''
			)
        )
    ),

    // INSPECTION FIRE EXTINGUISHER =============================================
    array(
        array(
            'permission_code' => 'inspection-fire-extinguiser-checklist',
			'permission_name' => array(
				'Fire Extinguisher Inspection Checklist Management',
				''
			),
			'permission_description' => array(
				'Allow account to access Fire Extinguisher Inspection Checklist and view Fire Extinguisher Inspection Checklist details.',
				''
			)
        ),
        array(
            'permission_code' => 'inspection-fire-extinguiser-checklist-add',
			'permission_name' => array(
				'Add Fire Extinguisher Inspection Checklist',
				''
			),
			'permission_description' => array(
				'Allow account to add Fire Extinguisher Inspection Checklist.',
				''
			)
        ),
        array(
            'permission_code' => 'inspection-fire-extinguiser-checklist-edit',
			'permission_name' => array(
				'Edit Fire Extinguisher Inspection Checklist',
				''
			),
			'permission_description' => array(
				'Allow account to edit Fire Extinguisher Inspection Checklist.',
				''
			)
        )
    ),
    
    // INSPECTION EMERGENCY LIGHT =====================================
    array(
        array(
            'permission_code' => 'inspection-emergency-light-checklist',
			'permission_name' => array(
				'Emergency Light Inspection Checklist Management',
				''
			),
			'permission_description' => array(
				'Allow account to access Emergency Light Inspection Checklist and view Emergency Light Inspection Checklist details.',
				''
			)
        ),
        array(
            'permission_code' => 'inspection-emergency-light-checklist-add',
			'permission_name' => array(
				'Add Emergency Light Inspection Checklist',
				''
			),
			'permission_description' => array(
				'Allow account to add Emergency Light Inspection Checklist.',
				''
			)
        ),
        array(
            'permission_code' => 'inspection-emergency-light-checklist-edit',
			'permission_name' => array(
				'Edit Emergency Light Inspection Checklist',
				''
			),
			'permission_description' => array(
				'Allow account to edit Emergency Light Inspection Checklist.',
				''
			)
        )
    ),

    // PREVENTIVE MAINTENANCE ==========================================================================
    array(
        array(
            'permission_code' => 'preventive-maintenance',
			'permission_name' => array(
				'Preventive Maintenance Management',
				''
			),
			'permission_description' => array(
				'Allow account to access move Preventive Maintenance Management list and view Preventive Maintenance Management details.',
				''
			)
        ),
        array(
            'permission_code' => 'preventive-maintenance-add',
			'permission_name' => array(
				'Add Preventive Maintenance',
				''
			),
			'permission_description' => array(
				'Allow account to add Preventive Maintenance.',
				''
			)
        ),
        array(
            'permission_code' => 'preventive-maintenance-edit',
			'permission_name' => array(
				'Edit Preventive Maintenance',
				''
			),
			'permission_description' => array(
				'Allow account to edit Preventive Maintenance.',
				''
			)
        ),
        array(
            'permission_code' => 'preventive-maintenance-Delete',
			'permission_name' => array(
				'Delete Preventive Maintenance',
				''
			),
			'permission_description' => array(
				'Allow account to delete Preventive Maintenance.',
				''
			)
        ),
        array(
            'permission_code' => 'preventive-maintenance-checklist',
			'permission_name' => array(
				'Access to preventive maintenance checklist',
				''
			),
			'permission_description' => array(
				'Allow account to view checklist of Preventive Maintenance.',
				''
			)
        )

    ),

    // CALIBRATION =========================================================================
    array(
    	array(
            'permission_code' => 'calibrations',
			'permission_name' => array(
				'Calibration Management',
				''
			),
			'permission_description' => array(
				'Allow account to access calibrations',
				''
			)
        )

    ),

    // CALIBRATION MONITORING =========================================================================
    array(
        array(
            'permission_code' => 'calibration-monitoring',
			'permission_name' => array(
				'Calibration Monitoring Management',
				''
			),
			'permission_description' => array(
				'Allow account to access calibration monitoring list and view calibration monitoring details.',
				''
			)
        ),
        array(
            'permission_code' => 'calibration-monitoring-add',
			'permission_name' => array(
				'Add Calibration Monitoring',
				''
			),
			'permission_description' => array(
				'Allow account to add calibration monitoring.',
				''
			)
        ),
        array(
            'permission_code' => 'calibration-monitoring-edit',
			'permission_name' => array(
				'Edit Calibration Monitoring',
				''
			),
			'permission_description' => array(
				'Allow account to edit calibration monitoring.',
				''
			)
        )
    ),

    // CALIBRATION PLAN ============================================================================
    array(
        array(
            'permission_code' => 'calibration-plans',
			'permission_name' => array(
				'Calibration Plan Monitoring',
				''
			),
			'permission_description' => array(
				'Allow account to access calibration plan list and details.',
				''
			)
        ),
        array(
            'permission_code' => 'calibration-plan-add',
			'permission_name' => array(
				'Add Calibration Plan',
				''
			),
			'permission_description' => array(
				'Allow account to add calibration plan.',
				''
			)
        ),
        array(
            'permission_code' => 'calibration-plan-edit',
			'permission_name' => array(
				'Edit Calibration Plan',
				''
			),
			'permission_description' => array(
				'Allow account to edit calibration plan.',
				''
			)
        )
	),

    // JOB ORDER ====================================================================================
    array(
        array(
            'permission_code' => 'job-orders',
			'permission_name' => array(
				'Job Order Management',
				''
			),
			'permission_description' => array(
				'Allow account to access move job order list and view job order details.',
				''
			)
        ),
        array(
            'permission_code' => 'job-order-add',
			'permission_name' => array(
				'Add Job Order',
				''
			),
			'permission_description' => array(
				'Allow account to add job order.',
				''
			)
        ),
        array(
            'permission_code' => 'job-order-edit',
			'permission_name' => array(
				'Edit Job Order',
				''
			),
			'permission_description' => array(
				'Allow account to edit work order.',
				''
			)
        ),
        array(
            'permission_code' => 'job-order-delete',
			'permission_name' => array(
				'Delete Job Order',
				''
			),
			'permission_description' => array(
				'Allow account to delete work order.',
				''
			)
        )
    ),

    // WORK ORDER ====================================================================================
    array(
        array(
            'permission_code' => 'work-orders',
			'permission_name' => array(
				'Work Order Management',
				''
			),
			'permission_description' => array(
				'Allow account to access move work order list and view work order details.',
				''
			)
        ),
        array(
            'permission_code' => 'work-order-add',
			'permission_name' => array(
				'Add Work Order',
				''
			),
			'permission_description' => array(
				'Allow account to add work order.',
				''
			)
        ),
        array(
            'permission_code' => 'work-order-edit',
			'permission_name' => array(
				'Edit Work Order',
				''
			),
			'permission_description' => array(
				'Allow account to edit work order.',
				''
			)
        ),
        array(
            'permission_code' => 'work-order-delete',
			'permission_name' => array(
				'Delete Work Order',
				''
			),
			'permission_description' => array(
				'Allow account to delete work order.',
				''
			)
        )
	),
	
	// COLLECTIONS ===========================================================================
	array(
		array(
            'permission_code' => 'collections',
			'permission_name' => array(
				'Collections Management',
				''
			),
			'permission_description' => array(
				'Allow account to access collections menu.',
				''
			)
		)
    ),
    
    //  UNDEPOSITED ==========================================================================
    array(
        array(
            'permission_code' => 'undeposited',
			'permission_name' => array(
				'Undeposited Collections Management',
				''
			),
			'permission_description' => array(
				'Allow account to access undeposited collections list and view undeposited collection details.',
				''
			)
		),
		array(
            'permission_code' => 'undeposited-summary',
			'permission_name' => array(
				'Undeposited Summary Mangement',
				''
			),
			'permission_description' => array(
				'Allow account to access undeposited collections summary list and view undeposited collection summary details.',
				''
			)
		)
    ),

    // DAILY COLLECTION ==========================================================================
    array(
        array(
            'permission_code' => 'daily-collections',
			'permission_name' => array(
				'Daily Collection Management',
				''
			),
			'permission_description' => array(
				'Allow account to access move daily collection list and view daily collection details.',
				''
			)
        ),
        array(
            'permission_code' => 'daily-collection-add',
			'permission_name' => array(
				'Add Daily Collection',
				''
			),
			'permission_description' => array(
				'Allow account to add daily collection.',
				''
			)
        ),
        array(
            'permission_code' => 'daily-collection-edit',
			'permission_name' => array(
				'Edit Daily Collection',
				''
			),
			'permission_description' => array(
				'Allow account to edit daily collection.',
				''
			)
        ),
        array(
            'permission_code' => 'daily-collection-delete',
			'permission_name' => array(
				'Delete Daily Collection',
				''
			),
			'permission_description' => array(
				'Allow account to delete daily collection.',
				''
			)
        ),
        array(
            'permission_code' => 'daily-collection-update-status',
			'permission_name' => array(
				'Update Status of Daily Collection',
				''
			),
			'permission_description' => array(
				'Allow account to update status of daily collection.',
				''
			)
        )
	),
	
	// CHECK VOUCHERS ========================================================================
	array(
		array(
            'permission_code' => 'check-vouchers',
			'permission_name' => array(
				'Check Vouchers Management',
				''
			),
			'permission_description' => array(
				'Allow account to access check vouchers and view details of check vouchers.',
				''
			)
		),
		array(
            'permission_code' => 'check-voucher-add',
			'permission_name' => array(
				'Add Check Vouchers',
				''
			),
			'permission_description' => array(
				'Allow account to add check vouchers.',
				''
			)
        ),
		array(
            'permission_code' => 'check-voucher-edit',
			'permission_name' => array(
				'Add Check Vouchers',
				''
			),
			'permission_description' => array(
				'Allow account to add check vouchers.',
				''
			)
        )
	),

	// DAILY DEPOSIT =========================================================================
	array(
		array(
            'permission_code' => 'daily-deposit',
			'permission_name' => array(
				'Daily Deposit Management',
				''
			),
			'permission_description' => array(
				'Allow account to access daily deposit list and view daily deposit details.',
				''
			)
        ),
        array(
            'permission_code' => 'daily-deposit-add',
			'permission_name' => array(
				'Add Daily Deposit',
				''
			),
			'permission_description' => array(
				'Allow account to add daily deposit.',
				''
			)
        ),
        array(
            'permission_code' => 'daily-deposit-edit',
			'permission_name' => array(
				'Edit Daily Deposit',
				''
			),
			'permission_description' => array(
				'Allow account to edit daily deposit.',
				''
			)
        ),
        array(
            'permission_code' => 'daily-deposit-delete',
			'permission_name' => array(
				'Delete Daily Deposit',
				''
			),
			'permission_description' => array(
				'Allow account to delete daily deposit.',
				''
			)
        ),
        array(
            'permission_code' => 'daily-deposit-verify',
			'permission_name' => array(
				'Verify Daily Deposit',
				''
			),
			'permission_description' => array(
				'Allow account to verify daily deposit.',
				''
			)
        ),
        array(
            'permission_code' => 'daily-deposit-approve',
			'permission_name' => array(
				'Approve Daily Deposit',
				''
			),
			'permission_description' => array(
				'Allow account to approve daily deposit.',
				''
			)
        ),
        array(
            'permission_code' => 'daily-deposit-comments',
			'permission_name' => array(
				'Daily Deposit Comments',
				''
			),
			'permission_description' => array(
				'Allow account to view daily deposit comments.',
				''
			)
        ),
        array(
            'permission_code' => 'daily-deposit-comment-add',
			'permission_name' => array(
				'Add Daily Deposit Comments',
				''
			),
			'permission_description' => array(
				'Allow account to view daily deposit comments.',
				''
			)
        )
    ),

    // UNIDENTIFIED ======================================================================
    array(
        array(
            'permission_code' => 'unidentified',
			'permission_name' => array(
				'Unidentified Management',
				''
			),
			'permission_description' => array(
				'Allow account to access unidentified list and view unidentified details.',
				''
			)
        ),
        array(
            'permission_code' => 'unidentified-add',
			'permission_name' => array(
				'Add Unidentified',
				''
			),
			'permission_description' => array(
				'Allow account to add unidentified.',
				''
			)
        )
    ),
    
    // DAILY COLLECTION REPORT ============================================================
    array(
        array(
            'permission_code' => 'daily-collection-reports',
			'permission_name' => array(
				'Daily Collection Report Management',
				''
			),
			'permission_description' => array(
				'Allow account to access daily collection report list and view daily collection report details.',
				''
			)
        ),
        array(
            'permission_code' => 'daily-collection-report-add',
			'permission_name' => array(
				'Add Daily Collection Report',
				''
			),
			'permission_description' => array(
				'Allow account to add daily collection report',
				''
			)
        ),
        array(
            'permission_code' => 'daily-collection-report-edit',
			'permission_name' => array(
				'Edit Daily Collection Report',
				''
			),
			'permission_description' => array(
				'Allow account to edit daily collection report',
				''
			)
        ),
        array(
            'permission_code' => 'daily-collection-report-verify',
			'permission_name' => array(
				'Verify Daily Collection Report',
				''
			),
			'permission_description' => array(
				'Allow account to verify daily collection report',
				''
			)
        ),
        array(
            'permission_code' => 'daily-collection-report-approve',
			'permission_name' => array(
				'Approve Daily Collection Report',
				''
			),
			'permission_description' => array(
				'Allow account to Approve daily collection report',
				''
			)
        ),
        array(
            'permission_code' => 'daily-collection-report-comment',
			'permission_name' => array(
				'Daily Collection Report Comments',
				''
			),
			'permission_description' => array(
				'Allow account to view daily collection report comments',
				''
			)
        ),
        array(
            'permission_code' => 'daily-collection-report-comment-add',
			'permission_name' => array(
				'Add Daily Collection Report Comments',
				''
			),
			'permission_description' => array(
				'Allow account to add daily collection report comments',
				''
			)
        ),
        array(
            'permission_code' => 'daily-collection-report-overage',
			'permission_name' => array(
				'Daily Collection Report Overage/shortage',
				''
			),
			'permission_description' => array(
				'Allow account to add daily collection report comments',
				''
			)
        )
    ),
    
    // PDC ============================================================
    array(
        array(
            'permission_code' => 'pdc',
			'permission_name' => array(
				'PDC Management',
				''
			),
			'permission_description' => array(
				'Allow account to access pdc list and view pdc details.',
				''
			)
        ),
        array(
            'permission_code' => 'pdc-add',
			'permission_name' => array(
				'Add PDC',
				''
			),
			'permission_description' => array(
				'Allow account to add pdc list',
				''
			)
        ),
        array(
            'permission_code' => 'pdc-edit',
			'permission_name' => array(
				'Edit PDC',
				''
			),
			'permission_description' => array(
				'Allow account to edit pdc list',
				''
			)
        ),
        array(
            'permission_code' => 'pdc-verify',
			'permission_name' => array(
				'Verify PDC',
				''
			),
			'permission_description' => array(
				'Allow account to verify pdc list',
				''
			)
        ),
        array(
            'permission_code' => 'pdc-approve',
			'permission_name' => array(
				'Approve PDC',
				''
			),
			'permission_description' => array(
				'Allow account to Approve pdc list',
				''
			)
        )
    ),

    // PDC MONITORING ================================================================================
    array(
        array(
            'permission_code' => 'pdc-monitoring',
			'permission_name' => array(
				'PDC Monitoring Management',
				''
			),
			'permission_description' => array(
				'Allow account to view PDC Monitoring list and PDC Monitoring details',
				''
			)
        ),
        array(
            'permission_code' => 'pdc-monitoring-add',
			'permission_name' => array(
				'Add PDC Monitoring',
				''
			),
			'permission_description' => array(
				'Allow account to add pdc monitoring',
				''
			)
        )
    ),

    // DEPOSIT IN TRANSIT ======================================================================
    array(
        array(
            'permission_code' => 'deposit-in-transit',
			'permission_name' => array(
				'Deposit in Transit Management',
				''
			),
			'permission_description' => array(
				'Allow account to access deposit in transit list and view deposit in transit details.',
				''
			)
        ),
        array(
            'permission_code' => 'deposit-in-transit-add',
			'permission_name' => array(
				'Add Deposit in Transit',
				''
			),
			'permission_description' => array(
				'Allow account to add deposit in transit.',
				''
			)
        )
    ),

    // CANCELLED COLLECTION ========================================================================
    array(
        array(
            'permission_code' => 'cancelled-collections',
			'permission_name' => array(
				'Cancelled Collections Management',
				''
			),
			'permission_description' => array(
				'Allow account to access cancelled collection list and view cancelled collection details.',
				''
			)
        ),
        array(
            'permission_code' => 'cancelled-collection-add',
			'permission_name' => array(
				'Add Cancelled Collection',
				''
			),
			'permission_description' => array(
				'Allow account to add cancelled collection.',
				''
			)
        ),
        array(
            'permission_code' => 'cancelled-collection-approve',
			'permission_name' => array(
				'Approve Cancelled Collection',
				''
			),
			'permission_description' => array(
				'Allow account to approve cancelled collection.',
				''
			)
        )
    ),

    // OPERATION AUDIT ===============================================================================
    array(
        array(
            'permission_code' => 'audits',
			'permission_name' => array(
				'Audit Management',
				''
			),
			'permission_description' => array(
				'',
				''
			)
        ),
        array(
            'permission_code' => 'audit-add',
			'permission_name' => array(
				'Add Audit',
				''
			),
			'permission_description' => array(
				'',
				''
			)
        ),
        array(
            'permission_code' => 'audits-edit',
			'permission_name' => array(
				'Edit Audit',
				''
			),
			'permission_description' => array(
				'',
				''
			)
        ),
        array(
            'permission_code' => 'audits-delete',
			'permission_name' => array(
				'Delete Audit',
				''
			),
			'permission_description' => array(
				'',
				''
			)
        )
    ),

    
    // OPERATION AUDIT PAD ================================================================
    array(
        array(
            'permission_code' => 'operation-audit-PAD',
			'permission_name' => array(
				'Operation Audit PAD Management',
				''
			),
			'permission_description' => array(
				'Allow account to view list and details of PAD audit.',
				''
			)
        ),
        array(
            'permission_code' => 'operation-audit-PAD-add',
			'permission_name' => array(
				'Add Operation Audit PAD',
				''
			),
			'permission_description' => array(
				'Allow account to add PAD audit.',
				''
			)
        ),
        array(
            'permission_code' => 'operation-audit-PAD-edit',
			'permission_name' => array(
				'Edit Operation Audit PAD',
				''
			),
			'permission_description' => array(
				'Allow account to edit PAD audit details.',
				''
			)
        ),
    ),
    
    // OPERATION AUDIT IAD ===================================================
    array(
        array(
            'permission_code' => 'operation-audit-IAD',
			'permission_name' => array(
				'Operation Audit IAD Management',
				''
			),
			'permission_description' => array(
				'Allow account to view list and details of IAD audit.',
				''
			)
        ),
        array(
            'permission_code' => 'operation-audit-IAD-add',
			'permission_name' => array(
				'Add Operation Audit IAD',
				''
			),
			'permission_description' => array(
				'Allow account to add IAD audit.',
				''
			)
        ),
        array(
            'permission_code' => 'operation-audit-IAD-edit',
			'permission_name' => array(
				'Edit Operation Audit IAD',
				''
			),
			'permission_description' => array(
				'Allow account to edit IAD audit details.',
				''
			)
        ),
        array(
            'permission_code' => 'operation-audit-IAD-delete',
			'permission_name' => array(
				'Delete Operation Audit IAD',
				''
			),
			'permission_description' => array(
				'Allow account to delete IAD audit.',
				''
			)
        ),
        array(
            'permission_code' => 'operation-audit-IAD-approve',
			'permission_name' => array(
				'Approve Operation Audit IAD',
				''
			),
			'permission_description' => array(
				'Allow account to approve IAD audit.',
				''
			)
        ),
        array(
            'permission_code' => 'operation-audit-IAD-comments',
			'permission_name' => array(
				'View Operation Audit IAD Comments',
				''
			),
			'permission_description' => array(
				'Allow account to view IAD audit comments.',
				''
			)
        ),
        array(
            'permission_code' => 'operation-audit-IAD-comment-add',
			'permission_name' => array(
				'Add Operation Audit IAD Comment',
				''
			),
			'permission_description' => array(
				'Allow account to add IAD audit comments.',
				''
			)
        )
    ),

    // OPERATION AUDIT TSA ===================================================
    array(
    	array(
    		'permission_code' => 'operations-audit-TSA',
    		'permission_name' => array(
    			'Operations Audit TSA Management',
    			''
    		),
    		'permission_description' => array(
    			'Allow account to view the list and details of TSA Audit',
    			''
    		)
    	),
        array(
            'permission_code' => 'operations-audit-TSA-add',
			'permission_name' => array(
				'Add Operations Audit TSA',
				''
			),
			'permission_description' => array(
				'Allow account to add TSA audit.',
				''
			)
        ),
        array(
            'permission_code' => 'operations-audit-TSA-edit',
			'permission_name' => array(
				'Edit Operations Audit TSA',
				''
			),
			'permission_description' => array(
				'Allow account to edit TSA audit details.',
				''
			)
        ),
        array(
            'permission_code' => 'operations-audit-TSA-delete',
			'permission_name' => array(
				'Delete Operations Audit TSA',
				''
			),
			'permission_description' => array(
				'Allow account to delete TSA audit.',
				''
			)
        ),
        array(
            'permission_code' => 'operations-audit-TSA-comments',
			'permission_name' => array(
				'Operations Audit TSA Comments',
				''
			),
			'permission_description' => array(
				'Allow account to view TSA audit comments.',
				''
			)
        ),
        array(
            'permission_code' => 'operations-audit-TSA-comment-add',
			'permission_name' => array(
				'Add Operations Audit TSA Comments',
				''
			),
			'permission_description' => array(
				'Allow account to add TSA audit comments.',
				''
			)
        ),
        array(
            'permission_code' => 'operations-audit-TSA-approve',
			'permission_name' => array(
				'Approve Operations Audit TSA',
				''
			),
			'permission_description' => array(
				'Allow account to approve TSA audit.',
				''
			)
        )
	),

    // COMMUNICATION MANAGEMENT ======================================================================
    array(
        array(
            'permission_code' => 'communication-managements',
			'permission_name' => array(
				'Communication Management',
				''
			),
			'permission_description' => array(
				'',
				''
			)
        )
    ),

    // PERMITS AND LICENCES =========================================================================
    array(
        array(
            'permission_code' => 'permits-licences',
			'permission_name' => array(
				'Permits and Licences Management',
				''
			),
			'permission_description' => array(
				'',
				''
			)
        ),
        array(
            'permission_code' => 'permits-licences-add',
			'permission_name' => array(
				'Add Permits and Licences',
				''
			),
			'permission_description' => array(
				'',
				''
			)
        )
    ),

    // MANAGEMENT REPORT =============================================================================
    array(
        array(
            'permission_code' => 'management-report',
			'permission_name' => array(
				'Management Report',
				''
			),
			'permission_description' => array(
				'Allow account to access management report list and view management report details.',
				''
			)
        ),
        array(
            'permission_code' => 'management-report-add',
			'permission_name' => array(
				'Add Management Report',
				''
			),
			'permission_description' => array(
				'Allow account to add management report.',
				''
			)
        ),
        array(
            'permission_code' => 'management-report-edit',
			'permission_name' => array(
				'Edit Management Report',
				''
			),
			'permission_description' => array(
				'Allow account to edit management report.',
				''
			)
        )
    ),

    // FILING SYSTEM ================================================================================
    array(
        array(
            'permission_code' => 'filing-system',
			'permission_name' => array(
				'Filing System Management',
				''
			),
			'permission_description' => array(
				'',
				''
			)
        )
    ),

    
    // INCIDENT REPORT =============================================================================
    array(
        array(
            'permission_code' => 'incident-reports',
			'permission_name' => array(
				'Incident Report Management',
				''
			),
			'permission_description' => array(
				'',
				''
			)
        ),
        array(
            'permission_code' => 'incident-report-add',
			'permission_name' => array(
				'Add Incident Report',
				''
			),
			'permission_description' => array(
				'',
				''
			)
        ),
        array(
            'permission_code' => 'incident-report-edit',
			'permission_name' => array(
				'Edit Incident Report',
				''
			),
			'permission_description' => array(
				'',
				''
			)
        ),
        array(
            'permission_code' => 'incident-report-delete',
			'permission_name' => array(
				'Delete Incident Report',
				''
			),
			'permission_description' => array(
				'',
				''
			)
        )
    ),

    // DOCUMENT MANAGENT =============================================================================
    array(
        array(
            'permission_code' => 'document-management',
			'permission_name' => array(
				'Document Management',
				''
			),
			'permission_description' => array(
				'',
				''
			)
        )
    ),

    // 201 FILES =======================================================================================
    array(
        array(
            'permission_code' => '201-files',
			'permission_name' => array(
				'201 Files Management',
				''
			),
			'permission_description' => array(
				'',
				''
			)
        ),
    ),

    // MINUTES OF MEETING ==============================================================================
    array(
        array(
            'permission_code' => 'minutes-of-meeting',
			'permission_name' => array(
				'Minutes of Meeting Management',
				''
			),
			'permission_description' => array(
				'',
				''
			)
        ),
        array(
            'permission_code' => 'minutes-of-meeting-add',
			'permission_name' => array(
				'Add Minutes of Meeting',
				''
			),
			'permission_description' => array(
				'',
				''
			)
        ),
        array(
            'permission_code' => 'minutes-of-meeting-edit',
			'permission_name' => array(
				'Edit Minutes of Meeting',
				''
			),
			'permission_description' => array(
				'',
				''
			)
        ),
        array(
            'permission_code' => 'minutes-of-meeting-departments',
			'permission_name' => array(
				'Add Minutes of Meeting Departments',
				''
			),
			'permission_description' => array(
				'Allow Input Departments.',
				''
			)
        ),
        array(
            'permission_code' => 'minutes-of-meeting-properties',
			'permission_name' => array(
				'Add Minutes of Meeting Properties',
				''
			),
			'permission_description' => array(
				'Allow Input Properties.',
				''
			)
        )
    ),

   // BOARD ==============================================================================
    array(
        array(
            'permission_code' => 'boards',
			'permission_name' => array(
				'Board Management',
				''
			),
			'permission_description' => array(
				'',
				''
			)
        ),
    ),

    // AGMM ==============================================================================
    array(
        array(
            'permission_code' => 'agmms',
			'permission_name' => array(
				'AGMM Management',
				''
			),
			'permission_description' => array(
				'',
				''
			)
        ),
    ),
    
    // ANNOUNCEMENT ==============================================================================
    array(
        array(
            'permission_code' => 'announcements',
			'permission_name' => array(
				'Announcement Management',
				''
			),
			'permission_description' => array(
				'',
				''
			)
        ),
    ),

    // MEMOS ==============================================================================
    array(
        array(
            'permission_code' => 'memos',
			'permission_name' => array(
				'Memo Management',
				''
			),
			'permission_description' => array(
				'',
				''
			)
        ),
    ),

    // RSVP ==============================================================================
    array(
        array(
            'permission_code' => 'rsvp',
			'permission_name' => array(
				'RSVP Management',
				''
			),
			'permission_description' => array(
				'',
				''
			)
        ),
    ),
	
	// EMPLOYEE GATE PASS ==============================================================================
	array(
		array(
            'permission_code' => 'gate-pass-employees',
			'permission_name' => array(
				'Gate Pass Employee Management',
				''
			),
			'permission_description' => array(
				'Allow account to access move gate pass employee list and view gate pass employee details.',
				''
			)
        ),
        array(
            'permission_code' => 'gate-pass-employee-add',
			'permission_name' => array(
				'Add Gate Pass Employee',
				''
			),
			'permission_description' => array(
				'Allow account to add gate pass employee.',
				''
			)
        ),
        array(
            'permission_code' => 'gate-pass-employee-edit',
			'permission_name' => array(
				'Edit Gate Pass Employee',
				''
			),
			'permission_description' => array(
				'Allow account to edit gate pass employee.',
				''
			)
        ),
        array(
            'permission_code' => 'gate-pass-employee-delete',
			'permission_name' => array(
				'Delete Gate Pass Employee',
				''
			),
			'permission_description' => array(
				'Allow account to delete gate pass employee.',
				''
			)
        )
	),

	// MAIL LOGS ==============================================================================
	array(
		array(
            'permission_code' => 'mail-logs',
			'permission_name' => array(
				'Mail Log Management',
				''
			),
			'permission_description' => array(
				'Allow account to access mail log list and view mail log details.',
				''
			)
        ),
        array(
            'permission_code' => 'mail-log-add',
			'permission_name' => array(
				'Add Mail Log',
				''
			),
			'permission_description' => array(
				'Allow account to add mail log.',
				''
			)
        ),
        array(
            'permission_code' => 'mail-log-edit',
			'permission_name' => array(
				'Edit Mail Log',
				''
			),
			'permission_description' => array(
				'Allow account to edit mail log.',
				''
			)
        ),
        array(
            'permission_code' => 'mail-log-delete',
			'permission_name' => array(
				'Delete Mail Log',
				''
			),
			'permission_description' => array(
				'Allow account to delete mail log.',
				''
			)
        )
	),

	// SERVICE REQUEST ==============================================================================
	array(
		array(
            'permission_code' => 'service-requests',
			'permission_name' => array(
				'Service Requests Management',
				''
			),
			'permission_description' => array(
				'Allow account to access move service request list and view service request details.',
				''
			)
        ),
        array(
            'permission_code' => 'service-request-add',
			'permission_name' => array(
				'Add Service Request',
				''
			),
			'permission_description' => array(
				'Allow account to add service request.',
				''
			)
        ),
        array(
            'permission_code' => 'service-request-edit',
			'permission_name' => array(
				'Edit Service Request',
				''
			),
			'permission_description' => array(
				'Allow account to edit service request.',
				''
			)
        ),
        array(
            'permission_code' => 'service-request-delete',
			'permission_name' => array(
				'Delete Service Request',
				''
			),
			'permission_description' => array(
				'Allow account to delete service request.',
				''
			)
        )
	),

	// BOARDROOMS ==============================================================================
	array(
		array(
            'permission_code' => 'boardrooms',
			'permission_name' => array(
				'Boardrooms Management',
				''
			),
			'permission_description' => array(
				'Allow account to access move boardroom list and view boardroom details.',
				''
			)
        ),
        array(
            'permission_code' => 'boardroom-add',
			'permission_name' => array(
				'Add Boardroom',
				''
			),
			'permission_description' => array(
				'Allow account to add boardroom.',
				''
			)
        ),
        array(
            'permission_code' => 'boardroom-edit',
			'permission_name' => array(
				'Edit Boardroom',
				''
			),
			'permission_description' => array(
				'Allow account to edit boardroom.',
				''
			)
        ),
        array(
            'permission_code' => 'boardroom-delete',
			'permission_name' => array(
				'Delete Boardroom',
				''
			),
			'permission_description' => array(
				'Allow account to delete boardroom.',
				''
			)
        )
	),

	// AMENITIES ==============================================================================
	array(
		array(
            'permission_code' => 'amenities',
			'permission_name' => array(
				'Amenities Management',
				''
			),
			'permission_description' => array(
				'Allow account to access move amenity list and view amenity details.',
				''
			)
        ),
        array(
            'permission_code' => 'amenity-add',
			'permission_name' => array(
				'Add Amenity',
				''
			),
			'permission_description' => array(
				'Allow account to add amenity.',
				''
			)
        ),
        array(
            'permission_code' => 'amenity-edit',
			'permission_name' => array(
				'Edit Amenity',
				''
			),
			'permission_description' => array(
				'Allow account to edit amenity-edit.',
				''
			)
        ),
        array(
            'permission_code' => 'amenity-delete',
			'permission_name' => array(
				'Delete Amenity',
				''
			),
			'permission_description' => array(
				'Allow account to delete amenity.',
				''
			)
        )
	),
	
	// POST OPERATIONS ==============================================================================
	array(
        array(
            'permission_code' => 'post-operations',
			'permission_name' => array(
				'Post Operations',
				''
			),
			'permission_description' => array(
				'Allow account to post operations.',
				''
			)
        )
	),

	// COLLECT ==============================================================================
	array(
        array(
            'permission_code' => 'collects',
			'permission_name' => array(
				'Collects',
				''
			),
			'permission_description' => array(
				'Allow account to collect.',
				''
			)
        )
	),

	// TURNOVER AUDIT ==============================================================================
	array(
        array(
            'permission_code' => 'turnover-audits',
			'permission_name' => array(
				'Turnover Audit',
				''
			),
			'permission_description' => array(
				'Allow account to turnover audit.',
				''
			)
        )
	),

	// REPORTS ==============================================================================
	array(
        array(
            'permission_code' => 'reports',
			'permission_name' => array(
				'Reports',
				''
			),
			'permission_description' => array(
				'Allow account to report.',
				''
			)
        )
	),

	// ACCOUNTING ==============================================================================
	array(
        array(
            'permission_code' => 'accounting',
			'permission_name' => array(
				'Accounting',
				''
			),
			'permission_description' => array(
				'Allow account to accounting.',
				''
			)
        )
	),

	// ADMIN ==============================================================================
	array(
        array(
            'permission_code' => 'admin',
			'permission_name' => array(
				'Admin',
				''
			),
			'permission_description' => array(
				'Allow account to admin.',
				''
			)
        )
	),
	
      // HELP DESK ==============================================================================
	array(
        array(
            'permission_code' => 'customer-service',
			'permission_name' => array(
				'Help Desk',
				''
			),
			'permission_description' => array(
				'Allow account to customer service.',
				''
			)
        )
	),
	
	// COOLFIX ==============================================================================
	array(
        array(
            'permission_code' => 'coolfix',
			'permission_name' => array(
				'Coolfix',
				''
			),
			'permission_description' => array(
				'Allow account to coolfix.',
				''
			)
        )
	),

	// PROPERTY PROFILE ==============================================================================
	array(
        array(
            'permission_code' => 'property-profile',
			'permission_name' => array(
				'Property Proffile',
				''
			),
			'permission_description' => array(
				'Allow account to Property Proffile.',
				''
			)
        )
	),

	// MARKET PLACE ==============================================================================
	array(
        array(
            'permission_code' => 'market-place',
			'permission_name' => array(
				'Market Place',
				''
			),
			'permission_description' => array(
				'Allow account to Market Place.',
				''
			)
        )
	),
	
	// BDMD PROSPECTING  ==============================================================================
	array(
        array(
            'permission_code' => 'prospecting-bdmd',
			'permission_name' => array(
				'BDMD',
				''
			),
			'permission_description' => array(
				'Allow account to BDMD.',
				''
			)
        )
	),

	// ESD PROSPECTING  ==============================================================================
	array(
        array(
            'permission_code' => 'prospecting-esd',
			'permission_name' => array(
				'ESD',
				''
			),
			'permission_description' => array(
				'Allow account to ESD.',
				''
			)
        )
	),

	// POD PROSPECTING  ==============================================================================
	array(
        array(
            'permission_code' => 'prospecting-pod',
			'permission_name' => array(
				'POD Prospecting',
				''
			),
			'permission_description' => array(
				'Allow account to ESD.',
				''
			)
        )
	),
	
	// OTHER TASK - PRE OPERATIONS ===================================================================
	array(
        array(
            'permission_code' => 'pre-operation-other-tasks',
			'permission_name' => array(
				'Other Task Management',
				''
			),
			'permission_description' => array(
				'Allow account to view Other Task List.',
				''
			)
        ),
        array(
            'permission_code' => 'pre-operation-other-task-add',
			'permission_name' => array(
				'Add Other Task',
				''
			),
			'permission_description' => array(
				'Allow account to add other task.',
				''
			)
        ),
        array(
            'permission_code' => 'pre-operation-other-task-edit',
			'permission_name' => array(
				'Edit Other Task',
				''
			),
			'permission_description' => array(
				'Allow account to edit other task.',
				''
			)
        ),
        array(
            'permission_code' => 'pre-operation-other-task-delete',
			'permission_name' => array(
				'Delete Other Task',
				''
			),
			'permission_description' => array(
				'Allow account to delete other task.',
				''
			)
        )
	),

	// SYSTEM  ==============================================================================
	array(
        array(
            'permission_code' => 'system',
			'permission_name' => array(
				'System',
				''
			),
			'permission_description' => array(
				'Allow account to System.',
				''
			)
        )
    ),
    
    // NOTIFICATIONS ===============================================================================
    array(
        array(
            'permission_code' => 'notifications',
			'permission_name' => array(
				'Notifications',
				''
			),
			'permission_description' => array(
				'Allow account to get notifications.',
				''
			)
        ),
        array(
            'permission_code' => 'notification-prospecting',
			'permission_name' => array(
				'Notification on QEHS pre-operation-audit',
				''
			),
			'permission_description' => array(
				'Allow account to get notifications on QEHS pre-operation-audit.',
				''
			)
        ),
        array(
            'permission_code' => 'notification-day-plan',
			'permission_name' => array(
				'Notification on 30-60-90 day plan',
				''
			),
			'permission_description' => array(
				'Allow account to get notifications on 30-60-90 day plan.',
				''
			)
        ),
        array(
            'permission_code' => 'notification-pre-operation-audit-QEHS',
			'permission_name' => array(
				'Notification on QEHS pre-operation-audit',
				''
			),
			'permission_description' => array(
				'Allow account to get notifications on QEHS pre-operation-audit.',
				''
			)
        ),
        array(
            'permission_code' => 'notification-nni',
			'permission_name' => array(
				'Notification on Notice of New Instruction',
				''
			),
			'permission_description' => array(
				'Allow account to get notifications on Notice of New Instruction.',
				''
			)
        ),
        array(
            'permission_code' => 'notification-billing-advice',
			'permission_name' => array(
				'Notification on Billing Advise',
				''
			),
			'permission_description' => array(
				'Allow account to get notifications on Billing Advise.',
				''
			)
        ),
        array(
            'permission_code' => 'notification-it-information',
			'permission_name' => array(
				'Notification on IT Information',
				''
			),
			'permission_description' => array(
				'Allow account to get notifications on IT Information.',
				''
			)
        ),
        array(
            'permission_code' => 'notification-cad-information',
			'permission_name' => array(
				'Notification on CAD Information',
				''
			),
			'permission_description' => array(
				'Allow account to get notifications on CAD Information.',
				''
			)
        ),
        array(
            'permission_code' => 'notification-hr-information',
			'permission_name' => array(
				'Notification on HR Information',
				''
			),
			'permission_description' => array(
				'Allow account to get notifications on HR Information.',
				''
			)
        ),
        array(
            'permission_code' => 'notification-prf',
			'permission_name' => array(
				'Notification on PRF',
				''
			),
			'permission_description' => array(
				'Allow account to get notifications on PRF.',
				''
			)
        ),
        array(
            'permission_code' => 'notification-contract',
			'permission_name' => array(
				'Notification on Contract',
				''
			),
			'permission_description' => array(
				'Allow account to get notifications on Contract.',
				''
			)
        ),
        array(
            'permission_code' => 'notification-gate-pass-employee',
			'permission_name' => array(
				'Notification on Gate Pass Employee',
				''
			),
			'permission_description' => array(
				'Allow account to get notifications on Gate Pass Employee.',
				''
			)
        ),
        array(
            'permission_code' => 'notification-notice-to-proceed',
			'permission_name' => array(
				'Notification on Notice to Proceed',
				''
			),
			'permission_description' => array(
				'Allow account to get notifications on Notice to Proceed.',
				''
			)
        ),
        array(
            'permission_code' => 'notification-visitor',
			'permission_name' => array(
				'Notification on Visitor',
				''
			),
			'permission_description' => array(
				'Allow account to get notifications on Visitor.',
				''
			)
        ),
        array(
            'permission_code' => 'notification-prf',
			'permission_name' => array(
				'Notification on PRF',
				''
			),
			'permission_description' => array(
				'Allow account to get notifications on PRF.',
				''
			)
        ),
        array(
            'permission_code' => 'notification-pre-operation-audit-iad',
			'permission_name' => array(
				'Notification on Pre Operation Audit IAD',
				''
			),
			'permission_description' => array(
				'Allow account to get notifications on Pre Operation Audit IAD.',
				''
			)
        ),
        array(
            'permission_code' => 'notification-pre-operation-audit-pad-pcc',
			'permission_name' => array(
				'Notification on Pre Operation Audit PAD PCC',
				''
			),
			'permission_description' => array(
				'Allow account to get notifications on Pre Operation Audit PAD PCC.',
				''
			)
        ),
        array(
            'permission_code' => 'notification-nni-status-endorsed',
			'permission_name' => array(
				'Notification on NNI if status is endorsed',
				''
			),
			'permission_description' => array(
				'Allow account to get notifications on NNI if status is endorsed.',
				''
			)
        ),
        array(
            'permission_code' => 'notification-nni-status-for-revision',
			'permission_name' => array(
				'Notification on NNI if status is for revision',
				''
			),
			'permission_description' => array(
				'Allow account to get notifications on NNI if status is for revision.',
				''
			)
        ),
        array(
            'permission_code' => 'notification-nni-status-assigned',
			'permission_name' => array(
				'Notification on NNI if status is assigned',
				''
			),
			'permission_description' => array(
				'Allow account to get notifications on NNI if status is assigned.',
				''
			)
        ),
        array(
            'permission_code' => 'notification-nni-status-for-execution',
			'permission_name' => array(
				'Notification on NNI if status is execution',
				''
			),
			'permission_description' => array(
				'Allow account to get notifications on NNI if status is execution.',
				''
			)
        ),
        array(
            'permission_code' => 'notification-nni-cad-status-completed',
			'permission_name' => array(
				'Notification on NNI CAD if status is completed',
				''
			),
			'permission_description' => array(
				'Allow account to get notifications on NNI CAD if status is completed.',
				''
			)
        ),
        array(
            'permission_code' => 'notification-nni-hr-status-completed',
			'permission_name' => array(
				'Notification on NNI HR if status is completed',
				''
			),
			'permission_description' => array(
				'Allow account to get notifications on NNI HR if status is completed.',
				''
			)
        ),
        array(
            'permission_code' => 'notification-nni-it-status-completed',
			'permission_name' => array(
				'Notification on NNI IT if status is completed ',
				''
			),
			'permission_description' => array(
				'Allow account to get notifications on NNI IT if status is completed .',
				''
			)
        ),
        array(
            'permission_code' => 'notification-nni-status-completed',
			'permission_name' => array(
				'Notification on NNI if status is completed ',
				''
			),
			'permission_description' => array(
				'Allow account to get notifications on NNI if status is completed.',
				''
			)
        ),
        array(
            'permission_code' => 'notification-minutes-of-meeting',
			'permission_name' => array(
				'Notification on Minutes of Meeting',
				''
			),
			'permission_description' => array(
				'Allow account to get notifications on Minutes of Meeting.',
				''
			)
        ),
        array(
            'permission_code' => 'notification-property',
			'permission_name' => array(
				'Notification on assigned property to cluster',
				''
			),
			'permission_description' => array(
				'Allow account to get notifications on assigned property to cluster.',
				''
			)
        ),
        array(
            'permission_code' => 'notification-contract-terminated',
			'permission_name' => array(
				'Notification on contract terminated',
				''
			),
			'permission_description' => array(
				'Allow account to get notifications on contract terminated.',
				''
			)
        ),
        array(
            'permission_code' => 'notification-prospecting-activity',
			'permission_name' => array(
				'Notification on prospecting activities',
				''
			),
			'permission_description' => array(
				'Allow account to get notifications on prospecting activity updates.',
				''
			)
        ),
        array(
            'permission_code' => 'notification-other-task-activities',
			'permission_name' => array(
				'Notification on other task remarks',
				''
			),
			'permission_description' => array(
				'Allow account to get notifications on other task activities remarks.',
				''
			)
        ),
        array(
            'permission_code' => 'notification-undeposited-collection',
			'permission_name' => array(
				'Notification on Undeposited Collection',
				''
			),
			'permission_description' => array(
				'Allow account to get notifications on undeposited collection.',
				''
			)
        ),
        array(
            'permission_code' => 'notification-other-task',
			'permission_name' => array(
				'Notification on other task.',
				''
			),
			'permission_description' => array(
				'Allow account to get notifications on other task.',
				''
			)
        ),
        //notification general inspection and function check
        array(
            'permission_code' => 'notification-general-inspection-and-function-check',
			'permission_name' => array(
				'Notification on general inspection and function check',
				''
			),
			'permission_description' => array(
				'Allow account to get notifications on general inspection and function check.',
				''
			)
        ),
        //notification proper installation general inspection and function check
        array(
            'permission_code' => 'notification-proper-installation-general-inspection-and-function-check',
			'permission_name' => array(
				'Notification on proper installation general inspection and function check',
				''
			),
			'permission_description' => array(
				'Allow account to get notifications on proper installation general inspection and function check.',
				''
			)
        ),
        //notification supply voltage and load current reading
        array(
            'permission_code' => 'notification-supply-voltage-and-load-current-reading',
			'permission_name' => array(
				'Notification on supply voltage and load current reading',
				''
			),
			'permission_description' => array(
				'Allow account to get notifications on supply voltage and load current reading.',
				''
			)
        ),
        //notification power and grounding wirings
        array(
            'permission_code' => 'notification-power-and-grounding-wirings',
			'permission_name' => array(
				'Notification on power and grounding wirings',
				''
			),
			'permission_description' => array(
				'Allow account to get notifications on power and grounding wirings.',
				''
			)
		),
		array(
            'permission_code' => 'notification-check-voucher',
			'permission_name' => array(
				'Notification on check voucher',
				''
			),
			'permission_description' => array(
				'Allow account to get notifications on check voucher.',
				''
			)
        ),
        array(
            'permission_code' => 'notification-fcu-monthly-inspections',
			'permission_name' => array(
				'Notification on fcu monthly inspections',
				''
			),
			'permission_description' => array(
				'Allow account to get notifications on fcu monthly inspections.',
				''
			)
        ),
        //notification DAILY COLLECTION
        array(
            'permission_code' => 'notification-daily-collection',
			'permission_name' => array(
				'Notification on Daily Collection',
				''
			),
			'permission_description' => array(
				'Allow account to get notifications on Daily Collection.',
				''
			)
        ),
        //notification CALIBRATION MONITORING
        array(
            'permission_code' => 'notification-calibration-monitoring',
			'permission_name' => array(
				'Notification on Calibration Monitoring',
				''
			),
			'permission_description' => array(
				'Allow account to get notifications on Calibration Monitoring.',
				''
			)
        ),
        //notification CALIBRATION PLAN
        array(
            'permission_code' => 'notification-calibration-plans',
			'permission_name' => array(
				'Notification on Calibration Plan',
				''
			),
			'permission_description' => array(
				'Allow account to get notifications on Calibration Plan.',
				''
			)
        ),
        //notification PROPOSAL INTRODUCTORY LETTER
        array(
            'permission_code' => 'notification-proposal-introductory-letter',
			'permission_name' => array(
				'Notification on Proposal Introductory Letter',
				''
			),
			'permission_description' => array(
				'Allow account to get notification on Proposal Introductory Letter.',
				''
			)
        ),
        // LABOR COST
        array(
            'permission_code' => 'notification-labor-cost-add',
			'permission_name' => array(
				'Notification on Labor Cost Add',
				''
			),
			'permission_description' => array(
				'Allow account to get notifications on new labor cost.',
				''
			)
        ),
        array(
            'permission_code' => 'notification-labor-cost-edit',
			'permission_name' => array(
				'Notification on Labor Cost Update',
				''
			),
			'permission_description' => array(
				'Allow account to get notifications on labor cost updates.',
				''
			)
        ),
        array(
            'permission_code' => 'notification-labor-cost-returned',
			'permission_name' => array(
				'Notification on Labor Cost Returned',
				''
			),
			'permission_description' => array(
				'Allow account to get notifications on labor cost returns.',
				''
			)
        ),
        array(
            'permission_code' => 'notification-labor-cost-approved',
			'permission_name' => array(
				'Notification on Labor Cost Approved',
				''
			),
			'permission_description' => array(
				'Allow account to get notifications on labor cost approves.',
				''
			)
        ),
        // DAILY COLLECTION REPORT
        array(
            'permission_code' => 'notification-daily-collection-report',
			'permission_name' => array(
				'Notification on Daily Collection Report',
				''
			),
			'permission_description' => array(
				'Allow account to get notifications on new daily collection report.',
				''
			)
        ),
        // DAILY DEPOSIT
        array(
            'permission_code' => 'notification-daily-deposit',
			'permission_name' => array(
				'Notification on Daily Deposit Add',
				''
			),
			'permission_description' => array(
				'Allow account to get notifications on new daily deposit.',
				''
			)
        ),
        // PRE OPERATIONS AUDIT PAD CHECKLIST
        array(
            'permission_code' => 'notification-pre-operations-audit-pad-checklist',
			'permission_name' => array(
				'Notification on Pre Operations Audit PAD Checklist',
				''
			),
			'permission_description' => array(
				'Allow account to get Notification on Pre Operations Audit PAD Checklist.',
				''
			)
        ),
        // PRE OPERATIONS AUDIT PAD PCV
        array(
            'permission_code' => 'notification-pre-operations-audit-pad-pcv',
			'permission_name' => array(
				'Notification on Pre Operations Audit PAD PCV',
				''
			),
			'permission_description' => array(
				'Allow account to get Notification on Pre Operations Audit PAD PCV.',
				''
			)
        ),
        // PRE OPERATIONS AUDIT TSA
        array(
            'permission_code' => 'notification-pre-operations-audit-tsa',
			'permission_name' => array(
				'Notification on Pre Operations Audit TSA',
				''
			),
			'permission_description' => array(
				'Allow account to get Notification on Pre Operations Audit TSA.',
				''
			)
        ),
        // OPERATIONS AUDIT TSA
        array(
            'permission_code' => 'notification-operations-audit-tsa',
			'permission_name' => array(
				'Notification on Operations Audit TSA',
				''
			),
			'permission_description' => array(
				'Allow account to get Notification on Operations Audit TSA.',
				''
			)
        ),
        // SERVICE REQUESTS
        array(
            'permission_code' => 'notification-service-requests',
			'permission_name' => array(
				'Notification on Service Requests',
				''
			),
			'permission_description' => array(
				'Allow account to get Notification on Service Requests.',
				''
			)
        )
    ),

    // DOCUMENT MANAGEMENT CONTRACTS ===============================================
    array(
        array(
            'permission_code' => 'doc-contracts',
			'permission_name' => array(
				'Document Management Contracts',
				''
			),
			'permission_description' => array(
				'Allow account to access document management contracts list and view contract details.',
				''
			)
        ),
        array(
            'permission_code' => 'doc-contract-add',
			'permission_name' => array(
				'ADd Document Management Contracts',
				''
			),
			'permission_description' => array(
				'Allow account to Add document management contracts.',
				''
			)
        ),
        array(
            'permission_code' => 'doc-contract-edit',
			'permission_name' => array(
				'Edit Document Management Contracts',
				''
			),
			'permission_description' => array(
				'Allow account to edit document management contracts.',
				''
			)
        )
    ),

    // CLUSTERS ====================================================================================
    array(
        array(
            'permission_code' => 'clusters',
			'permission_name' => array(
				'Clusters Management',
				''
			),
			'permission_description' => array(
				'Allow account to view list and details of clusters.',
				''
			)
        ),
        array(
            'permission_code' => 'cluster-add',
			'permission_name' => array(
				'Edit Clusters',
				''
			),
			'permission_description' => array(
				'Allow account to add cluster.',
				''
			)
        ),
        array(
            'permission_code' => 'cluster-edit',
			'permission_name' => array(
				'Edit Clusters',
				''
			),
			'permission_description' => array(
				'Allow account to edit cluster.',
				''
			)
        )
    ),
	
	// PROPERTY HANDBOOK ============================================================================
	array(
		array(
            'permission_code' => 'property-handbook',
			'permission_name' => array(
				'Property Handbook Management',
				''
			),
			'permission_description' => array(
				'Allow account to access property handbook and view property handbook details.',
				''
			)
        )
	),

    // INSPECTION > ENGINEER > General Inspection & Function Check ==========================================
	array(
        array(
            'permission_code' => 'general-inspection-and-function-check',
			'permission_name' => array(
				'General Inspection and Function Check Management',
				''
			),
			'permission_description' => array(
				'Allow account to access general inspection and function check list and view general inspection and function check details.',
				''
			)
        ),
        array(
            'permission_code' => 'general-inspection-and-function-check-add',
			'permission_name' => array(
				'Add General Inspection and Function Check',
				''
			),
			'permission_description' => array(
				'Allow account to Add general inspection and function check.',
				''
			)
        ),
        array(
            'permission_code' => 'general-inspection-and-function-check-edit',
			'permission_name' => array(
				'Edit General Inspection and Function Check',
				''
			),
			'permission_description' => array(
				'Allow account to edit general inspection and function check.',
				''
			)
        )
    ),

    // INSPECTION > ENGINEER > Proper Installation, General Inspection & Function Check ========================
	array(
        array(
            'permission_code' => 'proper-installation-general-inspection-and-function-check',
			'permission_name' => array(
				'Proper Installation, General Inspection and Function Check Management',
				''
			),
			'permission_description' => array(
				'Allow account to access proper installation, general inspection and function check list and view proper installation, general inspection and function check details.',
				''
			)
        ),
        array(
            'permission_code' => 'proper-installation-general-inspection-and-function-check-add',
			'permission_name' => array(
				'Add Proper Installation, General Inspection and Function Check',
				''
			),
			'permission_description' => array(
				'Allow account to Add proper installation general inspection and function check.',
				''
			)
        ),
        array(
            'permission_code' => 'proper-installation-general-inspection-and-function-check-edit',
			'permission_name' => array(
				'Edit Proper Installation, General Inspection and Function Check',
				''
			),
			'permission_description' => array(
				'Allow account to edit proper installation general inspection and function check.',
				''
			)
        )
    ),

    // INSPECTION > ENGINEER > Supply Voltage & Load Current Reading =================================
	array(
        array(
            'permission_code' => 'supply-voltage-and-load-current-reading',
			'permission_name' => array(
				'Supply Voltage & Load Current Reading Management',
				''
			),
			'permission_description' => array(
				'Allow account to access supply voltage and load current reading list and view supply voltage and load current reading details.',
				''
			)
        ),
        array(
            'permission_code' => 'supply-voltage-and-load-current-reading-add',
			'permission_name' => array(
				'Add Supply Voltage & Load Current Reading',
				''
			),
			'permission_description' => array(
				'Allow account to Add supply voltage and load current reading.',
				''
			)
        ),
        array(
            'permission_code' => 'supply-voltage-and-load-current-reading-edit',
			'permission_name' => array(
				'Edit Supply Voltage & Load Current Reading',
				''
			),
			'permission_description' => array(
				'Allow account to edit supply voltage and load current reading.',
				''
			)
        )
    ),

    // INSPECTION > ENGINEER > Power & Grounding Wirings =================================
	array(
        array(
            'permission_code' => 'power-and-grounding-wirings',
			'permission_name' => array(
				'Power & Grounding Wirings Management',
				''
			),
			'permission_description' => array(
				'Allow account to access power and grounding wiring list and view power and grounding wiring details.',
				''
			)
        ),
        array(
            'permission_code' => 'power-and-grounding-wiring-add',
			'permission_name' => array(
				'Add Power & Grounding Wirings',
				''
			),
			'permission_description' => array(
				'Allow account to Add power and grounding wiring.',
				''
			)
        ),
        array(
            'permission_code' => 'power-and-grounding-wiring-edit',
			'permission_name' => array(
				'Edit Power & Grounding Wirings',
				''
			),
			'permission_description' => array(
				'Allow account to edit power and grounding wiring.',
				''
			)
        )
    ),
    
    // FCU Monthly Inspections =================================
	array(
        array(
            'permission_code' => 'fcu-monthly-inspections',
			'permission_name' => array(
				'FCU Monthly Inspections Management',
				''
			),
			'permission_description' => array(
				'Allow account to access fcu monthly inspection list and view fcu monthly inspection details.',
				''
			)
        ),
        array(
            'permission_code' => 'fcu-monthly-inspection-add',
			'permission_name' => array(
				'Add FCU Monthly Inspections',
				''
			),
			'permission_description' => array(
				'Allow account to Add fcu monthly inspection.',
				''
			)
        ),
        array(
            'permission_code' => 'fcu-monthly-inspection-edit',
			'permission_name' => array(
				'Edit FCU Monthly Inspections',
				''
			),
			'permission_description' => array(
				'Allow account to edit fcu monthly inspection.',
				''
			)
        )
    ),

	// SYSTEM LOG ====================================================================================
	array(
		array(
			'permission_code' => 'system-log',
			'permission_name' => array(
				'System Log',
				'システムログ'
			),
			'permission_description' => array(
				'Allow account to access system log.',
				'アカウントにシステムログへのアクセスを許可します。'
			)
		)
	)
	
);
$permissions_count = 0;
foreach($permissions_arr as $permissions_group) {
	$permissions_count += count($permissions_group);
}
?>