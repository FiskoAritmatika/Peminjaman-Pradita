CREATE TABLE 'unit_kegiatan' (
    'id_unit' BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    'nama_unit' VARCHAR(255) NOT NULL,
    PRIMARY KEY ('id_unit')
);

CREATE TABLE 'users' (
    'id_user' BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    'nama_user' VARCHAR(255) NOT NULL,
    'password' VARCHAR(255) NOT NULL,
    'role' ENUM ('Admin', 'Organisasi', 'Mahasiswa') NOT NULL,
    'id_unit' BIGINT UNSIGNED NULL,
    PRIMARY KEY ('id_user'),
    CONSTRAINT 'users_id_unit_foreign' FOREIGN KEY ('id_unit') REFERENCES 'unit_kegiatan' ('id_unit') ON DELETE SET NULL
);

CREATE TABLE 'sessions' (
    'id' VARCHAR(255) NOT NULL PRIMARY KEY,
    'user_id' BIGINT UNSIGNED NULL,
    'ip_address' VARCHAR(45) NULL,
    'user_agent' TEXT NULL,
    'payload' LONGTEXT NOT NULL,
    'last_activity' INT NOT NULL,
    INDEX 'sessions_user_id_index' ('user_id'),
    INDEX 'sessions_last_activity_index' ('last_activity')
);

CREATE TABLE 'objek' (
    'id_objek' BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    'nama_objek' VARCHAR(255) NOT NULL,
    'jenis_objek' ENUM ('lapangan', 'barang') NOT NULL,
    'jumlah' INT NOT NULL,
    'id_user' BIGINT UNSIGNED NOT NULL,
    PRIMARY KEY ('id_objek'),
    CONSTRAINT 'objek_id_user_foreign' FOREIGN KEY ('id_user') REFERENCES 'users' ('id_user') ON DELETE CASCADE
);

CREATE TABLE 'peminjaman' (
    'id_peminjaman' BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    'id_user' BIGINT UNSIGNED NOT NULL,
    'tanggal_pengajuan' DATETIME NOT NULL,
    'kegiatan' VARCHAR(255) NOT NULL,
    PRIMARY KEY ('id_peminjaman'),
    CONSTRAINT 'peminjaman_id_user_foreign' FOREIGN KEY ('id_user') REFERENCES 'users' ('id_user') ON DELETE CASCADE
);

CREATE TABLE 'detail_peminjaman' (
    'id_detail' BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    'id_peminjaman' BIGINT UNSIGNED NOT NULL,
    'id_objek' BIGINT UNSIGNED NOT NULL,
    'jumlah_pinjam' INT NOT NULL,
    'tipe_pinjam' ENUM ('per_jam', 'per_hari') NOT NULL,
    'tanggal_mulai' DATE NOT NULL,
    'tanggal_selesai' DATE NOT NULL,
    'jam_mulai' TIME NULL,
    'jam_selesai' TIME NULL,
    'status' ENUM ('pending', 'approved', 'rejected', 'returned') NOT NULL DEFAULT 'pending',
    'created_at' TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    'updated_at' TIMESTAMP NULL,
    PRIMARY KEY ('id_detail'),
    CONSTRAINT 'detail_peminjaman_id_peminjaman_foreign' FOREIGN KEY ('id_peminjaman') REFERENCES 'peminjaman' ('id_peminjaman') ON DELETE CASCADE,
    CONSTRAINT 'detail_peminjaman_id_objek_foreign' FOREIGN KEY ('id_objek') REFERENCES 'objek' ('id_objek') ON DELETE CASCADE
);