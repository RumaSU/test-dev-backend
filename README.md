# Test Dev Backend

PHP test project untuk manajemen data hewan peliharaan dengan berbagai operasi dan fungsi utility.

> **Note:** README ini di-generate oleh Cursor Agent AI, namun seluruh **core logic dan business logic** merupakan implementasi original buatan sendiri.

## TL;DR
- Semua 9 requirement backend terpenuhi dan diimplementasikan
- Core logic ditulis manual menggunakan native PHP tanpa framework
- AI hanya digunakan untuk code preview, testing assistance, dan dokumentasi

## Overview

Project ini menyelesaikan 9 test requirement yang mencakup:
- Entity-based pet management system dengan operasi CRUD
- Utility functions untuk manipulasi string, array, dan JSON
- Transformasi dan agregasi data JSON berdasarkan kategori
- Validasi palindrome dan anagram

## Quick Start

### Prasyarat
- **PHP 8.2+** (menggunakan Constructor Property Promotion, Union Types)
- Web browser

### Menjalankan Project

```bash
# 1. Clone atau download project
git clone <repository-url>

# 2. Masuk ke direktori project
cd test-dev-backend

# 3. Jalankan PHP built-in server
php -S 127.0.0.1:8000

# 4. Buka browser dan akses
# http://127.0.0.1:8000
```

> **Tips:** Tekan `Ctrl + C` untuk menghentikan server.

## Features

### Pet Management
- Create & manage pet data (nama, jenis, ras, karakteristik)
- Mark favorite pets
- Add pet records

### Collection Operations
- Sort favorite pets (ascending/descending)
- Update pet race
- Count pets by species/type

### Utility Functions
- **Palindrome Checker**: Detect palindrome names dengan string length info
- **Anagram Validator**: Check if two strings are anagrams
- **Array Operations**: Sum even numbers, flatten arrays, dll
- **JSON Processing**: Extract & validate JSON files dengan data aggregation

### Data Transformation
- JSON data aggregation by category & code
- Hierarchical grouping & sorting

## Requirements Implementation

9 requirement yang telah diimplementasikan:

1. ✅ Membuat data array hewan peliharaan (jenis, ras, nama, karakteristik)
2. ✅ Menambah hewan peliharaan baru (Badak Jawa bernama Rino sebagai kesayangan)
3. ✅ Mengambil hewan kesayangan dengan sorting (ascending/descending)
4. ✅ Mengganti ras kucing Persia menjadi Maine Coon
5. ✅ Menghitung jumlah hewan per jenis (Anjing, Kucing, Ikan, Badak)
6. ✅ Mengecek palindrome pada nama hewan beserta panjang string
7. ✅ Menjumlah bilangan genap dari array `[15,18,3,9,6,2,12,14]`
8. ✅ Menentukan apakah dua string adalah anagram
9. ✅ Memformat dan mengagregasi data JSON (`assets/json/case.json` → format `expectation.json`)

## Tech Stack & Architecture

### Teknologi
- **PHP 8.2+**: Native PHP dengan namespaces, anonymous classes, typed properties
- **Tailwind CSS**: Styling via CDN (@tailwindcss/browser)
- **Architecture**: MVC-like pattern dengan separation of concerns

### Struktur Kode

**Namespaces:**
- `Core\Models\` - Pets collection manager
- `Core\Entities\` - Pet entity
- `Core\Lib\` - Utility libraries (Arr, Str, Json, Mat)
- `Core\Data\` - Category aggregator

**Design Patterns:**
- **Entity Pattern** - Pet sebagai domain entity
- **Repository Pattern** - Pets sebagai collection repository
- **Utility Pattern** - Static utility classes
- **Method Chaining** - Fluent interface untuk operasi berantai

### Struktur Proyek

```
test-dev-backend/
├── assets/json/          # Test data (case.json, expectation.json)
├── core/
│   ├── data/            # Data handlers
│   ├── entities/        # Entity classes (Pet.php)
│   ├── lib/             # Utility libraries (Arr, Str, Json, Mat)
│   └── models/          # Model classes (Pets.php)
├── view/                # View templates (code/, list.php, result.php, table.php)
├── code_preview.php     # Code snippets
└── index.php            # Entry point
```

## Notes

- **JSON Data**: File `case.json` & `expectation.json` memiliki perbedaan nilai total untuk Bayam (12 vs 25) - documented di section 9
- **Implementation**: Menggunakan anonymous classes untuk method chaining dan fleksibilitas
- **Code Preview**: Tersedia di `/view/code/index.php`

## AI Assistance Usage

> ⚠️ **Penting**: Seluruh **core logic dan business logic** merupakan implementasi original buatan sendiri. AI hanya digunakan untuk tooling dan testing assistance.

### Penggunaan AI dalam Project

Project ini merupakan **test requirement** yang mengizinkan penggunaan AI Assistance dengan catatan:

- **Code Preview Generator** - Tool preview code dibuat oleh AI untuk mempercepat proses preview (bukan bagian dari core logic)
- **Testing & Validasi** - AI digunakan untuk testing function/class tertentu guna memastikan fungsi berjalan dengan benar
- **Dokumentasi** - AI membantu generate README dengan informasi yang disediakan developer

### Prompt yang Digunakan

**Code Preview Generator:**
```
"@view/code/models/pets.php buatkan seluruh code yang ada di core agar bisa di preview langsung seperti ini, buatkan strukturnya juga sama, bagian header atau section lainnya buatkan tree untuk mengunjungi file file lainnya juga"
```

**Testing & Validasi Kode:**
1. Analisa dan validasi implementasi class `Pets` sesuai requirement
2. Pengujian ulang fungsi-fungsi utama untuk identifikasi bug/edge-case
3. Validasi fungsi flatten array recursive pada helper library
4. Validasi keterkaitan implementasi method dengan hasil di entry-point (`index.php`)

### Catatan Tambahan

- Semua core business logic, algoritma, dan implementasi requirement dibuat secara manual
- AI berperan sebagai **assistance tool** untuk code review, testing, dan dokumentasi
- Setiap fungsi dan class telah ditest dan divalidasi secara manual sebelum digunakan
