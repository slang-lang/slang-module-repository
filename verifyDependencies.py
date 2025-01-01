#!/usr/bin/python3

from packaging.version import Version, parse
import os
import json

def validate_dependencies(repository_path, index_file="index.json"):
    # Load the index.json
    index_path = os.path.join(repository_path, index_file)
    with open(index_path) as f:
        index = json.load(f)

    modules = {mod["name"]: mod for mod in index["modules"]}
    valid = True

    # Validate each module's dependencies
    for module in index["modules"]:
        config_path = os.path.join(repository_path, module["path"][1:])
        with open(config_path) as f:
            config = json.load(f)

        if "dependencies" in config:
            for dependency in config["dependencies"]:
                dep_name = dependency["module"]
                dep_min_version = dependency.get("version_min", "0.0.0")
                dep_max_version = dependency.get("version_max", None)

                # Find dependency in the index
                if dep_name in modules:
                    dep_versions = [
                        m for m in index["modules"]
                        if m["name"] == dep_name
                    ]
                    dep_versions.sort(
                        key=lambda x: Version(x["version"])
                    )  # Sort by version

                    # Check if there's a compatible version
                    compatible = False
                    for dep in dep_versions:
                        dep_version = Version(dep["version"])
                        if dep_version >= Version(dep_min_version) and (
                            not dep_max_version or dep_version <= Version(dep_max_version)
                        ):
                            compatible = True
                            break

                    if not compatible:
                        print(f"Error: {module['name']} depends on {dep_name} "
                              f"version {dep_min_version} to {dep_max_version}, but no compatible version found.")
                        valid = False
                else:
                    print(f"Error: {module['name']} depends on {dep_name}, which is not in the index.")
                    valid = False

    if valid:
        print("All dependencies are valid.")
    else:
        print("Some dependencies are invalid!")

# Example usage:
validate_dependencies("modules")

