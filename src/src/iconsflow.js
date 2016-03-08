jQuery(function () {

    var ajax = null,
        preview = jQuery('#gallery > div:nth-child(2)');

    new Vue({
        el: '#gallery',
        data: {
            term: 'hello',
            page: 1,
            pageSize: 10,
            allIcons: [1,2,3,4,5]
        },
        computed: {
            searching: function () {
                return ajax !== null;
            },
            icons: function () {
                var limit = this.pageSize,
                    offset = (this.page - 1) * this.pageSize;
                console.log(offset, limit);
                return this.allIcons.slice(offset, offset + limit);
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
                var _this = this;
                if (ajax) {
                    ajax.abort();
                }
                ajax = jQuery.ajax('//search.iconsflow.com/search', {data: {term: this.term}});
                Promise.resolve(ajax)
                    .then(function (response) {
                        _this.allIcons = response.icons;
                    })
                    .catch(function (error) {
                        console.error(error);
                    })
                    .finally(function () {
                        ajax = null;
                    });
            }
        },
        created: function () {
            this.refreshPageSize();
            jQuery(window).on('resize', this.refreshPageSize.bind(this));
        },
        beforeDestroy: function () {
            // jQuery(window).off('resize', ...);
        }
    });

});
