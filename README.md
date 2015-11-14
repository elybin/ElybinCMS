Elybin CMS (www.elybin.com) - Open Source Content Management System
@copyright => Copyright (C) 2015 Elybin Team, All rights reserved.
@license   => GNU General Public License version 2 or later; see LICENSE.txt
@author    => Khakim A <kim@elybin.com>

ELYBIN CMS - http://docs.elybin.com/about.html
=========================================
Elybin CMS adalah sebuah sistem menejemen konten (Content Management System) multi fungsi gratis yang bisa diinstall berbagai plugin dan tema tambahan. Sehingga bisa disesuaikan sesuai dengan kebutuhan anda.

CMS ini didesain agar bisa diubah menjadi bermacam macam aplikasi, mulai dari website hingga aplikasi internal tanpa harus melakukan pengkodean (coding). Serta aplikasi ini di desain untuk memudahkan dalam penggunaan. Sehingga aplikasi ini cocok untuk membuat website personal, bisnis ataupun komunitas.

PANDUAN INSTALASI SINGKAT - http://docs.elybin.com/installation.html
=========================================
1. Pastikan anda sudah mendownload Elybin CMS yang memiliki ekstensi akhir (.zip). Ekstrak file tersebut ke hosting atau local server anda.

2. Buat basis data (database) untuk menyimpan data-data anda nantinya.

3. Buka alamat installasi Elybin CMS melalui browser anda. Contoh pada hosting: http://namawebsiteanda.com/
Setelah membuka alamat, anda akan diarahkan ke tampilan installasi.

4. Pada halaman installasi (Konfigurasi Basis data), masukan Host Database, User Database, Sandi Database dan Nama Database pada kolom yang tepat.

5. Jika tahap pertama berhasil maka akan muncul tahap ke-2 (Informasi Situs). Masukan informasi situs anda.

6. Sampai pada tahap ke-3. Buat akun Administrator anda dengan mengisikan data - data.

7. Selesai, Klik untuk masuk ke halaman Administrator.

**Jangan lupa untuk menghapus folder installasi setelah berhasil.**
**Untuk panduan instalasi lengkap beserta video bisa dilihat pada situs kami.**
http://docs.elybin.com/installation.html



CHANGE LOG (PERUBAHAAN) - http://docs.elybin.com/changelog.html
=========================================
Version 1.1.4 (Beta) - 15 November 2015
----------------------
What's New?
- Theme Engine (Beta), now you can create your own themes with Wordpress like function
- Plugin Ready (Beta), create your awesome and powerfull application
- Upgradeable (Beta), if you had older version, you can upgrade without losing old data
- Customized Permalink Style (Beta), customize your website URL easily directly from option menu
- Dynamic Link & Menu (Beta), this features will automatically changing URL depend current option
- Twitter Card & Facebook Plugin (Beta), showing detail information when sharing on
  social media & improving search result
Fixing...
- Simplifying Installer (Removing htaccess while install, Patching 1.1.3 bug, Fixing typo)
- Moving `elybin_album` to `elybin_posts`
- Fixing Themes Management
- Fixing Plugin Management
- Fixing RSS & Atom feed
- Fixing Gallery & Album Management
- Fixing front-end widget
- Preformance Improvement

Version 1.1.3-dev (Developer Preview) - 1 July 2015
----------------------
- Penghapusan beberapa table, dan menggabung menjadi satu
- Penambahan fitur messages, statistic, album, feedback
- Peningkatan performa SQL
- Perbaikan install Theme
- Perbaikan install plguin
- Redesign Login & Installer
- Cut down beberapa sctipt
- Perbaikan bug XSS pada halaman dashboard
- Peningkatan Keamanan dengan memakai password hasher
- Penambahan fitur E-mail SMTP (Beta)
- Penambahan fitur "Daily Mail Limit"
- Perbaikan Login dan Blocking
- Perbaikan Bug Spam pada komentar & Contact
- Merubah Contact menjadi Messages
- Perbaikan module Post (Tidak bisa mengubah tulisan)
- Penambahan fitur share media
- Perbaikan Notifikasi
- Perbaikan script elybin-function.php
- Perbaikan fitur upgrade

Versi 1.1.0 (Gasing) - 5 Januari 2015
-----------------------
- Peningkatan performa muat halaman dengan mengoptimalkan CDN
- Kompresi halaman & aset, hingga 80%
- Perbaikan bug blocking content
- Perbaikan pada fitur instalasi
- Pembaharuan modul & plugin javascript
- Perbaikan "failed to decode json" pada panel notifikasi
- Perbaikan preview tema
- tampilan baru dan penambahan footer untuk tema "young-free"

Versi 1.0.12 (Beta) - 24 November 2015
-----------------------
- Perbaikan pada "Site Url" saat proses instalasi yang menyebabkan kegagalan total instalasi
- Penambahan fitur Captcha untuk peningkatan keamanan
- Penambahan beberapa fungsi pada sistem dasar (core)
- Perbaikan celah keamanan fatal pada sistem
- Peningkatan performa tampilan Front-end

Versi 1.0.1 (Alpha 2) - 21 November 2015
-----------------------
- Perbaikan pada prosses instalasi
- Peningkatan performa pada tampilan Front-end

Versi 1.0.0 (Alpha) - 20 November 2015
-----------------------
- Pertama kali dirilis dan masih berstatus Alpha I
