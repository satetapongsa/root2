#!/bin/bash
# CPE406 – Process Management Lab
# ใช้รันบน Linux (Ubuntu/Debian/Fedora ก็ได้)
# ------------------------------------------------

echo "========== STEP 1: ตรวจสอบ Process ด้วย ps =========="
ps
ps -ef | head -n 5
ps aux | head -n 5
ps -u $(whoami)

echo ""
echo "========== STEP 2: รัน sleep 100 & สร้าง Process =========="
sleep 100 &
SLEEP_PID=$!
echo "สร้าง process sleep 100 (PID=$SLEEP_PID)"

echo ""
echo "========== STEP 3: ตรวจสอบด้วย ps + grep =========="
ps aux | grep [s]leep

echo ""
echo "========== STEP 4: ใช้ top ดู Process (กด q เพื่อออก) =========="
top -n 1 -p $SLEEP_PID

echo ""
echo "========== STEP 5: ใช้ htop (ถ้ามี) =========="
command -v htop >/dev/null 2>&1 && htop -d 10 || echo "ยังไม่ได้ติดตั้ง htop"

echo ""
echo "========== STEP 6: ใช้ jobs/fg/bg =========="
jobs
bg %1 2>/dev/null || echo "ไม่มี job ที่ background อยู่"
fg %1 2>/dev/null || echo "ไม่มี job ที่ background อยู่"

echo ""
echo "========== STEP 7: ใช้ kill =========="
kill -STOP $SLEEP_PID
echo "หยุดชั่วคราว PID=$SLEEP_PID"
sleep 2
kill -CONT $SLEEP_PID
echo "ให้ทำงานต่อ PID=$SLEEP_PID"

echo ""
echo "========== STEP 8: ใช้ yes ทดสอบโหลด CPU =========="
yes > /dev/null &
YES_PID=$!
sleep 2
ps -p $YES_PID -o pid,ni,comm,%cpu,%mem
kill -9 $YES_PID
echo "หยุด yes (PID=$YES_PID)"

echo ""
echo "========== STEP 9: ใช้ nice =========="
nice -n 10 sleep 60 &
NICE_PID=$!
ps -p $NICE_PID -o pid,ni,comm
renice -n 15 -p $NICE_PID
ps -p $NICE_PID -o pid,ni,comm

echo ""
echo "========== STEP 10: ฆ่า process ที่ยังเหลือ =========="
kill -15 $SLEEP_PID 2>/dev/null
kill -15 $NICE_PID 2>/dev/null
echo "ลบ process ทั้งหมดแล้ว"

echo ""
echo "✅ Lab เสร็จสิ้น"
