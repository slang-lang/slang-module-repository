#!/usr/bin/python3

import os
import json

def get_latest_compatible_version(module_name, version_min, version_max=None, repository_path="repository", index_file="index.json"):
    # Load the index.json
    index_path = os.path.join(repository_path, index_file)
    with open(index_path) as f:
        index = json.load(f)

    # Find all versions of the module
    versions = [
        mod for mod in index["modules"] if mod["name_short"] == module_name
    ]

    # Sort by version (descending)
    versions.sort(key=lambda x: Version(x["version"]), reverse=True)

    # Find the latest compatible version
    for version in versions:
        ver = Version(version["version"])
        if ver >= Version(version_min) and (not version_max or ver <= Version(version_max)):
            return version  # Return the latest compatible version

    return None  # No compatible version found

# Example usage:
latest_version = get_latest_compatible_version(
    module_name="Slang",
    version_min="0.7.0",
    version_max="0.8.0",
    repository_path="modules"
)

if latest_version:
    print(f"Latest compatible version: {latest_version}")
else:
    print("No compatible version found.")

