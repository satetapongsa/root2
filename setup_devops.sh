sudo groupadd devops
sudo usermod -aG devops student
sudo usermod -aG devops alice
sudo mkdir /srv/devops
sudo chown :devops /srv/devops
sudo chmod 2775 /srv/devops

A:
su - student
cd /srv/devops
touch test_by_student.txt

B:
su - alice
cd /srv/devops
ls -l
echo "hello from alice" >> test_by_student.txt

7. ใช้ su แบบต่าง ๆ (ตามโจทย์คุณให้มา)

su - student → สลับเต็มรูปแบบ, โหลด env ของ student

su student → เปลี่ยน user แต่ยังใช้ env บางส่วนจากเดิม

su -c 'ls -l /srv/devops' student → รันคำสั่งเดียวในนาม student

su -s /bin/bash student → บังคับให้ใช้ shell ที่กำหนด

เมื่อเสร็จแล้วพิมพ์ exit เพื่อกลับ user เดิม
สรุปง่าย ๆ:
สร้างกลุ่ม devops
เพิ่มสมาชิกเข้าไป
ตั้งโฟลเดอร์กลาง /srv/devops
ใช้ chmod 2775 เพื่อแชร์สิทธิ์
ทดสอบด้วยการ su ไปยัง user ต่าง ๆ และลองอ่าน/เขียนไฟล์

#!/bin/bash
# Script สำหรับตั้งโฟลเดอร์ทีม devops และทดสอบสิทธิ์ user

# --- ตั้งค่า ---
GROUP="devops"
USERS=("student" "alice")
FOLDER="/srv/devops"
TESTFILE="$FOLDER/test_file.txt"

echo "=== สร้างกลุ่ม $GROUP ==="
sudo groupadd -f $GROUP  # -f ถ้ากลุ่มมีอยู่แล้วจะไม่ error

echo "=== เพิ่มสมาชิกเข้า $GROUP ==="
for user in "${USERS[@]}"; do
    sudo usermod -aG $GROUP $user
done

echo "=== สร้างโฟลเดอร์ $FOLDER ==="
sudo mkdir -p $FOLDER
sudo chown :$GROUP $FOLDER
sudo chmod 2775 $FOLDER   # setgid + rwxrwxr-x

echo "=== สร้างไฟล์ทดสอบโดย student ==="
sudo -u student bash -c "echo 'Created by student' > $TESTFILE"

echo "=== ลองแก้ไขไฟล์โดย alice ==="
sudo -u alice bash -c "echo 'Edited by alice' >> $TESTFILE"

echo "=== แสดงไฟล์ ==="
ls -l $FOLDER
cat $TESTFILE

# --- ทดลอง su แบบต่าง ๆ ---
echo "=== ทดสอบ su แบบ login shell (student) ==="
su - student -c "echo 'Login shell test by student' >> $TESTFILE"

echo "=== ทดสอบ su แบบ non-login shell (alice) ==="
su alice -c "echo 'Non-login shell test by alice' >> $TESTFILE"

echo "=== ทดสอบ su รันคำสั่งเดียว (student) ==="
su -c "echo 'Single command test by student' >> $TESTFILE" student

echo "=== ทดสอบ su บังคับ shell (alice) ==="
su -s /bin/bash alice -c "echo 'Force bash shell test by alice' >> $TESTFILE"

echo "=== สรุปไฟล์หลังทดสอบทั้งหมด ==="
ls -l $FOLDER
cat $TESTFILE

echo "=== เสร็จสิ้น ==="


chmod +x setup_devops.sh
sudo ./setup_devops.sh

