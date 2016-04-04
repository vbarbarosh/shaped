jQuery(function () {

    var ajax = null,
        cache = {
            search: {},
            fetch: {}
        },
        preview = jQuery('#gallery > div:nth-child(2)');

    function search(term, page, pageSize)
    {
        if (ajax) {
            ajax.abort();
            ajax = null;
        }

        return Promise.resolve(cache.search[term] ? cache.search[term] : ajax = jQuery.ajax(methodDraw.curConfig.searchUrl, {data: {lang: tt.lang, term: term}}))
            .then(function (searchResponse) {
                var offset = (page - 1) * pageSize;
                cache.search[term] = searchResponse;
                ajax = jQuery.ajax(methodDraw.curConfig.fetchUrl, {data: {icons: searchResponse.icons.slice(offset, offset + pageSize)}});
                return [searchResponse.icons.length, Promise.resolve(ajax)];
            })
            .spread(function (found, fetchResponse) {
                var key, fetched = [];
                for (key in fetchResponse) {
                    fetched.push(fetchResponse[key].defs[0]);
                    // fetched.push('<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 100 100">' + fetchResponse[key].defs[0] + '</svg>');
                }
                return [found, fetched];
            });
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
        el: '#gallery',
        data: {
            term: tt('animals'),
            searching: false,
            page: 1,
            pageSize: 1,
            found: 1,
            defs: []
        },
        methods: {
            tt: window.tt,
            insertIconIntoCanvas: function (svg) {
                var tmp = svgCanvas.getSvgString().split(/\s*<\/g>\s*<\/svg>\s*$/);
                if (tmp.length == 2) {
                    tmp[0] += svg;
                    svgCanvas.setSvgString(tmp.join('</g></svg>'));
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
            search: function (page) {
                var _this = this;
                this.searching += 1;
                search(this.term, this.page, this.pageSize)
                    .spread(function (found, fetched) {
                        _this.found = found;
                        _this.defs = fetched;
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
            }
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
