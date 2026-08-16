# ============================================================
#  CMakeLists.txt - Build Configuration
#  Geometri 3D dengan OpenGL (C++)
# ============================================================

cmake_minimum_required(VERSION 3.10)
project(Geometri3D_OpenGL CXX)

set(CMAKE_CXX_STANDARD 11)
set(CMAKE_CXX_STANDARD_REQUIRED ON)

# Prefer GLVND OpenGL libraries to suppress CMP0072 warning
set(OpenGL_GL_PREFERENCE "GLVND")

# Cari package OpenGL dan GLUT yang dibutuhkan
find_package(OpenGL REQUIRED)
find_package(GLUT REQUIRED)

# Sumber kode
add_executable(geometri3d main.cpp)

# Link library
target_link_libraries(geometri3d
    ${OPENGL_LIBRARIES}
    ${GLUT_LIBRARIES}
    GLU
)

# Untuk Linux: tambahkan flag untuk threading jika diperlukan
if(UNIX AND NOT APPLE)
    target_link_libraries(geometri3d pthread)
endif()

# Output info konfigurasi
message(STATUS "OpenGL Found: ${OPENGL_LIBRARIES}")
message(STATUS "GLUT   Found: ${GLUT_LIBRARIES}")
message(STATUS "Build Target: geometri3d")
