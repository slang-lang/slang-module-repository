#!/usr/bin/python3

import os
import json
import shutil
import sys

def organize_files( source_folder, target_folder ):
    """
    Moves files in the source folder into the specified folder structure.
    
    Args:
        source_folder ( str ): Path to the folder containing files to organize.
        target_folder ( str ): Path to the root folder where files will be organized.
    """

    # Ensure the target folder exists
    os.makedirs( target_folder, exist_ok=True )

    # Process each file in the source folder
    for filename in os.listdir( source_folder ):
        # Skip directories
        if not os.path.isfile( os.path.join( source_folder, filename ) ):
            continue

        # Parse the module name and version from the filename
        try:
            name, version_ext = filename.split( "_", 1 )
            version, extension = version_ext.rsplit( ".", 1 )

            if extension == "gz":
                version, extension = version.rsplit( ".", 1 )
                extension += ".gz"
        except ValueError:
            print( f"Skipping invalid file: {filename}" )
            continue

        # Define the target folder structure
        module_folder = os.path.join( target_folder, name, version )
        os.makedirs( module_folder, exist_ok=True )

        # Determine the target file name
        if extension == "json":
            target_file = os.path.join( module_folder, "module.json" )
        else:
            target_file = os.path.join( module_folder, f"module.{extension}" )

        # Move the file to the target location
        source_path = os.path.join( source_folder, filename )
        shutil.move( source_path, target_file )
        print( f"Moved: {filename} -> {target_file}" )

    print( "File organization complete." )


if __name__ == "__main__":
    basePath = ""

    if len( sys.argv ) == 2:
        basePath = sys.argv[1] + "/"

    if len( sys.argv ) > 2:
        print( f"Invalid number of arguments provided! Expected 1 received {len( sys.argv ) - 1}" )
        exit( -1 )

    sourceFolder = basePath + "upload"
    targetFolder = basePath + "modules"

    organize_files( sourceFolder, targetFolder )

