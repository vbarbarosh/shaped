# NAME=method-draw
# PACKAGE=$(NAME)
VERSION=$(shell git describe --tags --long | head -n1 | sed -r 's/^v([0-9]+)\.([0-9]+)-([0-9]+).*/\1.\2.\3/')
MAKEDOCS=naturaldocs/NaturalDocs
SHIP=bin/vendor/ship.py
CLOSURE=bin/vendor/closure-compiler.jar
YUICOMPRESSOR=bin/vendor/yuicompressor-2.4.7.jar

# All files that will be compiled by the Closure compiler.

JS_FILES=\
	static/src/tt.js \
	static/lib/pathseg.js \
	static/lib/touch.js \
	static/lib/js-hotkeys/jquery.hotkeys.min.js \
	static/icons/jquery.svgicons.js \
	static/lib/jgraduate/jquery.jgraduate.js \
	static/lib/contextmenu/jquery.contextMenu.js \
	static/src/browser.js \
	static/src/svgtransformlist.js \
	static/src/math.js \
	static/src/units.js \
	static/src/svgutils.js \
	static/src/sanitize.js \
	static/src/history.js \
	static/src/select.js \
	static/src/draw.js \
	static/src/path.js \
	static/src/svgcanvas.js \
	static/src/method-draw.js \
	static/lib/jquery-draginput.js \
	static/lib/contextmenu.js \
	static/lib/jquery-ui/jquery-ui-1.8.17.custom.min.js \
	static/lib/jgraduate/jpicker.min.js \
	static/lib/mousewheel.js \
	static/extensions/ext-eyedropper.js \
	static/extensions/ext-grid.js \
	static/extensions/ext-shapes.js \
	static/lib/requestanimationframe.js \
	static/lib/taphold.js \
	static/lib/filesaver.js \
	static/src/iconsflow.js

CSS_FILES=\
	static/lib/jgraduate/css/jPicker.css \
	static/lib/jgraduate/css/jgraduate.css \
	static/lib/jgraduate/css/iconsflow.css \
	static/css/method-draw.css \
	static/css/iconsflow.css \
	static/css/grid.css \
	static/css/spinner.css \
	static/css/sm.css

JS_INPUT_FILES=$(addprefix src/, $(JS_FILES))
CSS_INPUT_FILES=$(addprefix src/, $(CSS_FILES))
JS_BUILD_FILES=$(addprefix build/, $(JS_FILES))
CSS_BUILD_FILES=$(addprefix build/, $(CSS_FILES))
CLOSURE_JS_ARGS=$(addprefix --js , $(JS_INPUT_FILES))
STATIC_DIR=static/$(VERSION)
STATIC_PATH=build/$(STATIC_DIR)
COMPILED_JS_RELATIVE=$(STATIC_DIR)/method-draw.compiled.js
COMPILED_CSS_RELATIVE=$(STATIC_DIR)/css/method-draw.compiled.css
COMPILED_JS=build/$(COMPILED_JS_RELATIVE)
COMPILED_CSS=build/$(COMPILED_CSS_RELATIVE)

all: release

release: build $(COMPILED_JS) $(COMPILED_CSS)

compile: $(COMPILED_JS) $(COMPILED_CSS)

# The build directory relies on the JS being compiled.
build:
	if test -x $(MAKEDOCS) ; then rm -rf config; mkdir config; $(MAKEDOCS) -i src/ -o html docs/ -p config/ -oft -r ; fi

	# Make build directory and copy all editor contents into it
	mkdir -p build
	mkdir -p $(STATIC_PATH)
	cp -r src/static/* $(STATIC_PATH)
	rm $(STATIC_PATH)/css/sm.css
	rm $(STATIC_PATH)/css/iconsflow.css
	rm $(STATIC_PATH)/css/method-draw.css
	# Are necessary for embedapi.js
	# rm -r $(STATIC_PATH)/src

	# Remove all hidden .svn directories
	-find build/ -name .svn -type d | xargs rm -rf {} \;
	-find build/ -name .git -type d | xargs rm -rf {} \;
	-find build -name __test\* -delete

	# Create the release version of the main HTML file.
	STATIC=$(STATIC_DIR) \
	    COMPILED_JS=$(COMPILED_JS_RELATIVE) \
	    COMPILED_CSS=$(COMPILED_CSS_RELATIVE) \
	    php src/index.php > build/index.html

	sed 's:koo5ahgiechokie4Ohga:$(STATIC_DIR):' src/embedapi.php > build/embedapi.php

	# $(SHIP) --i=src/index.html --on=svg_edit_release > build/index.html
	# sed -i 's:static/css/method-draw.compiled.css:&?v$(VERSION):' build/index.html
	# sed -i 's:static/method-draw.compiled.js:&?v$(VERSION):' build/index.html

# NOTE: Some files are not ready for the Closure compiler: (jquery)
# NOTE: Our code safely compiles under SIMPLE_OPTIMIZATIONS
# NOTE: Our code is *not* ready for ADVANCED_OPTIMIZATIONS
# NOTE: WHITESPACE_ONLY and --formatting PRETTY_PRINT is helpful for debugging.

$(COMPILED_CSS): build
	cat $(CSS_INPUT_FILES) > temp.css
	java -jar $(YUICOMPRESSOR) temp.css -o $(COMPILED_CSS) --line-break 0
	rm temp.css

$(COMPILED_JS): build
#	java -jar $(CLOSURE) \
#		--compilation_level SIMPLE_OPTIMIZATIONS \
#		$(CLOSURE_JS_ARGS) \
#		--js_output_file $(COMPILED_JS)
	cat $(JS_INPUT_FILES) > $(COMPILED_JS)

clean:
	rm -rf config
	rm -rf build
	rm -rf $(COMPILED_JS)
	rm -rf $(COMPILED_CSS)
