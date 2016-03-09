jQuery(function () {

    var searchUrl = '//search.iconsflow.com/search',
        fetchUrl = '//localhost/iconmaker/src/backend/fetch-iconsflow.php',
        ajax = null,
        cache = {
            search: {},
            fetch: {}
        },
        preview = jQuery('#gallery > div:nth-child(2)');

    Vue.filter('svgInline', function (svg) {
        return 'data:image/svg+xml,' + svg;
    });

    new Vue({
        el: '#gallery',
        data: {
            term: 'animal',
            page: 1,
            pageSize: 1,
            icons: []
        },
        computed: {
            searching: function () {
                return ajax !== null;
            }
        },
        methods: {
            prev: function () {
                if (this.page > 1) {
                    this.page -= 1;
                }
            },
            next: function () {
                if ((this.page + 1) * this.pageSize < this.allIcons.length) {
                    this.page += 1;
                }
            },
            refreshPageSize: function () {
                var pageSize = Math.floor(preview.height() / (preview.width() / 3))*3;
                if (this.pageSize != pageSize) {
                    this.pageSize = pageSize;
                    this.page = 1;
                }
            },
            search: function () {
                var term = this.term,
                    _this = this;
                if (ajax) {
                    ajax.abort();
                    ajax = null;
                }
                Promise.resolve(cache.search[term] ? cache.search[term] : ajax = jQuery.ajax(searchUrl, {data: {term: term}}))
                    .then(function (searchResponse) {
                        cache.search[term] = searchResponse;
                        return Promise.resolve(ajax = jQuery.ajax(fetchUrl, {data: {icons: searchResponse.icons.slice(0, 10)}}));
                    })
                    .then(function (fetchResponse) {
                        var key, icons = [];
                        for (key in fetchResponse) {
                            icons.push('<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 100 100">' + fetchResponse[key].defs[0] + '</svg>');
                        }
                        _this.icons = icons;
                    })
                    .catch(function (error) {
                        // Ignore ajax.abort() calls
                        if (error.statusText != 'abort') {
                            console.error(error);
                        }
                    })
                    .finally(function () {
                        ajax = null;
                    });
            }
        },
        created: function () {
            this.refreshPageSize();
            this.search();
            jQuery(window).on('resize', this.refreshPageSize.bind(this));
        },
        beforeDestroy: function () {
            // jQuery(window).off('resize', ...);
        }
    });

});
