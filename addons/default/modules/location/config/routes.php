<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

$route['location/admin/provinsi(:any)'] = 'admin_provinsi$1';
$route['location/admin/kota(:any)'] = 'admin_kota$1';
$route['location/admin/kecamatan(:any)'] = 'admin_kecamatan$1';
$route['location/admin/kelurahan(:any)'] = 'admin_kelurahan$1';
$route['location/provinsi(:any)'] = 'location_provinsi$1';
$route['location/kota(:any)'] = 'location_kota$1';
$route['location/kecamatan(:any)'] = 'location_kecamatan$1';
$route['location/kelurahan(:any)'] = 'location_kelurahan$1';
