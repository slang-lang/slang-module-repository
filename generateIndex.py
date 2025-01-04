#!/usr/bin/python3

import os
import json

def generate_index( repository_path ):
    index = { "modules": [] }

    for module_name in sorted( os.listdir( repository_path ) ):
        module_path = os.path.join( repository_path, module_name )

        if os.path.isdir( module_path ):
            versions = os.listdir( module_path )

            # Filter to include only folders
            #versions = [ item for item in versions if os.path.isdir( os.path.join( module_path, item ) ) ]

            # Sort the folders alphabetically, reversed if specified
            versions.sort( reverse=True )

            for version in versions:
                version_path = os.path.join( module_path, version )

                if os.path.isdir( version_path ):
                    module_path = os.path.join(version_path, "module.json")

                    if os.path.exists( module_path ):
                        with open( module_path ) as f:
                            try:
                                module = json.load( f )
                            except:
                                print( f"Error: {module_path}" )
                                continue

                        index["modules"].append( {
                            "name": module["name_short"],
                            "name_full": module["name"],
                            "version": module["version"],
                            "path": f"/{module_name}/{version}/module.json"
                        } )
    return index

# Generate and save the index.json
repository_path = "modules"
index = generate_index( repository_path )

with open( os.path.join( repository_path, "index.json" ), "w" ) as f:
    json.dump( index, f, indent=2 )

