#!/usr/bin/python3

import os
import json

def generate_index(repository_path):
    index = {"modules": []}

    for module_name in os.listdir(repository_path):
        module_path = os.path.join(repository_path, module_name)

        if os.path.isdir(module_path):
            for version in os.listdir(module_path):
                version_path = os.path.join(module_path, version)

                if os.path.isdir(version_path):
                    config_path = os.path.join(version_path, "module.json")

                    if os.path.exists(config_path):
                        with open(config_path) as f:
                            try:
                                config = json.load(f)
                            except:
                                print(f"Error: {config_path}")
                                continue

                        index["modules"].append({
                            "name": config["name_short"],
                            "name_full": config["name"],
                            "version": config["version"],
                            "path": f"/{module_name}/{version}/module.json"
                        })
    return index

# Generate and save the index.json
repository_path = "modules"
index = generate_index(repository_path)

with open(os.path.join(repository_path, "index.json"), "w") as f:
    json.dump(index, f, indent=2)

