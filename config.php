<?php

$config = [
	// Anfitrião da base de dados
	'host' => 'bt-db',
	'port' => 3306,

	// A sua base de dados
	'schema' => 'banner_transfer',
	'user' => 'root',
	'password' => 'root',

	// Tabela onde será feita a transferência
	'table' => 'users',

	// Colunas
	'user_column' => 'user_id',
	'source_column' => 'kl_pc_cover_crop_y',
	'destination_column' => 'banner_position_y',
	'date_column' => 'banner_date',
];