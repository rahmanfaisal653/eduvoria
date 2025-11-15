
# 📘 **Dokumentasi Cara Clone, Push, Pull Project GitHub (Versi Pemula)**



# 🟦 **1. Persiapan Awal**

### ✔ A. Install Git

Download di sini:
[https://git-scm.com/downloads](https://git-scm.com/downloads)

Klik next-next saja sampai selesai.

---

### ✔ B. Login GitHub di Git Bash

(Jika belum pernah login)

```bash
git config --global user.name "Nama Kamu"
git config --global user.email "emailgithub@gmail.com"
```

---

# 🟩 **2. Cara Clone Project (Download ke Laptop)**

Jika ingin mengambil project pertama kali, lakukan:

1️⃣ Buka repository GitHub kamu
Tekan tombol **Code → Copy HTTPS**
Contoh link:

```
https://github.com/namaUser/namaRepo.git
```

2️⃣ Di laptop, buka terminal/git bash pada folder yang kamu inginkan
Contoh:

> Documents, Desktop, dll.

3️⃣ Jalankan:
```bash
git clone https://github.com/namaUser/namaRepo.git
```

4️⃣ Masuk ke folder project:
```bash
cd namaRepo
```

SELESAI ✔
Kamu sudah punya projectnya di laptop masing-masing.

---

# 🟧 **3. Cara Push (Mengirim Perubahan ke GitHub)**

⚠ *Gunakan jika kamu mengubah file, menambah file, atau menghapus file.*

1️⃣ Cek dulu file apa yang berubah:
```bash
git status
```

2️⃣ Tambahkan semua perubahan:
```bash
git add .
```

3️⃣ Buat pesan commit:
```bash
git commit -m "update fitur X"
```

4️⃣ Kirim ke GitHub:
```bash
git push
```

---

# 🟨 **4. Cara Pull (Ambil Update Terbaru dari GitHub)**

Kalau ada teman lain yang sudah push, kamu harus pull dulu sebelum kerja lagi!

```bash
git pull
```

Ini akan mengambil versi terbaru dari GitHub ke laptopmu.

---

# 🟥 **5. Alur Kerja Yang Benar (Important!)**

1. Setiap mau kerja → **git pull**
2. Kerjakan task
3. Setelah selesai →

   * `git add .`
   * `git commit -m "pesan update"`
   * `git push`

**Tujuannya:**
Supaya tidak bentrok / konflik antar file.

---

# 🟪 **6. Error Umum & Solusi Cepat**

### ❌ **"rejected / failed to push"**

Karena kamu belum pull versi terbaru.

✔ Solusi:

```bash
git pull
git push
```

---

### ❌ **"merge conflict"**

Artinya kamu dan temanmu mengubah file yang sama.

✔ Solusi paling mudah:

1. Buka file yang konflik
2. Hapus tanda `<<<<<<< HEAD` dan `>>>>>>>`
3. Rapikan isi file
4. Commit ulang:

```bash
git add .
git commit -m "fix conflict"
git push
```

---

# 🟦 **7. Cara Update Project Laravel**

Setelah clone project Laravel, jalankan:

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan serve
```

Jika sudah ada database, import file `.sql`.

---

# 🟫 **8. Cara Bikin Branch Baru (Optional Tapi Bagus)**

Supaya tidak merusak branch main:

```bash
git checkout -b fitur-xyz
```

Setelah selesai:

```bash
git add .
git commit -m "selesai fitur xyz"
git push --set-upstream origin fitur-xyz
```

---

# 🟧 **9. Cara Upload Project Pertama Kali ke GitHub**

1️⃣ buat repo di GitHub
2️⃣ Buka folder project
3️⃣ Jalankan:

```bash
git init
git add .
git commit -m "first commit"
git branch -M main
git remote add origin https://github.com/.../repo.git
git push -u origin main
```

---

# 🟩 **10. Saran Biar Teamwork Lancar**

* Selalu **git pull dulu** sebelum coding
* Push **sering-sering** (jangan numpuk)
* Commit message harus jelas
* Jangan ubah file yang bukan tanggung jawab

---

# Butuh versi **PDF**, **DOCX**, atau mau aku **buatkan template dokumentasi resmi** seperti perusahaan?

Tinggal bilang aja!
