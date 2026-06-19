import concurrent.futures
import urllib.request
import time

URL = "http://dental-pro.local/wp-json/dentalpro/v1/available-slots?doctor_id=1&date=2026-06-20"
TOTAL_REQUESTS = 2000
CONCURRENCY = 50

def fetch(url):
    try:
        req = urllib.request.Request(url)
        with urllib.request.urlopen(req) as response:
            return response.status
    except urllib.error.HTTPError as e:
        return e.code
    except Exception as e:
        return "ERROR"

def main():
    print(f"Starting DDoS simulation on {URL} with {TOTAL_REQUESTS} requests...")
    start_time = time.time()
    
    status_counts = {}
    with concurrent.futures.ThreadPoolExecutor(max_workers=CONCURRENCY) as executor:
        futures = [executor.submit(fetch, URL) for _ in range(TOTAL_REQUESTS)]
        for future in concurrent.futures.as_completed(futures):
            status = future.result()
            status_counts[status] = status_counts.get(status, 0) + 1
            
    end_time = time.time()
    
    print(f"\n--- Simulation Results ---")
    print(f"Total Requests: {TOTAL_REQUESTS}")
    print(f"Time Taken: {end_time - start_time:.2f} seconds")
    print(f"Requests per second: {TOTAL_REQUESTS / (end_time - start_time):.2f}")
    print("\nResponse Status Codes:")
    for status, count in status_counts.items():
        if status == 403:
            print(f" - {status} Forbidden (Blocked by Nonce Security): {count}")
        elif status == 429:
            print(f" - {status} Too Many Requests (Blocked by Rate Limiter): {count}")
        elif status == 200:
            print(f" - {status} OK (Success): {count}")
        else:
            print(f" - {status}: {count}")

if __name__ == "__main__":
    main()
