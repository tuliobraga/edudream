require 'compass/import-once/activate'


http_path = "./assets"
css_dir = "assets/css"
sass_dir = "assets/scss"
font_dir = "assets/font"
images_dir = "assets/images"
javascripts_dir = "assets/js"

output_style = :nested
relative_assets = true 
line_comments = false
preferred_syntax = :scss

asset_cache_buster :none