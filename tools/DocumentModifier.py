#!/usr/bin/env python
#
# DocumentModifier.py (Python OpenDocument Modifier) v0.1 - 2008-04-29
#
# This script can insert blank pages into office documents which
# can be accessed by OpenOffice.org by connecting to an OpenOffice.org
# instance via Python-UNO bridge.
#
# Copyright (C) 2008 Lion Vollnhals <lion.vollnhals@googlemail.com>
# Licensed under the GNU LGPL v2.1 - http://www.gnu.org/licenses/lgpl.html
#
# Adapted from PyODConverter (Python OpenDocument Converter) v0.9.1
# (Copyright (C) 2008 Mirko Nasato <mirko@artofsolving.com>)

DEFAULT_OPENOFFICE_PORT = 8100

import uno
from os.path import abspath
from com.sun.star.beans import PropertyValue
from com.sun.star.connection import NoConnectException


def _unoProps(**args):
    props = []
    for key in args:
        prop = PropertyValue()
        prop.Name = key
        prop.Value = args[key]
        props.append(prop)
    return tuple(props)


class DocumentModifier:
    
    def __init__(self, port=DEFAULT_OPENOFFICE_PORT):
        localContext = uno.getComponentContext()
        resolver = localContext.ServiceManager.createInstanceWithContext("com.sun.star.bridge.UnoUrlResolver", localContext)
        context = resolver.resolve("uno:socket,host=localhost,port=%s;urp;StarOffice.ComponentContext" % port)
        self.desktop = context.ServiceManager.createInstanceWithContext("com.sun.star.frame.Desktop", context)

    def insertBlankPages(self, inputFile, outputFile, pageCount):
        inputUrl = self._fileUrl(inputFile)
        outputUrl = self._fileUrl(outputFile)

        document = self.desktop.loadComponentFromURL(inputUrl, "_blank", 0, _unoProps(Hidden=True, ReadOnly=True))
        try:
          document.refresh()
        except AttributeError:
          pass

	text = document.getText()
	cursor = text.createTextCursor()

	breakPageAfter = uno.getConstantByName("com.sun.star.style.BreakType.PAGE_AFTER")
	paragraphBreak = uno.getConstantByName("com.sun.star.text.ControlCharacter.PARAGRAPH_BREAK")

	for i in range(pageCount):
		cursor.setPropertyValue("BreakType", breakPageAfter)
		cursor.setPropertyValue("NumberingStyleName", "None")
		text.insertControlCharacter(cursor, paragraphBreak, False)
	
        document.storeToURL(outputUrl, _unoProps())
        document.close(True)

    def _fileUrl(self, path):
        return uno.systemPathToFileUrl(abspath(path))


if __name__ == "__main__":
    from sys import argv, exit
    
    if len(argv) < 4:
        print "USAGE: " + argv[0] + " <input-file> <output-file> <page-count>"
        exit(255)

    try:
	modifier = DocumentModifier()
	modifier.insertBlankPages(argv[1], argv[2], int(argv[3]))
    except NoConnectException:
        print "ERROR! Failed to connect to OpenOffice.org on port %s" % DEFAULT_OPENOFFICE_PORT
        exit(1)

