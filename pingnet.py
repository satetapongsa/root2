#!/usr/bin/env python3

import requests
import time

def main():
    url = input("(pingnet web --> http://127.0.0.1:8000): ").strip()
    total_requests = int(input("ต้องการยิงกี่ครั้ง: ").strip())

    success = 0
    fail = 0
    start = time.time()

    print(f"\n start ping {url} all {total_requests} rool...\n")

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
