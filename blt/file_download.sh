#!/bin/bash

# Define the paths
contrib_dir="docroot/modules/contrib"
custom_dir="custom/file_download"
link_name="file_download"
link_path="$contrib_dir/$link_name"

# Check if the symbolic link doesn't exist
if [ ! -L "$link_path" ]; then
    # Create the symbolic link
    (cd "$contrib_dir" && ln -s "../$custom_dir" "$link_name")
    echo "Symbolic link '$link_name' created in '$contrib_dir'."
else
    echo "Symbolic link '$link_name' already exists in '$contrib_dir'."
fi

