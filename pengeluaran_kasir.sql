
CREATE TABLE `pengeluaran_kasir` (
  `id_pengeluaran` int(11) NOT NULL,
  `kasir_id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `pengeluaran` varchar(100) NOT NULL,
  `nominal` int(11) NOT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `pengeluaran_kasir`
  ADD PRIMARY KEY (`id_pengeluaran`);

