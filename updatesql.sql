ALTER TABLE `m_bs` ADD `terima_by` INT NOT NULL AFTER `tgl_terima_prov`;
ALTER TABLE `m_bs` ADD `kirim_ipds` INT NOT NULL AFTER `terima_by`;