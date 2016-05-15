<?php

$static = getenv('STATIC');
if (empty($static)) {
  $static = 'static';
}
$compiled_css = getenv('COMPILED_CSS');
$compiled_js = getenv('COMPILED_JS');

function e()
{
  echo implode('', array_filter(func_get_args(), 'htmlentities'));
}

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="chrome=1"/>
<link rel="icon" type="image/png" href="<?php e("$static/images/logo.png") ?>"/>

  <script type="text/javascript">
    function static_path(path) {
      return <?php echo json_encode("$static/") ?> + path;
    }
  </script>

<?php if ($compiled_css): ?>
  <link rel="stylesheet" href="<?php e($compiled_css) ?>" type="text/css"/>
<?php else: ?>
  <link rel="stylesheet" href="<?php e("$static/lib/jgraduate/css/jPicker.css") ?>" type="text/css"/>
  <link rel="stylesheet" href="<?php e("$static/lib/jgraduate/css/jgraduate.css") ?>" type="text/css"/>
  <link rel="stylesheet" href="<?php e("$static/lib/jgraduate/css/iconsflow.css") ?>" type="text/css"/>
  <link rel="stylesheet" href="<?php e("$static/css/method-draw.css") ?>" type="text/css"/>
  <link rel="stylesheet" href="<?php e("$static/css/fonts.css") ?>" type="text/css"/>
  <link rel="stylesheet" href="<?php e("$static/css/iconsflow.css") ?>" type="text/css"/>
  <link rel="stylesheet" href="<?php e("$static/css/grid.css") ?>" type="text/css"/>
  <link rel="stylesheet" href="<?php e("$static/css/spinner.css") ?>" type="text/css"/>
  <link rel="stylesheet" href="<?php e("$static/css/sm.css") ?>" type="text/css"/>
<?php endif ?>

  <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
  <meta name="apple-mobile-web-app-capable" content="yes"/>

  <script type="text/javascript" src="<?php e("$static/lib/jquery.js") ?>"></script>
  <script src="//cdn.jsdelivr.net/bluebird/3.3.4/bluebird.min.js" type="text/javascript"></script>
  <script src="//cdn.jsdelivr.net/vue/1.0.17/vue.min.js" type="text/javascript"></script>
<!--
  <script src="//vuejs.org/js/vue.js" type="text/javascript"></script>
-->

<?php if ($compiled_js): ?>
  <script type="text/javascript" src="<?php e($compiled_js) ?>"></script>
<?php else: ?>
  <script type="text/javascript" src="<?php e("$static/src/tt.js") ?>"></script>
  <script type="text/javascript" src="<?php e("$static/src/iconsflow.js") ?>"></script>
  <script type="text/javascript" src="<?php e("$static/lib/pathseg.js") ?>"></script>
  <script type="text/javascript" src="<?php e("$static/lib/touch.js") ?>"></script>
  <script type="text/javascript" src="<?php e("$static/lib/js-hotkeys/jquery.hotkeys.min.js") ?>"></script>
  <script type="text/javascript" src="<?php e("$static/icons/jquery.svgicons.js") ?>"></script>
  <script type="text/javascript" src="<?php e("$static/lib/jgraduate/jquery.jgraduate.js") ?>"></script>
  <script type="text/javascript" src="<?php e("$static/lib/contextmenu/jquery.contextMenu.js") ?>"></script>
  <script type="text/javascript" src="<?php e("$static/lib/jquery-ui/jquery-ui-1.8.17.custom.min.js") ?>"></script>
  <script type="text/javascript" src="<?php e("$static/src/browser.js") ?>"></script>
  <script type="text/javascript" src="<?php e("$static/src/svgtransformlist.js") ?>"></script>
  <script type="text/javascript" src="<?php e("$static/src/math.js") ?>"></script>
  <script type="text/javascript" src="<?php e("$static/src/units.js") ?>"></script>
  <script type="text/javascript" src="<?php e("$static/src/svgutils.js") ?>"></script>
  <script type="text/javascript" src="<?php e("$static/src/sanitize.js") ?>"></script>
  <script type="text/javascript" src="<?php e("$static/src/history.js") ?>"></script>
  <script type="text/javascript" src="<?php e("$static/src/select.js") ?>"></script>
  <script type="text/javascript" src="<?php e("$static/src/draw.js") ?>"></script>
  <script type="text/javascript" src="<?php e("$static/src/path.js") ?>"></script>
  <script type="text/javascript" src="<?php e("$static/src/dialog.js") ?>"></script>
  <script type="text/javascript" src="<?php e("$static/src/svgcanvas.js") ?>"></script>
  <script type="text/javascript" src="<?php e("$static/src/method-draw.js") ?>"></script>
  <script type="text/javascript" src="<?php e("$static/lib/jquery-draginput.js") ?>"></script>
  <script type="text/javascript" src="<?php e("$static/lib/contextmenu.js") ?>"></script>
  <script type="text/javascript" src="<?php e("$static/lib/jgraduate/jpicker.min.js") ?>"></script>
  <script type="text/javascript" src="<?php e("$static/lib/mousewheel.js") ?>"></script>
  <script type="text/javascript" src="<?php e("$static/extensions/ext-eyedropper.js") ?>"></script>
  <script type="text/javascript" src="<?php e("$static/extensions/ext-shapes.js") ?>"></script>
  <script type="text/javascript" src="<?php e("$static/extensions/ext-grid.js") ?>"></script>
  <script type="text/javascript" src="<?php e("$static/lib/requestanimationframe.js") ?>"></script>
  <script type="text/javascript" src="<?php e("$static/lib/taphold.js") ?>"></script>
  <script type="text/javascript" src="<?php e("$static/lib/filesaver.js") ?>"></script>
<?php endif ?>

<title>Method Draw</title>
</head>
<body>

<div v-show="true" style="display: none;" id="iconsflow">

  <!-- search box -->
  <div class="flex-cols abs-box w176 p3 border-box mg5" style="top: 36px;">
    <div class="rel ph5">
      <input v-on:keyup.enter="searchTerm" v-model="term" class="input pr28" type="text" placeholder="{{ tt('Search cliparts...') }}" />
      <a v-on:click="search" class="box16 abs" style="top: 5px; right: 15px;" href="#">
        <svg fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18">
          <path d="M12.65 11.6q1.6-1.9 1.6-4.45 0-2.95-2.1-5.05Q10.05 0 7.1 0q-2.95 0-5 2.1Q0 4.2 0 7.15q0 2.95 2.1 5 2.05 2.1 5 2.1 2.6 0 4.55-1.65l5.1 5.1q.6.6 1.05.05.45-.5-.05-1.05l-5.1-5.1m-1.5-8.5q1.7 1.65 1.7 4.05 0 2.35-1.7 4.05-1.7 1.65-4.05 1.65-2.35 0-4-1.65-1.7-1.7-1.7-4.05 0-2.4 1.7-4.05 1.65-1.7 4-1.7t4.05 1.7z"></path>
        </svg>
      </a>
    </div>
    <div class="flex-grow rel">
      <div class="abs-box flex-rows-center z1 no-pointer-events" v-bind:class="{o100: searching, o0: !searching, 'transition-opacity-1000ms': searching, 'transition-opacity-250ms': !searching}">
        <div class="spinner">
          <div class="dot1 bs10"></div>
          <div class="dot2 bs10"></div>
        </div>
      </div>
      <ul class="list-reset flex-rows flex-wrap" v-bind:class="{o100: !searching, o50: searching, 'transition-opacity-1000ms': searching, 'transition-opacity-250ms': !searching}">
        <li v-for="icon in icons" class="w50 m3">
          <a v-on:click="insertIconIntoCanvas(icon.defs[0])" href="#" class="expand-1-1 white br5">
            <img v-bind:src="icon.defs[0] | svgdef" class="abs-box-image p5" alt="" />
          </a>
        </li>
      </ul>
    </div>
    <div class="mig5 c">
      <a v-on:click="prev" class="button" href="#">
        <svg class="box p5 rel" style="right: 1px" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 67 100">
          <path d="M67 8.5q.2-3.35-2-5.85Q62.75.2 59.45 0q-3.3-.2-5.8 2L0 50l53.65 48q2.45 2.2 5.8 2 3.3-.15 5.55-2.65 2.2-2.45 2-5.8-.2-3.3-2.65-5.5L24.1 50l40.25-35.95q2.5-2.2 2.65-5.55z"></path>
        </svg>
      </a><!--
 --><input v-on:keyup.enter="searchPage" v-model="page" class="input w50" type="text" /><!--
 --><a v-on:click="next" class="button" href="#">
      <svg class="box p5 rel" style="left: 1px" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 67 100">
        <path d="M0 8.5q.15 3.35 2.65 5.55L42.9 50 2.65 86.05Q.2 88.25 0 91.55q-.2 3.35 2 5.8 2.25 2.5 5.55 2.65 3.35.2 5.8-2L67 50 13.35 2q-2.5-2.2-5.8-2Q4.25.2 2 2.65-.2 5.15 0 8.5z"></path>
      </svg>
    </a>
    </div>
  </div>

  <!-- font dialog -->
  <div id="iconsflow-dialog-font" class="abs z1" style="top: 70px; left: 330px; display: none;">
    <a v-on:click.prevent="hideFontDialog" href="#" class="abs fit30 t15n r15n">
      <img v-bind:src="static_path('iconsflow/icon-x.svg')" alt="Close" class="db fit" />
    </a>
    <span class="z1n abs fit30 t15n r15n br100p bs10"></span>
    <div class="white bs10 br5 p5 pb15">
      <h2 class="c fs16 xfw xm pt10">{{ tt('Choose a font:') }}</h2>
      <div v-for="row in chunk(fonts, 4)" class="flex-rows">
        <a v-for="font in row" v-on:click.prevent="search(font.term), hideFontDialog()" href="#" class="rel pv15 ph20">
          <img v-bind:src="font.img" alt="" class="fit50 db" />
          <span class="abs l0 r0 c color-black">
            {{ font.title }}
          </span>
        </a>
      </div>
    </div>
  </div>

</div>

<div id="svg_editor">
  <div id="rulers">
  <div id="ruler_corner"></div>
  <div id="ruler_x">
    <div id="ruler_x_cursor"></div>
    <div>
      <canvas height="15"></canvas>
    </div>
  </div>
  <div id="ruler_y">
    <div id="ruler_y_cursor"></div>
    <div>
      <canvas width="15"></canvas>
    </div>
  </div>
</div>

<div id="workarea">
<div id="svgcanvas" style="position:relative">

</div>
</div>

<div id="menu_bar">
  <div class="menu">
    <div class="menu_title cursor-auto">
      <img class="abs w35 t2 l7" src="<?php e("$static/iconsflow/logo.svg") ?>" alt="" />
    </div>
<!--
    <div class="menu_list">
      <div id="tool_about" class="menu_item">{{ tt('About this Editor...') }}</div>
      <div class="separator"></div>
      <div id="tool_about" class="menu_item">{{ tt('Keyboard Shortcuts...') }}</div>
    </div>
-->
  </div><!--
  no space should be here
  --><!--<div class="menu">
    <div class="menu_title">File</div>
    <div class="menu_list" id="file_menu"> 
      <div id="tool_clear" class="menu_item">{{ tt('New Document') }}</div>
      <div id="tool_open" class="menu_item" style="display: none;"><div id="fileinputs"></div>{{ tt('Open SVG...') }}</div>
      <div id="tool_import" class="menu_item" style="display: none;"><div id="fileinputs_import"></div>{{ tt('Import Image...') }}</div>
      <div id="tool_save" class="menu_item">{{ tt('Save Image... ') }}<span class="shortcut">⌘S</span></div>
      <div id="tool_export" class="menu_item">{{ tt('Export as PNG') }}</div>
    </div>
  </div>

  --><div class="menu">
    <div class="menu_title">{{ tt('Edit') }}</div>
    <div class="menu_list" id="edit_menu">
      <div class="menu_item" id="tool_undo">{{ tt('Undo') }}<span class="shortcut">⌘Z</span></div>
      <div class="menu_item" id="tool_redo">{{ tt('Redo') }}<span class="shortcut">⌘Y</span></div>
      <div class="separator"></div>
      <div class="menu_item action_selected disabled" id="tool_cut">{{ tt('Cut') }}<span class="shortcut">⌘X</span></div>
      <div class="menu_item action_selected disabled" id="tool_copy">{{ tt('Copy') }}<span class="shortcut">⌘C</span></div>
      <div class="menu_item action_selected disabled" id="tool_paste">{{ tt('Paste') }}<span class="shortcut">⌘V</span></div>
      <div class="menu_item action_selected disabled" id="tool_clone">{{ tt('Duplicate') }}<span class="shortcut">⌘D</span></div>
      <div class="menu_item action_selected disabled" id="tool_delete">{{ tt('Delete') }}<span>⌫</span></div>
    </div>
  </div>
  
  <div class="menu">
    <div class="menu_title">{{ tt('Object') }}</div>
    <div class="menu_list" id="object_menu">
      <div class="menu_item action_selected disabled" id="tool_move_top">{{ tt('Bring to Front') }}<span class="shortcut">⌘⇧↑</span></div>
      <div class="menu_item action_selected disabled" id="tool_move_up">{{ tt('Bring Forward') }}<span class="shortcut">⌘↑</span></div>
      <div class="menu_item action_selected disabled" id="tool_move_down">{{ tt('Send Backward') }}<span class="shortcut">⌘↓</span></div>
      <div class="menu_item action_selected disabled" id="tool_move_bottom">{{ tt('Send to Back') }}<span class="shortcut">⌘⇧↓</span></div>
      <div class="separator"></div>
      <div class="menu_item action_multi_selected disabled" id="tool_group">{{ tt('Group Elements') }}<span class="shortcut">⌘G</span></div>
      <div class="menu_item action_group_selected disabled" id="tool_ungroup">{{ tt('Ungroup Elements') }}<span class="shortcut">⌘⇧G</span></div>
      <div class="separator"></div>
      <div class="menu_item action_path_convert_selected disabled" id="tool_topath">{{ tt('Convert to Path') }}</div>
      <div class="menu_item action_path_selected disabled" id="tool_reorient">{{ tt('Reorient path') }}</div>
    </div>
  </div>
  <div class="menu">
    <div class="menu_title">{{ tt('View') }}</div>
    <div class="menu_list" id="view_menu">
<!--
        <div class="menu_item push_button_pressed" id="tool_rulers">{{ tt('View Rulers') }}</div>
-->
        <div class="menu_item" id="tool_wireframe">{{ tt('View Wireframe') }}</div>
<!--
        <div class="menu_item" id="tool_snap">{{ tt('Snap to Grid') }}</div>
-->
        <div class="separator"></div>
        <div class="menu_item" id="tool_source">{{ tt('Source...') }}<span class="shortcut">⌘U</span></div>
    </div>
  </div>

</div>

<div id="tools_top" class="tools_panel">

  <div id="canvas_panel" class="context_panel xd-force">
    
    <h4 class="clearfix">{{ tt('Canvas') }}</h4>
    
    <label data-title="{{ tt('Change canvas width') }}">
      <input size="3" id="canvas_width" type="text" pattern="[0-9]*" />
      <span class="icon_label">{{ tt('Width') }}</span>
    </label>
    <label data-title="{{ tt('Change canvas height') }}">
      <input id="canvas_height" size="3" type="text" pattern="[0-9]*" />
      <span class="icon_label">{{ tt('Height') }}</span>
    </label>
        
    
    <label data-title="{{ tt('Change canvas color') }}" class="draginput" style="display: none;">
      <span>{{ tt('Color') }}</span>
      <div id="color_canvas_tools">
        <div class="color_tool active" id="tool_canvas">
          <div class="color_block">
            <div id="canvas_bg"></div>
            <div id="canvas_color"></div>
          </div>
        </div>
      </div>
    </label>

    <div class="draginput">
      <span>{{ tt('Sizes') }}</span>
      <select id="resolution">
        <option id="selectedPredefined" selected="selected">{{ tt('Custom') }}</option>
        <option>640x480</option>
        <option>800x600</option>
        <option>1024x768</option>
        <option>1280x960</option>
        <option>1600x1200</option>
        <option id="fitToContent" value="content">{{ tt('Fit to Content') }}</option>
      </select>
      <div class="caret"></div>
      <label id="resolution_label">{{ tt('Custom') }}</label>
    </div>

  </div>
  
  <div id="rect_panel" class="context_panel">
    <h4 class="clearfix">{{ tt('Rectangle') }}</h4>
    <label>
      <input id="rect_x" class="attr_changer" data-title="{{ tt('Change X coordinate') }}" size="3" data-attr="x" pattern="[0-9]*" />
      <span>X</span>
    </label>
    <label>
      <input id="rect_y" class="attr_changer" data-title="{{ tt('Change Y coordinate') }}" size="3" data-attr="y" pattern="[0-9]*" />
      <span>Y</span> 
    </label>
    <label id="rect_width_tool attr_changer" data-title="{{ tt('Change rectangle width') }}">
      <input id="rect_width" class="attr_changer" size="3" data-attr="width" type="text" pattern="[0-9]*" />
      <span class="icon_label">{{ tt('Width') }}</span>
    </label>
    <label id="rect_height_tool" data-title="{{ tt('Change rectangle height') }}">
      <input id="rect_height" class="attr_changer" size="3" data-attr="height" type="text" pattern="[0-9]*" />
      <span class="icon_label">{{ tt('Height') }}</span>
    </label>
  </div>
  
  <div id="path_panel" class="context_panel clearfix">
    <h4 class="clearfix">{{ tt('Path') }}</h4>
    <label>
      <input id="path_x" class="attr_changer" data-title="{{ tt('Change ellipse\'s cx coordinate') }}" size="3" data-attr="x" pattern="[0-9]*" />
      <span>X</span>
    </label>
    <label>
      <input id="path_y" class="attr_changer" data-title="{{ tt('Change ellipse\'s cy coordinate') }}" size="3" data-attr="y" pattern="[0-9]*" />
      <span>Y</span>
    </label>
  </div>

  <div id="image_panel" class="context_panel clearfix">
  <h4>{{ tt('Image') }}</h4>
    <label>
      <input id="image_x" class="attr_changer" data-title="{{ tt('Change X coordinate') }}" size="3" data-attr="x"  pattern="[0-9]*"/>
      <span>X</span> 
    </label>
    <label>
      <input id="image_y" class="attr_changer" data-title="{{ tt('Change Y coordinate') }}" size="3" data-attr="y"  pattern="[0-9]*"/>
      <span>Y</span> 
    </label>
    <label>
      <input id="image_width" class="attr_changer" data-title="{{ tt('Change image width') }}" size="3" data-attr="width" pattern="[0-9]*" />
      <span class="icon_label">{{ tt('Width') }}</span>
    </label>
    <label>
      <input id="image_height" class="attr_changer" data-title="{{ tt('Change image height') }}" size="3" data-attr="height" pattern="[0-9]*" />
      <span class="icon_label">{{ tt('Height') }}</span>
    </label>
  </div>
  
  <div id="circle_panel" class="context_panel">
    <h4>{{ tt('Circle') }}</h4>
    <label id="tool_circle_cx">
      <span>{{ tt('Center X') }}</span>
      <input id="circle_cx" class="attr_changer" title="{{ tt('Change circle\'s cx coordinate') }}" size="3" data-attr="cx"/>
    </label>
    <label id="tool_circle_cy">
      <span>{{ tt('Center Y') }}</span>
      <input id="circle_cy" class="attr_changer" title="{{ tt('Change circle\'s cy coordinate') }}" size="3" data-attr="cy"/>
    </label>
    <label id="tool_circle_r">
      <span>{{ tt('Radius') }}</span>
      <input id="circle_r" class="attr_changer" title="{{ tt('Change circle\'s radius') }}" size="3" data-attr="r"/>
    </label>
  </div>

  <div id="ellipse_panel" class="context_panel clearfix">
    <h4>{{ tt('Ellipse') }}</h4>
    <label id="tool_ellipse_cx">
      <input id="ellipse_cx" class="attr_changer" data-title="{{ tt('Change ellipse\'s cx coordinate') }}" size="3" data-attr="cx" pattern="[0-9]*" />
      <span>X</span>
    </label>
    <label id="tool_ellipse_cy">
      <input id="ellipse_cy" class="attr_changer" data-title="{{ tt('Change ellipse\'s cy coordinate') }}" size="3" data-attr="cy" pattern="[0-9]*" />
      <span>Y</span>
    </label>
    <label id="tool_ellipse_rx">
      <input id="ellipse_rx" class="attr_changer" data-title="{{ tt('Change ellipse\'s x radius') }}" size="3" data-attr="rx" pattern="[0-9]*" />
      <span>{{ tt('Radius X') }}</span>
    </label>
    <label id="tool_ellipse_ry">
      <input id="ellipse_ry" class="attr_changer" data-title="{{ tt('Change ellipse\'s y radius') }}" size="3" data-attr="ry" pattern="[0-9]*" />
      <span>{{ tt('Radius Y') }}</span>
    </label>
  </div>

  <div id="line_panel" class="context_panel clearfix">
    <h4>{{ tt('Line') }}</h4>
    <label id="tool_line_x1">
      <input id="line_x1" class="attr_changer" data-title="{{ tt('Change line\'s starting x coordinate') }}" size="3" data-attr="x1" pattern="[0-9]*" />
      <span>{{ tt('Start X') }}</span>
    </label>
    <label id="tool_line_y1">
      <input id="line_y1" class="attr_changer" data-title="{{ tt('Change line\'s starting y coordinate') }}" size="3" data-attr="y1" pattern="[0-9]*" />
      <span>{{ tt('Start Y') }}</span>
    </label>
    <label id="tool_line_x2">
      <input id="line_x2" class="attr_changer" data-title="{{ tt('Change line\'s ending x coordinate') }}" size="3" data-attr="x2"   pattern="[0-9]*" />
      <span>{{ tt('End X') }}</span>
    </label>
    <label id="tool_line_y2">
      <input id="line_y2" class="attr_changer" data-title="{{ tt('Change line\'s ending y coordinate') }}" size="3" data-attr="y2"   pattern="[0-9]*" />
      <span>{{ tt('End Y') }}</span>
    </label>
  </div>

  <div id="text_panel" class="context_panel">
    <h4>{{ tt('Text') }}</h4>
    <label>
      <input id="text_x" class="attr_changer" data-title="{{ tt('Change text x coordinate') }}" size="3" data-attr="x" pattern="[0-9]*" />
      <span>X</span>
    </label>
    <label>
      <input id="text_y" class="attr_changer" data-title="{{ tt('Change text y coordinate') }}" size="3" data-attr="y" pattern="[0-9]*" />
      <span>Y</span>
    </label>
    
    <div class="toolset draginput select twocol" id="tool_font_family">
        <!-- Font family -->
      <span>{{ tt('Font') }}</span>
      <div id="preview_font" style="font-family: Helvetica, Arial, sans-serif;">{{ tt('Helvetica') }}</div>
      <div class="caret"></div>
      <input id="font_family" data-title="{{ tt('Change Font Family') }}" size="12" type="hidden" />
      <select id="font_family_dropdown">
          <option value="Arvo, sans-serif">{{ tt('Arvo') }}</option>
          <option value="'Courier New', Courier, monospace">{{ tt('Courier') }}</option>
          <option value="Euphoria, sans-serif">{{ tt('Euphoria') }}</option>
          <option value="Georgia, Times, 'Times New Roman', serif">{{ tt('Georgia') }}</option>
          <option value="Helvetica, Arial, sans-serif" selected="selected">{{ tt('Helvetica') }}</option>
          <option value="Junction, sans-serif">{{ tt('Junction') }}</option>
          <option value="'League Gothic', sans-serif">{{ tt('League Gothic') }}</option>
          <option value="Oswald, sans-serif">{{ tt('Oswald') }}</option>
          <option value="'Palatino Linotype', 'Book Antiqua', Palatino, serif">{{ tt('Palatino') }}</option>
          <option value="'Trebuchet MS', Gadget, sans-serif">{{ tt('Trebuchet') }}</option>
          <option value="'Shadows Into Light', serif">{{ tt('Shadows Into Light') }}</option>
          <option value="'Simonetta', serif">{{ tt('Simonetta') }}</option>
          <option value="'Times New Roman', Times, serif">{{ tt('Times') }}</option>
      </select>
      <div class="tool_button" id="tool_bold" data-title="{{ tt('Bold Text [B]') }}">B</div>
      <div class="tool_button" id="tool_italic" data-title="{{ tt('Italic Text [I]') }}">i</div>
    </div>

    <label id="tool_font_size" data-title="{{ tt('Change Font Size') }}">
      <input id="font_size" size="3" value="0" />
      <span id="font_sizeLabel" class="icon_label">{{ tt('Font Size') }}</span>
    </label>
    <!-- Not visible, but still used -->
    <input id="text" type="text" size="35"/>
  </div>

  <!-- formerly gsvg_panel -->
  <div id="container_panel" class="context_panel clearfix">
  </div>
  
  <div id="use_panel" class="context_panel clearfix">
    <div class="tool_button clearfix" id="tool_unlink_use" data-title="{{ tt('Break link to reference element (make unique)') }}">
      {{ tt('Break link reference') }}
    </div>
  </div>
  
  <div id="g_panel" class="context_panel clearfix">
    <h4>{{ tt('Group') }}</h4>
    <label>
      <input id="g_x" class="attr_changer" data-title="{{ tt('Change groups\'s x coordinate') }}" size="3" data-attr="x" pattern="[0-9]*" />
      <span>X</span>
    </label>
    <label>
      <input id="g_y" class="attr_changer" data-title="{{ tt('Change groups\'s y coordinate') }}" size="3" data-attr="y" pattern="[0-9]*" />
      <span>Y</span>
    </label>
  </div>
  
  <div id="path_node_panel" class="context_panel clearfix">
    <h4>{{ tt('Edit Path') }}</h4>

    <label id="tool_node_x">
      <input id="path_node_x" class="attr_changer" data-title="{{ tt('Change node\'s x coordinate') }}" size="3" data-attr="x" />
      <span>X</span>
    </label>
    <label id="tool_node_y">
      <input id="path_node_y" class="attr_changer" data-title="{{ tt('Change node\'s y coordinate') }}" size="3" data-attr="y" />
      <span>Y</span>
    </label>
    
    <div id="segment_type" class="draginput label">
      <span>{{ tt('Segment Type') }}</span>
      <select id="seg_type" data-title="{{ tt('Change Segment type') }}">
        <option id="straight_segments" selected="selected" value="4">{{ tt('Straight') }}</option>
        <option id="curve_segments" value="6">{{ tt('Curve') }}</option>
      </select>
      <div class="caret"></div>
      <label id="seg_type_label">{{ tt('Straight') }}</label>
    </div>
    
    <!--
    <label class="draginput checkbox" data-title="{{ tt('Link Control Points') }}">
      <span>{{ tt('Linked Control Points') }}</span>
      <div class="push_bottom"><input type="checkbox" id="tool_node_link" checked="checked" /></div>
    </label>
  -->
    
    <div class="clearfix"></div>
    <div class="tool_button" id="tool_node_clone" title="{{ tt('Adds a node') }}">{{ tt('Add Node') }}</div>
    <div class="tool_button" id="tool_node_delete" title="{{ tt('Delete Node') }}">{{ tt('Delete Node') }}</div>
    <div class="tool_button" id="tool_openclose_path" title="{{ tt('Open/close sub-path') }}">{{ tt('Open Path') }}</div>
    <!--<div class="tool_button" id="tool_add_subpath" title="{{ tt('Add sub-path') }}"></div>-->
  </div>
  
  <!-- Buttons when a single element is selected -->
  <div id="selected_panel" class="context_panel">

    <label id="tool_angle" data-title="{{ tt('Change rotation angle') }}" class="draginput">
      <input id="angle" class="attr_changer" size="2" value="0" data-attr="transform" data-min="-180" data-max="180" type="text"/>
      <span class="icon_label">{{ tt('Rotation') }}</span>
      <div id="tool_angle_indicator">
        <div id="tool_angle_indicator_cursor"></div>
      </div>
    </label>
    
      <label class="toolset" id="tool_opacity" data-title="{{ tt('Change selected item opacity') }}">
        <input id="group_opacity" class="attr_changer" data-attr="opacity" data-multiplier="0.01" size="3" value="100" step="5" min="0" max="100" />
        <span id="group_opacityLabel" class="icon_label">{{ tt('Opacity') }}</span>
      </label>
    
    <div class="toolset" id="tool_blur" data-title="{{ tt('Change gaussian blur value') }}">
      <label>
        <input id="blur" size="2" value="0" step=".1"  min="0" max="10" />
        <span class="icon_label">{{ tt('Blur') }}</span>
      </label>
    </div>
    
    <label id="cornerRadiusLabel" data-title="{{ tt('Change Rectangle Corner Radius') }}">
      <input id="rect_rx" size="3" value="0" data-attr="rx" class="attr_changer" type="text" pattern="[0-9]*" />
      <span class="icon_label">{{ tt('Roundness') }}</span>
    </label>
    
    <div class="clearfix"></div>
    <div id="align_tools">
      <h4>{{ tt('Align') }}</h4>
      <div class="toolset align_buttons" id="tool_position">
          <label>
            <div class="col last clear" id="position_opts">
              <div class="draginput_cell" id="tool_posleft" title="{{ tt('Align Left') }}"></div>
              <div class="draginput_cell" id="tool_poscenter" title="{{ tt('Align Center') }}"></div>
              <div class="draginput_cell" id="tool_posright" title="{{ tt('Align Right') }}"></div>
              <div class="draginput_cell" id="tool_postop" title="{{ tt('Align Top') }}"></div>
              <div class="draginput_cell" id="tool_posmiddle" title="{{ tt('Align Middle') }}"></div>
              <div class="draginput_cell" id="tool_posbottom" title="{{ tt('Align Bottom') }}"></div>
            </div>
          </label>
      </div>    
    </div>
  </div>
  
  <!-- Buttons when multiple elements are selected -->
  <div id="multiselected_panel" class="context_panel clearfix">
    <h4 class="hidable">{{ tt('Multiple Elements') }}</h4>
    
    <div class="toolset align_buttons" style="position: relative">
      <label id="tool_align_relative" style="margin-top: 10px;"> 
        <select id="align_relative_to" title="{{ tt('Align relative to ...') }}">
        <option id="selected_objects" value="selected">{{ tt('Align to objects') }}</option>
        <option id="page" value="page">{{ tt('Align to page') }}</option>
        </select>
      </label>
      <h4>.</h4>
        <div class="col last clear">
          <div class="draginput_cell" id="tool_alignleft" title="{{ tt('Align Left') }}"></div>
          <div class="draginput_cell" id="tool_aligncenter" title="{{ tt('Align Center') }}"></div>
          <div class="draginput_cell" id="tool_alignright" title="{{ tt('Align Right') }}"></div>
          <div class="draginput_cell" id="tool_aligntop" title="{{ tt('Align Top') }}"></div>
          <div class="draginput_cell" id="tool_alignmiddle" title="{{ tt('Align Middle') }}"></div>
          <div class="draginput_cell" id="tool_alignbottom" title="{{ tt('Align Bottom') }}"></div>
        </div>
    </div>
    <div class="clearfix"></div>

  </div>
  
  <div id="stroke_panel" class="context_panel clearfix">
    <div class="clearfix"></div>
    <h4>{{ tt('Stroke') }}</h4>
    <div class="toolset" data-title="{{ tt('Change stroke') }}">
      <label>
        <input id="stroke_width" size="2" value="5" data-attr="stroke-width" min="0" max="99" step="1" />
        <span class="icon_label">{{ tt('Stroke Width') }}</span>
      </label>
    </div>
    <div class="stroke_tool draginput"> 
      <span>{{ tt('Stroke Dash') }}</span>
      <select id="stroke_style" data-title="{{ tt('Change stroke dash style') }}">
        <option selected="selected" value="none">—</option>
        <option value="2,2">···</option>
        <option value="5,5">- -</option>
        <option value="5,2,2,2">-·-</option>
        <option value="5,2,2,2,2,2">-··-</option>
      </select>
      <div class="caret"></div>
      <label id="stroke_style_label">—</label>
    </div>
    
    <label style="display: none;">
      <span class="icon_label">{{ tt('Stroke Join') }}</span>
    </label>
    
    <label  style="display: none;">
      <span class="icon_label">{{ tt('Stroke Cap') }}</span>
    </label>
  </div>

</div> <!-- tools_top -->
  <div id="cur_context_panel">
    
  </div>


<div id="tools_left" class="tools_panel"><!--
--><div class="tool_button" id="tool_select" title="{{ tt('Select Tool [V]') }}"></div><!--
--><div class="tool_button" id="tool_fhpath" title="{{ tt('Pencil Tool [P]') }}"></div><!--
--><div class="tool_button" id="tool_line" title="{{ tt('Line Tool [L]') }}"></div><!--
--><div class="tool_button" id="tool_rect" title="{{ tt('Square/Rect Tool [R]') }}"></div><!--
--><div class="tool_button" id="tool_ellipse" title="{{ tt('Ellipse/Circle Tool [C]') }}"></div><!--
--><div class="tool_button" id="tool_path" title="{{ tt('Path Tool [P]') }}"></div><!--
--><div class="tool_button" id="tool_text" title="{{ tt('Text Tool [T]') }}"></div><!--
--><div class="tool_button" id="tool_zoom" title="{{ tt('Zoom Tool [Z]') }}"></div><!--
--><div class="tool_button" id="tool_font_letter" title="{{ tt('Letter [F]') }}"></div><!--
--><div id="color_tools">
        <div id="tool_switch" title="{{ tt('Switch stroke and fill colors [X]') }}"></div>
        <div class="color_tool active" id="tool_fill">
          <label class="icon_label" title="{{ tt('Change fill color') }}"></label>
          <div class="color_block">
            <div id="fill_bg"></div>
            <div id="fill_color" class="color_block"></div>
          </div>
        </div>

        <div class="color_tool" id="tool_stroke">
            <label class="icon_label" title="{{ tt('Change stroke color') }}"></label>
          <div class="color_block">
            <div id="stroke_bg"></div>
            <div id="stroke_color" class="color_block" title="{{ tt('Change stroke color') }}"></div>
          </div>
        </div>
   </div><!--
--><div id="tool_undo2" class="tool_button">
      <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="white" viewBox="0 0 18 18">
        <path d="M10.95 6.55q2.3 0 3.95 1.65 1.65 1.65 1.65 4v4.85q0 .95.75.95.7 0 .7-.95V12.2q0-2.9-2.1-5-2.05-2.05-4.95-2.05h-8.7L4.9 1.2Q5.3.55 4.75.15t-1 .2L0 6.1l3.75 5.7q.45.6 1 .2.55-.4.15-1L1.95 6.55h9z"></path>
      </svg>
   </div><!--
--><div id="tool_redo2" class="tool_button">
      <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="white" viewBox="0 0 18 18">
        <path d="M16 6.55L13.1 11q-.4.6.15 1t1-.2q.55-.75 3.75-5.7-3.2-4.95-3.75-5.75-.45-.6-1-.2-.55.4-.15 1.05l2.6 3.95H7q-2.9 0-4.95 2.05Q0 9.3 0 12.2v4.85q0 .95.7.95t.7-.95V12.2q0-2.35 1.65-4T7 6.55h9z"></path>
      </svg>
   </div>
</div>

<div id="tools_bottom" class="tools_panel">

    <!-- Zoom buttons -->
  <div id="zoom_panel" class="toolset" title="{{ tt('Change zoom level') }}">
    <div class="draginput select" id="zoom_label">
      <span  id="zoomLabel" class="zoom_tool icon_label"></span>
      <select id="zoom_select">
        <option value="6">6%</option>
        <option value="12">12%</option>
        <option value="16">16%</option>
        <option value="25">25%</option>
        <option value="50">50%</option>
        <option value="75">75%</option>
        <option value="100"  selected="selected">100%</option>
        <option value="150">150%</option>
        <option value="200">200%</option>
        <option value="300">300%</option>
        <option value="400">400%</option>
        <option value="600">600%</option>
        <option value="800">800%</option>
        <option value="1600">1600%</option>
      </select>
      <div class="caret"></div>
      <input id="zoom" size="3" value="100%" type="text" readonly="readonly" />
    </div>
  </div>

  <div id="tools_bottom_3">
    <div id="palette" title="{{ tt('Click to change fill color, shift-click to change stroke color') }}"></div>
  </div>
</div>

<!-- hidden divs -->
<div id="color_picker"></div>

  <div id="svg_source_editor">
    <div id="svg_source_overlay"></div>
    <div id="svg_source_container">
      <div id="save_output_btns">
        <p id="copy_save_note">{{ tt('Copy the contents of this box into a text editor, then save the file with a .svg extension.') }}</p>
        <button id="copy_save_done">{{ tt('Done') }}</button>
      </div>
      <form>
        <textarea id="svg_source_textarea" spellcheck="false"></textarea>
      </form>
      <div id="tool_source_back" class="toolbar_button">
        <button id="tool_source_cancel" class="cancel">{{ tt('Cancel') }}</button>
        <button id="tool_source_save" class="ok">{{ tt('Apply Changes') }}</button>
      </div>
    </div>
  </div>

  <div id="base_unit_container">
    <select id="base_unit">
      <option value="px">{{ tt('Pixels') }}</option>
      <option value="cm">{{ tt('Centimeters') }}</option>
      <option value="mm">{{ tt('Millimeters') }}</option>
      <option value="in">{{ tt('Inches') }}</option>
      <option value="pt">{{ tt('Points') }}</option>
      <option value="pc">{{ tt('Picas') }}</option>
      <option value="em">{{ tt('Ems') }}</option>
      <option value="ex">{{ tt('Exs') }}</option>
    </select>
  </div>

  <div id="dialog_box">
    <div id="dialog_box_overlay"></div>
    <div id="dialog_container">
      <div id="dialog_content"></div>
      <div id="dialog_buttons"></div>
    </div>
  </div>

  <ul id="cmenu_canvas" class="contextMenu">
    <li><a href="#cut">{{ tt('Cut') }}<span class="shortcut">⌘X;</span></a></li>
    <li><a href="#copy">{{ tt('Copy') }}<span class="shortcut">⌘C</span></a></li>
    <li><a href="#paste">{{ tt('Paste') }}<span class="shortcut">⌘V</span></a></li>
    <li class="separator"><a href="#delete">{{ tt('Delete') }}<span class="shortcut">⌫</span></a></li>
    <li class="separator"><a href="#group">{{ tt('Group') }}<span class="shortcut">⌘G</span></a></li>
    <li><a href="#ungroup">{{ tt('Ungroup') }}<span class="shortcut">⌘⇧G</span></a></li>
    <li class="separator"><a href="#move_front">{{ tt('Bring to Front') }}<span class="shortcut">⌘⇧↑</span></a></li>
    <li><a href="#move_up">{{ tt('Bring Forward') }}<span class="shortcut">⌘↑</span></a></li>
    <li><a href="#move_down">{{ tt('Send Backward') }}<span class="shortcut">⌘↓</span></a></li>
    <li><a href="#move_back">{{ tt('Send to Back') }}<span class="shortcut">⌘⇧↓</span></a></li>
  </ul>

</div> <!-- svg_editor -->

</body>
</html>
