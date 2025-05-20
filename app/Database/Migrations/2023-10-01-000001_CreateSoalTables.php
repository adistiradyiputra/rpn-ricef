<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSoalTables extends Migration
{
    public function up()
    {
        // Tabel untuk kategori soal
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nama_kategori' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('kategori_soal');

        // Tabel untuk bank soal
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_kategori' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'pertanyaan' => [
                'type' => 'TEXT',
            ],
            'jenis_soal' => [
                'type' => 'ENUM',
                'constraint' => ['pilihan_ganda', 'benar_salah', 'isian'],
                'default' => 'pilihan_ganda',
            ],
            'tingkat_kesulitan' => [
                'type' => 'ENUM',
                'constraint' => ['mudah', 'sedang', 'sulit'],
                'default' => 'sedang',
            ],
            'aktif' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'updated_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_kategori', 'kategori_soal', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('bank_soal');

        // Tabel untuk pilihan jawaban
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_soal' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'teks_pilihan' => [
                'type' => 'TEXT',
            ],
            'is_benar' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
            ],
            'urutan' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_soal', 'bank_soal', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pilihan_jawaban');

        // Tabel untuk set soal
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nama_set' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'jenis' => [
                'type' => 'ENUM',
                'constraint' => ['pretest', 'posttest'],
                'default' => 'pretest',
            ],
            'id_detail_pelatihan' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'waktu_pengerjaan' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 60,
            ],
            'nilai_lulus' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 70,
            ],
            'aktif' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'updated_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_detail_pelatihan', 'detail_pelatihan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('set_soal');

        // Tabel untuk relasi set soal dengan bank soal
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_set_soal' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'id_soal' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'bobot' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 1,
            ],
            'urutan' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_set_soal', 'set_soal', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_soal', 'bank_soal', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('set_soal_items');

        // Tabel untuk jawaban peserta
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_peserta' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'id_set_soal' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'id_soal' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'id_pilihan_jawaban' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'jawaban_text' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'is_benar' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
            ],
            'nilai_soal' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'default' => 0,
            ],
            'waktu_mulai' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'waktu_selesai' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_peserta', 'peserta', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_set_soal', 'set_soal', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_soal', 'bank_soal', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_pilihan_jawaban', 'pilihan_jawaban', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('jawaban_peserta');

        // Tabel untuk hasil test peserta
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_peserta' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'id_set_soal' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'nilai_mentah' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'default' => 0,
            ],
            'nilai_akhir' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'default' => 0,
            ],
            'status_lulus' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
            ],
            'status_verifikasi' => [
                'type' => 'ENUM',
                'constraint' => ['belum', 'proses', 'terverifikasi'],
                'default' => 'belum',
            ],
            'catatan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'waktu_mulai' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'waktu_selesai' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'diverifikasi_oleh' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'waktu_verifikasi' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_peserta', 'peserta', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_set_soal', 'set_soal', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('diverifikasi_oleh', 'users', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('hasil_test');
    }

    public function down()
    {
        $this->forge->dropTable('hasil_test');
        $this->forge->dropTable('jawaban_peserta');
        $this->forge->dropTable('set_soal_items');
        $this->forge->dropTable('set_soal');
        $this->forge->dropTable('pilihan_jawaban');
        $this->forge->dropTable('bank_soal');
        $this->forge->dropTable('kategori_soal');
    }
} 