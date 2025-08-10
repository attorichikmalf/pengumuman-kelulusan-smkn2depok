<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'dashboard'; // Pastikan hanya ini yang menjadi default

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Route Login
// $route['admin'] = 'admin/auth/login';
// $route[config_item('admin_login_path')] = 'admin/auth/login';
// $route['admin/auth/logout'] = 'admin/auth/logout';
// $route['admin/auth/process_login'] = 'admin/auth/process_login';

// // Route Dashboard Admin
// $route['admin/dashboard'] = 'admin/dashboard'; // Sesuaikan dengan controller yang benar

// Ambil konfigurasi login path dari config.php
$route['admin/auth/login'] = 'errors/show_404'; // Blokir akses langsung
$route[$this->config->item('admin_login_path') . '/' . $this->config->item('admin_login_token')] = 'admin/auth/login';
$route['admin/auth/logout'] = 'admin/auth/logout';
$route['admin/auth/process_login'] = 'admin/auth/process_login';

// Route Dashboard Admin
$route['admin/dashboard'] = 'admin/dashboard'; // Sesuaikan dengan controller yang benar

// Rute CRUD Siswa
$route['admin/siswa'] = 'admin/siswa/index';
$route['admin/siswa/tambah'] = 'admin/siswa/tambah';
$route['admin/siswa/simpan'] = 'admin/siswa/simpan';
$route['admin/siswa/edit/(:num)'] = 'admin/siswa/edit/$1';
$route['admin/siswa/update/(:num)'] = 'admin/siswa/update/$1';
$route['admin/siswa/hapus/(:num)'] = 'admin/siswa/hapus/$1';
$route['admin/siswa/import'] = 'admin/siswa/import_excel';
$route['admin/siswa/proses_import'] = 'admin/siswa/proses_import';
$route['admin/siswa/delete/(:num)'] = 'admin/siswa/delete/$1';

// Rute Pengumuman Admin
$route['admin/pengumuman'] = 'admin/pengumuman/index'; // Halaman pengumuman untuk admin
$route['admin/pengumuman/update_time'] = 'admin/pengumuman/update_time'; // Update waktu countdown
$route['pengumuman/update_time'] = 'pengumuman/update_time';

// Rute Pengumuman untuk Publik
$route['pengumuman'] = 'pengumuman/index'; // Halaman pengumuman untuk publik
$route['pengumuman/update_time'] = 'pengumuman/update_time'; // Update waktu countdown untuk publik
$route['pengumuman/cek'] = 'pengumuman/cek_pengumuman';  // Mengecek kelulusan berdasarkan NISN dan tanggal lahir

//rute edit sekolah
$route['admin/sekolah'] = 'admin/sekolah/index';
$route['admin/sekolah/edit/(:num)'] = 'admin/sekolah/edit/$1';
$route['admin/sekolah/update/(:num)'] = 'admin/sekolah/update/$1';

// Route untuk Statistik Pengumuman
$route['admin/dashboard/statistik_pengumuman'] = 'admin/dashboard/statistik_pengumuman';
$route['admin/dashboard'] = 'admin/Dashboard/index';


// $route['admin/profile'] = 'admin/AdminProfile/index';
// $route['admin/profile'] = 'admin/AdminProfile';
// $route['admin/profile/update_profile'] = 'admin/AdminProfile/update_profile';
// // $route['admin/profile/change-password'] = 'admin/AdminProfile/change_password';
// $route['admin/profile/change-password'] = 'admin/AdminProfile/change_password';
// $route['admin/profile/manage_admin'] = 'admin/AdminProfile/manage_admin';
// $route['admin/profile/add_admin'] = 'admin/AdminProfile/add_admin';
// $route['admin/profile/save_admin'] = 'admin/AdminProfile/save_admin';
// $route['admin/profile/delete_admin/(:num)'] = 'admin/AdminProfile/delete_admin/$1';


$route['admin/profile'] = 'admin/AdminProfile/index';
$route['admin/profile/update_profile'] = 'admin/AdminProfile/update_profile';
$route['admin/profile/change_password'] = 'admin/AdminProfile/change_password';
$route['admin/profile/manage_admin'] = 'admin/AdminProfile/manage_admin';
$route['admin/profile/add_admin'] = 'admin/AdminProfile/add_admin';
$route['admin/profile/save_admin'] = 'admin/AdminProfile/save_admin';
$route['admin/profile/delete_admin/(:num)'] = 'admin/AdminProfile/delete_admin/$1';