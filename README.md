# colorswatch Plugin for DokuWiki

Display a color swatch of the given color.

![Screenshot](docs/screenshot_dokuwiki_colorswatch.png?raw=true "Screenshot")

A colorswatch can contain only a hexadecimal color code
    
    <colorswatch #FFFF00>

or a color code and a name

    <colorswatch #FFFF00:some_yellow>
    
The plugin only supports hexadecimal color codes (the ones starting with ``#``), no functions like ``rgb()`` or ``hsla()`` or keywords like ``lightgray`` or ``fuchsia``. In the plugin's settings, it's possible to choose between small, middle sized and large color swatches. That setting is global, changes get applied the next time the wiki page with the color swatches in them is saved.

All documentation for this plugin can be found at
https://github.com/hkockerbeck/dokuwiki_colorswatch

If you install this plugin manually, make sure it is installed in lib/plugins/colorswatch/ - if the folder is called different it will not work!

Please refer to http://www.dokuwiki.org/plugins for additional info on how to install plugins in DokuWiki.

# License 

Copyright (C) Henning Kockerbeck <henning.kockerbeck@isatis-online.de>

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; version 2 of the License

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

See the LICENSE file for details
