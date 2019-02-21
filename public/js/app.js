
let app,
    appRun = function () {

    let a = this;

    a.$taskForm = $( '#taskForm' );
    a.$ajaxModal = $( '.ajax-modal' );
    a.$taskListView = $( '.task-list-view' );
    a.$taskSortColumn = $( '#taskSortColumn' );
    a.$taskSortDirection = $( '#taskSortDirection' );
    a.$taskPage = $( '.task-list-page' );

    a.alertCreateTask = function ( $el, msg ) {
        $el.text( msg ).show( 0 ).delay( 5000 ).hide( 0 );
    };

    a.alertSuccess = function ( msg ) {
        let $alertSuccess = a.$taskForm.find( '.alert-success' );
        a.alertCreateTask( $alertSuccess, msg );
    };

    a.alertError = function ( msg ) {
        let $alertDanger = a.$taskForm.find( '.alert-danger' );
        a.alertCreateTask( $alertDanger, msg );
    };

    a.taskFormSendSubmit = function( e ) {
        e.preventDefault();

        let $form = $( this );

        $form.removeClass( 'was-validated' );

        if (this.checkValidity() === false) {
            a.alertError( 'Заполните все поля.' );
            $form.addClass( 'was-validated' );
            return;
        }

        let ajaxData = new FormData( $form.get( 0 ) );

        a.$ajaxModal.show();

        $.ajax( {
            url: 'task/send',
            data: ajaxData,
            contentType: false,
            processData: false
        } );
    };

    a.taskSort = function ( e ) {

        let ajaxData = {
            'column': a.$taskSortColumn.val(),
            'direction': a.$taskSortDirection.val(),
            'page': a.taskPagination.getPage(),
        };

        a.$ajaxModal.show();

        $.ajax( {
            url: 'task/list',
            data: ajaxData
        } );
    };

    a.getTask = function ( id ) {

        a.$ajaxModal.show();

        $.ajax( {
            url: 'task/get',
            data: {
                id: id
            },
            success: function( data ) {
                if (data.task) {
                    let task = data.task,
                        user = data.user;

                    a.$taskForm.find( 'input[name="id"]' )
                        .val( task.id );

                    a.$taskForm.find( 'input[name="name"]' )
                        .val( user.name )
                        .prop( 'disabled', 1 );

                    a.$taskForm.find( 'input[name="email"]' )
                        .val( user.email )
                        .prop( 'disabled', 1 );

                    a.$taskForm.find( 'textarea[name="text"]' )
                        .html( task.text );

                    a.$taskForm.find( 'select[name="status"]' )
                        .val( task.status_id );
                }
            }
        } );
    };

//Ajax Setup
    $.ajaxSetup( {
        type: 'post',
        dataType: 'json',
        complete: function() {
            a.$ajaxModal.hide();
        },
        success: function( data ) {
            if ( data.msg ) {
                a.alertSuccess( data.msg );
                a.$taskForm.trigger( 'reset' );
            }
            if ( data.taskListView ) {
                a.$taskListView.html( data.taskListView );
            }
            if ( data.taskUpdate ) {
                a.$taskForm.find( 'input[name="id"]' )
                    .val( 0 );

                a.$taskForm.find( 'input[name="name"]' )
                    .prop( 'disabled', 0 );

                a.$taskForm.find( 'input[name="email"]' )
                    .prop( 'disabled', 0 );

                a.$taskForm.find( 'textarea[name="text"]' )
                    .text('');

                a.taskSort();
            }
            if ( data.page ) {
                a.taskPagination.refresh( data );
            }
            if ( data.error ) {
                a.alertError( data.error );
            }
        },
        error: function () {
            a.alertError( 'Ошибка: Напишите администратору!' );
        }
    } );

//Task Form Submit
    a.$taskForm.submit( a.taskFormSendSubmit );

//Task Sort
    a.$taskSortColumn.on( 'change', a.taskSort );
    a.$taskSortDirection.on( 'change', a.taskSort );

//Task page
    a.taskPagination = new Pagination( a.$taskPage, {
        callback: a.taskSort
    } );

    a.taskSort();

    return a;
};

$( function () {
    app = new appRun();

    //убираем рекламу хостинга
    $('.cbalink').remove()
} );