<div align="center">
    
# **Ditital Pesantren (digitren)**

<img src="/public/img/Dashboard DIGITREN.png" width="500" alt="Img Dashboard" >

</div>
<p align="center">
<a href="https://github.com/AhmadMuzayyin/digitren/stargazers" target="_blank"><img src="https://img.shields.io/github/stars/AhmadMuzayyin/digitren" alt="Stars" /></a>
<a href="https://github.com/AhmadMuzayyin/digitren/network/members" target="_blank"><img src="https://img.shields.io/github/forks/AhmadMuzayyin/digitren" alt="Forks" /></a>
</p>

Adalah sebuah aplikasi berbasis website yang dibangun dengan framework [laravel](https://laravel.com) dengan versi [php](https://www.php.net/) 8.2

## Role

-   Admin
-   Keuangan
-   Pengurus
-   Santri

## Fitur Admin

-   Dashboard
-   CRUD Data Kamar
-   CRUD Data Kelas
-   CRUD Data Santri
-   CRUD Tabungan Santri
-   CRUD Transaksi Tabungan Santri
-   CRUD Pengguna
-   Read Riwayat
-   Read dan Update Sinkronisasi Data ke Google Sheets

## Fitur Keuangan

-   Dashboard
-   CRUD Tabungan Santri
-   CRUD Transaksi Tabungan Santri

# Fitur Pengurus

-   Dashboard
-   CRUD Data Kamar
-   CRUD Data Kelas
-   CRUD Data Santri
-   CRUD Tabungan Santri
-   CRUD Transaksi Tabungan Santri
-   CRUD Pengguna
-   Read Riwayat
-   Read dan Update Sinkronisasi Data ke Google Sheets

## Fitur On Going

-   Santri Dashboard
-   CRUD Nilai Raport
-   CRUD Saldo Tabungan
-   CRUD Data Mata Pelajaran
-   CRUD Data Surat
-   CRUD Surat Izin Santri
-   CRUD Transfer Saldo Tabungan
-   Digitren Versi Desktop
-   Digitren Versi Mobile

# Fitur Unggulan

-   Backup Data Santri ke [google sheets](https://youtu.be/y-sIJ30Z5CU?si=wX9O9RROgO-iZGZX)
-   Kartu Santri dengan barcode [hubungi saya](https://wa.me/6285179695497?text=Halo%20Admin%20DIGITREN%20saya%20ingin%20membuat%20kartu%20santri%20dengan%20barcode)
-   Pesan notifikasi whatsapp transaksi tabungan [hubungi saya](https://wa.me/6285179695497?text=Halo%20Admin%20DIGITREN%20saya%20ingin%20mengaktifkan%20fitur%20pesan%20notifikasi%20whatsapp)

## Instalasi

clone repositori dengan [git](https://git-scm.com/downloads)

```bash
git clone https://github.com/AhmadMuzayyin/digitren
```

install dengan [composer](https://getcomposer.org/)

```bash
# pindah ke folder
cd digitren

# install dependency
composer install
```

## Konfigurasi

```bash
# database (sesuaikan dengan database anda)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=digitren
DB_USERNAME=root
DB_PASSWORD=root

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
