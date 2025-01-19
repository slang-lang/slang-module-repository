#!/usr/bin/python3

import hashlib
import json
import os
import shutil
import sys


def calculate_checksum(file_path, algorithm='sha256'):
    """
    Calculate the checksum of a file using a specified algorithm.

    :param file_path: Path to the file.
    :param algorithm: Hashing algorithm (default is 'sha256'). Options: 'md5', 'sha1', 'sha256', etc.
    :return: Checksum as a hexadecimal string.
    """
    try:
        # Create a hash object for the specified algorithm
        hash_func = hashlib.new(algorithm)
        
        # Read the file in chunks to handle large files efficiently
        with open(file_path, 'rb') as f:
            while chunk := f.read(8192):  # Read in 8KB chunks
                hash_func.update(chunk)
        
        # Return the hexadecimal checksum
        return hash_func.hexdigest()
    
    except FileNotFoundError:
        return f"Error: File '{file_path}' not found."
    except ValueError:
        return f"Error: Unsupported algorithm '{algorithm}'."


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
                    module_path = os.path.join( version_path, "module.json" )

                    if os.path.exists( module_path ):
                        with open( module_path ) as f:
                            try:
                                module = json.load( f )

                                if "checksum" not in module or not module[ "checksum" ]:
                                    module[ "checksum" ] = calculate_checksum( f"{version_path}/module.tar.gz" )

                                    #json.dump( module, f )
                            except:
                                print( f"Error: {module_path}" )
                                continue

                        index[ "modules" ].append( {
                            "name": module[ "name_short" ],
                            "version": module[ "version" ],
                            "checksum": module[ "checksum" ],
                            "name_full": module[ "name" ],
                            "path": f"/{module_name}/{version}/module.json"
                        } )
    return index

if __name__ == "__main__":
    basePath = ""

    if len( sys.argv ) == 2:
        basePath = sys.argv[1] + "/"

    if len( sys.argv ) > 2:
        print( f"Invalid number of arguments provided! Expected 1 received {len(sys.argv) - 1}" )
        exit( -1 )

    repositoryPath = basePath + "modules"

    # Generate and save the index.json
    index = generate_index( repositoryPath )

    with open( os.path.join( repositoryPath, "index.json" ), "w" ) as f:
        json.dump( index, f, indent=2 )

    shutil.copyfile( repositoryPath + "/index.json", repositoryPath + "/index.html" )

    print( "Index generation complete." )

