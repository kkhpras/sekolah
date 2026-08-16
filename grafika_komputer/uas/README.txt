================================================================================
   GEOMETRI 3D DENGAN OPENGL (C++)
   Membuat Objek 3 Dimensi Berbentuk Geometri dengan OpenGL
================================================================================

DAFTAR OBJEK YANG DITAMPILKAN:
  1. Kubus      (Cube)      - Kotak 6 sisi dengan warna berbeda tiap sisi
  2. Bola       (Sphere)    - Bola dengan gradasi warna
  3. Piramida   (Pyramid)   - Piramida segi empat 4 sisi miring
  4. Silinder   (Cylinder)  - Tabung dengan tutup atas dan bawah
  5. Torus      (Torus)     - Donat / cincin 3D
  6. Kerucut    (Cone)      - Kerucut dengan alas lingkaran

================================================================================
CARA KOMPILASI
================================================================================

METODE 1: Menggunakan g++ (Linux)
-----------------------------------
    sudo apt-get install freeglut3-dev mesa-common-dev libglu1-mesa-dev
    cd opengl-3d-geometri
    g++ main.cpp -o geometri3d -lGL -lGLU -lglut
    ./geometri3d

METODE 2: Menggunakan CMake (Linux)
------------------------------------
    sudo apt-get install cmake freeglut3-dev mesa-common-dev libglu1-mesa-dev
    cd opengl-3d-geometri
    mkdir build && cd build
    cmake ..
    make
    ./geometri3d

METODE 3: Menggunakan MinGW (Windows)
--------------------------------------
    # Pastikan MinGW terinstal dengan OpenGL
    g++ main.cpp -o geometri3d.exe -lopengl32 -lglu32 -lfreeglut
    geometri3d.exe

METODE 4: Menggunakan Visual Studio (Windows)
----------------------------------------------
    1. Buka Visual Studio, buat project C++ Console Empty
    2. Tambahkan main.cpp ke project
    3. Buka Project Properties > Configuration > Linker > Input
    4. Tambahkan: opengl32.lib; glu32.lib; freeglut.lib
    5. Pastikan include path mengarah ke folder GLUT
    6. Build & Run (Ctrl+F5)

================================================================================
KONTROL PROGRAM
================================================================================

KEYBOARD:
  Tombol 1       : Tampilkan KUBUS
  Tombol 2       : Tampilkan BOLA (Sphere)
  Tombol 3       : Tampilkan PIRAMIDA
  Tombol 4       : Tampilkan SILINDER
  Tombol 5       : Tampilkan TORUS
  Tombol 6       : Tampilkan KERUCUT
  Tombol A       : Tampilkan SEMUA objek sekaligus

  Tombol X/Y/Z   : Rotasi objek terhadap sumbu X, Y, atau Z
  Tombol R       : Reset semua rotasi dan posisi
  Tombol +/-     : Perbesar / Perkecil objek (Zoom)
  Tombol W/S     : Gerak objek naik / turun
  Tombol P       : Aktifkan/Matikan auto-rotasi
  Tombol Panah   : Rotasi objek (Up/Down/Left/Right)
  Tombol ESC     : Keluar dari program

MOUSE:
  Klik kiri + drag  : Rotasi objek
  Scroll atas        : Zoom in (perbesar)
  Scroll bawah       : Zoom out (perkecil)

================================================================================
FITUR PROGRAM
================================================================================

  - 6 objek geometri 3D berbeda
  - Pencahayaan ganda (key light + fill light) untuk tampilan realistis
  - Material dengan specular highlight (kilap/refleksi)
  - Grid lantai dan sumbu koordinat (X merah, Y hijau, Z biru)
  - Auto-rotasi smooth ~60 FPS
  - Anti-aliasing (multisampling)
  - Kontrol interaktif via keyboard dan mouse
  - Label nama objek di layar (HUD overlay)
  - Warna berbeda untuk setiap sisi dan objek

================================================================================
STRUKTUR FILE
================================================================================

  opengl-3d-geometri/
  |-- main.cpp          : Source code utama program
  |-- CMakeLists.txt    : Konfigurasi build CMake
  |-- README.txt        : File instruksi ini

================================================================================
