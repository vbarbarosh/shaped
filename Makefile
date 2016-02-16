# NAME=method-draw
# PACKAGE=$(NAME)
VERSION=$(shell git describe --tags --long | head -n1 | sed -r 's/^v([0-9]+)\.([0-9]+)-([0-9]+).*/\1.\2.\3/')
MAKEDOCS=naturaldocs/NaturalDocs
SHIP=bin/vendor/ship.py
CLOSURE=bin/vendor/closure-compiler.jar
YUICOMPRESSOR=bin/vendor/yuicompressor-2.4.7.jar

# All files that will be compiled by the Closure compiler.

JS_FILES=\
	lib/pathseg.js \
	lib/touch.js \
	lib/js-hotkeys/jquery.hotkeys.min.js \
	icons/jquery.svgicons.js \
	lib/jgraduate/jquery.jgraduate.js \
	lib/contextmenu/jquery.contextMenu.js \
	src/browser.js \
	src/svgtransformlist.js \
	src/math.js \
	src/units.js \
	src/svgutils.js \
	src/sanitize.js \
	src/history.js \
	src/select.js \
	src/draw.js \
	src/path.js \
	src/svgcanvas.js \
	src/method-draw.js \
	lib/jquery-draginput.js \
	lib/contextmenu.js \
	lib/jquery-ui/jquery-ui-1.8.17.custom.min.js \
	lib/jgraduate/jpicker.min.js \
	lib/mousewheel.js \
	extensions/ext-eyedropper.js \
	extensions/ext-grid.js \
	extensions/ext-shapes.js \
	lib/requestanimationframe.js \
	lib/taphold.js \
	lib/filesaver.js

CSS_FILES=\
	lib/jgraduate/css/jPicker.css \
	lib/jgraduate/css/jgraduate.css \
	css/method-draw.css \

JS_INPUT_FILES=$(addprefix src/, $(JS_FILES))
CSS_INPUT_FILES=$(addprefix src/, $(CSS_FILES))
JS_BUILD_FILES=$(addprefix build/, $(JS_FILES))
CSS_BUILD_FILES=$(addprefix build/, $(CSS_FILES))
CLOSURE_JS_ARGS=$(addprefix --js , $(JS_INPUT_FILES))
COMPILED_JS=build/method-draw.compiled.js
COMPILED_CSS=build/css/method-draw.compiled.css

all: release

release: build $(COMPILED_JS) $(COMPILED_CSS)

compile: $(COMPILED_JS) $(COMPILED_CSS)

# The build directory relies on the JS being compiled.
build:
	if test -x $(MAKEDOCS) ; then rm -rf config; mkdir config; $(MAKEDOCS) -i src/ -o html docs/ -p config/ -oft -r ; fi

	# Make build directory and copy all editor contents into it
	mkdir -p build
	cp -r src/* build/

	# Remove all hidden .svn directories
	-find build/ -name .svn -type d | xargs rm -rf {} \;
	-find build/ -name .git -type d | xargs rm -rf {} \;
	-find build -name __test\* -delete

	# Create the release version of the main HTML file.
	$(SHIP) --i=src/index.html --on=svg_edit_release > build/index.html

# NOTE: Some files are not ready for the Closure compiler: (jquery)
# NOTE: Our code safely compiles under SIMPLE_OPTIMIZATIONS
# NOTE: Our code is *not* ready for ADVANCED_OPTIMIZATIONS
# NOTE: WHITESPACE_ONLY and --formatting PRETTY_PRINT is helpful for debugging.

$(COMPILED_CSS): build
	cat $(CSS_INPUT_FILES) > temp.css
	java -jar $(YUICOMPRESSOR) temp.css -o $(COMPILED_CSS) --line-break 0
	rm temp.css

$(COMPILED_JS): build
	java -jar $(CLOSURE) \
		--compilation_level SIMPLE_OPTIMIZATIONS \
		$(CLOSURE_JS_ARGS) \
		--js_output_file $(COMPILED_JS)

clean:
	rm -rf config
	rm -rf build
	rm -rf $(COMPILED_JS)
	rm -rf $(COMPILED_CSS)
