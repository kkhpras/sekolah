/*
 * ============================================================
 *  Program  : Geometri 3D dengan OpenGL
 *  Bahasa    : C++
 *  Deskripsi : Menampilkan berbagai objek geometri 3D
 *              (Kubus, Bola, Piramida, Silinder, Torus, Kerucut)
 *              dengan pencahayaan, warna, dan kontrol interaktif.
 *
 *  Kontrol Keyboard:
 *    1-6       : Pilih objek (Kubus/Bola/Piramida/Silinder/Torus/Kerucut)
 *    A         : Tampilkan semua objek sekaligus
 *    X/Y/Z     : Rotasi terhadap sumbu X, Y, Z
 *    R         : Reset rotasi
 *    +/-       : Perbesar/Perkecil objek
 *    W/S       : Gerak naik/turun
 *    Arrow Keys: Rotasi dengan tombol panah
 *    ESC       : Keluar
 *
 *  Kontrol Mouse:
 *    Klik kiri + drag : Rotasi
 *    Scroll            : Zoom in/out

 * ============================================================
 */

#include <GL/glut.h>
#include <cmath>
#include <cstdio>
#include <cstring>

#ifndef M_PI
#define M_PI 3.14159265358979323846
#endif

// ============================================
//  GLOBAL STATE
// ============================================

// Rotasi objek
GLfloat rotX = 25.0f;
GLfloat rotY = 35.0f;
GLfloat rotZ = 0.0f;

// Skala dan posisi
GLfloat scaleFactor = 1.0f;
GLfloat posY = 0.0f;

// Objek yang sedang aktif (0=all, 1=kubus, 2=bola, ...)
int activeObject = 0;

// Mouse state
int mouseLastX = 0;
int mouseLastY = 0;
bool mouseDragging = false;

// Kecepatan auto-rotasi
GLfloat autoRotateSpeed = 0.3f;
bool autoRotate = true;

// Warna background
GLfloat bgColor[3] = {0.08f, 0.08f, 0.12f};

// ============================================
//  FUNGSI UTILITAS
// ============================================

// Mengubah sudut dari derajat ke radian
inline float degToRad(float deg) {
    return deg * (float)M_PI / 180.0f;
}

// Menampilkan teks di layar (Hud)
void drawText2D(float x, float y, const char* text, float r = 1.0f, float g = 1.0f, float b = 1.0f) {
    glMatrixMode(GL_PROJECTION);
    glPushMatrix();
    glLoadIdentity();
    GLint viewport[4];
    glGetIntegerv(GL_VIEWPORT, viewport);
    gluOrtho2D(0, viewport[2], 0, viewport[3]);

    glMatrixMode(GL_MODELVIEW);
    glPushMatrix();
    glLoadIdentity();

    glColor3f(r, g, b);
    glRasterPos2f(x, y);

    // GLUT_BITMAP_HELVETICA_18 = font ukuran 18
    for (const char* c = text; *c != '\0'; c++) {
        glutBitmapCharacter(GLUT_BITMAP_HELVETICA_18, *c);
    }

    glPopMatrix();
    glMatrixMode(GL_PROJECTION);
    glPopMatrix();
    glMatrixMode(GL_MODELVIEW);
}

// ============================================
//  MATERIAL / WARNA
// ============================================

typedef struct {
    GLfloat ambient[4];
    GLfloat diffuse[4];
    GLfloat specular[4];
    GLfloat shininess;
} Material;

void setMaterial(const Material& mat) {
    glMaterialfv(GL_FRONT_AND_BACK, GL_AMBIENT,   mat.ambient);
    glMaterialfv(GL_FRONT_AND_BACK, GL_DIFFUSE,   mat.diffuse);
    glMaterialfv(GL_FRONT_AND_BACK, GL_SPECULAR,  mat.specular);
    glMaterialf (GL_FRONT_AND_BACK, GL_SHININESS,  mat.shininess);
}

// Material predefined
Material matMerah   = {{0.2f,0.05f,0.05f,1.0f}, {0.9f,0.15f,0.15f,1.0f}, {1.0f,0.6f,0.6f,1.0f}, 80.0f};
Material matBiru    = {{0.05f,0.05f,0.2f,1.0f}, {0.15f,0.3f,0.9f,1.0f},  {0.6f,0.6f,1.0f,1.0f},   80.0f};
Material matHijau   = {{0.05f,0.2f,0.05f,1.0f}, {0.1f,0.8f,0.2f,1.0f},   {0.5f,1.0f,0.5f,1.0f},   60.0f};
Material matKuning  = {{0.2f,0.2f,0.05f,1.0f}, {0.95f,0.85f,0.1f,1.0f},  {1.0f,1.0f,0.6f,1.0f},     50.0f};
Material matUngu    = {{0.15f,0.05f,0.2f,1.0f}, {0.7f,0.2f,0.9f,1.0f},   {0.9f,0.6f,1.0f,1.0f},   70.0f};
Material matOrange  = {{0.2f,0.1f,0.05f,1.0f}, {0.95f,0.5f,0.1f,1.0f},   {1.0f,0.7f,0.4f,1.0f},   60.0f};
Material matEmas    = {{0.25f,0.2f,0.0f,1.0f},  {0.85f,0.65f,0.15f,1.0f}, {1.0f,0.9f,0.5f,1.0f},  100.0f};
Material matPerak   = {{0.15f,0.15f,0.15f,1.0f},{0.7f,0.7f,0.75f,1.0f},  {0.95f,0.95f,1.0f,1.0f}, 110.0f};

// ============================================
//  SETUP PENCAHAYAAN
// ============================================

void setupLighting() {
    glEnable(GL_LIGHTING);

    // Cahaya utama (key light) - posisi kanan atas
    GLfloat light0_pos[]     = { 5.0f, 8.0f, 5.0f, 1.0f };
    GLfloat light0_ambient[] = { 0.15f, 0.15f, 0.15f, 1.0f };
    GLfloat light0_diffuse[] = { 0.9f, 0.9f, 0.85f, 1.0f };
    GLfloat light0_specular[]= { 1.0f, 1.0f, 1.0f, 1.0f };

    glLightfv(GL_LIGHT0, GL_POSITION, light0_pos);
    glLightfv(GL_LIGHT0, GL_AMBIENT,  light0_ambient);
    glLightfv(GL_LIGHT0, GL_DIFFUSE,  light0_diffuse);
    glLightfv(GL_LIGHT0, GL_SPECULAR, light0_specular);
    glEnable(GL_LIGHT0);

    // Cahaya fill (fill light) - posisi kiri bawah, lebih lembut
    GLfloat light1_pos[]     = { -4.0f, -2.0f, 3.0f, 1.0f };
    GLfloat light1_ambient[] = { 0.05f, 0.05f, 0.08f, 1.0f };
    GLfloat light1_diffuse[] = { 0.3f, 0.3f, 0.4f, 1.0f };
    GLfloat light1_specular[]= { 0.2f, 0.2f, 0.3f, 1.0f };

    glLightfv(GL_LIGHT1, GL_POSITION, light1_pos);
    glLightfv(GL_LIGHT1, GL_AMBIENT,  light1_ambient);
    glLightfv(GL_LIGHT1, GL_DIFFUSE,  light1_diffuse);
    glLightfv(GL_LIGHT1, GL_SPECULAR, light1_specular);
    glEnable(GL_LIGHT1);

    // Global ambient
    GLfloat globalAmbient[] = { 0.1f, 0.1f, 0.12f, 1.0f };
    glLightModelfv(GL_LIGHT_MODEL_AMBIENT, globalAmbient);

    glEnable(GL_COLOR_MATERIAL);
    glColorMaterial(GL_FRONT_AND_BACK, GL_AMBIENT_AND_DIFFUSE);
    glShadeModel(GL_SMOOTH);
}

// ============================================
//  FUNGSI GAMBAR OBJEK GEOMETRI
// ============================================

// ---------- 1. KUBUS ----------
void drawCube(float size) {
    float s = size / 2.0f;

    setMaterial(matMerah);
    glBegin(GL_QUADS);

    // Depan (merah)
    glNormal3f( 0,  0,  1);
    glVertex3f(-s, -s,  s);
    glVertex3f( s, -s,  s);
    glVertex3f( s,  s,  s);
    glVertex3f(-s,  s,  s);

    // Belakang (oranye)
    setMaterial(matOrange);
    glNormal3f( 0,  0, -1);
    glVertex3f(-s, -s, -s);
    glVertex3f(-s,  s, -s);
    glVertex3f( s,  s, -s);
    glVertex3f( s, -s, -s);

    // Atas (kuning)
    setMaterial(matKuning);
    glNormal3f( 0,  1,  0);
    glVertex3f(-s,  s, -s);
    glVertex3f(-s,  s,  s);
    glVertex3f( s,  s,  s);
    glVertex3f( s,  s, -s);

    // Bawah (hijau)
    setMaterial(matHijau);
    glNormal3f( 0, -1,  0);
    glVertex3f(-s, -s, -s);
    glVertex3f( s, -s, -s);
    glVertex3f( s, -s,  s);
    glVertex3f(-s, -s,  s);

    // Kanan (biru)
    setMaterial(matBiru);
    glNormal3f( 1,  0,  0);
    glVertex3f( s, -s, -s);
    glVertex3f( s,  s, -s);
    glVertex3f( s,  s,  s);
    glVertex3f( s, -s,  s);

    // Kiri (ungu)
    setMaterial(matUngu);
    glNormal3f(-1,  0,  0);
    glVertex3f(-s, -s, -s);
    glVertex3f(-s, -s,  s);
    glVertex3f(-s,  s,  s);
    glVertex3f(-s,  s, -s);

    glEnd();

    // Gambar garis tepi (wireframe overlay)
    glDisable(GL_LIGHTING);
    glColor3f(0.0f, 0.0f, 0.0f);
    glLineWidth(2.0f);
    glBegin(GL_LINE_LOOP);
    // Depan
    glVertex3f(-s, -s,  s); glVertex3f( s, -s,  s);
    glVertex3f( s,  s,  s); glVertex3f(-s,  s,  s);
    glEnd();
    glBegin(GL_LINE_LOOP);
    // Belakang
    glVertex3f(-s, -s, -s); glVertex3f( s, -s, -s);
    glVertex3f( s,  s, -s); glVertex3f(-s,  s, -s);
    glEnd();
    glBegin(GL_LINES);
    // Sambungan
    glVertex3f(-s, -s,  s); glVertex3f(-s, -s, -s);
    glVertex3f( s, -s,  s); glVertex3f( s, -s, -s);
    glVertex3f( s,  s,  s); glVertex3f( s,  s, -s);
    glVertex3f(-s,  s,  s); glVertex3f(-s,  s, -s);
    glEnd();
    glEnable(GL_LIGHTING);
}

// ---------- 2. BOLA (Sphere) ----------
void drawSphere(float radius, int slices, int stacks) {
    setMaterial(matBiru);

    for (int i = 0; i < stacks; i++) {
        float lat0 = degToRad(-90.0f + i * 180.0f / stacks);
        float lat1 = degToRad(-90.0f + (i + 1) * 180.0f / stacks);
        float y0 = radius * sinf(lat0);
        float y1 = radius * sinf(lat1);
        float r0 = radius * cosf(lat0);
        float r1 = radius * cosf(lat1);

        // Gradasi warna berdasarkan posisi
        if (i % 4 == 0) setMaterial(matBiru);
        else if (i % 4 == 1) setMaterial(matUngu);
        else if (i % 4 == 2) setMaterial(matMerah);
        else setMaterial(matOrange);

        glBegin(GL_QUAD_STRIP);
        for (int j = 0; j <= slices; j++) {
            float lng = degToRad(j * 360.0f / slices);
            float x = cosf(lng);
            float z = sinf(lng);

            glNormal3f(x * cosf(lat0), sinf(lat0), z * cosf(lat0));
            glVertex3f(x * r0, y0, z * r0);

            glNormal3f(x * cosf(lat1), sinf(lat1), z * cosf(lat1));
            glVertex3f(x * r1, y1, z * r1);
        }
        glEnd();
    }
}

// ---------- 3. PIRAMIDA (Pyramid / Tetrahedron) ----------
void drawPyramid(float base, float height) {
    float h = base / 2.0f;
    float topY = height;

    // 4 titik alas
    float v0[3] = { -h, 0,  h }; // depan-kiri
    float v1[3] = {  h, 0,  h }; // depan-kanan
    float v2[3] = {  h, 0, -h }; // belakang-kanan
    float v3[3] = { -h, 0, -h }; // belakang-kiri
    float apex[3]= { 0, topY, 0 };

    // Hitung normal untuk setiap sisi
    // Fungsi helper: cross product dan normalize
    auto crossNormal = [](float a[3], float b[3], float c[3], float n[3]) {
        float e1[3] = {b[0]-a[0], b[1]-a[1], b[2]-a[2]};
        float e2[3] = {c[0]-a[0], c[1]-a[1], c[2]-a[2]};
        n[0] = e1[1]*e2[2] - e1[2]*e2[1];
        n[1] = e1[2]*e2[0] - e1[0]*e2[2];
        n[2] = e1[0]*e2[1] - e1[1]*e2[0];
        float len = sqrtf(n[0]*n[0] + n[1]*n[1] + n[2]*n[2]);
        if (len > 0) { n[0]/=len; n[1]/=len; n[2]/=len; }
    };

    float n[3];

    // Sisi depan
    setMaterial(matMerah);
    crossNormal(v0, v1, apex, n);
    glBegin(GL_TRIANGLES);
    glNormal3fv(n);
    glVertex3fv(v0); glVertex3fv(v1); glVertex3fv(apex);
    glEnd();

    // Sisi kanan
    setMaterial(matHijau);
    crossNormal(v1, v2, apex, n);
    glBegin(GL_TRIANGLES);
    glNormal3fv(n);
    glVertex3fv(v1); glVertex3fv(v2); glVertex3fv(apex);
    glEnd();

    // Sisi belakang
    setMaterial(matBiru);
    crossNormal(v2, v3, apex, n);
    glBegin(GL_TRIANGLES);
    glNormal3fv(n);
    glVertex3fv(v2); glVertex3fv(v3); glVertex3fv(apex);
    glEnd();

    // Sisi kiri
    setMaterial(matKuning);
    crossNormal(v3, v0, apex, n);
    glBegin(GL_TRIANGLES);
    glNormal3fv(n);
    glVertex3fv(v3); glVertex3fv(v0); glVertex3fv(apex);
    glEnd();

    // Alas
    setMaterial(matOrange);
    glBegin(GL_QUADS);
    glNormal3f(0, -1, 0);
    glVertex3fv(v0); glVertex3fv(v1); glVertex3fv(v2); glVertex3fv(v3);
    glEnd();
}

// ---------- 4. SILINDER ----------
void drawCylinder(float radius, float height, int slices) {
    float halfH = height / 2.0f;

    // Sisi tubuh
    for (int i = 0; i < slices; i++) {
        float a0 = degToRad(i * 360.0f / slices);
        float a1 = degToRad((i + 1) * 360.0f / slices);
        float x0 = radius * cosf(a0), z0 = radius * sinf(a0);
        float x1 = radius * cosf(a1), z1 = radius * sinf(a1);

        // Warna bergantian (striped pattern)
        if (i % 2 == 0) setMaterial(matHijau);
        else setMaterial(matUngu);

        glBegin(GL_QUADS);
        // Normal mengarah keluar
        float nx0 = cosf(a0), nz0 = sinf(a0);
        float nx1 = cosf(a1), nz1 = sinf(a1);
        glNormal3f(nx0, 0, nz0);
        glVertex3f(x0, -halfH, z0);
        glVertex3f(x0,  halfH, z0);
        glNormal3f(nx1, 0, nz1);
        glVertex3f(x1,  halfH, z1);
        glVertex3f(x1, -halfH, z1);
        glEnd();
    }

    // Tutup atas
    setMaterial(matKuning);
    glBegin(GL_POLYGON);
    glNormal3f(0, 1, 0);
    for (int i = 0; i < slices; i++) {
        float a = degToRad(i * 360.0f / slices);
        glVertex3f(radius * cosf(a), halfH, radius * sinf(a));
    }
    glEnd();

    // Tutup bawah
    setMaterial(matOrange);
    glBegin(GL_POLYGON);
    glNormal3f(0, -1, 0);
    for (int i = slices - 1; i >= 0; i--) {
        float a = degToRad(i * 360.0f / slices);
        glVertex3f(radius * cosf(a), -halfH, radius * sinf(a));
    }
    glEnd();
}

// ---------- 5. TORUS ----------
void drawTorus(float innerRadius, float outerRadius, int sides, int rings) {
    for (int i = 0; i < rings; i++) {
        float theta0 = degToRad(i * 360.0f / rings);
        float theta1 = degToRad((i + 1) * 360.0f / rings);

        // Warna bergantian
        if (i % 3 == 0) setMaterial(matEmas);
        else if (i % 3 == 1) setMaterial(matPerak);
        else setMaterial(matMerah);

        glBegin(GL_QUAD_STRIP);
        for (int j = 0; j <= sides; j++) {
            float phi = degToRad(j * 360.0f / sides);

            for (int k = 0; k < 2; k++) {
                float theta = (k == 0) ? theta0 : theta1;
                float cx = outerRadius * cosf(theta);
                float cz = outerRadius * sinf(theta);

                float x = cx + innerRadius * cosf(phi) * cosf(theta);
                float y = innerRadius * sinf(phi);
                float z = cz + innerRadius * cosf(phi) * sinf(theta);

                float nx = cosf(phi) * cosf(theta);
                float ny = sinf(phi);
                float nz = cosf(phi) * sinf(theta);

                glNormal3f(nx, ny, nz);
                glVertex3f(x, y, z);
            }
        }
        glEnd();
    }
}

// ---------- 6. KERUCUT (Cone) ----------
void drawCone(float radius, float height, int slices) {
    float apexY = height;
    float slopeLen = sqrtf(radius * radius + height * height);

    // Sisi kerucut menggunakan GL_TRIANGLE_FAN dari apex
    glBegin(GL_TRIANGLE_FAN);
    // Apex (puncak kerucut)
    glNormal3f(0.0f, radius / slopeLen, 0.0f);
    glVertex3f(0.0f, apexY, 0.0f);

    for (int i = 0; i <= slices; i++) {
        float angle = degToRad(i * 360.0f / slices);
        float x = radius * cosf(angle);
        float z = radius * sinf(angle);

        // Normal sisi kerucut (mengarah keluar)
        float nx = cosf(angle) * height / slopeLen;
        float nz = sinf(angle) * height / slopeLen;
        glNormal3f(nx, radius / slopeLen, nz);

        // Warna bergantian
        if (i % 2 == 0) setMaterial(matUngu);
        else setMaterial(matOrange);

        glVertex3f(x, 0.0f, z);
    }
    glEnd();

    // Alas kerucut
    setMaterial(matKuning);
    glBegin(GL_TRIANGLE_FAN);
    glNormal3f(0.0f, -1.0f, 0.0f);
    glVertex3f(0.0f, 0.0f, 0.0f);  // Pusat alas
    for (int i = 0; i <= slices; i++) {
        float angle = degToRad(-i * 360.0f / slices);
        glVertex3f(radius * cosf(angle), 0.0f, radius * sinf(angle));
    }
    glEnd();
}

// ============================================
//  FUNGSI GAMBAR GRID (lantai)
// ============================================

void drawGrid() {
    glDisable(GL_LIGHTING);
    glColor4f(0.3f, 0.3f, 0.35f, 0.5f);
    glLineWidth(1.0f);

    float gridSize = 6.0f;
    float step = 0.5f;

    glBegin(GL_LINES);
    for (float i = -gridSize; i <= gridSize; i += step) {
        // Garis horizontal (sumbu X)
        glVertex3f(-gridSize, -2.0f, i);
        glVertex3f( gridSize, -2.0f, i);
        // Garis vertikal (sumbu Z)
        glVertex3f(i, -2.0f, -gridSize);
        glVertex3f(i, -2.0f,  gridSize);
    }
    glEnd();

    // Sumbu koordinat ( lebih tebal dan berwarna )
    glLineWidth(2.5f);
    float axisLen = 4.0f;

    // Sumbu X = Merah
    glColor3f(1.0f, 0.3f, 0.3f);
    glBegin(GL_LINES);
    glVertex3f(-axisLen, -2.0f, 0);
    glVertex3f( axisLen, -2.0f, 0);
    glEnd();

    // Sumbu Y = Hijau
    glColor3f(0.3f, 1.0f, 0.3f);
    glBegin(GL_LINES);
    glVertex3f(0, -2.0f, 0);
    glVertex3f(0, axisLen - 2.0f, 0);
    glEnd();

    // Sumbu Z = Biru
    glColor3f(0.3f, 0.3f, 1.0f);
    glBegin(GL_LINES);
    glVertex3f(0, -2.0f, -axisLen);
    glVertex3f(0, -2.0f,  axisLen);
    glEnd();

    glEnable(GL_LIGHTING);
}

// ============================================
//  FUNGSI GAMBAR OBJEK DI POSISI TERTENTU
// ============================================

void drawObjectAt(int objType, float x, float y, float z, float scale) {
    glPushMatrix();
    glTranslatef(x, y, z);
    glScalef(scale, scale, scale);

    switch (objType) {
        case 1: drawCube(1.5f);           break;
        case 2: drawSphere(1.0f, 32, 24); break;
        case 3: drawPyramid(1.5f, 2.0f);   break;
        case 4: drawCylinder(0.8f, 2.0f, 32); break;
        case 5: drawTorus(0.4f, 1.0f, 20, 36); break;
        case 6: drawCone(0.8f, 2.0f, 32); break;
        default: drawCube(1.5f);           break;
    }

    glPopMatrix();
}

// ============================================
//  DISPLAY (fungsi render utama)
// ============================================

void display() {
    // Bersihkan layar
    glClear(GL_COLOR_BUFFER_BIT | GL_DEPTH_BUFFER_BIT);
    glLoadIdentity();

    // Kamera
    gluLookAt(0, 2, 8,    // posisi kamera
              0, 0, 0,     // titik tujuan
              0, 1, 0);    // vektor up

    // Terapkan rotasi
    glRotatef(rotX, 1, 0, 0);
    glRotatef(rotY, 0, 1, 0);
    glRotatef(rotZ, 0, 0, 1);

    // Terapkan skala dan posisi
    glScalef(scaleFactor, scaleFactor, scaleFactor);
    glTranslatef(0, posY, 0);

    // Gambar grid lantai
    drawGrid();

    // Gambar objek berdasarkan pilihan
    if (activeObject == 0) {
        // Tampilkan semua objek dalam susunan grid
        drawObjectAt(1, -2.5f, 0.0f,  0.0f, 0.7f);  // Kubus kiri
        drawObjectAt(2,  0.0f, 0.0f,  0.0f, 0.7f);  // Bola tengah
        drawObjectAt(3,  2.5f, 0.0f,  0.0f, 0.7f);  // Piramida kanan
        drawObjectAt(4, -2.5f, 0.0f, -2.5f, 0.7f);  // Silinder kiri-belakang
        drawObjectAt(5,  0.0f, 0.0f, -2.5f, 0.7f);  // Torus tengah-belakang
        drawObjectAt(6,  2.5f, 0.0f, -2.5f, 0.7f);  // Kerucut kanan-belakang
    } else {
        drawObjectAt(activeObject, 0, 0, 0, 1.0f);
    }

    // Gambar label nama objek (HUD overlay)
    glDisable(GL_LIGHTING);
    glDisable(GL_DEPTH_TEST);

    const char* namaObjek = "";
    switch (activeObject) {
        case 0: namaObjek = "SEMUA OBJEK GEOMETRI 3D"; break;
        case 1: namaObjek = "KUBUS (Cube)"; break;
        case 2: namaObjek = "BOLA (Sphere)"; break;
        case 3: namaObjek = "PIRAMIDA (Pyramid)"; break;
        case 4: namaObjek = "SILINDER (Cylinder)"; break;
        case 5: namaObjek = "TORUS (Torus)"; break;
        case 6: namaObjek = "KERUCUT (Cone)"; break;
    }
    drawText2D(10, 20, namaObjek, 1.0f, 0.9f, 0.2f);

    // Instruksi kontrol di bagian bawah
    drawText2D(10, 50, "Tombol 1-6: Pilih Objek | A: Semua | Mouse Drag: Rotasi | +/-: Zoom | ESC: Keluar",
               0.6f, 0.6f, 0.6f);

    glEnable(GL_DEPTH_TEST);
    glEnable(GL_LIGHTING);

    glutSwapBuffers();
}

// ============================================
//  RESIZE (jika ukuran window berubah)
// ============================================

void reshape(int w, int h) {
    if (h == 0) h = 1;
    glViewport(0, 0, w, h);

    glMatrixMode(GL_PROJECTION);
    glLoadIdentity();
    // Field of view 45 derajat, aspect ratio sesuai window
    gluPerspective(45.0, (double)w / (double)h, 0.1, 100.0);

    glMatrixMode(GL_MODELVIEW);
}

// ============================================
//  TIMER (untuk auto-rotasi)
// ============================================

void timer(int value) {
    if (autoRotate) {
        rotY += autoRotateSpeed;
        if (rotY > 360.0f) rotY -= 360.0f;
    }
    glutPostRedisplay();
    glutTimerFunc(16, timer, 0); // ~60 FPS
}

// ============================================
//  KEYBOARD HANDLER
// ============================================

void keyboard(unsigned char key, int x, int y) {
    switch (key) {
        // Pilih objek
        case '1': activeObject = 1; printf(">> Kubus\n"); break;
        case '2': activeObject = 2; printf(">> Bola\n"); break;
        case '3': activeObject = 3; printf(">> Piramida\n"); break;
        case '4': activeObject = 4; printf(">> Silinder\n"); break;
        case '5': activeObject = 5; printf(">> Torus\n"); break;
        case '6': activeObject = 6; printf(">> Kerucut\n"); break;
        case 'a': case 'A':
            activeObject = 0;
            printf(">> Semua Objek\n");
            break;

        // Rotasi manual
        case 'x': case 'X': rotX += 5.0f; break;
        case 'y': case 'Y': rotY += 5.0f; break;
        case 'z': case 'Z': rotZ += 5.0f; break;

        // Reset
        case 'r': case 'R':
            rotX = 25.0f; rotY = 35.0f; rotZ = 0.0f;
            scaleFactor = 1.0f; posY = 0.0f;
            printf(">> Reset\n");
            break;

        // Skala
        case '+': case '=':
            scaleFactor += 0.1f;
            if (scaleFactor > 5.0f) scaleFactor = 5.0f;
            break;
        case '-': case '_':
            scaleFactor -= 0.1f;
            if (scaleFactor < 0.1f) scaleFactor = 0.1f;
            break;

        // Posisi Y
        case 'w': case 'W': posY += 0.2f; break;
        case 's': case 'S': posY -= 0.2f; break;

        // Toggle auto-rotasi
        case 'p': case 'P':
            autoRotate = !autoRotate;
            printf(">> Auto-rotasi: %s\n", autoRotate ? "ON" : "OFF");
            break;

        // Keluar
        case 27: // ESC
            printf(">> Program selesai.\n");
            exit(0);
            break;
    }
}

// ============================================
//  SPECIAL KEYBOARD (tombol panah)
// ============================================

void specialKeys(int key, int x, int y) {
    switch (key) {
        case GLUT_KEY_LEFT:  rotY -= 5.0f; break;
        case GLUT_KEY_RIGHT: rotY += 5.0f; break;
        case GLUT_KEY_UP:    rotX -= 5.0f; break;
        case GLUT_KEY_DOWN:  rotX += 5.0f; break;
    }
}

// ============================================
//  MOUSE HANDLER
// ============================================

void mouse(int button, int state, int x, int y) {
    if (button == GLUT_LEFT_BUTTON) {
        if (state == GLUT_DOWN) {
            mouseDragging = true;
            mouseLastX = x;
            mouseLastY = y;
        } else {
            mouseDragging = false;
        }
    }
    // Scroll wheel handling (Linux: button 3 = up, button 4 = down)
    if (state == GLUT_UP) {
        if (button == 3) {
            // Scroll up = zoom in
            scaleFactor += 0.1f;
            if (scaleFactor > 5.0f) scaleFactor = 5.0f;
            glutPostRedisplay();
        } else if (button == 4) {
            // Scroll down = zoom out
            scaleFactor -= 0.1f;
            if (scaleFactor < 0.1f) scaleFactor = 0.1f;
            glutPostRedisplay();
        }
    }
}

void mouseMotion(int x, int y) {
    if (mouseDragging) {
        int dx = x - mouseLastX;
        int dy = y - mouseLastY;

        rotY += dx * 0.5f;
        rotX += dy * 0.5f;

        mouseLastX = x;
        mouseLastY = y;
    }
}

// ============================================
//  INISIALISASI OPENGL
// ============================================

void initGL() {
    // Warna background (gelap)
    glClearColor(bgColor[0], bgColor[1], bgColor[2], 1.0f);

    // Depth buffer
    glEnable(GL_DEPTH_TEST);
    glDepthFunc(GL_LEQUAL);

    // Anti-aliasing
    glEnable(GL_MULTISAMPLE);
    glEnable(GL_LINE_SMOOTH);
    glHint(GL_LINE_SMOOTH_HINT, GL_NICEST);

    // Setup pencahayaan
    setupLighting();

    // Normal normalization (untuk skala)
    glEnable(GL_NORMALIZE);

    // Back-face culling (opsional, uncomment untuk mengaktifkan)
    // glEnable(GL_CULL_FACE);
    // glCullFace(GL_BACK);
}

// ============================================
//  MAIN
// ============================================

int main(int argc, char** argv) {
    // Inisialisasi GLUT
    glutInit(&argc, argv);

    // Request multisampling untuk anti-aliasing
    glutInitDisplayMode(GLUT_DOUBLE | GLUT_RGB | GLUT_DEPTH | GLUT_MULTISAMPLE);

    // Ukuran dan posisi window
    glutInitWindowSize(1024, 768);
    glutInitWindowPosition(100, 100);

    // Buat window
    glutCreateWindow("Geometri 3D - OpenGL (C++)");
    glutSetWindowTitle("Geometri 3D - Kubus | Bola | Piramida | Silinder | Torus | Kerucut");

    // Inisialisasi OpenGL
    initGL();

    // Daftarkan callback functions
    glutDisplayFunc(display);
    glutReshapeFunc(reshape);
    glutKeyboardFunc(keyboard);
    glutSpecialFunc(specialKeys);
    glutMouseFunc(mouse);
    glutMotionFunc(mouseMotion);
    // Scroll wheel handled in mouse() callback (buttons 3/4 on Linux)

    // Timer untuk animasi
    glutTimerFunc(0, timer, 0);

    // Cetak informasi kontrol
    printf("====================================================\n");
    printf("  GEOMETRI 3D - OpenGL (C++)\n");
    printf("====================================================\n");
    printf("  Kontrol:\n");
    printf("    1-6    : Pilih objek (Kubus/Bola/Piramida/Silinder/Torus/Kerucut)\n");
    printf("    A      : Tampilkan semua objek\n");
    printf("    X/Y/Z  : Rotasi manual\n");
    printf("    R      : Reset tampilan\n");
    printf("    +/-    : Zoom in/out\n");
    printf("    W/S    : Gerak naik/turun\n");
    printf("    P      : Toggle auto-rotasi\n");
    printf("    Arrow  : Rotasi (tombol panah)\n");
    printf("    Mouse  : Drag = rotasi, Scroll = zoom\n");
    printf("    ESC    : Keluar program\n");
    printf("====================================================\n\n");

    // Mulai main loop
    glutMainLoop();

    return 0;
}
