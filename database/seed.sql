INSERT INTO 'unit_kegiatan' ('nama_unit') VALUES
    ('UKM Basket'),
    ('UKM Voli'),
    ('UKM Futsal'),
    ('BEM'),
    ('HIMTIKA'),
    ('HIMSI'),
    ('NextSoft'),
    ('UKM Chess'),
    ('UKM Music'),
    ('UKM Art');

INSERT INTO 'users' ('nama_user', 'password', 'role', 'id_unit') VALUES
    ('Admin BM',          '$2y$10$V1U/8fZc7PXv5JtLCeppnu8TlEMtY8YU/HU7sV4nUxl9lk7pUQv4W', 'Admin',       NULL),
    ('Budi Basket',       '$2y$10$XkwBObFtFJZxEIj9ZxJV6uK3oa7T1VbSiFXpZUXNYo1.cJXO9hXyS',  'Organisasi', 1),
    ('Sari Voli',         '$2y$10$XkwBObFtFJZxEIj9ZxJV6uK3oa7T1VbSiFXpZUXNYo1.cJXO9hXyS',  'Organisasi', 2),
    ('Rudi Futsal',       '$2y$10$XkwBObFtFJZxEIj9ZxJV6uK3oa7T1VbSiFXpZUXNYo1.cJXO9hXyS',  'Organisasi', 3),
    ('Budi BEM',          '$2y$10$XkwBObFtFJZxEIj9ZxJV6uK3oa7T1VbSiFXpZUXNYo1.cJXO9hXyS',  'Organisasi', 4),
    ('Citra HIMTIKA',    '$2y$10$XkwBObFtFJZxEIj9ZxJV6uK3oa7T1VbSiFXpZUXNYo1.cJXO9hXyS',  'Organisasi', 5),
    ('Dedi HIMSI',        '$2y$10$XkwBObFtFJZxEIj9ZxJV6uK3oa7T1VbSiFXpZUXNYo1.cJXO9hXyS',  'Organisasi', 6),
    ('Eka NextSoft',      '$2y$10$XkwBObFtFJZxEIj9ZxJV6uK3oa7T1VbSiFXpZUXNYo1.cJXO9hXyS',  'Organisasi', 7),
    ('Andi Wijaya',       '$2y$10$K1JZbL9gPjwR0UfLmXw1.e3M5E4B6G7V9eJ0YzCqB2jU1kDm2hU3W',   'Mahasiswa',   NULL),
    ('Siti Mahasiswa',    '$2y$10$K1JZbL9gPjwR0UfLmXw1.e3M5E4B6G7V9eJ0YzCqB2jU1kDm2hU3W',   'Mahasiswa',   NULL);

INSERT INTO 'objek' ('nama_objek', 'jenis_objek', 'jumlah', 'id_user') VALUES
    ('Lapangan Utama',   'lapangan', 1, 1),
    ('Bola Basket',      'barang',   5, 2),
    ('Cone',             'barang',  10, 2),
    ('Bola Voli',        'barang',   5, 3),
    ('Net Voli',         'barang',   2, 3),
    ('Bola Futsal',      'barang',   5, 4),
    ('Raket Badminton', 'barang',   8, 5),
    ('Meja Pingpong',    'barang',   4, 6),
    ('Kursi',            'barang',  12, 7),
    ('Meja',             'barang',   6, 8);

INSERT INTO 'peminjaman' ('id_user', 'tanggal_pengajuan', 'kegiatan') VALUES
    (9, '2026-05-01 09:00:00', 'Turnamen Basket'),
    (10, '2026-05-02 10:30:00', 'Latihan Voli'),
    (9, '2026-05-03 14:00:00', 'Workshop Futsal'),
    (10, '2026-05-04 08:15:00', 'Kegiatan HIMTIKA'),
    (9, '2026-05-05 13:45:00', 'Seminar HIMSI'),
    (10, '2026-05-06 11:00:00', 'Pelatihan NextSoft'),
    (9, '2026-05-07 15:30:00', 'Komunitas Chess Tournament'),
    (10, '2026-05-08 09:20:00', 'Acara Musik UKM'),
    (9, '2026-05-09 10:00:00', 'Pameran Seni UKM'),
    (10, '2026-05-10 12:00:00', 'Rapat Organisasi');

INSERT INTO 'detail_peminjaman'
    ('id_peminjaman','id_objek','jumlah_pinjam','tipe_pinjam','tanggal_mulai','tanggal_selesai','jam_mulai','jam_selesai','status')
VALUES
    (1,2,2,'per_hari','2026-05-01','2026-05-03',NULL,NULL,'approved'),
    (2,3,1,'per_hari','2026-05-02','2026-05-03',NULL,NULL,'approved'),
    (3,4,1,'per_hari','2026-05-03','2026-05-06',NULL,NULL,'approved'),
    (4,5,1,'per_hari','2026-05-04','2026-05-06',NULL,NULL,'approved'),
    (5,6,2,'per_hari','2026-05-05','2026-05-09',NULL,NULL,'approved'),
    (6,7,1,'per_jam','2026-05-06','2026-05-06','09:00:00','11:00:00','approved'),
    (7,8,1,'per_jam','2026-05-07','2026-05-07','14:00:00','16:00:00','approved'),
    (8,9,2,'per_jam','2026-05-08','2026-05-08','10:00:00','12:00:00','approved'),
    (9,10,1,'per_jam','2026-05-09','2026-05-09','13:30:00','14:30:00','approved'),
    (10,1,1,'per_jam','2026-05-10','2026-05-10','08:00:00','09:30:00','approved');
