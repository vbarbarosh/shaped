jQuery(function () {

    var ajax = null,
        preview = jQuery('#iconsflow > div > div:nth-child(2)');

    function hideFontDialog()
    {
        jQuery('#tool_select').click();
        jQuery('#iconsflow-dialog-font').hide();
    }

    function search(term, page, pageSize)
    {
        if (ajax) {
            ajax.abort();
            ajax = null;
        }

        ajax = jQuery.ajax(methodDraw.curConfig.searchUrl, {data: {lang: tt.lang, term: term, page: page, limit: pageSize}});
        return Promise.resolve(ajax);
    }

    function chunk(array, chunkSize)
    {
        var i, end, ret = [];
        for (i = 0, end = array.length; i < end; i += chunkSize) {
            ret.push(array.slice(i, i + chunkSize));
        }
        return ret;
    }

    Vue.filter('svgdef', function (def) {
        var svg = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 100 100">' + def + '</svg>';
        // IE doesn't work with this
        // return 'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 100 100">' + def + '</svg>';
        // return 'data:image/svg+xml;base64,' + btoa(svg);
        return 'data:image/svg+xml;base64,' + svgedit.utilities.encode64(svg);
    });

    // Just for translation
    new Vue({
        el: '#svg_editor',
        methods: {
            tt: window.tt
        }
    });

    new Vue({
        el: '#iconsflow',
        data: {
            // Each time new icon was added into the canvas
            // its credits will be merged with this array
            credits: [],
            term: tt('outlined'),
            searching: false,
            page: 1,
            pageSize: 1,
            found: 1,
            icons: [],
            fonts: [
                {
                    img: static_path('iconsflow/font-dialog/font-preview-opensans.png'),
                    term: 'opensans',
                    title: 'Open Sans'
                },
                {
                    img: static_path('iconsflow/font-dialog/font-preview-noteworthy.png'),
                    term: 'noteworthy',
                    title: 'Noteworthy'
                },
                {
                    img: static_path('iconsflow/font-dialog/font-preview-roboto.png'),
                    term: 'roboto',
                    title: 'Roboto'
                },
                {
                    img: static_path('iconsflow/font-dialog/font-preview-raleway.png'),
                    term: 'raleway',
                    title: 'Raleway'
                },
                {
                    img: static_path('iconsflow/font-dialog/font-preview-orbitron.png'),
                    term: 'orbitron',
                    title: 'Orbitron'
                },
                {
                    img: static_path('iconsflow/font-dialog/font-preview-slurry.png'),
                    term: 'slurry',
                    title: 'Slurry'
                },
                {
                    img: static_path('iconsflow/font-dialog/font-preview-fjallaone.png'),
                    term: 'fjallaone',
                    title: 'Fjalla One'
                },
                {
                    img: static_path('iconsflow/font-dialog/font-preview-pinyonscript.png'),
                    term: 'pinyonscript',
                    title: 'Pinyon Script'
                },
                {
                    img: static_path('iconsflow/font-dialog/font-preview-kaushanscript.png'),
                    term: 'kaushanscript',
                    title: 'Kaushan Script'
                },
                {
                    img: static_path('iconsflow/font-dialog/font-preview-lekton.png'),
                    term: 'lekton',
                    title: 'Lekton'
                },
                {
                    img: static_path('iconsflow/font-dialog/font-preview-montez.png'),
                    term: 'montez',
                    title: 'Montez'
                },
                {
                    img: static_path('iconsflow/font-dialog/font-preview-monoton.png'),
                    term: 'monoton',
                    title: 'Monoton'
                }
            ]
        },
        methods: {
            tt: window.tt,
            chunk: chunk,
            static_path: static_path,
            insertIconIntoCanvas: function (svgdef, credits) {
                var tmp = svgCanvas.getSvgString().split(/\s*<\/g>\s*<\/svg>\s*$/);
                if (tmp.length == 2) {
                    this.appendCredits(credits);
                    tmp[0] += svgdef;
                    svgCanvas.setSvgString(tmp.join('</g></svg>'));
                }
            },
            appendCredits: function (credits) {
                var s, i, end;
                for (i = 0, end = credits.length; i < end; ++i) {
                    s = credits[i];
                    if (this.credits.indexOf(s) === -1) {
                        this.credits.push(s);
                    }
                }
            },
            refreshPageSize: function () {
                var pageSize = Math.max(1, Math.floor(preview.height() / (preview.width() / 3))) * 3;
                if (this.pageSize != pageSize) {
                    this.pageSize = pageSize;
                    this.page = 1;
                    this.search();
                }
            },
            prev: function () {
                if (this.page > 1) {
                    this.page = parseInt(this.page, 10) - 1;
                }
                this.search();
            },
            next: function () {
                var last = Math.ceil(this.found / this.pageSize);
                if (this.page + 1 <= last) {
                    this.page = parseInt(this.page, 10) + 1;
                }
                this.search();
            },
            searchTerm: function () {
                this.page = 1;
                this.found = 0;
                this.search();
            },
            searchPage: function () {
                this.page = Math.max(1, Math.min(Math.ceil(this.found/this.pageSize), this.page));
                this.search();
            },
            search: function (term) {
                var _this = this;
                if (typeof term !== 'undefined') {
                    this.term = term;
                }
                this.searching += 1;
                search(this.term, this.page, this.pageSize)
                    .then(function (response) {
                        _this.found = response.rows;
                        _this.icons = response.data;
                    })
                    // catch -> caught: because of js compiler in Makefile
                    .caught(function (error) {
                        // Ignore ajax.abort() calls
                        if (error.statusText != 'abort') {
                            console.error(error);
                        }
                    })
                    // finally -> lastly: because of js compiler in Makefile
                    .lastly(function () {
                        _this.searching -= 1;
                    });
            },
            hideFontDialog: hideFontDialog
        },
        ready: function () {
            this.refreshPageSize();
            jQuery(window).on('resize', this.refreshPageSize.bind(this));
        },
        beforeDestroy: function () {
            // jQuery(window).off('resize', ...);
        }
    });

});
