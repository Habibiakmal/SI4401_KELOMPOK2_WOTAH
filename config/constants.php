<?php 

define("ERR_INVALID_TOKEN", '40001');
define("ERR_INVALID_PARAM", '40002');
define('ERR_INVALID_REQUEST', '40003');
define('ERR_NO_DATA_FOUND', '40004');
define('ERR_GENERAL', '50001');
define('ERR_INTERNAL', '50002');
define('SUCCESS_REQUEST', '0000');

define('BLOOD_TYPE', ['Tidak Tahu','A+', 'A-', 'AB+', 'AB-', 'B+', 'B-', 'O+', 'O-', 'Rh-null']);
define('FAMILY_RELATION', ['Suami', 'Ayah', 'Ibu', 'Saudara', 'Anak']);
define('MPASI', ["ASI", "Susu Formula", "ASI + Susu Formula", "Lainnya"]);
define('OBSTETRI_HISTORY', ["Belum Ada", "Normal", "Operasi / Sesar", "Abortus"]);
define('MARRIED_STATUS', ['Belum Menikah', 'Sudah Menikah', 'Janda']);
define('GROWTH', [
	"normal" => "Normal",
	"need_attention" => "Butuh Perhatian"
]);

define('APP_MENU', [
	[
		"name" => "dashboard",
		"label" => "Dashboard",
		"icon" => "bx bx-buildings",
		"link"	=> "/dashboard",
		"access" => true,
		"has_child" => false,
	],
	[
		"name" => "clinic",
		"label" => "Klinik",
		"icon" => "bx bx-buildings",
		"link"	=> "/master_data/clinic",
		"access" => true,
		"has_child" => false,
	],
	[
		"name" => "officer",
		"label" => "Petugas",
		"icon" => "bx bx-buildings",
		"link"	=> "/master_data/officer",
		"access" => true,
		"has_child" => false,
	],
	[
		"name" => "patient",
		"label" => "Pasien",
		"icon" => "bx bx-buildings",
		"link"	=> "/master_data/patient",
		"access" => true,
		"has_child" => false,
	],
	[
		"name" => "children",
		"label" => "Anak / Balita",
		"icon" => "bx bx-buildings",
		"link"	=> "/master_data/child",
		"access" => true,
		"has_child" => false,
	]
])

/*define('APP_MENU', [
	[
		"name" => "dashboard",
		"label" => "Dashboard",
		"icon" => "bx bx-buildings",
		"link"	=> "/dashboard",
		"access" => true,
		"has_child" => false,
	],
	[
		"name" => "master_data",
		"label" => "Master Data",
		"icon" => "bx bx-buildings",
		"link" => "",
		"access" => true,
		"has_child" => true,
		"child" => [
			[
				"name" => "clinic",
				"label" => "Klinik",
				"icon" => "bx bx-buildings",
				"link" => "/master_data/clinic",
				"access" => true
			],
			[
				"name" => "officer",
				"label" => "Petugas",
				"icon" => "bx bx-buildings",
				"link" => "/master_data/officer",
				"access" => true
			],
			[
				"name" => "patient",
				"label" => "Pasien",
				"icon" => "bx bx-buildings",
				"link" => "/master_data/patient",
				"access" => true
			],
			[
				"name" => "children",
				"label" => "Anak / Balita",
				"icon" => "bx bx-buildings",
				"link" => "/master_data/child",
				"access" => true
			]
		]
	],
	[
		"name" => "setting",
		"label" => "Setting",
		"icon" => "bx bx-buildings",
		"link" => "",
		"access" => true,
		"has_child" => true,
		"child" => [
			[
				"name" => "role",
				"label" => "Role",
				"icon" => "bx bx-buildings",
				"link" => "/setting/role",
				"access" => true
			],
			[
				"name" => "application",
				"label" => "Aplikasi",
				"icon" => "bx bx-buildings",
				"link" => "/setting/application",
				"access" => true
			]
		]
	]
])*/;

define('COMPONENTS', [
	'master_data' => [
		'clinic' => [
			'view' 		=> true,
			'add' 		=> true,
			'edit' 		=> true,
			'delete' 	=> true,
			'detail' 	=> true,
			'export-import' => [
				'export' => true,
				'import' => true
			]
		],
		'patient' => [
			'view'		=> true,
			'add'		=> true,
			'edit'		=> true,
			'delete'	=> true,
			'detail'	=> true,
			'export-import' => [
				'export' => true,
				'import' => true
			]
		],
		'bride-consultation' => [
			'view' => true,
			'add' => true,
			'edit' => true,
			'delete' => true
		],
		'children' => [
			'view'	=> true,
			'add'	=> true,
			'edit'	=> true,
			'delete' => true,
			'detail' => true,
			'export-import' => [
				'export' => true,
				'import' => true
			]
		],
		'officer' => [
			'view'	=> true,
			'add'	=> true,
			'edit'	=> true,
			'delete' => true,
			'detail' => true,
			'export-import' => [
				'export' => true,
				'import' => true
			]
		]
	],
	'transactional' => [
		'pregnancy'	=> [
			'view' => true,
			'checkup' => [
				'view' => true,
				'add'  => true,
				'edit' => true,
				'delete' => true 
			],
			'add' => true,
			'edit' => true,
			'delete' => true
		],
		'medic' => [
			'children' => [
				'view' => true,
				'add' => true,
				'edit' => true,
				'delete' => true 
			],
			'patient' => [
				'view' => true,
				'add' => true,
				'edit' => true,
				'delete' => true
			],
			'pregnancy' => [
				'view' => true,
				'add' => true,
				'edit' => true,
				'delete' => true
			]
		]
	],
	'setting' => [
		'role' => [
			'view' => true,
			'add' => true,
			'edit' => true,
			'delete' => true
		],
		'application' => [
			'view' => true,
			'add' => true
		]
	]
]);


define('FORM_ROLE', [
	[
		"name" => 'master_data',
		"label" => 'Master Data',
		"service" => [
			[
				"name" => "clinic",
				"label" => "Klinik",
				"access" => [
					[
						"name" => "view",
						"label" => "Lihat",
						"status" => true
					],
					[
						"name" => "add",
						"label" => "Tambah",
						"status" => true
					],
					[
						"name" => "update",
						"label" => "Ubah",
						"status" => true
					],
					[
						"name" => "delete",
						"label" => "Hapus",
						"status" => true
					],
					[
						"name" => "export",
						"label" => "Export",
						"status" => true
					],
					[
						"name" => "import",
						"label" => "Import",
						"status" => true
					]
				]
			],
			[
				"name" => "officer",
				"label" => "Petugas",
				"access" => [
					[
						"name" => "view",
						"label" => "Lihat",
						"status" => true
					],
					[
						"name" => "add",
						"label" => "Tambah",
						"status" => true
					],
					[
						"name" => "update",
						"label" => "Ubah",
						"status" => true
					],
					[
						"name" => "delete",
						"label" => "Hapus",
						"status" => true
					],
					[
						"name" => "export",
						"label" => "Export",
						"status" => true
					],
					[
						"name" => "import",
						"label" => "Import",
						"status" => true
					]
				]
			],
			[
				"name" => "patient",
				"label" => "Pasien",
				"access" => [
					[
						"name" => "view",
						"label" => "Lihat",
						"status" => true
					],
					[
						"name" => "add",
						"label" => "Tambah",
						"status" => true
					],
					[
						"name" => "update",
						"label" => "Ubah",
						"status" => true
					],
					[
						"name" => "delete",
						"label" => "Hapus",
						"status" => true
					],
					[
						"name" => "export",
						"label" => "Export",
						"status" => true
					],
					[
						"name" => "import",
						"label" => "Import",
						"status" => true
					]
				]
			],
			[
				"name" => "children",
				"label" => "Anak / Balita",
				"access" => [
					[
						"name" => "view",
						"label" => "Lihat",
						"status" => true
					],
					[
						"name" => "add",
						"label" => "Tambah",
						"status" => true
					],
					[
						"name" => "update",
						"label" => "Ubah",
						"status" => true
					],
					[
						"name" => "delete",
						"label" => "Hapus",
						"status" => true
					],
					[
						"name" => "export",
						"label" => "Export",
						"status" => true
					],
					[
						"name" => "import",
						"label" => "Import",
						"status" => true
					]
				]
			],
		]
	],
	[
		"name" => 'transactional',
		"label" => 'Monitoring',
		"service" => [
			[
				"name" => 'pregnancy_health',
				"label" => "Kesehatan Kandungan",
				"access" => [
					[
						"name" => "view",
						"label" => "Lihat",
						"status" => true
					],
					[
						"name" => "add",
						"label" => "Tambah",
						"status" => true
					],
					[
						"name" => "update",
						"label" => "Ubah",
						"status" => true
					],
					[
						"name" => "delete",
						"label" => "Hapus",
						"status" => true
					]
				]
			],
			[
				"name" => 'children_health',
				"label" => "Kesehatan Balita",
				"access" => [
					[
						"name" => "view",
						"label" => "Lihat",
						"status" => true
					],
					[
						"name" => "add",
						"label" => "Tambah",
						"status" => true
					],
					[
						"name" => "update",
						"label" => "Ubah",
						"status" => true
					],
					[
						"name" => "delete",
						"label" => "Hapus",
						"status" => true
					]
				]
			],
			[
				"name" => 'youth_health',
				"label" => "Kesehatan Remaja / Wanita",
				"access" => [
					[
						"name" => "view",
						"label" => "Lihat",
						"status" => true
					],
					[
						"name" => "add",
						"label" => "Tambah",
						"status" => true
					],
					[
						"name" => "update",
						"label" => "Ubah",
						"status" => true
					],
					[
						"name" => "delete",
						"label" => "Hapus",
						"status" => true
					]
				]
			],
			[
				"name" => 'catin',
				"label" => "Konsultasi Calon Pengantin",
				"access" => [
					[
						"name" => "view",
						"label" => "Lihat",
						"status" => true
					],
					[
						"name" => "add",
						"label" => "Tambah",
						"status" => true
					],
					[
						"name" => "update",
						"label" => "Ubah",
						"status" => true
					],
					[
						"name" => "delete",
						"label" => "Hapus",
						"status" => true
					]
				]
			]
		]
	],
	[
		"name" => 'report',
		"label" => 'Laporan',
		"service" => [
			[
				"name" => 'pregnancy_health',
				"label" => "Kesehatan Wanita",
				"access" => [
					[
						"name" => "view",
						"label" => "Lihat",
						"status" => true
					],
					[
						"name" => "export",
						"label" => "Export",
						"status" => true
					],
					[
						"name" => "import",
						"label" => "Import",
						"status" => true
					]
				]
			],
			[
				"name" => 'children_health',
				"label" => "Kesehatan Balita",
				"access" => [
					[
						"name" => "view",
						"label" => "Lihat",
						"status" => true
					],
					[
						"name" => "export",
						"label" => "Export",
						"status" => true
					],
					[
						"name" => "import",
						"label" => "Import",
						"status" => true
					]
				]
			]
		]
	]
]);

?>