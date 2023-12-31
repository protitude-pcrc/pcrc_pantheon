##
## This file is only needed for Compass/Sass integration. If you are not using
## Compass, you may safely ignore or delete this file.
##

# Default to development if environment is not set.
saved = environment
if (environment.nil?)
  environment = :development
else
  environment = saved
end

environment = :development
# Location of the theme's resources.
css_dir = "style/css"
sass_dir = "style/scss"
additional_import_paths = ["../../contrib/omega/omega/style/scss", "../../contrib/omega/omega/style/scss/grids"]
images_dir = "images"
generated_images_dir = images_dir + "/generated"
javascripts_dir = "js"

# Require any additional compass plugins installed on your system.
# require 'compass-normalize'
require 'sass-globbing'

##
## You probably don't need to edit anything below this.
##

# You can select your preferred output style here (:expanded, :nested, :compact
# or :compressed).
output_style = (environment == :production) ? :expanded : :nested

# To enable relative paths to assets via compass helper functions. Since Drupal
# themes can be installed in multiple locations, we don't need to worry about
# the absolute path to the theme from the server omega.
relative_assets = true

# Conditionally enable line comments when in development mode.
line_comments = (environment == :production) ? false : true

# Output debugging info in development mode. (Set to true to enable, false to disable)
# sass_options = (environment == :production) ? {} : {:debug_info => true}