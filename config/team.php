<?php
// Sumber tunggal data tim — dipakai di home (banner) & about (halaman tim)
// Ubah di sini saja, semua tempat otomatis sinkron.
return [
    'directors' => [
        [
            'cn' => '易衍',
            'py' => 'YI YAN',
            'photo' => 'yiyan.png',
            'role_cn' => '董事长',
            'role_id' => 'Chairman',
            'role_en' => 'Chairman',
        ],
        [
            'cn' => '刘裕洁',
            'py' => 'Amber',
            'photo' => 'amber.png',
            'role_cn' => '总监',
            'role_id' => 'Director',
            'role_en' => 'Director',
        ],
    ],
    'team' => [
        ['cn'=>'玉雪慧', 'py'=>'Xiao Yu', 'photo'=>'xiaoyu.png', 'role_cn'=>'总经理', 'role_id'=>'General Manager', 'role_en'=>'General Manager', 'color'=>'#1a2a4f'],
        ['cn'=>'潘炫颖', 'py'=>'Novi',    'photo'=>'novi.png',   'role_cn'=>'培训总监', 'role_id'=>'Training Director',      'role_en'=>'Training Director',      'color'=>'#b03a3a'],
        ['cn'=>'洪莉莎', 'py'=>'Elissa', 'photo'=>'elissa.png', 'role_cn'=>'教研主管', 'role_id'=>'Curriculum Supervisor',  'role_en'=>'Curriculum Supervisor',  'color'=>'#2d6a4f'],
        ['cn'=>'李美慧', 'py'=>'Susanty','photo'=>'susanty.png','role_cn'=>'教务主管', 'role_id'=>'Academic Supervisor',    'role_en'=>'Academic Supervisor',    'color'=>'#7a5200'],
        ['cn'=>'吴丽娜', 'py'=>'Rina',   'photo'=>'rina.png',   'role_cn'=>'教学主管', 'role_id'=>'Teaching Supervisor',    'role_en'=>'Teaching Supervisor',    'color'=>'#2d4a7a'],
    ],
    // Banner beranda tampilkan berapa orang (diambil dari awal array team)
    'home_limit' => 4,
];
