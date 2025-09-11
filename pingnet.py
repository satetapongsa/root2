#!/usr/bin/env python3
# interactive_stress_test.py
import requests
import time

def main():
    url = input("ใส่ลิงก์เว็บที่ต้องการทดสอบ (เช่น http://127.0.0.1:8000): ").strip()
    total_requests = int(input("ต้องการยิงกี่ครั้ง: ").strip())

    success = 0
    fail = 0
    start = time.time()

    print(f"\nเริ่มยิงเว็บ {url} ทั้งหมด {total_requests} ครั้ง...\n")

    for i in range(total_requests):
        try:
            r = requests.get(url, timeout=5)
            print(f"[{i+1}] {r.status_code}")
            success += 1
        except Exception as e:
            print(f"[{i+1}] ERROR {e}")
            fail += 1

    elapsed = time.time() - start
    print("\n==== SUMMARY ====")
    print(f"Success: {success}")
    print(f"Fail: {fail}")
    print(f"Total time: {elapsed:.2f} sec")
    print(f"Requests per second: {total_requests/elapsed:.2f} req/s")

if __name__ == "__main__":
    main()
