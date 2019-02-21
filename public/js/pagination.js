'use strict';

class Pagination {
    constructor( $element, options = {} ) {
        this.page = 1;
        this.pageSize = 5;
        this.totalCount = 0;
        this.pageMax = 5;
        this.$element = $element;
        this.callback = function (page) {};

        $.extend(this, options);

        this.render();
    }
    _drawWrap() {

        this.$wrap = $( '<ul>' )
            .addClass( 'pagination justify-content-center' );

        this.$element.append( this.$wrap );
    }
    _drawPage(page, pageName, status = '') {
        let $li = $('<li>').addClass( 'page-item' ),
            that = this, $button;

        if ( status === 'disabled' || status === 'active' ) {

            $button = $( '<span>' );

            if ( status === 'disabled' ) {
                $li.addClass( 'disabled' );
            }
            else if ( status === 'active' ) {
                $li.addClass( 'active' );
            }

        }
        else {
            $button = $( '<a>', {
                href: '#'
            } );

            $button.on( 'click', function () {
                let $this = $( this ),
                    pageNumber = $this.prop( 'page' );

                that.setPage(pageNumber);
                that.callback();
            } );
        }
        $button.prop( 'page', page )
            .html( pageName );

        $button.addClass( 'page-link' );
        $li.append( $button );

        this.$wrap.append( $li );
    }
    _drawPageFirst() {
        let status, prevName = '&laquo;';
        if (this.page === 1) {
            status = 'disabled';
        }
        this._drawPage(1, prevName, status);
    }
    _drawPageLast() {
        let status, prevName = '&raquo;';

        let lastPage = Math.ceil( this.totalCount / this.pageSize );
        if (lastPage === this.page) {
            status = 'disabled';
        }

        this._drawPage(lastPage, prevName, status);
    }
    _renderPage() {
        if (!this.totalCount) return;

        let pageStart = 0,
            pageMax = this.pageMax,
            lastPage = Math.ceil( this.totalCount / this.pageSize );

        if (lastPage > pageMax && this.page > 1) {

            pageStart = this.page - 2;

            if ( lastPage - pageStart < pageMax ) pageStart = lastPage - pageMax + 1;

        }

        if ( pageStart < 1 ) pageStart = 1;

        this._drawPageFirst();

        for( ; pageStart <= lastPage && pageMax > 0; pageStart++, pageMax-- ) {
            let status = (this.page === pageStart) ? 'active' : '';
            this._drawPage(pageStart, pageStart, status);
        }

        this._drawPageLast();
    }
    render() {
        this._drawWrap();
        this._renderPage();
    }
    refresh( options = {} ) {
        if ( options.page ) this.page = options.page / 1;

        if ( options.pageSize ) this.pageSize = options.pageSize / 1;

        if ( options.totalCount ) this.totalCount = options.totalCount / 1;

        this.$wrap.empty();
        this._renderPage();
    }
    getPage() {
        return this.page;
    }
    setPage(page) {
        this.page = page;
    }

}