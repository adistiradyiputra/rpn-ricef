<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Login::index');
$routes->post('auth', 'Login::auth');
$routes->get('logout', 'Login::logout');

$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('user', 'UserController::index');
    $routes->get('user/getUsers', 'UserController::getUsers');
    $routes->post('user/saveUser', 'UserController::saveUser');
    $routes->post('user/updateUser/(:num)', 'UserController::updateUser/$1');
    $routes->get('user/deleteUser/(:num)', 'UserController::deleteUser/$1');

    $routes->get('pelatihan', 'PelatihanController::index');
    $routes->get('pelatihan/getPelatihan', 'PelatihanController::getPelatihan');
    $routes->post('pelatihan/savePelatihan', 'PelatihanController::savePelatihan');
    $routes->post('pelatihan/updatePelatihan/(:num)', 'PelatihanController::updatePelatihan/$1');
    $routes->get('pelatihan/deletePelatihan/(:num)', 'PelatihanController::deletePelatihan/$1');
    
    $routes->get('detailPelatihan', 'DetailPelatihanController::index');
    $routes->post('detailPelatihan/saveDetailPelatihan', 'DetailPelatihanController::saveDetailPelatihan');
    $routes->post('detailPelatihan/delete/(:num)', 'DetailPelatihanController::delete/$1');
    $routes->post('detailPelatihan/update', 'DetailPelatihanController::update');
    $routes->get('detailPelatihan/getDetail/(:num)', 'DetailPelatihanController::getDetail/$1');

    // Dokumen routes
    $routes->get('detailPelatihan/getDokumen/(:num)', 'DetailPelatihanController::getDokumen/$1');
    $routes->post('detailPelatihan/saveDokumen', 'DetailPelatihanController::saveDokumen');
    $routes->post('detailPelatihan/updateDokumen/(:num)', 'DetailPelatihanController::updateDokumen/$1');
    $routes->post('detailPelatihan/deleteDokumen/(:num)', 'DetailPelatihanController::deleteDokumen/$1');

    // Peserta routes
    $routes->get('detailPelatihan/getPeserta/(:num)', 'DetailPelatihanController::getPeserta/$1');
    $routes->post('detailPelatihan/savePeserta', 'DetailPelatihanController::savePeserta');
    $routes->post('detailPelatihan/updatePeserta/(:num)', 'DetailPelatihanController::updatePeserta/$1');
    $routes->post('detailPelatihan/deletePeserta/(:num)', 'DetailPelatihanController::deletePeserta/$1');

    // Peserta Count routes
    $routes->get('detailPelatihan/getPesertaCount/(:num)', 'DetailPelatihanController::getPesertaCount/$1');

    // New route for getting pelatihan details by ID
    $routes->get('pelatihan/getPelatihanById/(:num)', 'PelatihanController::getPelatihanById/$1');

    // Add these routes inside your auth group
    $routes->post('detailPelatihan/deleteAllPeserta/(:num)', 'DetailPelatihanController::deleteAllPeserta/$1');
    $routes->post('detailPelatihan/deleteAllDokumen/(:num)', 'DetailPelatihanController::deleteAllDokumen/$1');

    // Peserta routes
    $routes->get('peserta', 'PesertaController::index');
    $routes->get('peserta/getPesertaData', 'PesertaController::getPesertaData');
    $routes->get('peserta/getPesertaById/(:num)', 'PesertaController::getPesertaById/$1');
    $routes->post('peserta/update/(:num)', 'PesertaController::update/$1');
    $routes->post('peserta/delete/(:num)', 'PesertaController::delete/$1');
    $routes->get('peserta/exportExcel', 'PesertaController::exportExcel');
    $routes->get('peserta/exportExcel/(:num)', 'PesertaController::exportExcel/$1');

    // Instruktur routes
    $routes->get('instruktur', 'InstrukturController::index');
    $routes->get('instruktur/getInstrukturData', 'InstrukturController::getInstrukturData');
    $routes->get('instruktur/getInstrukturById/(:num)', 'InstrukturController::getInstrukturById/$1');
    $routes->post('instruktur/save', 'InstrukturController::save');
    $routes->post('instruktur/update/(:num)', 'InstrukturController::update/$1');
    $routes->post('instruktur/delete/(:num)', 'InstrukturController::delete/$1');
    $routes->get('instruktur/getInstrukturOptions', 'InstrukturController::getInstrukturOptions');

    // Bank Soal (combined with Set Soal)
    $routes->get('banksoal', 'BankSoalController::index');
    $routes->get('banksoal/create', 'BankSoalController::create');
    $routes->get('banksoal/edit/(:num)', 'BankSoalController::edit/$1');
    $routes->get('banksoal/edit_set/(:num)', 'BankSoalController::edit_set/$1');
    $routes->post('banksoal/save', 'BankSoalController::save');
    $routes->post('banksoal/save_combined', 'BankSoalController::save_combined');
    $routes->post('banksoal/update/(:num)', 'BankSoalController::update/$1');
    $routes->post('banksoal/update_set/(:num)', 'BankSoalController::update_set/$1');
    $routes->post('banksoal/delete/(:num)', 'BankSoalController::delete/$1');
    $routes->post('banksoal/delete_set/(:num)', 'BankSoalController::delete_set/$1');
    $routes->get('banksoal/getSoal/(:num)', 'BankSoalController::getSoal/$1');
    $routes->get('banksoal/getSoal', 'BankSoalController::getSoal');
    $routes->get('banksoal/getSoalByKategori/(:num)', 'BankSoalController::getSoalByKategori/$1');
    $routes->get('banksoal/getSoalByKategori', 'BankSoalController::getSoalByKategori');

    // Test (untuk peserta)
    $routes->get('test', 'TestController::index');
    $routes->get('test/mulai/(:num)', 'TestController::mulaiTest/$1');
    $routes->post('test/simpanJawaban', 'TestController::simpanJawaban');
    $routes->post('test/selesai', 'TestController::selesaiTest');

    // Verifikasi Nilai
    $routes->get('verifikasi', 'VerifikasiNilaiController::index');
    $routes->get('verifikasi/detail/(:num)', 'VerifikasiNilaiController::detail/$1');
    $routes->post('verifikasi/verifikasi/(:num)', 'VerifikasiNilaiController::verifikasi/$1');
});