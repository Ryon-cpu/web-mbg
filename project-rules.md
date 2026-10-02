# Prompt untuk Antigravity — Web Dokumentasi Program MBG

## ATURAN WAJIB (baca dulu sebelum mulai)

1. DILARANG membuat file baru. Semua file (controller, model, migration, view, route, dsb) sudah/akan saya buat sendiri secara manual.
2. DILARANG membuat folder baru. Struktur folder project sudah saya siapkan mengikuti struktur standar Laravel.
3. Tugas kamu HANYA mengisi/menulis isi/konten ke dalam file yang sudah ada, sesuai nama file dan lokasinya.
4. Kalau kamu butuh sebuah file yang menurutmu belum ada, JANGAN dibuat sendiri — cukup sebutkan ke saya nama file dan lokasinya, biar saya yang buat filenya dulu, baru kamu isi.
5. Kalau ragu file itu sudah ada atau belum, cek dulu (list directory / baca file), jangan asumsi lalu membuat baru.

## Konteks Project

Saya sedang membangun web dokumentasi untuk program MBG (Makan Bergizi Gratis). Aturan utama:
- Admin (login) → bisa CRUD (create, read, update, delete) semua konten.
- Publik (tanpa login) → hanya bisa melihat (read-only), tidak ada akses ke fitur tambah/edit/hapus sama sekali, baik di UI maupun di route/endpoint backend.

## Tech Stack

- Backend: Laravel (PHP)
- Database: MySQL
- Auth: Laravel built-in auth (session-based), khusus untuk admin
- Frontend: Blade template

## Struktur Data (Database)

Isi migration & model sesuai skema berikut (sesuaikan nama tabel/kolom dengan file migration yang sudah saya buat, jangan bikin migration baru):

users (admin)
- id, nama, email, password, role, created_at, updated_at

laporan
- id, judul, isi, tanggal, penulis_id (FK ke users), created_at, updated_at

galeri
- id, judul, file_path, laporan_id (FK ke laporan, nullable), created_at, updated_at

data_penerima
- id, nama_sekolah, alamat, jumlah_penerima, tanggal_distribusi, created_at, updated_at

berita
- id, judul, isi, thumbnail, tanggal_publish, status (draft/publish), created_at, updated_at

Catatan: gambar (file fisik) disimpan di storage/app/public (via Laravel Storage), database hanya menyimpan file_path-nya.

## Halaman & Route

Publik (read-only, tanpa middleware auth):
- / — beranda (ringkasan program + statistik)
- /laporan — daftar laporan + /laporan/{id} — detail
- /galeri — galeri foto
- /data — daftar data penerima
- /berita — daftar berita + /berita/{id} — detail

Admin (wajib middleware auth + cek role admin):
- /admin/login
- /admin/dashboard
- /admin/laporan (index, create, edit, delete)
- /admin/galeri (index, create, delete)
- /admin/data (index, create, edit, delete)
- /admin/berita (index, create, edit, delete)

## Keamanan (wajib diterapkan)

- Semua route /admin/* HARUS dibungkus middleware auth dan cek role admin — bukan hanya disembunyikan di tampilan.
- Validasi input di semua form admin ($request->validate(...)), termasuk validasi tipe file untuk upload gambar.
- Gunakan Eloquent / query builder Laravel (hindari raw query rentan SQL injection).
- Gunakan @csrf di semua form Blade.
- Pastikan route publik TIDAK memiliki method store/update/destroy yang bisa diakses tanpa login.

## Langkah Kerja yang Diminta

1. Cek dulu file-file yang sudah ada di project (migration, model, controller, route, view) yang saya sediakan.
2. Isi logic di masing-masing file sesuai fungsinya (migration → schema, model → relasi & fillable, controller → CRUD logic dengan validasi, route → daftarkan sesuai file routes yang ada, view → tampilkan data sesuai desain UI publik/admin).
3. Kalau ada file yang kamu butuhkan tapi belum saya buat, STOP dan beri tahu saya nama filenya — jangan dibuat sendiri.
4. Setelah selesai satu bagian (misal modul laporan), beri ringkasan singkat apa yang sudah diisi dan file mana saja yang tersentuh.