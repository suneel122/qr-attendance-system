# 📷 QR Code Attendance System

A reliable, lightweight, and local network-based QR Code Attendance System developed using **HTML5, JavaScript, PHP, and MySQL (XAMPP)**. Designed specifically for university class sections (e.g., BSCS 7B) to automate daily attendance tracking, prevent duplicate entries, map student Roll Numbers to Real Names, and generate Excel reports.

---

## 🌟 Key Features

* **📷 Web Camera QR Scanner:** Integrates `html5-qrcode` library for real-time QR code scanning from PC or Mobile web browsers.
* **👤 Automatic Student Name Mapping:** Uses a lookup table (`students`) to map scanned Roll Numbers (`student_id`) directly to student full names.
* **🚫 Duplicate Scan Prevention:** Automatically checks MySQL database to block multiple attendance logs for the same student within the same calendar day (`CURDATE()`).
* **📊 One-Click CSV/Excel Export:** Generates formatted `.csv` reports sorted sequentially by Student ID (`ORDER BY student_id ASC`) with custom headers.
* **🌐 Local Network Access:** Accessible across local Wi-Fi networks using Apache server IP routing (`http://192.168.x.x/attendance_system/`).
* **⚡ Self-Healing Database Structure:** Works with dynamic relational queries to ensure `N/A` fallback prevention.

---

## 📁 Project Structure

```text
attendance_system/
│
├── index.html            # Frontend UI with camera scanner & Download button
├── mark_attendance.php   # Backend API for student lookup, duplicate check & insertion
├── export_excel.php      # CSV generator script for downloading reports
└── README.md             # Project documentation
