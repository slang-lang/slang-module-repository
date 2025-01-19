#!/usr/bin/python3

import os
import json
import shutil
import sys

def organize_files( sourceFolder, targetFolder ):
    """
    Moves files in the source folder into the specified folder structure.
    
    Args:
        sourceFolder ( str ): Path to the folder containing files to organize.
        targetFolder ( str ): Path to the root folder where files will be organized.
    """

    # Ensure the target folder exists
    os.makedirs( targetFolder, exist_ok=True )

    # Process each file in the source folder
    for filename in os.listdir( sourceFolder ):
        # Skip directories
        if not os.path.isfile( os.path.join( sourceFolder, filename ) ):
            continue

        # Parse the module name and version from the filename
        try:
            name, version_ext  = filename.split( "_", 1 )
            version, extension = version_ext.rsplit( ".", 1 )

            if extension == "gz":
                version, extension = version.rsplit( ".", 1 )
                extension += ".gz"
        except ValueError:
            print( f"Skipping invalid file: {filename}" )
            continue

        # Define the target folder structure
        moduleFolder = os.path.join( targetFolder, name, version )
        os.makedirs( moduleFolder, exist_ok=True )

        # Determine the target file name
        if extension == "json":
            targetFile = os.path.join( moduleFolder, "module.json" )
        else:
            targetFile = os.path.join( moduleFolder, f"module.{extension}" )

        # Move the file to the target location
        sourcePath = os.path.join( sourceFolder, filename )
        shutil.move( sourcePath, targetFile )
        print( f"Moved: {filename} -> {targetFile}" )

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

