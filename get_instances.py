import json
import requests
r = requests.get("https://searx.space/data/instances.json")
instances = r.json()["instances"]
print(json.dumps(list(instances)))
