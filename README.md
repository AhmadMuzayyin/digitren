<div align="center">
    
# **Ditital Pesantren (digitren)**

<img src="/public/img/Dashboard DIGITREN.png" width="500" alt="Img Dashboard" >

</div>
<p align="center">
<a href="https://github.com/AhmadMuzayyin/digitren/stargazers" target="_blank"><img src="https://img.shields.io/github/stars/AhmadMuzayyin/digitren" alt="Stars" /></a>
<a href="https://github.com/AhmadMuzayyin/digitren/network/members" target="_blank"><img src="https://img.shields.io/github/forks/AhmadMuzayyin/digitren" alt="Forks" /></a>
</p>
Adalah sebuah aplikasi berbasis website yang dibangun dengan framework [laravel](https://laravel.com) dengan versi [php](https://www.php.net/) 8.1
## Role
- Admin
- Keuangan
- Pengurus
- Santri

## Fitur Admin
- Dashboard
- CRUD Data Kamar
- CRUD Data Kelas
- CRUD Data Santri
- CRUD Data Mata Pelajaran
- CRUD Data Surat
- CRUD Surat Izin Santri
- CRUD Tabungan Santri
- CRUD Transaksi Tabungan Santri
- CRUD Pengguna
- Read Riwayat
- Read dan Update Sinkronisasi Data ke Google Sheets

## Fitur Keuangan
- Dashboard
- CRUD Tabungan Santri
- CRUD Transaksi Tabungan Santri

# Fitur Pengurus
- Dashboard
- CRUD Data Kamar
- CRUD Data Kelas
- CRUD Data Santri
- CRUD Data Mata Pelajaran
- CRUD Data Surat
- CRUD Surat Izin Santri
- CRUD Tabungan Santri
- CRUD Transaksi Tabungan Santri
- CRUD Pengguna
- Read Riwayat
- Read dan Update Sinkronisasi Data ke Google Sheets

## Fitur Santri (on going)
- Dashboard
- Read Nilai Raport
- Read Saldo Tabungan

# Fitur Lain
- Backup Data Santri ke google sheets
- Kartu Santri dengan barcode

## Instalasi

clone repositori dengan [git](https://git-scm.com/downloads)

```bash
git clone https://github.com/AhmadMuzayyin/digitren
```

install dengan [composer](https://getcomposer.org/) untuk menginstall aplikasi.

```bash
# pindah ke folder
cd digitren

# install dependency
composer install
```
## Konfigurasi

```bash
# google sheets authorization (config/google.php)
'file' => public_path('files/sheets/file.json')

# google authorization (.env)
 GOOGLE_CLIENT_ID=
 GOOGLE_SERVICE_ENABLED=true
 SPREDSHEET_ID=
```

## Contributing
Pull requests dipersilakan. Untuk perubahan besar, harap buka issues terlebih dahulu untuk mendiskusikan apa yang ingin Anda ubah.

Harap pastikan untuk memperbarui unit test sebagaimana mestinya.

## License

[MIT](https://github.com/AhmadMuzayyin/digitren/blob/main/LICENSE)
